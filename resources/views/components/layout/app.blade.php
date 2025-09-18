@props([
    'title' => null,
    'withError' => null,
])

<!doctype html>

<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-skin="default"
    data-assets-path="{{ asset('vuexy/') }}" data-template="horizontal-menu-template" data-bs-theme="light">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>
            @if ($title)
                {{ $title }}
            @else
                {{ config('app.name', 'Prabubima Tech') }}
            @endif
        </title>

        <meta name="description" content="{{ config('app.name', 'Prabubima Tech') }}" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('vuexy/vendor/fonts/iconify-icons.css') }}" />
        <!-- Boxicons CDN -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

        <!-- Core CSS -->
        <!-- build:css assets/vendor/css/theme.css  -->

        <link rel="stylesheet" href="{{ asset('vuexy/vendor/libs/node-waves/node-waves.css') }}" />
        <link rel="stylesheet" href="{{ asset('vuexy/vendor/libs/pickr/pickr-themes.css') }}" />

        <link rel="stylesheet" href="{{ asset('vuexy/vendor/css/core.css') }}" />

        <!-- di head, setelah core CSS -->
        <!-- head (letakkan setelah core CSS agar segera berlaku) -->
        <style>
            /* default safe reserve agar tidak terjadi jump awal */
            :root {
                --navbar-height: 70px;
            }

            /* pastikan ini override inline style yang mungkin ditulis oleh JS */
            .layout-navbar-fixed .layout-page {
                padding-top: var(--navbar-height) !important;
            }

            /* perbaikan untuk variant lain (jika kamu pakai layout-navbar-full / layout-navbar) */
            .layout-navbar .layout-page,
            .layout-navbar-full .layout-page {
                padding-top: var(--navbar-height) !important;
            }

            /* mobile default */
            @media (max-width: 767px) {
                :root {
                    --navbar-height: 56px;
                }
            }

            .my-custom-toast {
                margin-top: 3.5rem !important;
            }

            /* pastikan ini dimuat setelah CSS lain */
            .swal2-container .swal2-toast {
                width: auto !important;
                min-width: 350px !important;
                padding: .5rem !important;
                font-size: 13px !important;
            }
        </style>

        <link rel="stylesheet" href="{{ asset('vuexy/css/demo.css') }}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('vuexy/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('vuexy/vendor/libs/swiper/swiper.css') }}" />
        <link rel="stylesheet" href="{{ asset('vuexy/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('vuexy/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('vuexy/vendor/fonts/flag-icons.css') }}" />

        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ asset('vuexy/vendor/css/pages/cards-advance.css') }}" />

        <!-- Helpers -->
        <script src="{{ asset('vuexy/vendor/js/helpers.js') }}"></script>

        <!-- Template customizer & Theme config -->
        <script src="{{ asset('vuexy/js/config.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('style')
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
            <div class="layout-container">
                <!-- Navbar -->
                @include('components.layout.partials.navbar')
                <!-- / Navbar -->

                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Menu -->
                        @include('components.layout.partials.menu')
                        <!-- / Menu -->

                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            {{ $slot }}
                        </div>
                        <!--/ Content -->

                        <!-- Footer -->
                        @include('components.layout.partials.footer')
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!--/ Content wrapper -->
                </div>

                <!--/ Layout container -->
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>

        <!--/ Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/theme.js -->

        <script src="{{ asset('vuexy/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/libs/node-waves/node-waves.js') }}"></script>

        <script src="{{ asset('vuexy/vendor/libs/@algolia/autocomplete-js.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/libs/pickr/pickr.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/js/menu.js') }}"></script>

        <!-- Vendors JS -->
        <script src="{{ asset('vuexy/vendor/libs/swiper/swiper.js') }}"></script>
        <script src="{{ asset('vuexy/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('vuexy/js/main.js') }}"></script>

        <script src="https://unpkg.com/htmx.org@2.0.4"
            integrity="sha384-HGfztofotfshcF7+8n44JQL2oJmowVChPTg48S+jvZoztPfvwD79OC/LTtG6dMp+" crossorigin="anonymous">
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        @if (session('noback'))
            <script type="text/javascript">
                window.history.pushState(null, null, window.location.href);
                window.onpopstate = function() {
                    window.history.pushState(null, null, window.location.href);
                };
            </script>
        @endif

        @if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'my-custom-toast'
                    },
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: "{{ session()->has('success') ? 'success' : (session()->has('error') ? 'error' : (session()->has('warning') ? 'warning' : 'info')) }}",
                    title: "{{ session('success') ?? (session('error') ?? (session('warning') ?? session('info'))) }}"
                });
            </script>
        @endif

        @stack('script')

        <script>
            (function() {
                const selectors = ['.layout-navbar', '.navbar', 'header'];

                function findNav() {
                    for (const s of selectors) {
                        const el = document.querySelector(s);
                        if (el) return el;
                    }
                    return null;
                }

                function updateNavbarHeight() {
                    const nav = findNav();
                    if (!nav) return;
                    const h = Math.ceil(nav.getBoundingClientRect().height || 0);
                    if (h > 0) {
                        document.documentElement.style.setProperty('--navbar-height', h + 'px');
                    }
                }

                // Try asap (if navbar already in DOM)
                if (document.readyState === 'complete' || document.readyState === 'interactive') {
                    updateNavbarHeight();
                } else {
                    document.addEventListener('DOMContentLoaded', updateNavbarHeight, {
                        once: true
                    });
                }

                // Observe DOM additions in case Vuexy injects navbar later
                const rootObserver = new MutationObserver((mutations) => {
                    if (findNav()) {
                        updateNavbarHeight();
                    }
                });
                rootObserver.observe(document.documentElement || document.body, {
                    childList: true,
                    subtree: true
                });

                // Update on window resize (responsive)
                window.addEventListener('resize', () => requestAnimationFrame(updateNavbarHeight));

                // Safety: run again shortly after load (cover assets that load after)
                window.addEventListener('load', () => {
                    setTimeout(updateNavbarHeight, 50);
                    setTimeout(updateNavbarHeight, 300);
                });
            })();
        </script>
    </body>

</html>
