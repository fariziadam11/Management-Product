<!-- Sidebar -->
<div
     :class="{ 'translate-x-0': $store.app.sidebarOpen, '-translate-x-full': !$store.app.sidebarOpen }"
     class="fixed top-0 left-0 z-40 w-64 flex flex-col transform transition-transform duration-300 ease-in-out md:translate-x-0 bg-gradient-to-b from-blue-800 to-blue-900 h-screen overflow-hidden pt-16">

    <!-- Sidebar Content -->
    <div class="flex flex-col flex-grow overflow-y-auto scrollbar-thin scrollbar-thumb-blue-600 scrollbar-track-transparent scrollbar-thumb-rounded-full scrollbar-w-1.5">
        <!-- Sidebar Header -->
        <div class="flex items-center flex-shrink-0 px-4 py-5">
            <!-- Mobile Close Button -->
            <button @click="$store.app.toggleSidebar()" class="ml-auto p-1 rounded-full text-blue-200 hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-white md:hidden transition-colors duration-200">
                <span class="sr-only">Close sidebar</span>
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="border-t border-blue-700 opacity-25"></div>

        <!-- Navigation Menu -->
        <nav class="mt-5 flex-1 px-3 space-y-1 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:bg-opacity-70' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors duration-200">
                <i class="bi bi-speedometer2 mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
                <span class="truncate">Dashboard</span>
            </a>

            @include('components.tailwind.sidebar-management')
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-blue-700 mt-auto">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=4e73df&color=ffffff&size=32" alt="{{ auth()->user()->name ?? 'User' }}">
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Guest' }}</p>
                    <p class="text-xs text-blue-300 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar Backdrop (Mobile) -->
<div
    x-cloak
    x-show="$store.app.sidebarOpen && window.innerWidth < 768"
    @click="$store.app.toggleSidebar()"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 md:hidden"
></div>
