
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /* ----------------------------------------------------------
               TABS
               ---------------------------------------------------------- */

            var tabs = document.querySelectorAll(
                '.wpct-tab'
            );

            var panels = document.querySelectorAll(
                '.wpct-panel'
            );


            function showPanel(id) {

                tabs.forEach(
                    function (tab) {

                        tab.classList.toggle(
                            'is-active',
                            tab.getAttribute('data-target') === id
                        );

                    }
                );


                panels.forEach(
                    function (panel) {

                        panel.classList.toggle(
                            'is-visible',
                            panel.id === id
                        );

                    }
                );


                if (
                    window.history &&
                    window.history.replaceState
                ) {

                    window.history.replaceState(
                        null,
                        '',
                        '#' + id
                    );

                }

            }


            tabs.forEach(
                function (tab) {

                    tab.addEventListener(
                        'click',
                        function () {

                            showPanel(
                                tab.getAttribute(
                                    'data-target'
                                )
                            );

                        }
                    );

                }
            );


            if (window.location.hash) {

                var target =
                    window.location.hash.substring(1);

                if (
                    document.getElementById(target)
                ) {

                    showPanel(target);

                }

            }


            /* ----------------------------------------------------------
               DEFAULT FEATURE TOGGLES
               ---------------------------------------------------------- */

            document
                .querySelectorAll(
                    '.wpct-feature input'
                )
                .forEach(
                    function (input) {

                        input.addEventListener(
                            'change',
                            function () {

                                var feature =
                                    input.closest(
                                        '.wpct-feature'
                                    );

                                if (feature) {

                                    feature.classList.toggle(
                                        'is-on',
                                        input.checked
                                    );

                                }

                            }
                        );

                    }
                );


            /* ----------------------------------------------------------
               CLIENT FEATURE TOGGLES
               ---------------------------------------------------------- */

            document
                .querySelectorAll(
                    '.wpct-mini-feature input'
                )
                .forEach(
                    function (input) {

                        input.addEventListener(
                            'change',
                            function () {

                                var feature =
                                    input.closest(
                                        '.wpct-mini-feature'
                                    );

                                if (feature) {

                                    feature.classList.toggle(
                                        'is-on',
                                        input.checked
                                    );

                                }

                            }
                        );

                    }
                );


            /* ----------------------------------------------------------
               ACTION PERMISSION TOGGLES
               ---------------------------------------------------------- */

            document
                .querySelectorAll(
                    '.wpct-action-option input'
                )
                .forEach(
                    function (input) {

                        input.addEventListener(
                            'change',
                            function () {

                                var option =
                                    input.closest(
                                        '.wpct-action-option'
                                    );

                                if (option) {

                                    option.classList.toggle(
                                        'is-on',
                                        input.checked
                                    );

                                }

                            }
                        );

                    }
                );


            /* ----------------------------------------------------------
               DEVELOPER / CLIENT SWITCH
               ---------------------------------------------------------- */

            document
                .querySelectorAll(
                    '.wpct-mode-switch'
                )
                .forEach(
                    function (switcher) {

                        switcher
                            .querySelectorAll(
                                'input[type="radio"]'
                            )
                            .forEach(
                                function (input) {

                                    input.addEventListener(
                                        'change',
                                        function () {

                                            switcher
                                                .querySelectorAll(
                                                    '.wpct-mode-option'
                                                )
                                                .forEach(
                                                    function (option) {

                                                        option.classList.remove(
                                                            'is-active',
                                                            'developer',
                                                            'client'
                                                        );

                                                    }
                                                );


                                            var selected =
                                                input.closest(
                                                    '.wpct-mode-option'
                                                );


                                            if (selected) {

                                                selected.classList.add(
                                                    'is-active'
                                                );


                                                if (
                                                    input.value ===
                                                    'client'
                                                ) {

                                                    selected.classList.add(
                                                        'client'
                                                    );

                                                } else {

                                                    selected.classList.add(
                                                        'developer'
                                                    );

                                                }

                                            }

                                        }
                                    );

                                }
                            );

                    }
                );

        }
    );

