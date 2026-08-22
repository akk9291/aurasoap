<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();

        if ($user->isAgent() && !$user->hasRole(['super-admin', 'admin', 'content-manager', 'seo-manager', 'enquiry-manager'])) {
            abort(403, 'Unauthorized. Principal Agents are not permitted to access the Admin CMS.');
        }

        if (empty($roles)) {
            return $next($request);
        }

        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action for your role.');
    }
}
