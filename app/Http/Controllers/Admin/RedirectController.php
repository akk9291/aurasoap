<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index()
    {
        $redirects = Redirect::orderBy('id', 'desc')->get();
        return view('admin.redirects.index', compact('redirects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'old_url' => 'required|string|unique:redirects,old_url',
            'new_url' => 'required|string',
            'status_code' => 'required|in:301,302',
        ]);

        $validated['is_active'] = $request->has('is_active');
        Redirect::create($validated);

        return redirect()->back()->with('success', 'URL redirect rule added successfully.');
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        return redirect()->back()->with('success', 'Redirect rule deleted successfully.');
    }
}
