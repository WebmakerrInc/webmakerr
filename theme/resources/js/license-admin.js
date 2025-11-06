(function () {
    const activateButton = document.getElementById('webmakerr-activate-license');
    if (!activateButton || typeof window.webmakerrLicenseData === 'undefined') {
        return;
    }

    const input = document.getElementById('webmakerr-license-key');
    const feedback = document.getElementById('webmakerr-license-feedback');
    const statusText = document.getElementById('webmakerr-license-status-text');
    const spinner = document.querySelector('.webmakerr-license-spinner');
    const { endpoint, nonce, messages, labels, storedStatus } = window.webmakerrLicenseData;

    const updateStatus = (status) => {
        if (!statusText) {
            return;
        }

        statusText.className = `status-${status}`;
        const fallback = labels?.inactive || 'Inactive';
        statusText.textContent = (labels && labels[status]) || fallback;
    };

    const setFeedback = (message, type) => {
        if (!feedback) {
            return;
        }

        feedback.textContent = message;
        feedback.classList.remove('success', 'error');
        if (type) {
            feedback.classList.add(type);
        }
    };

    const toggleLoading = (isLoading) => {
        if (!spinner) {
            return;
        }

        spinner.hidden = !isLoading;
        activateButton.disabled = isLoading;
    };

    if (storedStatus) {
        updateStatus(storedStatus);
    }

    activateButton.addEventListener('click', () => {
        if (!input) {
            return;
        }

        const key = input.value.trim();
        if (!key) {
            setFeedback(messages.empty, 'error');
            updateStatus('invalid');
            return;
        }

        toggleLoading(true);
        setFeedback('', '');

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'X-WP-Nonce': nonce,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ license_key: key })
        })
            .then(async (response) => {
                const payload = await response.json().catch(() => null);

                if (!payload) {
                    throw new Error(messages.error);
                }

                if (!response.ok) {
                    const error = new Error(payload.message || messages.error);
                    error.payload = payload;
                    throw error;
                }

                return payload;
            })
            .then((data) => {
                const status = typeof data.status === 'string' ? data.status : 'active';
                const message = typeof data.message === 'string' && data.message ? data.message : messages.success;

                if (data.valid) {
                    setFeedback(message, 'success');
                    updateStatus(status);
                } else {
                    setFeedback(message, 'error');
                    updateStatus(status);
                }
            })
            .catch((error) => {
                const status = error?.payload?.status && typeof error.payload.status === 'string'
                    ? error.payload.status
                    : 'invalid';
                const message = error?.message || messages.error;

                setFeedback(message, 'error');
                updateStatus(status);
            })
            .finally(() => {
                toggleLoading(false);
            });
    });
})();
