<nav class="bg-gradient-to-r from-blue-800 to-blue-900 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Mobile menu button-->
                <button
                    x-data
                    @click="$store.app.toggleSidebar()"
                    class="inline-flex items-center justify-center p-2 rounded-md text-blue-100 hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white md:hidden transition-colors duration-200"
                    aria-label="Toggle sidebar"
                >
                    <i class="bi bi-list text-xl"></i>
                </button>

                <!-- Branding -->
                <a class="flex items-center space-x-3 text-white ml-2" href="{{ url('/') }}">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="bi bi-box-seam text-2xl text-blue-200"></i>
                    </div>
                    <div class="hidden md:block font-semibold text-xl tracking-tight truncate max-w-[150px] lg:max-w-xs">{{ config('app.name', 'Laravel Management System') }}</div>
                </a>
            </div>

            <!-- Right Navigation -->
            <div class="flex items-center space-x-1 sm:space-x-2 md:space-x-4">
                @auth

                <!-- Notifications -->
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        class="p-1.5 rounded-full text-blue-100 hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-white transition-colors duration-200"
                        aria-label="View notifications"
                    >
                        <i class="bi bi-bell text-lg sm:text-xl"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-blue-800"></span>
                        @endif
                    </button>

                    <!-- Notifications Dropdown -->
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        @click.outside="open = false"
                        class="origin-top-right absolute right-0 mt-2 w-72 sm:w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 max-h-[80vh] overflow-y-auto"
                        style="display: none;"
                    >
                        @include('components.notifications')
                    </div>
                </div>
                @endauth

                <!-- User Menu -->
                <div class="relative">
                    @guest
                    <div class="flex space-x-1 sm:space-x-2">
                        <a href="{{ route('login') }}" class="text-blue-100 hover:bg-blue-700 hover:text-white px-2 sm:px-3 py-2 rounded-md text-xs sm:text-sm font-medium flex items-center transition-colors duration-200">
                            <i class="bi bi-box-arrow-in-right mr-1 sm:mr-2"></i> <span class="hidden xs:inline">{{ __('Login') }}</span>
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white hover:bg-blue-500 px-2 sm:px-3 py-2 rounded-md text-xs sm:text-sm font-medium flex items-center transition-colors duration-200">
                            <i class="bi bi-person-plus mr-1 sm:mr-2"></i> <span class="hidden xs:inline">{{ __('Register') }}</span>
                        </a>
                    </div>
                    @else
                    @include('components.tailwind.user-dropdown')
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Search (Expandable) -->
    <div x-data="{ open: false }" @toggle-mobile-search.window="open = $event.detail.open" class="md:hidden">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="px-2 py-2 bg-blue-900"
            style="display: none;"
        >
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-search text-blue-300"></i>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-md leading-5 bg-blue-700 bg-opacity-25 text-blue-100 placeholder-blue-300 focus:outline-none focus:bg-white focus:text-gray-900 focus:placeholder-gray-500 focus:ring-2 focus:ring-white sm:text-sm transition duration-150 ease-in-out" placeholder="Search...">
            </div>
        </div>
    </div>
</nav>
