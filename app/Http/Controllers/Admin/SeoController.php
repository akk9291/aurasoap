<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $seoMetas = SeoMeta::paginate(15);
        return view('admin.seo.index', compact('seoMetas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_route' => 'required|string|unique:seo_metas,page_route',
            'title' => 'required|string|max:255',
            'meta_description' => 'nullable|string',
            'focus_keyword' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'robots' => 'nullable|string',
            'og_title' => 'nullable|string',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|string',
        ]);

        SeoMeta::create($validated);

        return redirect()->back()->with('success', 'SEO metadata created successfully.');
    }

    public function update(Request $request, SeoMeta $seo)
    {
        $validated = $request->validate([
            'page_route' => 'required|string|unique:seo_metas,page_route,' . $seo->id,
            'title' => 'required|string|max:255',
            'meta_description' => 'nullable|string',
            'focus_keyword' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'robots' => 'nullable|string',
            'og_title' => 'nullable|string',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|string',
        ]);

        $seo->update($validated);

        return redirect()->back()->with('success', 'SEO metadata updated successfully.');
    }

    public function destroy(SeoMeta $seo)
    {
        $seo->delete();
        return redirect()->back()->with('success', 'SEO metadata deleted successfully.');
    }
}
