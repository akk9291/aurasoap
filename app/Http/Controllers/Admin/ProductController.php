<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'ingredients']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('sort_order')->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $categories = ProductCategory::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->get();
        $ingredients = Ingredient::where('status', true)->get();
        return view('admin.products.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:product_categories,id',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'product_image' => 'nullable|string',
            'benefits' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'weight' => 'nullable|string',
            'packaging_info' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
            'ingredients' => 'nullable|array',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        if ($request->has('ingredients')) {
            $product->ingredients()->sync($request->ingredients);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $ingredients = Ingredient::all();
        return view('admin.products.edit', compact('product', 'categories', 'ingredients'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:product_categories,id',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'product_image' => 'nullable|string',
            'benefits' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'weight' => 'nullable|string',
            'packaging_info' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
            'ingredients' => 'nullable|array',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $product->update($validated);

        if ($request->has('ingredients')) {
            $product->ingredients()->sync($request->ingredients);
        } else {
            $product->ingredients()->detach();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->ingredients()->detach();
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function duplicate(Product $product)
    {
        $replica = $product->replicate();
        $replica->name = $product->name . ' (Copy)';
        $replica->slug = Str::slug($product->slug . '-copy-' . time());
        $replica->sku = $product->sku ? $product->sku . '-COPY' : null;
        $replica->status = 'draft';
        $replica->save();

        $replica->ingredients()->sync($product->ingredients->pluck('id'));

        return redirect()->route('admin.products.index')->with('success', 'Product duplicated successfully as draft.');
    }
}
