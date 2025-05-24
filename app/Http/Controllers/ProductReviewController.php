<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = ProductReview::with(['product', 'user']);
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Sorting functionality
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        // Filter by product
        if ($request->has('product_id') && $request->input('product_id') !== '') {
            $query->where('product_id', $request->input('product_id'));
        }
        
        // Filter by rating
        if ($request->has('rating') && $request->input('rating') !== '') {
            $query->where('rating', $request->input('rating'));
        }
        
        // Filter by verification status
        if ($request->has('is_verified')) {
            $isVerified = $request->input('is_verified');
            if ($isVerified !== '') {
                $query->where('is_verified', $isVerified);
            }
        }
        
        $reviews = $query->paginate(10);
        $products = Product::all();
        
        return view('reviews.index', compact('reviews', 'products'));
    }
    
    /**
     * Show the form for creating a new review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $productId = $request->input('product_id');
        $product = null;
        
        if ($productId) {
            $product = Product::find($productId);
        }
        
        $products = Product::all();
        
        return view('reviews.create', compact('products', 'product'));
    }
    
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'attachment' => 'nullable|file|mimes:pdf|min:100|max:500',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('reviews.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        $reviewData = [
            'product_id' => $request->input('product_id'),
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_verified' => false,
            'additional_data' => $request->input('additional_data', []),
        ];
        
        // Handle attachment upload
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('reviews/attachments', $fileName, 'public');
            $reviewData['attachment'] = $filePath;
        }
        
        $review = ProductReview::create($reviewData);
        
        return redirect()->route('reviews.index')
            ->with('success', 'Review created successfully.');
    }
    
    /**
     * Display the specified review.
     *
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\View\View
     */
    public function show(ProductReview $review)
    {
        $review->load(['product', 'user']);
        return view('reviews.show', compact('review'));
    }
    
    /**
     * Show the form for editing the specified review.
     *
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\View\View
     */
    public function edit(ProductReview $review)
    {
        $products = Product::all();
        return view('reviews.edit', compact('review', 'products'));
    }
    
    /**
     * Update the specified review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ProductReview $review)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_verified' => 'boolean',
            'attachment' => 'nullable|file|mimes:pdf|min:100|max:500',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('reviews.edit', $review)
                ->withErrors($validator)
                ->withInput();
        }
        
        $reviewData = [
            'product_id' => $request->input('product_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_verified' => $request->input('is_verified', false),
            'additional_data' => $request->input('additional_data', []),
        ];
        
        // Set verified_at timestamp if review is being verified
        if ($request->input('is_verified') && !$review->is_verified) {
            $reviewData['verified_at'] = now();
        } elseif (!$request->input('is_verified')) {
            $reviewData['verified_at'] = null;
        }
        
        // Handle attachment upload
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            // Delete old attachment if exists
            if ($review->attachment) {
                Storage::disk('public')->delete($review->attachment);
            }
            
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('reviews/attachments', $fileName, 'public');
            $reviewData['attachment'] = $filePath;
        }
        
        $review->update($reviewData);
        
        return redirect()->route('reviews.index')
            ->with('success', 'Review updated successfully.');
    }
    
    /**
     * Remove the specified review from storage.
     *
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProductReview $review)
    {
        // Delete attachment if exists
        if ($review->attachment) {
            Storage::disk('public')->delete($review->attachment);
        }
        
        $review->delete();
        
        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
