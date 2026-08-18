<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $fillable = [
        'page_route', 'title', 'meta_description', 'focus_keyword',
        'canonical_url', 'robots', 'og_title', 'og_description',
        'og_image', 'twitter_title', 'twitter_description',
        'twitter_image', 'schema_type'
    ];

    public function seoable()
    {
        return $this->morphTo();
    }
}
