<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('agent.login')->with('error', 'Please log in to access the Principal Agent Portal.');
        }

        $user = auth()->user();

        if (!$user->isAgent()) {
            abort(403, 'Unauthorized. This portal is strictly for approved Aura Soaps Principal Agents.');
        }

        $profile = $user->agentProfile;

        if (!$profile) {
            abort(403, 'Agent profile not found.');
        }

        if ($profile->application_status === 'pending' || $profile->application_status === 'under_review') {
            // Allow access only to the pending status info page or logout
            if (!$request->routeIs('agent.pending-status') && !$request->routeIs('agent.logout')) {
                return redirect()->route('agent.pending-status');
            }
        } elseif ($profile->application_status === 'suspended') {
            auth()->logout();
            return redirect()->route('agent.login')->with('error', 'Your Agent account has been suspended. Please contact Aura Soaps Management.');
        } elseif ($profile->application_status === 'rejected') {
            auth()->logout();
            return redirect()->route('agent.login')->with('error', 'Your Agent application was rejected. Please contact Aura Soaps Management for further inquiries.');
        }

        return $next($request);
    }
}
