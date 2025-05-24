@extends('layouts.app')

@section('page_heading', 'Export Data')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
    <div class="flex flex-col">
        <div class="w-full lg:w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <h6 class="text-base sm:text-lg font-semibold text-blue-600">Export {{ ucfirst($type) }}</h6>
                    <div>
                        <a href="{{ route($type . '.index') }}" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 border border-blue-600 text-blue-600 bg-white hover:bg-blue-50 rounded-md text-sm transition-colors duration-150 ease-in-out">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back to {{ ucfirst($type) }}
                        </a>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <form action="{{ route('export.process', ['type' => $type]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <!-- Export Format -->
                        <div class="mb-4 sm:mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm h-full transition-transform duration-200 hover:-translate-y-1 hover:shadow-md">
                                        <div class="p-4 text-center">
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="format" id="format_csv" value="csv" checked>
                                                <label class="flex flex-col items-center w-full p-4 cursor-pointer rounded-lg border border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50" for="format_csv">
                                                    <div class="mb-3 text-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <h6 class="font-medium text-gray-900">CSV</h6>
                                                    <p class="text-xs text-gray-500 mb-0">Comma-separated values</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm h-full transition-transform duration-200 hover:-translate-y-1 hover:shadow-md">
                                        <div class="p-4 text-center">
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="format" id="format_xlsx" value="xlsx">
                                                <label class="flex flex-col items-center w-full p-4 cursor-pointer rounded-lg border border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50" for="format_xlsx">
                                                    <div class="mb-3 text-blue-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <h6 class="font-medium text-gray-900">Excel</h6>
                                                    <p class="text-xs text-gray-500 mb-0">Microsoft Excel format</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm h-full transition-transform duration-200 hover:-translate-y-1 hover:shadow-md">
                                        <div class="p-4 text-center">
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="format" id="format_json" value="json">
                                                <label class="flex flex-col items-center w-full p-4 cursor-pointer rounded-lg border border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50" for="format_json">
                                                    <div class="mb-3 text-yellow-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <h6 class="font-medium text-gray-900">JSON</h6>
                                                    <p class="text-xs text-gray-500 mb-0">JavaScript Object Notation</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fields to Export -->
                        <div class="mb-4 sm:mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fields to Export</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                @if($type == 'users')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex items-start mb-2">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" name="fields[]" id="field_email" value="email" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="field_email" class="font-medium text-gray-700">Email</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex items-start mb-2">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" name="fields[]" id="field_role" value="role" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="field_role" class="font-medium text-gray-700">Role</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex items-start mb-2">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" name="fields[]" id="field_active" value="is_active" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="field_active" class="font-medium text-gray-700">Active Status</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @elseif($type == 'products')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_category" value="category_id" checked>
                                            <label class="form-check-label" for="field_category">Category</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_price" value="price" checked>
                                            <label class="form-check-label" for="field_price">Price</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_stock" value="stock" checked>
                                            <label class="form-check-label" for="field_stock">Stock</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_description" value="description">
                                            <label class="form-check-label" for="field_description">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_featured" value="is_featured">
                                            <label class="form-check-label" for="field_featured">Featured Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @elseif($type == 'roles')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_description" value="description" checked>
                                            <label class="form-check-label" for="field_description">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_permissions" value="permissions">
                                            <label class="form-check-label" for="field_permissions">Permissions</label>
                                        </div>
                                    </div>
                                @elseif($type == 'categories')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_name" value="name" checked>
                                            <label class="form-check-label" for="field_name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_description" value="description">
                                            <label class="form-check-label" for="field_description">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_uuid" value="uuid">
                                            <label class="form-check-label" for="field_uuid">UUID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_active" value="is_active" checked>
                                            <label class="form-check-label" for="field_active">Active Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @elseif($type == 'reviews')
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_id" value="id" checked>
                                            <label class="form-check-label" for="field_id">ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_product" value="product_id" checked>
                                            <label class="form-check-label" for="field_product">Product</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_user" value="user_id" checked>
                                            <label class="form-check-label" for="field_user">User</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_rating" value="rating" checked>
                                            <label class="form-check-label" for="field_rating">Rating</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_title" value="title" checked>
                                            <label class="form-check-label" for="field_title">Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_content" value="content">
                                            <label class="form-check-label" for="field_content">Content</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_status" value="status" checked>
                                            <label class="form-check-label" for="field_status">Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="fields[]" id="field_created" value="created_at" checked>
                                            <label class="form-check-label" for="field_created">Created At</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="mb-4 sm:mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filters</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @if($type == 'users')
                                    <div class="col-span-1">
                                        <label for="filter_role" class="form-label">Role</label>
                                        <select class="form-select" id="filter_role" name="filters[role_id]">
                                            <option value="">All Roles</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <label for="filter_status" class="form-label">Status</label>
                                        <select class="form-select" id="filter_status" name="filters[is_active]">
                                            <option value="">All Statuses</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                @elseif($type == 'products')
                                    <div class="col-span-1">
                                        <label for="filter_category" class="form-label">Category</label>
                                        <select class="form-select" id="filter_category" name="filters[category_id]">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <label for="filter_featured" class="form-label">Featured</label>
                                        <select class="form-select" id="filter_featured" name="filters[is_featured]">
                                            <option value="">All Products</option>
                                            <option value="1">Featured Only</option>
                                            <option value="0">Non-Featured Only</option>
                                        </select>
                                    </div>
                                @elseif($type == 'categories')
                                    <div class="col-span-1">
                                        <label for="filter_category" class="form-label">Category</label>
                                        <select class="form-select" id="filter_category" name="filters[id]">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <label for="filter_status" class="form-label">Status</label>
                                        <select class="form-select" id="filter_status" name="filters[is_active]">
                                            <option value="">All Statuses</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                @elseif($type == 'reviews')
                                    <div class="col-span-1">
                                        <label for="filter_product" class="form-label">Product</label>
                                        <select class="form-select" id="filter_product" name="filters[product_id]">
                                            <option value="">All Products</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <label for="filter_rating" class="form-label">Rating</label>
                                        <select class="form-select" id="filter_rating" name="filters[rating]">
                                            <option value="">All Ratings</option>
                                            <option value="5">5 Stars</option>
                                            <option value="4">4 Stars</option>
                                            <option value="3">3 Stars</option>
                                            <option value="2">2 Stars</option>
                                            <option value="1">1 Star</option>
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <label for="filter_status" class="form-label">Status</label>
                                        <select class="form-select" id="filter_status" name="filters[status]">
                                            <option value="">All Statuses</option>
                                            <option value="approved">Approved</option>
                                            <option value="pending">Pending</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                @endif
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                                    <select name="filters[date_range]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">All Time</option>
                                        <option value="today">Today</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="this_week">This Week</option>
                                        <option value="last_week">Last Week</option>
                                        <option value="this_month">This Month</option>
                                        <option value="last_month">Last Month</option>
                                        <option value="this_year">This Year</option>
                                        <option value="last_year">Last Year</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route($type . '.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Previous Exports -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h6 class="text-base sm:text-lg font-semibold text-blue-600">Previous Exports</h6>
                </div>
                <div class="p-4 sm:p-6">
                    @if(count($previousExports) > 0)
                        <div class="overflow-x-auto -mx-4 sm:-mx-0">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Records</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($previousExports as $export)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ $export->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ ucfirst($export->type) }}</td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                @if($export->format == 'csv')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">CSV</span>
                                                @elseif($export->format == 'xlsx')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">XLSX</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ strtoupper($export->format) }}</span>
                                                @endif
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ number_format($export->record_count) }}</td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <a href="{{ route('export.download', $export->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-blue-300 text-xs font-medium rounded text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 rounded-md bg-blue-50">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">No previous exports found.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card.shadow-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }

    .form-check-label {
        cursor: pointer;
    }
</style>
@endsection
