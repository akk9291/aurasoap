<?php

namespace App\Services;

use App\Models\SeoMeta;
use App\Models\Setting;
use Illuminate\Support\Str;

class SeoService
{
    public static function getMeta($pageRoute = null, $model = null)
    {
        $siteName = Setting::get('site_name', 'Aura Soaps');
        $defaultDesc = Setting::get('site_description', 'Aura Soaps offers crafted organic cold-processed soaps and eco-friendly skincare.');

        $title = $siteName . ' | Natural Care • Pure Touch';
        $description = $defaultDesc;
        $canonical = url()->current();
        $robots = 'index, follow';
        $ogImage = asset(Setting::get('site_logo', 'assets/images/logo.png'));
        $focusKeyword = '';

        if ($model) {
            $modelTitle = $model->name ?? $model->title ?? '';
            $modelDesc = strip_tags($model->short_description ?? $model->excerpt ?? $model->description ?? '');
            
            $title = $modelTitle ? $modelTitle . ' | ' . $siteName : $title;
            $description = $modelDesc ? Str::limit($modelDesc, 160) : $description;
            
            if (isset($model->product_image) && $model->product_image) {
                $ogImage = asset($model->product_image);
            } elseif (isset($model->featured_image) && $model->featured_image) {
                $ogImage = asset($model->featured_image);
            } elseif (isset($model->image) && $model->image) {
                $ogImage = asset($model->image);
            }

            if (method_exists($model, 'seo') && $model->seo) {
                $seo = $model->seo;
                $title = $seo->title ?: $title;
                $description = $seo->meta_description ?: $description;
                $canonical = $seo->canonical_url ?: $canonical;
                $robots = $seo->robots ?: $robots;
                $ogImage = $seo->og_image ? asset($seo->og_image) : $ogImage;
                $focusKeyword = $seo->focus_keyword ?: '';
            }
        } elseif ($pageRoute) {
            $seo = SeoMeta::where('page_route', $pageRoute)->first();
            if ($seo) {
                $title = $seo->title ?: $title;
                $description = $seo->meta_description ?: $description;
                $canonical = $seo->canonical_url ?: $canonical;
                $robots = $seo->robots ?: $robots;
                $ogImage = $seo->og_image ? asset($seo->og_image) : $ogImage;
                $focusKeyword = $seo->focus_keyword ?: '';
            }
        }

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'robots' => $robots,
            'og_image' => $ogImage,
            'site_name' => $siteName,
            'focus_keyword' => $focusKeyword,
        ];
    }

    public static function generateOrganizationSchema()
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => Setting::get('site_name', 'Aura Soaps'),
            'url' => url('/'),
            'logo' => asset(Setting::get('site_logo', 'assets/images/logo.png')),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => Setting::get('contact_phone', '+1-800-555-2872'),
                'contactType' => 'customer service',
                'email' => Setting::get('contact_email', 'hello@aurasoaps.com'),
            ],
            'sameAs' => array_values(array_filter([
                Setting::get('social_facebook'),
                Setting::get('social_instagram'),
                Setting::get('social_linkedin'),
                Setting::get('social_youtube'),
            ]))
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public static function generateProductSchema($product)
    {
        return json_encode([
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => [asset($product->product_image ?: Setting::get('site_logo', 'assets/images/logo.png'))],
            'description' => strip_tags($product->short_description ?: $product->description ?: $product->name),
            'sku' => $product->sku ?: 'AURA-' . $product->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => Setting::get('site_name', 'Aura Soaps'),
            ],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'USD',
                'price' => '12.00',
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public static function generateArticleSchema($post)
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'image' => [asset($post->featured_image ?: Setting::get('site_logo', 'assets/images/logo.png'))],
            'datePublished' => $post->publish_date ? $post->publish_date->toIso8601String() : $post->created_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author->name ?? Setting::get('site_name', 'Aura Soaps Specialist'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => Setting::get('site_name', 'Aura Soaps'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(Setting::get('site_logo', 'assets/images/logo.png')),
                ]
            ],
            'description' => strip_tags($post->excerpt ?: $post->content ?: $post->title),
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public static function generateFaqSchema($faqs)
    {
        $faqItems = [];
        foreach ($faqs as $faq) {
            $faqItems[] = [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($faq->answer),
                ],
            ];
        }

        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqItems,
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public static function generateBreadcrumbSchema($crumbs)
    {
        $listItems = [];
        $position = 1;
        foreach ($crumbs as $name => $url) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => $url,
            ];
        }

        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
