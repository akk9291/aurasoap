<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'country', 'designation', 'profile_image',
        'testimonial', 'rating', 'is_featured', 'status', 'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => 'boolean',
    ];
}
