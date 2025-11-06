(function () {
    const settings = window.webmakerrRegisterData || {};
    const fallbackPlans = Array.isArray(settings.plans) ? settings.plans : [];
    const strings = settings.strings || {};
    const endpoints = settings.endpoints || {};
    const requestNonce = typeof settings.nonce === 'string' ? settings.nonce : '';
    const planWrapper = document.querySelector('[data-register-plan-wrapper]');
    const planContainer = document.querySelector('[data-register-plans]');
    const planField = document.querySelector('[data-register-selected-plan]');
    const planNameOutput = document.querySelector('[data-register-plan-name]');
    const form = document.querySelector('[data-register-form]');
    const submitButton = document.querySelector('[data-register-submit]');
    const emailInput = document.querySelector('[data-register-email]');
    const siteInput = document.querySelector('[data-register-site]');
    const nameInput = form ? form.querySelector('[data-register-field="name"]') : null;
    const passwordInput = form ? form.querySelector('[data-register-field="password"]') : null;
    const cssEscape = window.CSS && typeof window.CSS.escape === 'function'
        ? window.CSS.escape.bind(window.CSS)
        : (value) => String(value).replace(/[^a-zA-Z0-9_-]/g, '_');

    function clearRegistrationQuery() {
        if (!window.history || typeof window.history.replaceState !== 'function') {
            return;
        }

        try {
            const url = new URL(window.location.href);
            url.searchParams.delete('registration');
            url.searchParams.delete('registration_destination');
            window.history.replaceState({}, '', url.toString());
        } catch (error) {
            // Ignore environments where URL parsing is unavailable.
        }
    }

    function resolveRedirectTarget(destination) {
        if (typeof destination !== 'string' || destination === '') {
            return '';
        }

        try {
            return new URL(destination, window.location.origin).href;
        } catch (error) {
            return '';
        }
    }

    function maybeHandleSuccessRedirect() {
        try {
            const params = new URLSearchParams(window.location.search);

            if (params.get('registration') !== 'success') {
                return;
            }

            const destinationParam = params.get('registration_destination');

            if (!destinationParam) {
                clearRegistrationQuery();
                return;
            }

            const targetUrl = resolveRedirectTarget(destinationParam);

            if (!targetUrl) {
                clearRegistrationQuery();
                return;
            }

            if (targetUrl === window.location.href) {
                clearRegistrationQuery();
                return;
            }

            window.location.replace(targetUrl);
        } catch (error) {
            // If URLSearchParams is unavailable, fall back to leaving the page as is.
        }
    }

    maybeHandleSuccessRedirect();

    if (!planContainer || !form) {
        return;
    }

    const fieldStates = {
        name: 'neutral',
        email: 'neutral',
        site: 'neutral',
        password: 'neutral',
    };

    const feedbackElements = {
        name: document.querySelector('[data-feedback-for="name"]'),
        email: document.querySelector('[data-feedback-for="email"]'),
        site: document.querySelector('[data-feedback-for="site"]'),
        password: document.querySelector('[data-feedback-for="password"]'),
    };

    function setFieldState(field, state, message) {
        const input = form.querySelector(`[data-register-field="${field}"]`);
        const feedback = feedbackElements[field];

        fieldStates[field] = state;

        if (input) {
            input.dataset.state = state !== 'neutral' ? state : '';
            if (typeof input.setCustomValidity === 'function') {
                input.setCustomValidity(state === 'error' ? message || '' : '');
            }
            if (message && state === 'checking') {
                input.setAttribute('aria-busy', 'true');
            } else {
                input.removeAttribute('aria-busy');
            }
        }

        if (feedback) {
            feedback.dataset.state = state !== 'neutral' ? state : '';
            feedback.textContent = message || '';
        }
    }

    function clearFieldState(field) {
        setFieldState(field, 'neutral', '');
    }

    function getString(path, fallback = '') {
        const parts = path.split('.');
        let current = strings;

        for (const part of parts) {
            if (current && Object.prototype.hasOwnProperty.call(current, part)) {
                current = current[part];
            } else {
                return fallback;
            }
        }

        if (typeof current === 'string') {
            return current;
        }

        return fallback;
    }

    function requestJSON(url, options = {}) {
        if (!url) {
            return Promise.resolve(null);
        }

        const config = typeof options === 'object' && options !== null ? options : {};
        const method = typeof config.method === 'string' ? config.method.toUpperCase() : 'GET';
        const headers = {};

        if (config.headers && typeof config.headers === 'object') {
            Object.keys(config.headers).forEach((key) => {
                headers[key] = config.headers[key];
            });
        }

        if (requestNonce) {
            headers['X-WP-Nonce'] = requestNonce;
            headers['X-WU-Registration-Nonce'] = requestNonce;
        }

        let finalUrl = String(url);
        const query = config.query || config.params;

        if (query && typeof query === 'object') {
            const searchParams = new URLSearchParams();

            Object.entries(query).forEach(([key, value]) => {
                if (value === undefined || value === null) {
                    return;
                }

                if (Array.isArray(value)) {
                    value.forEach((entry) => {
                        if (entry !== undefined && entry !== null && entry !== '') {
                            searchParams.append(key, entry);
                        }
                    });
                } else if (value !== '') {
                    searchParams.append(key, value);
                }
            });

            const queryString = searchParams.toString();

            if (queryString) {
                finalUrl += finalUrl.includes('?') ? `&${queryString}` : `?${queryString}`;
            }
        }

        let body;

        if (config.body && method !== 'GET') {
            if (!Object.prototype.hasOwnProperty.call(headers, 'Content-Type')) {
                headers['Content-Type'] = 'application/json';
            }

            body = typeof config.body === 'string' ? config.body : JSON.stringify(config.body);
        }

        const fetchOptions = {
            method,
            headers,
            credentials: 'same-origin',
        };

        if (body !== undefined) {
            fetchOptions.body = body;
        }

        return fetch(finalUrl, fetchOptions)
            .then(async (response) => {
                let payload = null;

                try {
                    payload = await response.json();
                } catch (error) {
                    payload = null;
                }

                if (!payload) {
                    if (!response.ok) {
                        return {
                            success: false,
                            data: {},
                            errors: [
                                {
                                    code: 'http_error',
                                    message: getString('errors.generic', 'Something went wrong. Please try again.'),
                                },
                            ],
                        };
                    }

                    return null;
                }

                if (!response.ok) {
                    if (!Array.isArray(payload.errors) || payload.errors.length === 0) {
                        return {
                            success: false,
                            data: {},
                            errors: [
                                {
                                    code: 'http_error',
                                    message: getString('errors.generic', 'Something went wrong. Please try again.'),
                                },
                            ],
                        };
                    }

                    return payload;
                }

                return payload;
            })
            .catch(() => null);
    }

    function buildFeatureList(features) {
        if (!Array.isArray(features) || features.length === 0) {
            return null;
        }

        const list = document.createElement('ul');
        list.className = 'register-plan-card__features';

        for (const feature of features) {
            const li = document.createElement('li');
            li.textContent = feature;
            list.appendChild(li);
        }

        return list;
    }

    function createPlanCard(plan) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'register-plan-card';
        button.dataset.planId = String(plan.id);
        button.setAttribute('role', 'radio');
        button.setAttribute('aria-pressed', 'false');
        button.setAttribute('aria-label', plan.name);

        if (plan.recommended) {
            button.dataset.planRecommended = 'true';
        }

        const badge = document.createElement('span');
        badge.className = 'register-plan-card__badge';
        badge.textContent = getString('labels.popular', 'Popular');
        button.appendChild(badge);

        const nameEl = document.createElement('span');
        nameEl.className = 'register-plan-card__name';
        nameEl.textContent = plan.name;
        button.appendChild(nameEl);

        if (plan.price) {
            const priceEl = document.createElement('span');
            priceEl.className = 'register-plan-card__price';
            priceEl.textContent = plan.price;

            if (plan.priceSuffix) {
                const suffix = document.createElement('span');
                suffix.className = 'register-plan-card__price-suffix';
                suffix.textContent = plan.priceSuffix;
                priceEl.appendChild(suffix);
            }

            button.appendChild(priceEl);
        }

        if (plan.description) {
            const description = document.createElement('span');
            description.className = 'register-plan-card__description';
            description.textContent = plan.description;
            button.appendChild(description);
        }

        const features = buildFeatureList(plan.features);
        if (features) {
            button.appendChild(features);
        }

        button.addEventListener('click', () => {
            selectPlan(plan, true, button);
        });

        return button;
    }

    function updateEmptyState(message) {
        if (!planContainer) {
            return;
        }

        const fallbackMessage = message || getString('planUnavailable', 'Plans are unavailable right now.');
        let target = planContainer.querySelector('[data-register-plan-empty]');

        if (!target) {
            target = document.createElement('p');
            target.className = 'register-plan-empty';
            target.setAttribute('data-register-plan-empty', '');
            planContainer.innerHTML = '';
            planContainer.appendChild(target);
        }

        target.textContent = fallbackMessage;

        if (planWrapper) {
            planWrapper.setAttribute('data-loading', 'false');
        }
    }

    function renderPlans(data) {
        if (!Array.isArray(data) || data.length === 0) {
            updateEmptyState(getString('planUnavailable', 'Plans are unavailable right now.'));
            return;
        }

        planContainer.innerHTML = '';

        const fragment = document.createDocumentFragment();
        for (const plan of data) {
            fragment.appendChild(createPlanCard(plan));
        }

        planContainer.appendChild(fragment);
        planWrapper && planWrapper.setAttribute('data-loading', 'false');

        const recommended = data.find((plan) => plan.recommended);
        const initial = data.find((plan) => String(plan.id) === String(planField.value)) || recommended || data[0];

        if (initial) {
            selectPlan(initial, false);
        }
    }

    function updatePlanSelectionUI(button) {
        const cards = planContainer.querySelectorAll('.register-plan-card');
        cards.forEach((card) => {
            const isActive = button && card === button;
            card.classList.toggle('register-plan-card--selected', isActive);
            card.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
    }

    function selectPlan(plan, focusCard = true, explicitButton) {
        if (!planField) {
            return;
        }

        const planId = String(plan.id);
        planField.value = planId;

        if (planNameOutput) {
            planNameOutput.textContent = plan.name;
        }

        const escapedId = cssEscape(planId);
        const button = explicitButton || planContainer.querySelector(`.register-plan-card[data-plan-id="${escapedId}"]`);
        updatePlanSelectionUI(button);

        if (button && focusCard) {
            button.focus();
        }
    }

    function loadPlansFromEndpoint() {
        if (!endpoints || !endpoints.plans) {
            if (!fallbackPlans.length) {
                updateEmptyState(getString('planUnavailable', 'Plans are unavailable right now.'));
            }

            return;
        }

        if (!fallbackPlans.length && planWrapper) {
            planWrapper.setAttribute('data-loading', 'true');
        }

        requestJSON(endpoints.plans)
            .then((payload) => {
                if (payload && payload.success === true) {
                    const data = payload.data && typeof payload.data === 'object' ? payload.data : {};
                    const plans = Array.isArray(data.plans) ? data.plans : [];

                    if (plans.length) {
                        renderPlans(plans);
                        return;
                    }
                }

                if (fallbackPlans.length) {
                    renderPlans(fallbackPlans);
                    return;
                }

                let message = getString('planUnavailable', 'Plans are unavailable right now.');

                if (payload && Array.isArray(payload.errors) && payload.errors.length) {
                    const firstError = payload.errors[0];

                    if (firstError && typeof firstError === 'object' && firstError.message) {
                        message = firstError.message;
                    }
                }

                updateEmptyState(message);
            })
            .catch(() => {
                if (fallbackPlans.length) {
                    renderPlans(fallbackPlans);
                    return;
                }

                updateEmptyState(getString('planUnavailable', 'Plans are unavailable right now.'));
            });
    }

    function debounce(fn, wait) {
        let timeout;
        return function debounced(...args) {
            if (timeout) {
                clearTimeout(timeout);
            }
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function availabilityRequest(params) {
        if (!endpoints || !endpoints.validate) {
            return Promise.resolve(null);
        }

        return requestJSON(endpoints.validate, {
            method: 'GET',
            query: params,
        });
    }

    const debouncedCheck = debounce((field, value) => {
        if (value === '') {
            clearFieldState(field);
            return;
        }

        setFieldState(field, 'checking', getString('labels.checking', 'Checking availability…'));

        const params = {};
        if (field === 'email') {
            params.email = value;
        }
        if (field === 'site') {
            params.site = value;
        }

        availabilityRequest(params).then((payload) => {
            if (!payload) {
                setFieldState(field, 'neutral', '');
                return;
            }

            if (payload.success !== true) {
                let message = getString('errors.generic', 'Something went wrong. Please try again.');

                if (Array.isArray(payload.errors) && payload.errors.length) {
                    const firstError = payload.errors[0];

                    if (firstError && typeof firstError === 'object') {
                        if (firstError.code === 'invalid_nonce') {
                            message = firstError.message || getString('errors.nonce', 'Your session has expired. Please refresh the page and try again.');
                        } else if (firstError.message) {
                            message = firstError.message;
                        }
                    }
                }

                setFieldState(field, 'error', message);
                return;
            }

            const data = payload.data && typeof payload.data === 'object' ? payload.data : {};
            const fieldResponse = data[field];

            if (!fieldResponse) {
                setFieldState(field, 'neutral', '');
                return;
            }

            const status = fieldResponse.status;

            if (status === 'available') {
                setFieldState(field, 'success', getString(`validation.${field}.available`, 'Looks good!'));
            } else if (status === 'taken') {
                setFieldState(field, 'error', getString(`validation.${field}.taken`, 'Already taken.'));
            } else if (status === 'invalid') {
                setFieldState(field, 'error', getString(`validation.${field}.invalid`, 'Invalid value.'));
            } else {
                clearFieldState(field);
            }
        });
    }, 450);

    function attachValidation(input, field) {
        if (!input || (field !== 'email' && field !== 'site')) {
            return;
        }

        input.addEventListener('input', () => {
            if (field === 'email') {
                if (!input.value) {
                    clearFieldState(field);
                    return;
                }
                if (!input.checkValidity()) {
                    setFieldState(field, 'error', getString('validation.email.invalid', 'Enter a valid email address.'));
                    return;
                }
            }

            if (field === 'site') {
                const sanitized = input.value.trim().toLowerCase();
                input.value = sanitized.replace(/[^a-z0-9-]/g, '');
                if (input.value.length < 4) {
                    setFieldState(field, 'error', getString('validation.site.invalid', 'Use at least 4 lowercase characters or dashes.'));
                    return;
                }
            }

            clearFieldState(field);
            debouncedCheck(field, input.value.trim());
        });

        input.addEventListener('blur', () => {
            if (!input.value) {
                setFieldState(field, 'error', getString('validation.required', 'This field is required.'));
                return;
            }

            if (!input.checkValidity()) {
                const invalidKey = field === 'site' ? 'validation.site.invalid' : `validation.${field}.invalid`;
                setFieldState(field, 'error', getString(invalidKey, 'Please double-check this field.'));
                return;
            }

            debouncedCheck(field, input.value.trim());
        });
    }

    attachValidation(emailInput, 'email');
    attachValidation(siteInput, 'site');

    if (nameInput) {
        nameInput.addEventListener('input', () => {
            if (nameInput.value.trim()) {
                clearFieldState('name');
            }
        });
        nameInput.addEventListener('blur', () => {
            if (!nameInput.value.trim()) {
                setFieldState('name', 'error', getString('validation.required', 'This field is required.'));
            } else {
                clearFieldState('name');
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', () => {
            if (passwordInput.value && passwordInput.value.length >= 8) {
                clearFieldState('password');
            }
        });
        passwordInput.addEventListener('blur', () => {
            if (!passwordInput.value || passwordInput.value.length < 8) {
                setFieldState('password', 'error', getString('validation.password', 'Password must be at least 8 characters.'));
            } else {
                clearFieldState('password');
            }
        });
    }

    if (form) {
        form.addEventListener('submit', (event) => {
            let hasError = false;

            if (!planField.value) {
                hasError = true;
                planContainer.focus({ preventScroll: false });
            }

            ['name', 'email', 'site', 'password'].forEach((field) => {
                const input = form.querySelector(`[data-register-field="${field}"]`);
                if (!input) {
                    return;
                }

                if (!input.value) {
                    setFieldState(field, 'error', getString('validation.required', 'This field is required.'));
                    if (!hasError) {
                        input.focus();
                        hasError = true;
                    }
                } else if (!input.checkValidity()) {
                    setFieldState(field, 'error', getString(`validation.${field}.invalid`, 'Please double-check this field.'));
                    if (!hasError) {
                        input.focus();
                        hasError = true;
                    }
                }
            });

            if (hasError) {
                event.preventDefault();
                return;
            }

            form.dataset.submitting = 'true';
            if (submitButton) {
                submitButton.disabled = true;
            }
        });
    }

    if (fallbackPlans.length) {
        renderPlans(fallbackPlans);
    } else if (planWrapper) {
        planWrapper.setAttribute('data-loading', 'true');
    }

    loadPlansFromEndpoint();
})();
