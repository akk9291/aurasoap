<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'filename', 'original_name', 'mime_type', 'file_path',
        'disk', 'file_size', 'alt_text', 'caption'
    ];
}
