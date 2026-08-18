<?php

namespace App\Http\Controllers;

use App\Models\DistributorApplication;
use App\Services\SeoService;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $seo = SeoService::getMeta('become-a-distributor');
        return view('pages.distributor', compact('seo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'estimated_order_volume' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = substr($request->userAgent(), 0, 500);

        DistributorApplication::create($validated);

        return redirect()->back()->with('success', 'Thank you! Your distributor application has been submitted successfully. Our global sales team will contact you shortly.');
    }
}
