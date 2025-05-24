<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Export audits to Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AuditExport([
            'id', 'user_id', 'event', 'auditable_type', 'auditable_id', 'old_values', 'new_values', 'created_at'
        ]), 'audits_' . date('Y-m-d') . '.xlsx');
    }
    /**
     * Display a listing of the audits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Audit::with('user');
        
        // Filter by auditable type
        if ($request->has('auditable_type') && $request->input('auditable_type') !== '') {
            $type = $request->input('auditable_type');
            
            // Map simple type names to their corresponding model classes
            $typeMap = [
                'user' => User::class,
                'role' => Role::class,
                'category' => Category::class,
                'product' => Product::class,
                'product_review' => ProductReview::class,
            ];
            
            if (isset($typeMap[$type])) {
                $query->where('auditable_type', $typeMap[$type]);
            }
        }
        
        // Filter by event type
        if ($request->has('event') && $request->input('event') !== '') {
            $query->where('event', $request->input('event'));
        }
        
        // Filter by user
        if ($request->has('user_id') && $request->input('user_id') !== '') {
            $userId = $request->input('user_id');
            // For polymorphic relationships, we need to specify both user_id and user_type
            $query->where(function($q) use ($userId) {
                $q->where('user_id', (int)$userId)
                  ->where('user_type', 'App\\Models\\User');
            });
        }
        
        // Filter by date range
        if ($request->has('from_date') && $request->input('from_date') !== '') {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }
        
        if ($request->has('to_date') && $request->input('to_date') !== '') {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }
        
        // Sorting
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $audits = $query->paginate(20);
        $users = User::all();
        
        return view('audits.index', compact('audits', 'users'));
    }
    
    /**
     * Display the specified audit.
     *
     * @param  \App\Models\Audit  $audit
     * @return \Illuminate\View\View
     */
    public function show(Audit $audit)
    {
        return view('audits.show', compact('audit'));
    }
    
    /**
     * Display audits for a specific model.
     *
     * @param  string  $type
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showForModel($type, $id)
    {
        $auditableType = $this->getAuditableType($type);
        $model = null;
        $modelName = null;
        
        // Get the model instance based on type
        switch ($type) {
            case 'roles':
                $model = Role::findOrFail($id);
                $modelName = 'Role: ' . $model->name;
                break;
            case 'users':
                $model = User::findOrFail($id);
                $modelName = 'User: ' . $model->name;
                break;
            case 'categories':
                $model = Category::findOrFail($id);
                $modelName = 'Category: ' . $model->name;
                break;
            case 'products':
                $model = Product::findOrFail($id);
                $modelName = 'Product: ' . $model->name;
                break;
            case 'reviews':
                $model = ProductReview::findOrFail($id);
                $modelName = 'Review: ' . $model->title;
                break;
            default:
                abort(404);
        }
        
        $audits = Audit::where('auditable_type', $auditableType)
                       ->where('auditable_id', $id)
                       ->with('user')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);
        
        return view('audits.model', compact('audits', 'model', 'modelName', 'type'));
    }
    
    /**
     * Get the full class name for the auditable type.
     *
     * @param  string  $type
     * @return string
     */
    private function getAuditableType($type)
    {
        if (!$type) {
            return null;
        }
        
        switch ($type) {
            case 'role':
            case 'roles':
                return Role::class;
            case 'user':
            case 'users':
                return User::class;
            case 'category':
            case 'categories':
                return Category::class;
            case 'product':
            case 'products':
                return Product::class;
            case 'product_review':
            case 'reviews':
                return ProductReview::class;
            default:
                // Check if it's a valid class name before returning
                if (class_exists($type)) {
                    return $type;
                }
                return null;
        }
    }
}
