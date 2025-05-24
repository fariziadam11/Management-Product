<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting functionality
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        // Filter by category
        if ($request->has('category_id') && $request->input('category_id') !== '') {
            $query->where('category_id', $request->input('category_id'));
        }
        
        // Filter by featured status
        if ($request->has('is_featured')) {
            $isFeatured = $request->input('is_featured');
            if ($isFeatured !== '') {
                $query->where('is_featured', $isFeatured);
            }
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->input('min_price') !== '') {
            $query->where('price', '>=', $request->input('min_price'));
        }
        
        if ($request->has('max_price') && $request->input('max_price') !== '') {
            $query->where('price', '<=', $request->input('max_price'));
        }
        
        // Filter by availability date
        if ($request->has('available_from') && $request->input('available_from') !== '') {
            $query->where('available_from', '>=', $request->input('available_from'));
        }
        
        $products = $query->withCount('reviews')->paginate(10);
        $categories = Category::where('is_active', true)->get();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('products.create', compact('categories'));
    }
    
    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'specifications' => 'nullable|json',
            'document' => 'nullable|file|mimes:pdf|min:100|max:500',
            'available_from' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('products.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        $productData = [
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'is_featured' => $request->input('is_featured', false),
            'specifications' => $request->input('specifications', []),
            'available_from' => $request->input('available_from'),
        ];
        
        // Handle document upload
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('products/documents', $fileName, 'public');
            $productData['document'] = $filePath;
        }
        
        $product = Product::create($productData);
        
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }
    
    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user']);
        return view('products.show', compact('product'));
    }
    
    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }
    
    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'specifications' => 'nullable|json',
            'document' => 'nullable|file|mimes:pdf|min:100|max:500',
            'available_from' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('products.edit', $product)
                ->withErrors($validator)
                ->withInput();
        }
        
        $productData = [
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'is_featured' => $request->input('is_featured', false),
            'specifications' => $request->input('specifications', []),
            'available_from' => $request->input('available_from'),
        ];
        
        // Handle document upload
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            // Delete old document if exists
            if ($product->document) {
                Storage::disk('public')->delete($product->document);
            }
            
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('products/documents', $fileName, 'public');
            $productData['document'] = $filePath;
        }
        
        $product->update($productData);
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }
    
    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Check if product has reviews before deleting
        if ($product->reviews()->count() > 0) {
            return redirect()->route('products.index')
                ->with('error', 'Cannot delete product with associated reviews.');
        }
        
        // Delete document if exists
        if ($product->document) {
            Storage::disk('public')->delete($product->document);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
