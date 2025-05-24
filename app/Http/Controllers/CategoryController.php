<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Category::query();
        
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
        
        // Filter by active status
        if ($request->has('is_active')) {
            $isActive = $request->input('is_active');
            if ($isActive !== '') {
                $query->where('is_active', $isActive);
            }
        }
        
        // Filter by published status
        if ($request->has('published')) {
            $published = $request->input('published');
            if ($published === '1') {
                $query->whereNotNull('published_at');
            } elseif ($published === '0') {
                $query->whereNull('published_at');
            }
        }
        
        $categories = $query->withCount('products')->paginate(10);
        
        return view('categories.index', compact('categories'));
    }
    
    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('categories.create');
    }
    
    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'metadata' => 'nullable|json',
            'published_at' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('categories.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        $category = Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active', true),
            'metadata' => $request->input('metadata', []),
            'published_at' => $request->input('published_at'),
        ]);
        
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }
    
    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->withCount('reviews');
        }]);
        
        return view('categories.show', compact('category'));
    }
    
    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    
    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'metadata' => 'nullable|json',
            'published_at' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('categories.edit', $category)
                ->withErrors($validator)
                ->withInput();
        }
        
        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active', true),
            'metadata' => $request->input('metadata', []),
            'published_at' => $request->input('published_at'),
        ]);
        
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }
    
    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        // Check if category has products before deleting
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with associated products.');
        }
        
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
