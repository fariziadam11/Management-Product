<!-- Management Section -->
<div x-data="{open: true}" class="pt-5">
    <!-- Section Header with Toggle -->
    <div @click="open = !open" class="px-3 py-2 flex items-center justify-between cursor-pointer group hover:bg-blue-700 hover:bg-opacity-30 rounded-md transition-colors duration-200">
        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider group-hover:text-white">Management</p>
        <button class="text-blue-300 group-hover:text-white focus:outline-none">
            <i class="bi" :class="open ? 'bi-chevron-down' : 'bi-chevron-right'"></i>
        </button>
    </div>

    <!-- Menu Items -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-1 space-y-1">
        <!-- Users -->
        @if(Auth::user()->hasAnyRole(['admin', 'Test' , 'manager']))
        <a href="{{ route('users.index') }}"
           class="{{ request()->routeIs('users.*') ? 'bg-blue-700 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:bg-opacity-70' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <i class="bi bi-people-fill mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('users.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="truncate">Users</span>
            @if(isset($newUsers) && $newUsers > 0)
            <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-100 bg-blue-600 rounded-full">{{ $newUsers }}</span>
            @endif
        </a>
        @endif

        <!-- Roles -->
    @if(Auth::user()->hasAnyRole(['admin', 'customer', 'manager', 'editor', 'Test']))
        <a href="{{ route('roles.index') }}"
           class="{{ request()->routeIs('roles.*') ? 'bg-blue-700 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:bg-opacity-70' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <i class="bi bi-person-badge-fill mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('roles.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="truncate">Roles</span>
        </a>
        @endif

        <!-- Categories -->
        @if(Auth::user()->hasAnyRole(['admin', 'manager', 'editor', 'customer']))
        <a href="{{ route('categories.index') }}"
           class="{{ request()->routeIs('categories.*') ? 'bg-blue-700 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:bg-opacity-70' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <i class="bi bi-folder-fill mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('categories.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="truncate">Categories</span>
        </a>
        @endif

        <!-- Products -->
        @if(Auth::user()->hasAnyRole(['admin', 'manager', 'editor' , 'customer']))
        <a href="{{ route('products.index') }}"
           class="{{ request()->routeIs('products.*') ? 'bg-blue-700 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:bg-opacity-70' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <i class="bi bi-box-fill mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('products.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="truncate">Products</span>
            @if(isset($pendingProducts) && $pendingProducts > 0)
            <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $pendingProducts }}</span>
            @endif
        </a>
        @endif

        <!-- Reviews -->
        <a href="{{ route('reviews.index') }}"
           class="{{ request()->routeIs('reviews.*') ? 'bg-blue-700 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:bg-opacity-70' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <i class="bi bi-star-fill mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('reviews.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="truncate">Reviews</span>
            @if(isset($pendingReviews) && $pendingReviews > 0)
            <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-yellow-100 bg-yellow-600 rounded-full">{{ $pendingReviews }}</span>
            @endif
        </a>

        <!-- Audits -->
        @if(Auth::user()->hasAnyRole(['admin' , 'manager', 'editor' , 'customer']))
        <a href="{{ route('audits.index') }}"
           class="{{ request()->routeIs('audits.*') ? 'bg-blue-700 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:bg-opacity-70' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200">
            <i class="bi bi-clock-history mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('audits.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="truncate">Audit Log</span>
        </a>
        @endif
    </div>
</div>
