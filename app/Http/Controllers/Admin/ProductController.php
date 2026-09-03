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
        $galleryImages = $this->getAvailableImages();
        return view('admin.products.create', compact('categories', 'ingredients', 'galleryImages'));
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
            'product_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
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

        if ($request->hasFile('product_image_file')) {
            $file = $request->file('product_image_file');
            $dir = public_path('assets/images/products');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $validated['product_image'] = 'assets/images/products/' . $filename;
        }

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
        $galleryImages = $this->getAvailableImages();
        return view('admin.products.edit', compact('product', 'categories', 'ingredients', 'galleryImages'));
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
            'product_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
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

        if ($request->hasFile('product_image_file')) {
            $file = $request->file('product_image_file');
            $dir = public_path('assets/images/products');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $validated['product_image'] = 'assets/images/products/' . $filename;
        }

        $product->update($validated);

        if ($request->has('ingredients')) {
            $product->ingredients()->sync($request->ingredients);
        } else {
            $product->ingredients()->detach();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function getAvailableImages(): array
    {
        $images = [];

        // 1. Check aurasoap images
        $auraDir = public_path('assets/images/aurasoap images');
        if (is_dir($auraDir)) {
            $files = scandir($auraDir);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $images[] = 'assets/images/aurasoap images/' . $file;
                }
            }
        }

        // 2. Check uploaded products images
        $prodDir = public_path('assets/images/products');
        if (is_dir($prodDir)) {
            $files = scandir($prodDir);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $images[] = 'assets/images/products/' . $file;
                }
            }
        }

        // 3. Check Media library
        try {
            $mediaPaths = \App\Models\Media::pluck('file_path')->toArray();
            foreach ($mediaPaths as $mp) {
                if (!in_array($mp, $images) && file_exists(public_path($mp))) {
                    $images[] = $mp;
                }
            }
        } catch (\Exception $e) {
            // ignore if table not present
        }

        return $images;
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
