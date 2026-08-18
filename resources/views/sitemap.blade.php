{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($staticPages as $url)
        <url>
            <loc>{{ $url }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

    @foreach($categories as $cat)
        <url>
            <loc>{{ route('products.category', $cat->slug) }}</loc>
            <lastmod>{{ $cat->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach($products as $prod)
        <url>
            <loc>{{ route('products.show', $prod->slug) }}</loc>
            <lastmod>{{ $prod->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach

    @foreach($ingredients as $ing)
        <url>
            <loc>{{ route('ingredients.show', $ing->slug) }}</loc>
            <lastmod>{{ $ing->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach($posts as $post)
        <url>
            <loc>{{ route('blog.show', $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
