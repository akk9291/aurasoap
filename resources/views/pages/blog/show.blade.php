@extends('layouts.app')

@section('content')
<section class="py-5 pt-6">
  <div class="container-custom max-w-900">
    <span class="badge bg-amber text-white px-3 py-2 rounded-pill fs-8 fw-bold mb-3 d-inline-block">{{ $post->category ? $post->category->name : 'Skincare' }}</span>
    <h1 class="font-heading section-title mb-3">{{ $post->title }}</h1>
    <div class="d-flex align-items-center gap-3 text-muted fs-7 mb-4 border-bottom pb-3">
      <div><i class="fas fa-user me-1 text-amber"></i> {{ $post->author ? $post->author->name : 'Aura Soaps Specialist' }}</div>
      <div><i class="fas fa-calendar-alt me-1 text-amber"></i> {{ $post->publish_date ? $post->publish_date->format('F d, Y') : $post->created_at->format('F d, Y') }}</div>
    </div>

    <img src="{{ asset($post->featured_image ?: 'assets/images/blog_1.jpg') }}" alt="{{ $post->title }}" class="img-fluid rounded-xl w-100 mb-5 shadow">

    <div class="blog-content fs-6 text-muted-custom line-height-lg mb-5">
      {!! $post->content !!}
    </div>

    <div class="p-4 bg-section rounded-xl border border-amber d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <h5 class="font-heading mb-1">Share This Article</h5>
        <p class="text-muted fs-7 mb-0">Help others discover holistic organic skincare tips</p>
      </div>
      <div class="d-flex gap-2">
        <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="social-icon-btn"><i class="fab fa-facebook-f"></i></a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" class="social-icon-btn"><i class="fab fa-twitter"></i></a>
        <a href="https://linkedin.com/shareArticle?url={{ urlencode(url()->current()) }}" target="_blank" class="social-icon-btn"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>
</section>
@endsection
