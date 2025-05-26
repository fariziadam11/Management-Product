@extends('layouts.app')

@section('page_heading', 'Product Details')

@section('content')
<x-tailwind.card>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Product Image -->
        <div class="md:col-span-1">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
            @else
                <div class="w-full h-64 bg-gray-200 rounded-lg shadow-md flex items-center justify-center">
                    <i class="bi bi-image text-gray-400 text-5xl"></i>
                </div>
            @endif

            <div class="mt-4 flex space-x-2">
                <x-tailwind.button href="{{ route('products.edit', $product) }}" variant="primary" icon="pencil">
                    Edit
                </x-tailwind.button>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <x-tailwind.button type="submit" variant="danger" icon="trash"
                        onclick="return confirm('Are you sure you want to delete this product?')">
                        Delete
                    </x-tailwind.button>
                </form>
            </div>
        </div>

        <!-- Product Details -->
        <div class="md:col-span-2">
            <div class="flex flex-col space-y-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                    @if($product->status == 'active')
                        <x-tailwind.badge variant="success">
                            Active
                        </x-tailwind.badge>
                    @elseif($product->status == 'draft')
                        <x-tailwind.badge variant="secondary">
                            Draft
                        </x-tailwind.badge>
                    @else
                        <x-tailwind.badge variant="danger">
                            Inactive
                        </x-tailwind.badge>
                    @endif
                </div>

                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price)
                        <span class="ml-2 text-sm text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                        @php
                            $discount = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                        @endphp
                        <x-tailwind.badge variant="danger" class="ml-2">
                            {{ $discount }}% OFF
                        </x-tailwind.badge>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">SKU</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->sku }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Category</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->category->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Stock</h3>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($product->stock <= 0)
                                    <x-tailwind.badge variant="danger" size="sm">
                                        Out of Stock
                                    </x-tailwind.badge>
                                @elseif($product->stock <= $product->low_stock_threshold)
                                    <x-tailwind.badge variant="warning" size="sm">
                                        Low Stock ({{ $product->stock }})
                                    </x-tailwind.badge>
                                @else
                                    {{ $product->stock }} in stock
                                @endif
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Created</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <div class="mt-2 prose prose-sm text-gray-900">
                        {!! $product->description !!}
                    </div>
                </div>

                @if($product->specifications)
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-medium text-gray-500">Specifications</h3>
                        <div class="mt-2 prose prose-sm text-gray-900">
                            {!! $product->specifications !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-tailwind.card>

<div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
    <div class="px-4 py-3 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-900">Product Information</h2>
    </div>

    <div x-data="{ activeTab: 'description' }" class="px-4 py-4">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'description'"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'description', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'description' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                    Description
                </button>
                <button @click="activeTab = 'specifications'"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'specifications', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'specifications' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                    Specifications
                </button>
                <button @click="activeTab = 'documents'"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'documents', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'documents' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                    Documents
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="py-4">
            <!-- Description Tab -->
            <div x-show="activeTab === 'description'" class="prose prose-sm max-w-none">
                <p class="text-gray-700">{{ $product->description }}</p>

                @if($product->details)
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(json_decode($product->details, true) ?? [] as $key => $value)
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="font-medium text-gray-900">{{ ucfirst($key) }}:</span>
                                <span class="text-gray-700">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Specifications Tab -->
            <div x-show="activeTab === 'specifications'" class="overflow-x-auto" style="display: none;">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Product Name</th>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($product->price, 2) }}</td>
                        </tr>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->stock }}</td>
                        </tr>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->created_at->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->updated_at->format('F d, Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Documents Tab -->
            <div x-show="activeTab === 'documents'" style="display: none;">
                @if($product->document)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Product Documentation</h3>
                        <a href="{{ asset('storage/' . $product->document) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" target="_blank">
                            <i class="bi bi-file-earmark-pdf mr-2"></i> View PDF
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                            <i class="bi bi-file-earmark-x text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">No Documents Available</h3>
                        <p class="mt-1 text-sm text-gray-500">This product doesn't have any documentation attached.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<x-tailwind.card class="mt-6">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">Customer Reviews</h2>
    </x-slot>

    @if($product->reviews->count() > 0)
        <div class="space-y-4">
            @foreach($product->reviews as $review)
                <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($review->user ? $review->user->name : $review->reviewer_name) }}&background=4e73df&color=ffffff&size=100" alt="{{ $review->user ? $review->user->name : $review->reviewer_name }}">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    @if($review->user)
                                        {{ $review->user->name }}
                                        @if($review->user_id === auth()->id())
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">You</span>
                                        @endif
                                    @else
                                        {{ $review->reviewer_name }}
                                    @endif
                                </p>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <p class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                            @auth
                                @if($review->user_id === auth()->id())
                                    <div class="flex gap-2">
                                        <a href="{{ route('reviews.edit', $review) }}" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this review?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="text-sm font-medium text-gray-900">{{ $review->title }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $review->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-6">
            <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
        </div>
    @endif
</x-tailwind.card>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <!-- Related Products Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Related Products</h3>
                </div>
                <div class="p-4">
                    @php
                        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->take(3)
                            ->get();
                    @endphp

                    @if($relatedProducts->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($relatedProducts as $relatedProduct)
                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="block py-3 hover:bg-gray-50 transition-colors duration-150 {{ !$loop->first ? 'pt-3' : '' }}">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($relatedProduct->image)
                                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="h-12 w-12 rounded object-cover">
                                            @else
                                                <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center">
                                                    <i class="bi bi-image text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $relatedProduct->name }}</h4>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">{{ $relatedProduct->category->name }}</span>
                                                <span class="text-sm font-medium text-blue-600">${{ number_format($relatedProduct->price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-4">No related products found.</p>
                    @endif
                </div>
            </div>

            <!-- Write a Review Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Write a Review</h3>
                </div>
                <div class="p-4">
                    @auth
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Rating -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                <div x-data="{ rating: 0 }" class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer p-1">
                                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only" x-on:click="rating = {{ $i }}" required>
                                            <i class="bi" x-bind:class="rating >= {{ $i }} ? 'bi-star-fill text-yellow-400' : 'bi-star text-gray-300'"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" id="title" name="title" required>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Review</label>
                                <textarea class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" id="content" name="content" rows="5" required></textarea>
                            </div>

                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Please <a href="{{ route('login') }}" class="font-medium underline text-blue-700 hover:text-blue-600">login</a> to write a review.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Product Reviews Summary -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Review Summary</h3>
                </div>
                <div class="p-4">
                    @php
                        $avgRating = $product->reviews->avg('rating') ?? 0;
                        $reviewCount = $product->reviews->count();
                        $ratingDistribution = [
                            5 => $product->reviews->where('rating', 5)->count(),
                            4 => $product->reviews->where('rating', 4)->count(),
                            3 => $product->reviews->where('rating', 3)->count(),
                            2 => $product->reviews->where('rating', 2)->count(),
                            1 => $product->reviews->where('rating', 1)->count(),
                        ];
                    @endphp

                    <div class="flex flex-col items-center mb-4">
                        <div class="text-3xl font-bold text-gray-900">{{ number_format($avgRating, 1) }}</div>
                        <div class="flex items-center mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))
                                    <i class="bi bi-star-fill text-yellow-400"></i>
                                @else
                                    <i class="bi bi-star text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="text-sm text-gray-500 mt-1">{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</div>
                    </div>

                    @if($reviewCount > 0)
                        <div class="space-y-2">
                            @foreach($ratingDistribution as $rating => $count)
                                <div class="flex items-center">
                                    <div class="w-8 text-sm text-gray-600">{{ $rating }}★</div>
                                    <div class="flex-1 mx-2">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $reviewCount > 0 ? ($count / $reviewCount) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="w-8 text-sm text-gray-600 text-right">{{ $count }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-2">No reviews yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
