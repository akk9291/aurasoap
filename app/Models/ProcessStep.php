<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    use HasFactory;

    protected $fillable = ['step_number', 'title', 'description', 'icon_image', 'sort_order', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];
}
