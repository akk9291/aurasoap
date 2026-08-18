<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductCategory;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'published')->get();
        $categories = ProductCategory::where('is_active', true)->get();
        $ingredients = Ingredient::where('status', true)->get();
        $posts = BlogPost::where('status', 'published')->get();

        $staticPages = [
            url('/'),
            url('/about-us'),
            url('/products'),
            url('/ingredients'),
            url('/blog'),
            url('/become-a-distributor'),
            url('/faq'),
            url('/contact'),
            url('/privacy-policy'),
            url('/terms-and-conditions'),
            url('/return-policy'),
            url('/shipping-policy'),
        ];

        return response()->view('sitemap', compact('products', 'categories', 'ingredients', 'posts', 'staticPages'))
            ->header('Content-Type', 'text/xml');
    }
}
