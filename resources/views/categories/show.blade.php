@extends('layouts.app')

@section('page_heading', 'Category Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Category Header Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->published_at ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $category->published_at ? 'Published' : 'Draft' }}
                    </span>
                    <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-1">Description</h4>
                    <p class="text-sm text-gray-900">{{ $category->description ?: 'No description provided.' }}</p>
                </div>

                @if(!empty($category->metadata))
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-1">Metadata</h4>
                    <pre class="bg-gray-50 p-3 rounded-md text-xs font-mono overflow-x-auto"><code>{{ json_encode($category->metadata, JSON_PRETTY_PRINT) }}</code></pre>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Created</h4>
                        <p class="text-sm text-gray-900">{{ $category->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Last Updated</h4>
                        <p class="text-sm text-gray-900">{{ $category->updated_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Published Date</h4>
                        <p class="text-sm text-gray-900">{{ $category->published_at ? $category->published_at->format('F d, Y \a\t h:i A') : 'Not published (Draft)' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-1">Products in this Category</h4>
                        <p class="text-sm text-gray-900">{{ $category->products()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products in this Category -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h3 class="text-lg font-medium text-gray-900">Products in this Category</h3>
                <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Product
                </a>
            </div>
            <div class="px-6 py-4">
                @if($category->products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 rounded object-cover">
                                        @else
                                            <div class="h-12 w-12 rounded bg-gray-100 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('products.show', $product) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                            {{ $product->name }}
                                        </a>
                                        <div class="text-xs text-gray-500">
                                            SKU: {{ $product->sku ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->reviews_count > 0)
                                            <div class="flex items-center">
                                                <div class="flex mr-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($product->average_rating))
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
                                                <span class="text-xs text-gray-500">({{ $product->reviews_count }})</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-500">No reviews</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="text-yellow-600 hover:text-yellow-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($category->products()->count() > 10)
                        <div class="mt-4 text-center">
                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View All Products in this Category
                            </a>
                        </div>
                    @endif
                @else
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-sm text-blue-700">
                                    No products have been added to this category yet.
                                </p>
                                <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                    <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="whitespace-nowrap font-medium text-blue-700 hover:text-blue-600">
                                        Add your first product <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Category Audit History -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Audit History</h3>
            </div>
            <div class="px-6 py-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changes</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($category->audits()->with('user')->latest()->take(5)->get() as $audit)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($audit->user)
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($audit->user->name) }}&background=4e73df&color=ffffff" alt="{{ $audit->user->name }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $audit->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $audit->user->email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">System</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($audit->event == 'created')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Created</span>
                                    @elseif($audit->event == 'updated')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Updated</span>
                                    @elseif($audit->event == 'deleted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Deleted</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $audit->event }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if(!empty($audit->new_values))
                                        <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="toggleAuditDetails({{ $audit->id }})">
                                            View Changes
                                        </button>
                                        <div id="auditDetails{{ $audit->id }}" class="hidden mt-2 bg-gray-50 p-3 rounded-md">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                                @foreach($audit->new_values as $key => $value)
                                                    <div class="sm:col-span-1">
                                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                                        <dd class="mt-1 text-sm text-gray-900 break-all">
                                                            @if(is_array($value))
                                                                {{ json_encode($value) }}
                                                            @elseif(is_bool($value))
                                                                {{ $value ? 'Yes' : 'No' }}
                                                            @else
                                                                {{ $value }}
                                                            @endif
                                                        </dd>
                                                    </div>
                                                @endforeach
                                            </dl>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">No changes recorded</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $audit->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No audit records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($category->audits()->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('audits.model', ['type' => 'category', 'id' => $category->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View All Audit History
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleAuditDetails(auditId) {
        const details = document.getElementById(`auditDetails${auditId}`);
        details.classList.toggle('hidden');
    }
</script>
@endpush
@endsection
