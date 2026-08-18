<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'published');

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('sort_order')->paginate(9)->withQueryString();
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        $seo = SeoService::getMeta('products');

        return view('pages.products.index', compact('products', 'categories', 'seo'));
    }

    public function category($slug)
    {
        $category = ProductCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = Product::with('category')->where('category_id', $category->id)->where('status', 'published')->orderBy('sort_order')->paginate(9);
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        $seo = SeoService::getMeta(null, $category);

        return view('pages.products.index', compact('products', 'categories', 'category', 'seo'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'ingredients'])->where('slug', $slug)->where('status', 'published')->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('status', 'published')->take(3)->get();

        $seo = SeoService::getMeta(null, $product);
        $productSchema = SeoService::generateProductSchema($product);

        return view('pages.products.show', compact('product', 'relatedProducts', 'seo', 'productSchema'));
    }
}
