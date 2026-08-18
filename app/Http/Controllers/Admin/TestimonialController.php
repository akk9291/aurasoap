<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:100',
            'profile_image' => 'nullable|string',
            'testimonial' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['status'] = $request->has('status');

        Testimonial::create($validated);

        return redirect()->back()->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:100',
            'profile_image' => 'nullable|string',
            'testimonial' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['status'] = $request->has('status');

        $testimonial->update($validated);

        return redirect()->back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }
}
