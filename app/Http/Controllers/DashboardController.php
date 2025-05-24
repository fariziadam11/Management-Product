<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Auth middleware will be applied in routes
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Gather statistics for dashboard cards
        $stats = [
            'users' => User::count(),
            'categories' => Category::count(),
            'products' => Product::count(),
            'reviews' => ProductReview::count(),
        ];
        
        // Get recent products with their categories
        $recentProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get recent reviews with their products and users
        $recentReviews = ProductReview::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get recent audit logs with their users
        $recentAudits = Audit::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return view('dashboard', compact('stats', 'recentProducts', 'recentReviews', 'recentAudits'));
    }
}
