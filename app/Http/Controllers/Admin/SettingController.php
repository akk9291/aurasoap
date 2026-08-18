<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $seoMetas = SeoMeta::all()->keyBy('page_route');
        
        return view('admin.settings.index', compact('settings', 'seoMetas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'site_favicon_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,ico,svg|max:2048',
        ]);

        // Process SEO metas if provided
        if ($request->has('seo') && is_array($request->seo)) {
            foreach ($request->seo as $pageRoute => $seoData) {
                SeoMeta::updateOrCreate(
                    ['page_route' => $pageRoute],
                    [
                        'title' => $seoData['title'] ?? null,
                        'meta_description' => $seoData['meta_description'] ?? null,
                        'focus_keyword' => $seoData['focus_keyword'] ?? null,
                        'canonical_url' => $seoData['canonical_url'] ?? null,
                        'robots' => $seoData['robots'] ?? 'index, follow',
                    ]
                );
            }
        }

        $inputs = $request->except(['_token', 'site_logo_file', 'site_favicon_file', 'seo']);

        if ($request->hasFile('site_logo_file')) {
            $file = $request->file('site_logo_file');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('settings', $filename, 'public');
            $inputs['site_logo'] = 'storage/' . $path;
        }

        if ($request->hasFile('site_favicon_file')) {
            $file = $request->file('site_favicon_file');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('settings', $filename, 'public');
            $inputs['site_favicon'] = 'storage/' . $path;
        }

        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Website settings, section content, and SEO details saved successfully.');
    }
}
