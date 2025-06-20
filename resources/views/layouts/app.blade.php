<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Custom CSS for responsive design */
        @media (max-width: 640px) {
            .xs\:inline {
                display: inline;
            }
        }

        /* Select2 styling */
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px 10px;
            border-color: #d1d5db;
            border-radius: 0.375rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
        }

        /* Responsive table styles */
        .responsive-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Fix for mobile overflow issues */
        body, html {
            overflow-x: hidden;
            max-width: 100%;
        }
    </style>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fix for Alpine.js elements flashing before initialization -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Navbar -->
        @include('components.tailwind.navbar')

        <!-- Page Container -->
        <div class="flex flex-1">
            @auth
            <!-- Sidebar -->
            @include('components.tailwind.sidebar')
            @endauth

            <!-- Main Content Wrapper -->
            <div class="flex flex-col flex-1 {{ auth()->check() ? 'md:ml-64' : '' }}">
                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto focus:outline-none pt-4">
                    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8">
                        <!-- Page Heading -->
                        @include('components.tailwind.page-heading')

                        <!-- Alerts -->
                        @include('components.tailwind.alerts')

                        <!-- Page Content -->
                        <div class="py-4">
                            @yield('content')
                        </div>
                    </div>
                </main>

                <!-- Footer -->
                @include('components.tailwind.footer')
            </div>
        </div>
    </div>

    <!-- Scripts (includes Alpine.js) -->
    @include('components.tailwind.scripts')

    <!-- Alpine.js initialization for responsive behavior -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('app', {
                // Initial state set directly here
                sidebarOpen: window.innerWidth >= 768,
                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                },
                closeSidebar() { // Explicit close function
                    this.sidebarOpen = false;
                },
                isMobile() { // Helper to check if mobile view
                    return window.innerWidth < 768;
                }
            });

            // More robust resize handling
            let currentModeIsDesktop = window.innerWidth >= 768;

            window.addEventListener('resize', () => {
                const newModeIsDesktop = window.innerWidth >= 768;
                const appStore = Alpine.store('app');
                if (!appStore) return;

                if (newModeIsDesktop !== currentModeIsDesktop) {
                    // Breakpoint was crossed
                    if (newModeIsDesktop) {
                        // Switched to Desktop view: always open sidebar
                        appStore.sidebarOpen = true;
                    } else {
                        // Switched to Mobile view: always close sidebar
                        appStore.sidebarOpen = false;
                    }
                    currentModeIsDesktop = newModeIsDesktop;
                }
                // If breakpoint is not crossed (e.g., mobile-to-mobile resize),
                // the sidebarOpen state remains as manually toggled by the user.
            });

            // The initial sidebarOpen state is already set when the store is defined.
            // No need for the separate if (Alpine.store('app')) block for initialization here.



            // Dropdown functionality
            Alpine.data('dropdown', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                }
            }));

            Alpine.data('notifications', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                }
            }));
        });
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Initialize Select2 after DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Show error messages using SweetAlert2
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3085d6',
                });
            @endif

            // Show success messages using SweetAlert2
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            @endif

            // Small delay to ensure all elements are available
            setTimeout(function() {
                if (typeof $ !== 'undefined' && $.fn.select2) {
                    $('.select2').select2({
                        theme: 'classic',
                        width: '100%',
                        dropdownAutoWidth: true
                    });
                }
            }, 100);

            // Make tables responsive
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                if (!table.parentElement.classList.contains('responsive-table-wrapper')) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('responsive-table-wrapper');
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
