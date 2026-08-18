<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Services\SeoService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author'])->where('status', 'published');

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('publish_date', 'desc')->paginate(6)->withQueryString();
        $categories = BlogCategory::where('status', true)->get();

        $seo = SeoService::getMeta('blog');

        return view('pages.blog.index', compact('posts', 'categories', 'seo'));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['category', 'author'])->where('slug', $slug)->where('status', 'published')->firstOrFail();
        $relatedPosts = BlogPost::where('category_id', $post->category_id)->where('id', '!=', $post->id)->where('status', 'published')->take(2)->get();

        $seo = SeoService::getMeta(null, $post);

        $articleSchema = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'image' => [asset($post->featured_image)],
            'datePublished' => $post->publish_date ? $post->publish_date->toIso8601String() : $post->created_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author ? $post->author->name : 'Aura Soaps Specialist',
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return view('pages.blog.show', compact('post', 'relatedPosts', 'seo', 'articleSchema'));
    }
}
