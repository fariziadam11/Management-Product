@extends('layouts.app')

@section('page_heading', 'Edit Review')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Edit Review #{{ $review->id }}</h3>
                <div class="mt-2 sm:mt-0">
                    <a href="{{ route('reviews.show', $review) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Review
                    </a>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <!-- Product Information -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            @if($review->product && $review->product->image)
                                <img src="{{ asset('storage/' . $review->product->image) }}" alt="{{ $review->product->name }}" class="h-20 w-20 rounded-md object-cover">
                            @else
                                <div class="h-20 w-20 rounded-md bg-gray-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">
                                <a href="{{ route('products.show', $review->product_id) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $review->product ? $review->product->name : 'Unknown Product' }}
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <form action="{{ route('reviews.update', $review) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Product Selection -->
                    <div class="mb-4">
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                        <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('product_id') border-red-300 text-red-900 @enderror" id="product_id" name="product_id" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $review->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <div class="mt-1">
                            <div class="flex items-center space-x-2">
                                @for($i = 5; $i >= 1; $i--)
                                    <div class="flex items-center">
                                        <input class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-gray-300" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'checked' : '' }} required>
                                        <label for="rating{{ $i }}" class="ml-1">
                                            <div class="flex">
                                                @for($j = 1; $j <= $i; $j++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $j <= old('rating', $review->rating) ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        @error('rating')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('title') border-red-300 text-red-900 @enderror" id="title" name="title" value="{{ old('title', $review->title) }}" required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Review</label>
                        <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('content') border-red-300 text-red-900 @enderror" id="content" name="content" rows="5" required>{{ old('content', $review->content) }}</textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reviewer Name -->
                    <div class="mb-4">
                        <label for="reviewer_name" class="block text-sm font-medium text-gray-700 mb-1">Reviewer Name</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('reviewer_name') border-red-300 text-red-900 @enderror" id="reviewer_name" name="reviewer_name" value="{{ old('reviewer_name', $review->reviewer_name) }}" required>
                        @error('reviewer_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reviewer Email -->
                    <div class="mb-4">
                        <label for="reviewer_email" class="block text-sm font-medium text-gray-700 mb-1">Reviewer Email</label>
                        <input type="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('reviewer_email') border-red-300 text-red-900 @enderror" id="reviewer_email" name="reviewer_email" value="{{ old('reviewer_email', $review->reviewer_email) }}">
                        @error('reviewer_email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('status') border-red-300 text-red-900 @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', $review->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attachment -->
                    <div class="mb-6">
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
                        @if($review->attachment)
                            <div class="mb-2">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <a href="{{ asset('storage/' . $review->attachment) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                                            Current Attachment
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="remove_attachment" name="remove_attachment" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="remove_attachment" class="ml-2 block text-sm text-gray-700">
                                    Remove current attachment
                                </label>
                            </div>
                        @endif
                        <input type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" id="attachment" name="attachment">
                        <p class="mt-1 text-sm text-gray-500">Upload a new attachment (PDF only, max 500KB)</p>
                        @error('attachment')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('reviews.show', $review) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Review
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
        // Rating input interaction
        const ratingInputs = document.querySelectorAll('input[name="rating"]');

        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                const selectedRating = parseInt(this.value);
                const allStars = document.querySelectorAll('[id^="rating"]');

                allStars.forEach(star => {
                    const starRating = parseInt(star.id.replace('rating', ''));
                    const starsContainer = star.nextElementSibling.querySelectorAll('svg');

                    starsContainer.forEach((svg, index) => {
                        if (index < selectedRating) {
                            svg.classList.remove('text-gray-300');
                            svg.classList.add('text-yellow-400');
                        } else {
                            svg.classList.remove('text-yellow-400');
                            svg.classList.add('text-gray-300');
                        }
                    });
                });
            });
        });
    });
</script>
@endpush
@endsection
