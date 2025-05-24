@extends('layouts.app')

@section('page_heading', 'Product Reviews')

@section('content')
<div class="space-y-6">
    <!-- Filters and Search -->
    <div x-data="{showFilters: true}" class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="bi bi-funnel mr-2 text-blue-600"></i>
                <span>Filter Reviews</span>
            </h3>
            <button @click="showFilters = !showFilters" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="bi" :class="showFilters ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
            </button>
        </div>
        <div x-show="showFilters" x-transition class="px-4 py-4 bg-white">
            <form action="{{ route('reviews.index') }}" method="GET" class="space-y-4 md:space-y-0">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 items-center">
                    <div class="lg:col-span-3">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                id="search" name="search" placeholder="Search reviews..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="lg:col-span-2">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="product_id">
                            <option value="">All Products</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="rating">
                            <option value="">All Ratings</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="status">
                            <option value="">All Status</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="sort">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Highest Rating</option>
                            <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Lowest Rating</option>
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

    <!-- Reviews List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-4 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="bi bi-star mr-2 text-blue-600"></i>
                <span>Reviews</span>
            </h3>
            <div class="flex space-x-2">
                <a href="{{ route('export.form', ['type' => 'reviews']) }}" class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-sm font-medium rounded text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="bi bi-download mr-1.5"></i> Export
                </a>
                <a href="{{ route('import.form', ['type' => 'reviews']) }}" class="inline-flex items-center px-3 py-1.5 border border-green-600 text-sm font-medium rounded text-green-600 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <i class="bi bi-upload mr-1.5"></i> Import
                </a>
            </div>
        </div>

        @if($reviews->count() > 0)
            <!-- Desktop view (md and above) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reviews as $review)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($review->product && $review->product->image)
                                            <img src="{{ asset('storage/' . $review->product->image) }}" alt="{{ $review->product->name }}" class="h-10 w-10 rounded-full object-cover flex-shrink-0">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-content-center flex-shrink-0">
                                                <i class="bi bi-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <a href="{{ route('products.show', $review->product_id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                {{ $review->product ? $review->product->name : 'Unknown Product' }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill text-yellow-400"></i>
                                            @else
                                                <i class="bi bi-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <div x-data="{ open: false }" class="space-y-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->title }}</div>
                                            <p class="text-sm text-gray-500 truncate">{{ $review->content }}</p>
                                            <button @click="open = !open" class="text-xs text-blue-600 hover:text-blue-800 focus:outline-none">
                                                {{ __('Read more') }}
                                            </button>
                                            <div x-show="open" x-transition class="mt-2 p-3 bg-gray-50 rounded-md text-sm text-gray-700 border border-gray-200">
                                                {{ $review->content }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-6 w-6 rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer_name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $review->reviewer_name }}">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $review->reviewer_name }}</div>
                                            @if($review->reviewer_email)
                                                <div class="text-xs text-gray-500">{{ $review->reviewer_email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($review->status == 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @elseif($review->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($review->status == 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $review->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('reviews.show', $review) }}" class="inline-flex items-center px-2 py-1 border border-blue-600 text-xs font-medium rounded text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="bi bi-eye mr-1"></i>
                                        </a>
                                        <a href="{{ route('reviews.edit', $review) }}" class="inline-flex items-center px-2 py-1 border border-yellow-600 text-xs font-medium rounded text-yellow-600 hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            <i class="bi bi-pencil mr-1"></i>
                                        </a>
                                        <button type="button"
                                                @click="$dispatch('open-modal', 'delete-modal-{{ $review->id }}')"
                                                class="inline-flex items-center px-2 py-1 border border-red-600 text-xs font-medium rounded text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <i class="bi bi-trash mr-1"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal with Alpine.js -->
                                    <div
                                        x-data="{ open: false }"
                                        @open-modal.window="if ($event.detail === 'delete-modal-{{ $review->id }}') open = true"
                                        @keydown.escape.window="open = false"
                                        x-show="open"
                                        class="fixed inset-0 z-50 overflow-y-auto"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        style="display: none;"
                                    >
                                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div
                                                x-show="open"
                                                x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"
                                                @click="open = false"
                                                class="fixed inset-0 transition-opacity"
                                                aria-hidden="true"
                                            >
                                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                            </div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div
                                                x-show="open"
                                                x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                @click.away="open = false"
                                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                                role="dialog"
                                                aria-modal="true"
                                                aria-labelledby="modal-headline"
                                            >
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                            <i class="bi bi-exclamation-triangle text-red-600"></i>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                                                Confirm Delete
                                                            </h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500">
                                                                    Are you sure you want to delete this review? This action cannot be undone.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                    <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile view (sm and below) -->
                <div class="block md:hidden">
                    <div class="divide-y divide-gray-200">
                        @foreach($reviews as $review)
                            <div class="p-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        @if($review->product && $review->product->image)
                                            <img src="{{ asset('storage/' . $review->product->image) }}" alt="{{ $review->product->name }}" class="h-10 w-10 rounded-full object-cover flex-shrink-0">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-content-center flex-shrink-0">
                                                <i class="bi bi-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <a href="{{ route('products.show', $review->product_id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                {{ $review->product ? $review->product->name : 'Unknown Product' }}
                                            </a>
                                            <div class="flex mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="bi bi-star-fill text-yellow-400 text-xs"></i>
                                                    @else
                                                        <i class="bi bi-star text-gray-300 text-xs"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-full hover:bg-gray-100">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                            <a href="{{ route('reviews.show', $review) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <i class="bi bi-eye text-blue-600 mr-2"></i> View
                                            </a>
                                            <a href="{{ route('reviews.edit', $review) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <i class="bi bi-pencil text-yellow-600 mr-2"></i> Edit
                                            </a>
                                            <div class="border-t border-gray-100 my-1"></div>
                                            <button @click="$dispatch('open-modal', 'delete-modal-{{ $review->id }}'); open = false" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center">
                                                <i class="bi bi-trash mr-2"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $review->title }}</div>
                                    <div x-data="{ expanded: false }" class="mt-1">
                                        <p class="text-sm text-gray-500" :class="{ 'line-clamp-2': !expanded }">
                                            {{ $review->content }}
                                        </p>
                                        <button @click="expanded = !expanded" class="text-xs text-blue-600 hover:text-blue-800 focus:outline-none mt-1">
                                            {{ __('Read ') }} <span x-text="expanded ? 'less' : 'more'"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs mt-3">
                                    <div>
                                        <span class="text-gray-500">Reviewer:</span>
                                        <span class="font-medium text-gray-900">{{ $review->reviewer_name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Status:</span>
                                        @if($review->status == 'approved')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                        @elseif($review->status == 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($review->status == 'rejected')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </div>
                                    <div class="col-span-2">
                                        <span class="text-gray-500">Date:</span>
                                        <span class="font-medium text-gray-900">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-5 border-t border-gray-200">
                    {{ $reviews->appends(request()->query())->links('components.tailwind.pagination') }}
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="flex flex-col items-center">
                        <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <i class="bi bi-star text-3xl text-blue-600"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No reviews found</h3>
                        <p class="text-sm text-gray-500 mb-6 max-w-md">There are no reviews matching your criteria. Try adjusting your filters or check back later.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('chart_content')
<!-- Review Statistics -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Review Distribution</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="reviewDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rating Summary</h6>
            </div>
            <div class="card-body">
                <div class="row align-items-center mb-4">
                    <div class="col-md-4 text-center">
                        @php
                            $averageRating = $reviews->avg('rating') ?? 0;
                            $averageRating = round($averageRating * 2) / 2; // Round to nearest 0.5

                            // Calculate rating counts
                            $ratingCounts = [
                                5 => $reviews->where('rating', 5)->count(),
                                4 => $reviews->where('rating', 4)->count(),
                                3 => $reviews->where('rating', 3)->count(),
                                2 => $reviews->where('rating', 2)->count(),
                                1 => $reviews->where('rating', 1)->count(),
                            ];

                            // Calculate rating percentages
                            $ratingPercentages = [];
                            $totalReviews = $reviews->count();
                            if ($totalReviews > 0) {
                                foreach ($ratingCounts as $rating => $count) {
                                    $ratingPercentages[$rating] = ($count / $totalReviews) * 100;
                                }
                            }

                            // Prepare chart data
                            $reviewChartData = [
                                'labels' => [],
                                'data' => []
                            ];

                            // Get the last 7 days for the chart
                            for ($i = 6; $i >= 0; $i--) {
                                $date = now()->subDays($i)->format('M d');
                                $reviewChartData['labels'][] = $date;

                                // Count reviews for this date
                                $dayCount = $reviews->filter(function($review) use ($i) {
                                    $dateToCheck = now()->subDays($i)->startOfDay();
                                    return $review->created_at->startOfDay()->equalTo($dateToCheck);
                                })->count();

                                $reviewChartData['data'][] = $dayCount;
                            }
                        @endphp
                        <div class="display-4 fw-bold text-primary">{{ number_format($averageRating, 1) }}</div>
                        <div class="d-flex justify-content-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($averageRating))
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        @php
                            $totalReviews = $reviews->total() ?? count($reviews);
                        @endphp
                        <div class="text-muted mt-1">{{ $totalReviews }} reviews</div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">5</span>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="flex-grow-1 mx-3">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $ratingPercentages[5] ?? 0 }}%" aria-valuenow="{{ $ratingPercentages[5] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <span>{{ $ratingCounts[5] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">4</span>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="flex-grow-1 mx-3">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $ratingPercentages[4] ?? 0 }}%" aria-valuenow="{{ $ratingPercentages[4] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <span>{{ $ratingCounts[4] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">3</span>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="flex-grow-1 mx-3">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $ratingPercentages[3] ?? 0 }}%" aria-valuenow="{{ $ratingPercentages[3] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <span>{{ $ratingCounts[3] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">2</span>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="flex-grow-1 mx-3">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $ratingPercentages[2] ?? 0 }}%" aria-valuenow="{{ $ratingPercentages[2] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <span>{{ $ratingCounts[2] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">1</span>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="flex-grow-1 mx-3">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $ratingPercentages[1] ?? 0 }}%" aria-valuenow="{{ $ratingPercentages[1] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <span>{{ $ratingCounts[1] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Review Distribution Chart
        var ctx = document.getElementById('reviewDistributionChart').getContext('2d');
        var reviewChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($reviewChartData['labels']) !!},
                datasets: [
                    {
                        label: 'Reviews',
                        data: {!! json_encode($reviewChartData['data']) !!},
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointBorderColor: 'rgba(78, 115, 223, 1)',
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    },
                    y: {
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            beginAtZero: true,
                            precision: 0
                        },
                        grid: {
                            color: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyColor: "#858796",
                        titleMarginBottom: 10,
                        titleColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false
                    }
                }
            }
        });
    });
</script>
@endpush
