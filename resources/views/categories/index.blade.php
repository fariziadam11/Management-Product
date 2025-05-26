@extends('layouts.app')

@section('page_heading', 'Categories')

@section('page_actions')
<a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
    <i class="bi bi-plus-circle mr-2"></i> Add Category
</a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filters and Search -->
    <div x-data="{showFilters: true}" class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <div class="flex items-center justify-between w-full sm:w-auto">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="bi bi-funnel mr-2 text-blue-600"></i>
                    <span>Filter Categories</span>
                </h3>
                <button @click="showFilters = !showFilters" class="text-gray-500 hover:text-gray-700 focus:outline-none sm:ml-2">
                    <i class="bi" :class="showFilters ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </button>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('export.form', ['type' => 'categories']) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-download mr-1.5"></i> Export
                </a>
                <a href="{{ route('import.form', ['type' => 'categories']) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-upload mr-1.5"></i> Import
                </a>
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="bi bi-plus-circle mr-1.5"></i> Create
                </a>
                @endif
            </div>
        </div>
        <div x-show="showFilters" x-transition class="px-4 py-4 bg-white">
            <form action="{{ route('categories.index') }}" method="GET" class="space-y-4 md:space-y-0">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-10 gap-4 items-center">
                    <div class="lg:col-span-4">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                id="search" name="search" placeholder="Search categories..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="lg:col-span-2">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="status">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="lg:col-span-3">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="sort">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                    <div class="lg:col-span-1">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="bi bi-funnel-fill mr-2"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @if($categories->count() > 0)
            @foreach($categories as $category)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                        <div class="flex items-center">
                            <h3 class="text-lg font-medium text-gray-900 truncate">{{ $category->name }}</h3>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-full hover:bg-gray-100">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                <a href="{{ route('categories.show', $category->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="bi bi-eye text-blue-600 mr-2"></i> View
                                </a>
                                <a href="{{ route('categories.edit', $category->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="bi bi-pencil text-indigo-600 mr-2"></i> Edit
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center"
                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="bi bi-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-col space-y-3">
                            <div class="flex items-center mt-4">
                                <div class="flex items-center text-xs text-gray-500">
                                    <i class="bi bi-box mr-2 text-blue-500"></i>
                                    <span class="font-medium text-xs justify-center w-5">{{ $category->products_count ?? 0 }}</span> Products
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-600 line-clamp-2">
                                {{ $category->description ?? 'No description available' }}
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span class="flex items-center">
                                <i class="bi bi-calendar mr-1"></i> {{ $category->created_at->format('M d, Y') }}
                            </span>
                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="text-blue-600 hover:text-blue-800 flex items-center transition-colors duration-150">
                                View Products <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-full">
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-8 rounded-lg text-center">
                    <div class="flex flex-col items-center">
                        <i class="bi bi-folder-plus text-4xl mb-3 text-blue-400"></i>
                        <p class="text-lg font-medium">No categories found</p>
                        <p class="text-sm mt-1 mb-3">Start organizing your products by creating categories</p>
                        @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('categories.create') }}" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="bi bi-plus-circle mr-2"></i> Create your first category
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
    <div class="mt-6">
        {{ $categories->appends(request()->query())->links('components.tailwind.pagination') }}
    </div>
    @endif
</div>
@endsection
