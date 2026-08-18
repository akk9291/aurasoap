<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['category', 'author'])->orderBy('publish_date', 'desc')->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');
        $validated['publish_date'] = $validated['publish_date'] ?? now();

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $blog->id,
            'category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
