<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $validated['email']],
            ['name' => $validated['name'] ?? null, 'status' => 'active', 'source' => 'website_footer']
        );

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Thank you for subscribing to Aura Soaps newsletter!']);
        }

        return redirect()->back()->with('success', 'Thank you for subscribing to Aura Soaps newsletter!');
    }
}
