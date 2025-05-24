@extends('layouts.app')

@section('page_heading', 'Products')

@section('page_actions')
@if(auth()->user()->hasAnyRole('admin', 'manager', 'editor'))
<a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
    <i class="bi bi-plus-circle mr-2"></i> Add Product
</a>
@endif
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
            <h2 class="text-lg font-medium text-gray-900">Product List</h2>
            <div class="relative rounded-md shadow-sm max-w-xs">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
                <input type="text" id="product-search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Search products...">
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
    <!-- Desktop view (md and above) -->
    <div class="hidden md:block">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($product->image)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="bi bi-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->category->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${{ number_format($product->price, 2) }}</div>
                            @if($product->compare_price)
                                <div class="text-xs text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->stock <= 0)
                                <x-tailwind.badge variant="danger" size="sm">Out of Stock</x-tailwind.badge>
                            @elseif($product->stock <= $product->low_stock_threshold)
                                <x-tailwind.badge variant="warning" size="sm">Low Stock ({{ $product->stock }})</x-tailwind.badge>
                            @else
                                <span class="text-sm text-gray-900">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->status == 'active')
                                <x-tailwind.badge variant="success" size="sm">Active</x-tailwind.badge>
                            @elseif($product->status == 'draft')
                                <x-tailwind.badge variant="secondary" size="sm">Draft</x-tailwind.badge>
                            @else
                                <x-tailwind.badge variant="danger" size="sm">Inactive</x-tailwind.badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('products.show', $product) }}" class="inline-flex items-center px-2.5 py-1.5 border border-blue-600 text-xs font-medium rounded text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="bi bi-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-2.5 py-1.5 border border-indigo-600 text-xs font-medium rounded text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="bi bi-pencil mr-1"></i> Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-red-600 text-xs font-medium rounded text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="bi bi-trash mr-1"></i> Delete
                                    </button>
                                </form>
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
            @foreach($products as $product)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 mr-3">
                                @if($product->image)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="bi bi-box text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-full hover:bg-gray-100">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                <a href="{{ route('products.show', $product) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="bi bi-eye text-blue-600 mr-2"></i> View
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class="bi bi-pencil text-indigo-600 mr-2"></i> Edit
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center" 
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="bi bi-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs mt-3">
                        <div>
                            <span class="text-gray-500">Category:</span>
                            <span class="font-medium text-gray-900">{{ $product->category->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Price:</span>
                            <span class="font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
                            @if($product->compare_price)
                                <span class="text-xs text-gray-500 line-through ml-1">${{ number_format($product->compare_price, 2) }}</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-500">Stock:</span>
                            @if($product->stock <= 0)
                                <x-tailwind.badge variant="danger" size="sm">Out of Stock</x-tailwind.badge>
                            @elseif($product->stock <= $product->low_stock_threshold)
                                <x-tailwind.badge variant="warning" size="sm">Low ({{ $product->stock }})</x-tailwind.badge>
                            @else
                                <span class="font-medium text-gray-900">{{ $product->stock }}</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-500">Status:</span>
                            @if($product->status == 'active')
                                <x-tailwind.badge variant="success" size="sm">Active</x-tailwind.badge>
                            @elseif($product->status == 'draft')
                                <x-tailwind.badge variant="secondary" size="sm">Draft</x-tailwind.badge>
                            @else
                                <x-tailwind.badge variant="danger" size="sm">Inactive</x-tailwind.badge>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-500">Created:</span>
                            <span class="font-medium text-gray-900">{{ $product->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($products->hasPages())
        <div class="px-4 py-5 border-t border-gray-200">
            {{ $products->links('components.tailwind.pagination') }}
        </div>
    @endif
        </div>
    </div>
</div>

<!-- Empty state for when no products exist -->
@if($products->isEmpty())
<div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="p-8 text-center">
        <div class="flex flex-col items-center">
            <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <i class="bi bi-box text-3xl text-blue-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No products found</h3>
            <p class="text-sm text-gray-500 mb-6 max-w-md">There are no products matching your criteria. Try adjusting your filters or add a new product.</p>
            @if(auth()->user()->hasAnyRole('admin', 'manager', 'editor'))
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="bi bi-plus-circle mr-2"></i> Add Product
            </a>
            @endif
        </div>
    </div>
</div>
@endif
@endsection
