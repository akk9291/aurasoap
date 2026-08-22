<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Ingredient;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Testimonial;
use App\Services\SeoService;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')->where('status', 'published')->where('is_featured', true)->orderBy('sort_order')->take(6)->get();
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with('category')->where('status', 'published')->orderBy('sort_order')->take(6)->get();
        }

        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();
        $featuredIngredients = Ingredient::where('status', true)->where('is_featured', true)->orderBy('sort_order')->take(3)->get();
        $processSteps = ProcessStep::where('status', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('status', true)->where('is_featured', true)->orderBy('sort_order')->get();
        $latestBlogs = BlogPost::with('category')->where('status', 'published')->orderBy('publish_date', 'desc')->take(3)->get();
        $faqs = Faq::where('status', true)->orderBy('sort_order')->take(6)->get();

        $seo = SeoService::getMeta('home');
        $orgSchema = SeoService::generateOrganizationSchema();

        return view('pages.home', compact(
            'featuredProducts', 'categories', 'featuredIngredients',
            'processSteps', 'testimonials', 'latestBlogs', 'faqs', 'seo', 'orgSchema'
        ));
    }
}
