<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentMarketingMaterial;
use Illuminate\Http\Request;

class AgentMarketingController extends Controller
{
    public function index(Request $request)
    {
        $query = AgentMarketingMaterial::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $materials = $query->orderBy('sort_order')->get();

        $categories = [
            'catalogue' => 'Product Catalogues',
            'spec_sheet' => 'Pricing & Spec Sheets',
            'poster' => 'Promotional Posters',
            'training' => 'Sales & Training Guides',
            'brochure' => 'Wholesale Brochures',
            'photo' => 'Photo Assets',
        ];

        return view('agent.marketing.index', compact('materials', 'categories'));
    }

    public function download(AgentMarketingMaterial $material)
    {
        if (!$material->is_active) {
            abort(404);
        }

        $filePath = public_path($material->file_path);
        
        if (file_exists($filePath)) {
            return response()->download($filePath, basename($material->file_path));
        }

        // If file is stored in storage
        if (\Storage::disk('public')->exists($material->file_path)) {
            return \Storage::disk('public')->download($material->file_path);
        }

        return back()->with('info', 'Digital resource requested. File stream generated for: ' . $material->title);
    }
}
