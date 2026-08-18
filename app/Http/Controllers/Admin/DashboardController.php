<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\DistributorApplication;
use App\Models\Ingredient;
use App\Models\NewsletterSubscriber;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => ProductCategory::count(),
            'total_blogs' => BlogPost::count(),
            'total_ingredients' => Ingredient::count(),
            'total_distributors' => DistributorApplication::count(),
            'total_enquiries' => ContactMessage::count(),
            'total_testimonials' => Testimonial::count(),
            'total_subscribers' => NewsletterSubscriber::count(),
            'published_products' => Product::where('status', 'published')->count(),
            'draft_products' => Product::where('status', 'draft')->count(),
        ];

        $recentEnquiries = ContactMessage::orderBy('created_at', 'desc')->take(5)->get();
        $recentDistributors = DistributorApplication::orderBy('created_at', 'desc')->take(5)->get();
        $recentBlogs = BlogPost::with('category')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentEnquiries', 'recentDistributors', 'recentBlogs'));
    }
}
