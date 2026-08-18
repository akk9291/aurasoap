<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Services\SeoService;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::where('status', true)->orderBy('sort_order')->get();
        $seo = SeoService::getMeta('ingredients');

        return view('pages.ingredients.index', compact('ingredients', 'seo'));
    }

    public function show($slug)
    {
        $ingredient = Ingredient::with(['products' => function($q) {
            $q->where('status', 'published');
        }])->where('slug', $slug)->where('status', true)->firstOrFail();

        $seo = SeoService::getMeta(null, $ingredient);

        return view('pages.ingredients.show', compact('ingredient', 'seo'));
    }
}
