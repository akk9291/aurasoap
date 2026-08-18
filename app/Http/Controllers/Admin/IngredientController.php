<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('sort_order')->get();
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ingredients,slug',
            'image' => 'nullable|string',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['status'] = $request->has('status');

        Ingredient::create($validated);

        return redirect()->back()->with('success', 'Ingredient created successfully.');
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ingredients,slug,' . $ingredient->id,
            'image' => 'nullable|string',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['status'] = $request->has('status');

        $ingredient->update($validated);

        return redirect()->back()->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->back()->with('success', 'Ingredient deleted successfully.');
    }
}
