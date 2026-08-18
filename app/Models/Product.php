<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'short_description', 'description',
        'product_image', 'gallery', 'benefits', 'usage_instructions',
        'weight', 'packaging_info', 'tags', 'is_featured', 'status', 'sort_order'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
