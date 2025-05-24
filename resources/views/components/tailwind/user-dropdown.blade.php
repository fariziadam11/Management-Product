<div x-data="dropdown" class="relative">
    <button
        @click="toggle()"
        type="button"
        class="flex items-center max-w-xs text-sm bg-blue-700 hover:bg-blue-600 transition-colors duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white p-0.5 pl-2"
        id="userDropdown"
        :aria-expanded="open"
        aria-haspopup="true"
    >
        <span class="sr-only">Open user menu</span>
        <span class="mr-2 hidden md:inline-block text-white font-medium truncate max-w-[120px]">{{ Auth::user()->name }}</span>
        <img class="h-8 w-8 rounded-full ring-2 ring-blue-800" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=ffffff&size=36" alt="{{ Auth::user()->name }}">
    </button>

    <!-- Dropdown - User Information -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @click.outside="close()"
        @keydown.escape.window="close()"
        class="absolute right-0 mt-2 w-56 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 divide-y divide-gray-100"
        x-cloak
    >
        <!-- User Info -->
        <div class="px-4 py-3">
            <p class="text-sm text-gray-900 font-medium truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
        </div>

        <!-- Menu Items -->
        <div class="py-1">
            <a href="{{ route('profile') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150">
                <i class="bi bi-person-fill mr-3 text-gray-400 group-hover:text-blue-500"></i> Profile
            </a>

            @if(Auth::user()->hasAnyRole(['admin']))
            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150">
                <i class="bi bi-speedometer2 mr-3 text-gray-400 group-hover:text-blue-500"></i> Dashboard
            </a>
            @endif

            <a href="{{ route('notifications.index') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150">
                <i class="bi bi-bell-fill mr-3 text-gray-400 group-hover:text-blue-500"></i> Notifications
                @if(Auth::user()->unreadNotifications->count() > 0)
                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>
        </div>

        <!-- Logout -->
        <div class="py-1">
            <a
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="group flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors duration-150"
            >
                <i class="bi bi-box-arrow-right mr-3 text-red-400"></i> {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>
