<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        // Total products and growth
        $totalProducts = Product::count();
        $lastMonthProducts = Product::where('created_at', '<', Carbon::now()->subMonth())->count();
        $productGrowth = $lastMonthProducts > 0 
            ? round(($totalProducts - $lastMonthProducts) / $lastMonthProducts * 100, 1) 
            : 100;

        // Calculate total revenue (using price as a proxy since we don't have actual sales data)
        $totalRevenue = Product::sum('price');
        $lastMonthRevenue = Product::where('created_at', '<', Carbon::now()->subMonth())->sum('price');
        $revenueGrowth = $lastMonthRevenue > 0 
            ? round(($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100, 1) 
            : 100;

        // Average rating
        $averageRating = ProductReview::avg('rating') ?? 0;
        $totalReviews = ProductReview::count();

        // Low stock count
        $lowStockCount = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();

        // Sales chart data (using created_at as a proxy for sales date)
        $salesData = Product::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(price) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesChartData = [
            'labels' => $salesData->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('M d');
            })->toArray(),
            'data' => $salesData->pluck('total')->toArray(),
        ];

        // Category statistics
        $categoryStats = Category::select('categories.name', DB::raw('COUNT(products.id) as count'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->count,
                ];
            })
            ->toArray();

        // Recent activity (using audits table)
        $recentActivity = DB::table('audits')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->select(
                'users.name as user',
                'audits.event as action',
                'audits.auditable_type as item_type',
                'audits.created_at as time'
            )
            ->orderBy('audits.created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                // Extract the model name from the namespace
                $itemType = class_basename($activity->item_type);
                
                return [
                    'user' => $activity->user,
                    'action' => $activity->action,
                    'item' => $itemType,
                    'time' => Carbon::parse($activity->time)->diffForHumans(),
                ];
            })
            ->toArray();

        // Top products (by price as a proxy for popularity)
        $topProducts = Product::with('category')
            ->orderBy('price', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'category' => $product->category->name ?? 'Uncategorized',
                ];
            })
            ->toArray();

        return view('analytics.dashboard', compact(
            'totalProducts',
            'productGrowth',
            'totalRevenue',
            'revenueGrowth',
            'averageRating',
            'totalReviews',
            'lowStockCount',
            'salesChartData',
            'categoryStats',
            'recentActivity',
            'topProducts'
        ));
    }
}
