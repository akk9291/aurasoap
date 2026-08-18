<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = ['section_key', 'title', 'subtitle', 'content', 'payload', 'is_active'];

    protected $casts = [
        'payload' => 'array',
        'is_active' => 'boolean',
    ];
}
