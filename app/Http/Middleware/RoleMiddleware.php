<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }
            return redirect()->route('login');
        }

        $roles = explode('|', $role);
        $hasRole = false;

        foreach ($roles as $roleName) {
            if ($request->user()->hasRole($roleName)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'You do not have the required role to perform this action.'], 403);
            }
            return redirect()->back()->with('error', 'You do not have the required role to perform this action.');
        }

        // Get the current route name
        $routeName = $request->route()->getName();

        // Extract the permission from route name (e.g., 'users.index' -> 'users.view')
        $permission = str_replace(['index', 'show'], 'view', $routeName);
        $permission = str_replace(['create', 'store'], 'create', $permission);
        $permission = str_replace(['edit', 'update'], 'edit', $permission);
        $permission = str_replace('destroy', 'delete', $permission);

        // Check if user has the required permission
        if (!$request->user()->hasPermission($permission)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'You do not have permission to perform this action.'], 403);
            }
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
