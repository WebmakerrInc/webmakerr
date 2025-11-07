window.addEventListener('load', function () {
    const mainNavigation = document.getElementById('primary-navigation')
    const mainNavigationToggle = document.getElementById('primary-menu-toggle')

    if (mainNavigation && mainNavigationToggle) {
        const breakpoint = window.matchMedia('(min-width: 768px)')
        const openClasses = ['opacity-100', 'translate-y-0', 'pointer-events-auto']
        const closedClasses = ['opacity-0', '-translate-y-2', 'pointer-events-none']
        let isMobileNavOpen = false

        const addClasses = function (target, classes) {
            classes.forEach(function (className) {
                target.classList.add(className)
            })
        }

        const removeClasses = function (target, classes) {
            classes.forEach(function (className) {
                target.classList.remove(className)
            })
        }

        const documentClickHandler = function (event) {
            if (mainNavigation.contains(event.target) || mainNavigationToggle.contains(event.target)) {
                return
            }

            closeMobileNav()
        }

        const documentKeyHandler = function (event) {
            if (event.key === 'Escape') {
                closeMobileNav()
            }
        }

        const openMobileNav = function () {
            if (isMobileNavOpen || breakpoint.matches) {
                return
            }

            isMobileNavOpen = true

            mainNavigation.classList.remove('hidden')
            mainNavigation.classList.add('flex')

            requestAnimationFrame(function () {
                removeClasses(mainNavigation, closedClasses)
                addClasses(mainNavigation, openClasses)
            })

            mainNavigation.setAttribute('aria-hidden', 'false')
            mainNavigationToggle.setAttribute('aria-expanded', 'true')

            document.addEventListener('click', documentClickHandler)
            document.addEventListener('keydown', documentKeyHandler)
        }

        const closeMobileNav = function (options) {
            options = options || {}

            if (!isMobileNavOpen && !options.immediate && !breakpoint.matches) {
                return
            }

            isMobileNavOpen = false

            removeClasses(mainNavigation, openClasses)
            addClasses(mainNavigation, closedClasses)

            mainNavigation.setAttribute('aria-hidden', 'true')
            mainNavigationToggle.setAttribute('aria-expanded', 'false')

            document.removeEventListener('click', documentClickHandler)
            document.removeEventListener('keydown', documentKeyHandler)

            const finalize = function () {
                if (!breakpoint.matches) {
                    mainNavigation.classList.add('hidden')
                    mainNavigation.classList.remove('flex')
                }
            }

            if (options.immediate || breakpoint.matches) {
                finalize()
                return
            }

            const handleTransitionEnd = function () {
                finalize()
                mainNavigation.removeEventListener('transitionend', handleTransitionEnd)
            }

            mainNavigation.addEventListener('transitionend', handleTransitionEnd, { once: true })

            window.setTimeout(function () {
                finalize()
            }, 250)
        }

        const syncNavigationState = function () {
            if (breakpoint.matches) {
                mainNavigation.classList.remove('hidden')
                removeClasses(mainNavigation, closedClasses)
                mainNavigation.classList.remove('flex')
                mainNavigation.setAttribute('aria-hidden', 'false')
                mainNavigationToggle.setAttribute('aria-expanded', 'false')
                document.removeEventListener('click', documentClickHandler)
                document.removeEventListener('keydown', documentKeyHandler)
                isMobileNavOpen = false
            } else {
                closeMobileNav({ immediate: true })
            }
        }

        mainNavigationToggle.addEventListener('click', function (event) {
            event.preventDefault()

            if (isMobileNavOpen) {
                closeMobileNav()
            } else {
                openMobileNav()
            }
        })

        if (typeof breakpoint.addEventListener === 'function') {
            breakpoint.addEventListener('change', syncNavigationState)
        } else if (typeof breakpoint.addListener === 'function') {
            breakpoint.addListener(syncNavigationState)
        }

        syncNavigationState()
    }

    const solutionsToggle = document.querySelector('[data-solutions-toggle]')
    const solutionsMenu = document.querySelector('[data-solutions-menu]')

    if (solutionsToggle && solutionsMenu) {
        const solutionsIcon = solutionsToggle.querySelector('[data-solutions-icon]')

        let isSolutionsOpen = false

        const documentClickHandler = function (event) {
            if (!solutionsMenu.contains(event.target) && !solutionsToggle.contains(event.target)) {
                closeSolutions()
            }
        }

        const documentKeyHandler = function (event) {
            if (event.key === 'Escape') {
                closeSolutions()
            }
        }

        const openSolutions = function () {
            if (isSolutionsOpen) {
                return
            }

            isSolutionsOpen = true

            solutionsMenu.classList.remove('hidden')
            solutionsMenu.setAttribute('aria-hidden', 'false')
            solutionsToggle.setAttribute('aria-expanded', 'true')

            if (solutionsIcon) {
                solutionsIcon.classList.add('rotate-180')
            }

            document.addEventListener('click', documentClickHandler)
            document.addEventListener('keydown', documentKeyHandler)
        }

        const closeSolutions = function () {
            if (!isSolutionsOpen) {
                return
            }

            isSolutionsOpen = false

            solutionsMenu.classList.add('hidden')
            solutionsMenu.setAttribute('aria-hidden', 'true')
            solutionsToggle.setAttribute('aria-expanded', 'false')

            if (solutionsIcon) {
                solutionsIcon.classList.remove('rotate-180')
            }

            document.removeEventListener('click', documentClickHandler)
            document.removeEventListener('keydown', documentKeyHandler)
        }

        solutionsToggle.addEventListener('click', function (event) {
            event.preventDefault()

            if (isSolutionsOpen) {
                closeSolutions()
            } else {
                openSolutions()
            }
        })
    }

    const footerAccordions = document.querySelectorAll('[data-footer-accordion-item]')

    if (footerAccordions.length) {
        const breakpoint = window.matchMedia('(min-width: 768px)')

        footerAccordions.forEach(function (item) {
            const trigger = item.querySelector('[data-footer-accordion-trigger]')
            const content = item.querySelector('[data-footer-accordion-content]')
            const icon = item.querySelector('[data-footer-accordion-icon]')

            if (!trigger || !content) {
                return
            }

            const close = function () {
                content.classList.remove('max-h-96', 'opacity-100', 'pointer-events-auto')
                content.classList.add('max-h-0', 'opacity-0', 'pointer-events-none')
                content.setAttribute('aria-hidden', 'true')
                trigger.setAttribute('aria-expanded', 'false')

                if (icon) {
                    icon.classList.remove('rotate-45')
                }
            }

            const open = function () {
                content.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none')
                content.classList.add('max-h-96', 'opacity-100', 'pointer-events-auto')
                content.setAttribute('aria-hidden', 'false')
                trigger.setAttribute('aria-expanded', 'true')

                if (icon) {
                    icon.classList.add('rotate-45')
                }
            }

            const syncState = function () {
                if (breakpoint.matches) {
                    content.classList.remove('max-h-0', 'max-h-96', 'opacity-0', 'opacity-100', 'pointer-events-none', 'pointer-events-auto')
                    content.setAttribute('aria-hidden', 'false')
                    trigger.setAttribute('aria-expanded', 'true')

                    if (icon) {
                        icon.classList.remove('rotate-45')
                    }
                } else {
                    close()
                }
            }

            trigger.addEventListener('click', function (event) {
                event.preventDefault()

                if (trigger.getAttribute('aria-expanded') === 'true') {
                    close()
                } else {
                    open()
                }
            })

            syncState()

            if (typeof breakpoint.addEventListener === 'function') {
                breakpoint.addEventListener('change', syncState)
            } else if (typeof breakpoint.addListener === 'function') {
                breakpoint.addListener(syncState)
            }
        })
    }
})
