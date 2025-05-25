@extends('layouts.app')

@section('page_heading', 'Import Data')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
    <div class="flex flex-col">
        <div class="w-full lg:w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <h6 class="text-base sm:text-lg font-semibold text-blue-600">Import {{ ucfirst($type) }}</h6>
                    <div>
                        <a href="{{ route($type . '.index') }}" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 border border-blue-600 text-blue-600 bg-white hover:bg-blue-50 rounded-md text-sm transition-colors duration-150 ease-in-out">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back to {{ ucfirst($type) }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('import.process', ['type' => $type]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        
                        <!-- Hidden fields for import -->
                        @if($type == 'users')
                            <input type="hidden" name="fields[]" value="name">
                            <input type="hidden" name="fields[]" value="email">
                            <input type="hidden" name="fields[]" value="role_id">
                            <input type="hidden" name="fields[]" value="is_active">
                        @elseif($type == 'products')
                            <input type="hidden" name="fields[]" value="name">
                            <input type="hidden" name="fields[]" value="category_id">
                            <input type="hidden" name="fields[]" value="price">
                            <input type="hidden" name="fields[]" value="stock">
                            <input type="hidden" name="fields[]" value="description">
                            <input type="hidden" name="fields[]" value="is_featured">
                        @elseif($type == 'categories')
                            <input type="hidden" name="fields[]" value="name">
                            <input type="hidden" name="fields[]" value="description">
                            <input type="hidden" name="fields[]" value="is_active">
                        @elseif($type == 'reviews')
                            <input type="hidden" name="fields[]" value="product_id">
                            <input type="hidden" name="fields[]" value="user_id">
                            <input type="hidden" name="fields[]" value="rating">
                            <input type="hidden" name="fields[]" value="title">
                            <input type="hidden" name="fields[]" value="content">
                            <input type="hidden" name="fields[]" value="is_verified">
                        @elseif($type == 'roles')
                            <input type="hidden" name="fields[]" value="name">
                            <input type="hidden" name="fields[]" value="description">
                            <input type="hidden" name="fields[]" value="is_active">
                        @endif

                        <!-- Upload File -->
                        <div class="mb-4 sm:mb-6">
                            <label for="import_file" class="block text-sm font-medium text-gray-700 mb-1">Upload File</label>
                            <div class="flex">
                                <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none @error('import_file') border-red-500 @enderror" id="import_file" name="import_file" required>
                                <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Supported formats: CSV, Excel (XLSX)</p>
                            @error('import_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Import Options -->
                        <div class="mb-4 sm:mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Import Options</label>
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                <div class="p-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="col-span-1">
                                            <div class="flex items-start mb-2">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="options[header_row]" id="option_header" value="1" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="option_header" class="font-medium text-gray-700">File contains header row</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <div class="flex items-start mb-2">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="options[update_existing]" id="option_update" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="option_update" class="font-medium text-gray-700">Update existing records</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <div class="flex items-start mb-2">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="options[skip_validation]" id="option_skip" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="option_skip" class="font-medium text-gray-700">Skip validation (not recommended)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <div class="flex items-start mb-2">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="options[dry_run]" id="option_dry" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="option_dry" class="font-medium text-gray-700">Dry run (validate without importing)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column Mapping -->
                        <div class="mb-4 sm:mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Column Mapping</label>
                            <div class="p-4 rounded-md bg-blue-50 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1 md:flex md:justify-between">
                                        <p class="text-sm text-blue-700">Column mapping will be automatically detected based on the file headers. You can adjust the mapping after uploading.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-x-auto -mx-4 sm:-mx-0">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/5">File Column</th>
                                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/5">Database Field</th>
                                            <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Required</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($type == 'users')
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[name]" value="name" placeholder="Column name in file"></td>
                                                <td>Name</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr class="bg-white hover:bg-gray-50">
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <input type="text" class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" name="mapping[email]" value="email" placeholder="Column name in file">
                                                </td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-700">Email</td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Required</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <input type="text" class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" name="mapping[role_id]" value="role_id" placeholder="Column name in file">
                                                </td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-700">Role</td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Required</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <input type="text" class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" name="mapping[is_active]" value="is_active" placeholder="Column name in file">
                                                </td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-700">Active Status</td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary text-gray-700">Optional</span>
                                                </td>
                                            </tr>
                                        @elseif($type == 'products')
                                            <tr>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <input type="text" class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" name="mapping[name]" value="name" placeholder="Column name in file">
                                                </td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-700">Name</td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Required</span>
                                                </td>
                                            </tr>
                                            <tr class="bg-white hover:bg-gray-50">
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <input type="text" class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" name="mapping[category_id]" value="category_id" placeholder="Column name in file">
                                                </td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-700">Category</td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Required</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <input type="text" class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" name="mapping[price]" value="price" placeholder="Column name in file">
                                                </td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-700">Price</td>
                                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Required</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[stock]" value="stock" placeholder="Column name in file"></td>
                                                <td>Stock</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[description]" value="description" placeholder="Column name in file"></td>
                                                <td>Description</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[is_featured]" value="is_featured" placeholder="Column name in file"></td>
                                                <td>Featured Status</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                        @elseif($type == 'categories')
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[name]" value="name" placeholder="Column name in file"></td>
                                                <td>Name</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[description]" value="description" placeholder="Column name in file"></td>
                                                <td>Description</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[uuid]" value="uuid" placeholder="Column name in file"></td>
                                                <td>UUID</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[is_active]" value="is_active" placeholder="Column name in file"></td>
                                                <td>Active Status</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                        @elseif($type == 'reviews')
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[product_id]" value="product_id" placeholder="Column name in file"></td>
                                                <td>Product</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[user_id]" value="user_id" placeholder="Column name in file"></td>
                                                <td>User</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[rating]" value="rating" placeholder="Column name in file"></td>
                                                <td>Rating</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[title]" value="title" placeholder="Column name in file"></td>
                                                <td>Title</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[content]" value="content" placeholder="Column name in file"></td>
                                                <td>Content</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[reviewer_name]" value="reviewer_name" placeholder="Column name in file"></td>
                                                <td>Reviewer Name</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[reviewer_email]" value="reviewer_email" placeholder="Column name in file"></td>
                                                <td>Reviewer Email</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[status]" value="status" placeholder="Column name in file"></td>
                                                <td>Status</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route($type . '.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Import Data
                            </button>
                    </form>
                </div>
            </div>

            <!-- Previous Imports -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6 md:w-1/2 xl:w-1/3">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h6 class="text-base sm:text-lg font-semibold text-blue-600">Previous Imports</h6>
                </div>
                <div class="p-4 sm:p-6">
                    @if(count($previousImports) > 0)
                        <div class="overflow-x-auto -mx-4 sm:-mx-0">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Records</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($previousImports as $import)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ $import->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ ucfirst($import->type) }}</td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ $import->filename }}</td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <div class="text-xs sm:text-sm text-gray-700">Processed: {{ number_format($import->processed_count) }}</div>
                                                <div class="text-xs text-green-600">Success: {{ number_format($import->success_count) }}</div>
                                                <div class="text-xs text-red-600">Failed: {{ number_format($import->error_count) }}</div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                @if($import->status == 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                                @elseif($import->status == 'processing')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Processing</span>
                                                @elseif($import->status == 'failed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Failed</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($import->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                @if($import->error_log)
                                                    <a href="{{ route('import.download-log', $import->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-red-300 text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        Error Log
                                                    </a>
                                                @endif
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
                                    <p class="text-sm text-blue-700">No import history found.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sample Template -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h6 class="text-base sm:text-lg font-semibold text-blue-600">Download Sample Template</h6>
                </div>
                <div class="p-4 sm:p-6">
                    <p class="text-sm text-gray-700 mb-4">Download a sample template to see the expected format for importing {{ $type }}:</p>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <a href="{{ route('import.sample-template', ['type' => $type, 'format' => 'csv']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-green-500 shadow-sm text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            CSV Template
                        </a>
                        <a href="{{ route('import.sample-template', ['type' => $type, 'format' => 'xlsx']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-blue-500 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Excel Template
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
