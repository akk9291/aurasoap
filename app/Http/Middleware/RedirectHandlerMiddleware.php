<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectHandlerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = '/' . ltrim($request->path(), '/');

        $redirect = Redirect::where('old_url', $path)->where('is_active', true)->first();

        if ($redirect) {
            return redirect($redirect->new_url, $redirect->status_code);
        }

        return $next($request);
    }
}
