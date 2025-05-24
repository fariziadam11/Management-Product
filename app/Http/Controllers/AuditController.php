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
            $auditableType = $this->getAuditableType($request->input('auditable_type'));
            $query->where('auditable_type', $auditableType);
        }
        
        // Filter by event type
        if ($request->has('event') && $request->input('event') !== '') {
            $query->where('event', $request->input('event'));
        }
        
        // Filter by user
        if ($request->has('user_id') && $request->input('user_id') !== '') {
            $query->where('user_id', $request->input('user_id'));
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
        switch ($type) {
            case 'roles':
                return Role::class;
            case 'users':
                return User::class;
            case 'categories':
                return Category::class;
            case 'products':
                return Product::class;
            case 'reviews':
                return ProductReview::class;
            default:
                return null;
        }
    }
}
