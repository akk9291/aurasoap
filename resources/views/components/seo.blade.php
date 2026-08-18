@props(['seo' => null, 'schema' => null])

@php
    $meta = $seo ?? App\Services\SeoService::getMeta();
@endphp

<title>{{ $meta['title'] }}</title>
<meta name="description" content="{{ $meta['description'] }}">
<meta name="robots" content="{{ $meta['robots'] }}">
<link rel="canonical" href="{{ $meta['canonical'] }}">

<!-- OpenGraph Meta -->
<meta property="og:title" content="{{ $meta['title'] }}">
<meta property="og:description" content="{{ $meta['description'] }}">
<meta property="og:url" content="{{ $meta['canonical'] }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $meta['og_image'] }}">
<meta property="og:site_name" content="{{ $meta['site_name'] }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $meta['title'] }}">
<meta name="twitter:description" content="{{ $meta['description'] }}">
<meta name="twitter:image" content="{{ $meta['og_image'] }}">

@if(!empty($schema))
<script type="application/ld+json">
{!! $schema !!}
</script>
@endif
