@extends('layouts.app')

@section('page_heading', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h2 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="text-gray-600">Here's what's happening with your store today.</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('analytics.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Analytics
                        </a>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Add Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Users Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-blue-600 uppercase tracking-wider">Users</h3>
                    </div>
                    <div class="relative">
                        <button class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View All</a>
                                <a href="{{ route('users.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add New</a>
                                <div class="border-t border-gray-200"></div>
                                <a href="{{ route('export.form', 'users') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['users'] }}</div>
                <div class="mt-2 flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                    </svg>
                    {{ isset($stats['user_growth']) ? $stats['user_growth'] : '0' }}% since last month
                </div>
            </div>
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                    Manage Users
                </a>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-green-600 uppercase tracking-wider">Categories</h3>
                    </div>
                    <div class="relative">
                        <button class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View All</a>
                                <a href="{{ route('categories.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add New</a>
                                <div class="border-t border-gray-200"></div>
                                <a href="{{ route('export.form', 'categories') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['categories'] }}</div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    {{ isset($stats['active_categories']) ? $stats['active_categories'] : $stats['categories'] }} active
                </div>
            </div>
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    Manage Categories
                </a>
            </div>
        </div>

        <!-- Products Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-indigo-600 uppercase tracking-wider">Products</h3>
                    </div>
                    <div class="relative">
                        <button class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <a href="{{ route('products.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View All</a>
                                <a href="{{ route('products.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add New</a>
                                <div class="border-t border-gray-200"></div>
                                <a href="{{ route('export.form', 'products') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['products'] }}</div>
                <div class="mt-2 flex items-center text-sm text-red-600">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ isset($stats['low_stock']) ? $stats['low_stock'] : '0' }} low stock
                </div>
            </div>
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                    </svg>
                    Manage Products
                </a>
            </div>
        </div>

        <!-- Reviews Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-yellow-600 uppercase tracking-wider">Reviews</h3>
                    </div>
                    <div class="relative">
                        <button class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <a href="{{ route('reviews.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View All</a>
                                <div class="border-t border-gray-200"></div>
                                <a href="{{ route('export.form', 'reviews') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['reviews'] }}</div>
                <div class="mt-2 flex items-center text-sm text-yellow-600">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ isset($stats['pending_reviews']) ? $stats['pending_reviews'] : '0' }} pending
                </div>
            </div>
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('reviews.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Manage Reviews
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Add Product -->
                    <a href="{{ route('products.create') }}" class="group block">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden group-hover:shadow-md transition duration-150 ease-in-out">
                            <div class="p-6 text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h4 class="mt-4 font-medium text-gray-900 group-hover:text-blue-600 transition duration-150 ease-in-out">Add Product</h4>
                            </div>
                        </div>
                    </a>

                    <!-- Add Category -->
                    <a href="{{ route('categories.create') }}" class="group block">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden group-hover:shadow-md transition duration-150 ease-in-out">
                            <div class="p-6 text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12 13a1 1 0 100-2H9.465a1 1 0 00-.9.5L6.035 15H3a1 1 0 100 2h3.465a1 1 0 00.9-.5l2.53-4.5H12zm3.5-8.5a1.5 1.5 0 01-1.5 1.5h-1a1 1 0 100-2h1a1.5 1.5 0 011.5 1.5zM4 5a1 1 0 000 2h1a1 1 0 100-2H4zm3.5-1.5A1.5 1.5 0 019 5h1a1 1 0 100-2H9a1.5 1.5 0 00-1.5 1.5z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h4 class="mt-4 font-medium text-gray-900 group-hover:text-green-600 transition duration-150 ease-in-out">Add Category</h4>
                            </div>
                        </div>
                    </a>

                    <!-- Add User -->
                    <a href="{{ route('users.create') }}" class="group block">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden group-hover:shadow-md transition duration-150 ease-in-out">
                            <div class="p-6 text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                    </svg>
                                </div>
                                <h4 class="mt-4 font-medium text-gray-900 group-hover:text-indigo-600 transition duration-150 ease-in-out">Add User</h4>
                            </div>
                        </div>
                    </a>

                    <!-- View Analytics -->
                    <a href="{{ route('analytics.dashboard') }}" class="group block">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden group-hover:shadow-md transition duration-150 ease-in-out">
                            <div class="p-6 text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                                <h4 class="mt-4 font-medium text-gray-900 group-hover:text-purple-600 transition duration-150 ease-in-out">View Analytics</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Products -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Products</h3>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View All
                </a>
            </div>
            <div class="p-6">
                @if(count($recentProducts) > 0)
                    <div class="space-y-4">
                        @foreach($recentProducts as $product)
                            <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-4">
                                        @if($product->image)
                                            <img class="h-12 w-12 rounded-md object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-center">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $product->stock > 10 ? 'green' : ($product->stock > 0 ? 'yellow' : 'red') }}-100 text-{{ $product->stock > 10 ? 'green' : ($product->stock > 0 ? 'yellow' : 'red') }}-800">
                                                {{ $product->stock > 10 ? 'In Stock' : ($product->stock > 0 ? 'Low Stock' : 'Out of Stock') }}
                                            </span>
                                        </div>
                                        <div class="mt-1 flex justify-between items-center">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $product->category->name }}
                                                </span>
                                                <span class="ml-2">Added {{ $product->created_at->diffForHumans() }}</span>
                                            </div>
                                            <span class="text-sm font-medium text-blue-600">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-end space-x-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-sm text-blue-700">
                                    No products found. <a href="{{ route('products.create') }}" class="font-medium text-blue-700 hover:text-blue-600">Add your first product</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                    </svg>
                    View All Products
                </a>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Reviews</h3>
                <a href="{{ route('reviews.index') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View All
                </a>
            </div>
            <div class="p-6">
                @if(count($recentReviews) > 0)
                    <div class="space-y-4">
                        @foreach($recentReviews as $review)
                            <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-4">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer_name) }}&background=4e73df&color=ffffff" alt="{{ $review->reviewer_name }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-center">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $review->reviewer_name }}</h4>
                                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="mt-1 flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $review->status == 'approved' ? 'green' : ($review->status == 'pending' ? 'yellow' : 'red') }}-100 text-{{ $review->status == 'approved' ? 'green' : ($review->status == 'pending' ? 'yellow' : 'red') }}-800">
                                                {{ ucfirst($review->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <h5 class="text-sm font-medium text-gray-900">{{ $review->title }}</h5>
                                    <p class="mt-1 text-sm text-gray-500">{{ Str::limit($review->content, 100) }}</p>
                                    <div class="mt-1 text-xs text-gray-500">Product: <a href="{{ route('products.show', $review->product_id) }}" class="text-blue-600 hover:text-blue-500">{{ $review->product->name }}</a></div>
                                </div>
                                <div class="mt-3 flex justify-end space-x-2">
                                    <a href="{{ route('reviews.show', $review->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('reviews.edit', $review->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-sm text-blue-700">
                                    No reviews found yet.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('reviews.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    View All Reviews
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mb-8">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                <a href="{{ route('audits.index') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View All Audits
                </a>
            </div>
            <div class="p-6">
                @if(count($recentAudits) > 0)
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($recentAudits as $audit)
                                <li>
                                    <div class="relative pb-8">
                                            <div>
                                                <div class="flex items-center space-x-2">
                                                    <h4 class="text-sm font-medium text-gray-900">
                                                        {{ ucfirst($audit->event) }} {{ class_basename($audit->auditable_type) }}
                                                    </h4>
                                                    <span class="text-xs text-gray-500">{{ $audit->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-500">
                                                    @if($audit->auditable)
                                                        @if(method_exists($audit->auditable, 'getNameAttribute'))
                                                            {{ $audit->auditable->name }}
                                                        @elseif(property_exists($audit->auditable, 'name'))
                                                            {{ $audit->auditable->name }}
                                                        @elseif(property_exists($audit->auditable, 'title'))
                                                            {{ $audit->auditable->title }}
                                                        @endif
                                                    @endif
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <div class="flex items-center space-x-2">
                                                        <h4 class="text-sm font-medium text-gray-900">
                                                            {{ ucfirst($audit->event) }} {{ class_basename($audit->auditable_type) }}
                                                        </h4>
                                                        <span class="text-xs text-gray-500">{{ $audit->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="mt-1 text-sm text-gray-500">
                                                        @if($audit->auditable)
                                                            @if(method_exists($audit->auditable, 'getNameAttribute'))
                                                                {{ $audit->auditable->name }}
                                                            @elseif(property_exists($audit->auditable, 'name'))
                                                                {{ $audit->auditable->name }}
                                                            @elseif(property_exists($audit->auditable, 'title'))
                                                                {{ $audit->auditable->title }}
                                                            @else
                                                                ID: {{ $audit->auditable_id }}
                                                            @endif
                                                        @else
                                                            ID: {{ $audit->auditable_id }} (deleted)
                                                        @endif
                                                    </div>
                                                    @if($audit->event == 'updated' && !empty($audit->old_values) && !empty($audit->new_values))
                                                        <div class="mt-2 flex flex-wrap gap-1">
                                                            @foreach($audit->old_values as $key => $value)
                                                                @if(array_key_exists($key, $audit->new_values))
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                                        {{ $key }}
                                                                    </span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <a href="{{ route('audits.show', $audit->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-sm text-blue-700">
                                    No audit logs found yet.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
