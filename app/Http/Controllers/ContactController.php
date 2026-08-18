<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $seo = SeoService::getMeta('contact');
        return view('pages.contact', compact('seo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = substr($request->userAgent(), 0, 500);

        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent successfully! We will get back to you as soon as possible.');
    }
}
