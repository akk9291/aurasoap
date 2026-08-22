<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class AgentProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'ingredients'])
            ->where('status', 'published')
            ->whereNotNull('wholesale_price');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('sort_order')->paginate(12)->withQueryString();
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('agent.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'ingredients']);
        return view('agent.products.show', compact('product'));
    }

    public function wholesalePrices()
    {
        $categories = ProductCategory::with(['products' => function($q) {
            $q->where('status', 'published')->whereNotNull('wholesale_price')->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        $uncategorized = Product::whereNull('category_id')
            ->where('status', 'published')
            ->whereNotNull('wholesale_price')
            ->orderBy('sort_order')
            ->get();

        return view('agent.products.wholesale-prices', compact('categories', 'uncategorized'));
    }
}
