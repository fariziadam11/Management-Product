<div x-data="notifications" class="relative ml-3">
    <button 
        @click="toggle()"
        @keydown.escape="close()"
        type="button" 
        class="relative p-1 text-white hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white rounded-full"
        :aria-expanded="open"
        aria-haspopup="true"
    >
        <i class="bi bi-bell-fill text-xl"></i>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-xs justify-center items-center text-white">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        </span>
        @endif
    </button>
    
    <!-- Dropdown panel, show/hide based on dropdown state -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @click.outside="close()"
        class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 max-h-[80vh] overflow-y-auto"
        x-cloak
    >
        @include('components.notifications')
    </div>
</div>
