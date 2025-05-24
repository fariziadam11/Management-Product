@extends('layouts.app')

@section('page_heading', 'Edit Category')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Edit Category Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Edit Category: {{ $category->name }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="px-6 py-4">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $category->name) }}"
                                required
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                            >{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 flex items-center">
                            <div class="flex items-center h-5">
                                <input
                                    id="is_active"
                                    name="is_active"
                                    type="checkbox"
                                    value="1"
                                    {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                >
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700">Active</label>
                                <p class="text-gray-500">Inactive categories won't appear in product dropdowns</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="metadata" class="block text-sm font-medium text-gray-700 mb-1">
                                Metadata (JSON)
                            </label>
                            <textarea
                                id="metadata"
                                name="metadata"
                                rows="3"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-mono text-sm @error('metadata') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                            >{{ old('metadata', json_encode($category->metadata ?? new stdClass(), JSON_PRETTY_PRINT)) }}</textarea>
                            @error('metadata')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">
                                Publish Date
                            </label>
                            <input
                                type="datetime-local"
                                id="published_at"
                                name="published_at"
                                value="{{ old('published_at', $category->published_at ? $category->published_at->format('Y-m-d\TH:i') : '') }}"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('published_at') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                            >
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Leave empty to save as draft</p>
                        </div>

                        <div class="flex justify-between items-center mt-8 pb-4">
                            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category Usage Information -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Category Usage Information</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Created</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Products in this Category</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $category->products()->count() }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1 flex space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->published_at ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $category->published_at ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($category->products()->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Recent Products in this Category</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($category->products()->latest()->limit(5)->get() as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ${{ number_format($product->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($product->stock > 10)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $product->stock }} in stock
                                                </span>
                                            @elseif($product->stock > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {{ $product->stock }} left
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Out of stock
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($category->products()->count() > 5)
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="text-indigo-600 hover:text-indigo-900">
                                                View all {{ $category->products()->count() }} products
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format the metadata JSON when the form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            const metadataField = document.getElementById('metadata');
            try {
                // Parse and then stringify to format the JSON
                const formattedJson = JSON.stringify(JSON.parse(metadataField.value), null, 2);
                metadataField.value = formattedJson;
            } catch (e) {
                // If it's not valid JSON, leave it as is - validation will catch it
            }
        });
    });
</script>
@endpush
@endsection
