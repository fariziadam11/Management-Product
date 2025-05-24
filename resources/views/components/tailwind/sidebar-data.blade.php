<!-- Data Section -->
<div class="pt-5">
    <p class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Data</p>

    <!-- Export -->
    <a href="{{ route('export.form', 'data') }}" class="{{ request()->routeIs('export.*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1">
        <i class="bi bi-file-earmark-arrow-down mr-3 flex-shrink-0 h-5 w-5 text-blue-300"></i>
        Export Data
    </a>

    <!-- Import Users -->
    @if(Auth::user()->hasAnyRole(['admin']))
    <a href="{{ route('import.form', 'users') }}" class="{{ request()->routeIs('import.form') && request()->route('type') == 'users' ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1">
        <i class="bi bi-file-earmark-arrow-up mr-3 flex-shrink-0 h-5 w-5 text-blue-300"></i>
        Import Users
    </a>
    @endif

    <!-- Import Products -->
    @if(Auth::user()->hasAnyRole(['admin', 'manager']))
    <a href="{{ route('import.form', 'products') }}" class="{{ request()->routeIs('import.form') && request()->route('type') == 'products' ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1">
        <i class="bi bi-file-earmark-arrow-up mr-3 flex-shrink-0 h-5 w-5 text-blue-300"></i>
        Import Products
    </a>
    @endif
</div>
