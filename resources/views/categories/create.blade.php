@extends('layouts.app')

@section('page_heading', 'Create Category')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Category Information</h3>
            </div>

            <div class="px-6 py-4">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
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
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Provide a brief description of this category</p>
                    </div>

                    <div class="mb-6 flex items-center">
                        <div class="flex items-center h-5">
                            <input
                                id="is_active"
                                name="is_active"
                                type="checkbox"
                                value="1"
                                {{ old('is_active', '1') == '1' ? 'checked' : '' }}
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
                        >{{ old('metadata', '{}') }}</textarea>
                        @error('metadata')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Optional JSON metadata for this category</p>
                    </div>

                    <div class="mb-6">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">
                            Publish Date
                        </label>
                        <input
                            type="datetime-local"
                            id="published_at"
                            name="published_at"
                            value="{{ old('published_at') }}"
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
                            Create Category
                        </button>
                    </div>
                </form>
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
