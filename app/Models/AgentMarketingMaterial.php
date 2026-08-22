<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentMarketingMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'thumbnail_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'sort_order' => 'integer',
    ];

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'catalogue' => 'Product Catalogue',
            'poster' => 'Promotional Poster',
            'spec_sheet' => 'Product Specification Sheet',
            'training' => 'Training & Educational Guide',
            'brochure' => 'Sales Brochure',
            'photo' => 'High-Res Photo Pack',
            default => ucfirst($this->category),
        };
    }

    public function getIconAttribute(): string
    {
        return match (strtolower($this->file_type ?? '')) {
            'pdf' => 'fa-file-pdf text-danger',
            'jpg', 'jpeg', 'png', 'webp' => 'fa-file-image text-primary',
            'doc', 'docx' => 'fa-file-word text-info',
            'zip', 'rar' => 'fa-file-archive text-warning',
            default => 'fa-file-alt text-secondary',
        };
    }
}
