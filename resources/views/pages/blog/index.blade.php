@extends('layouts.app')

@section('content')
<main>
  <!-- PAGE BANNER -->
  <section class="page-banner text-center">
    <div class="container-custom">
      <nav class="breadcrumb-aura mb-3">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">Blog</span>
      </nav>
      <h1 class="page-banner-title">Organic Bathing & Skincare Journal</h1>
      <p class="page-banner-subtitle mx-auto">Expert guides on natural skin barrier preservation, aromatherapy, and eco-friendly rituals.</p>
    </div>
  </section>

<section class="py-5">
  <div class="container-custom">
    <div class="row g-4">
      @foreach($posts as $post)
        <div class="col-lg-4 col-md-6">
          <div class="card product-card-aura border-0 h-100">
            <img src="{{ asset($post->featured_image ?: 'assets/images/aurasoap images/aurashop (20).jpeg') }}" alt="{{ $post->title }}" class="card-img-top" style="height: 220px; object-fit: cover;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
              <div>
                <div class="text-amber fs-8 fw-bold text-uppercase mb-1">{{ $post->category ? $post->category->name : 'Skincare' }}</div>
                <h4 class="card-title font-heading mb-2">
                  <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">{{ $post->title }}</a>
                </h4>
                <p class="text-muted-custom fs-7 mb-3">{{ $post->excerpt }}</p>
              </div>
              <div class="d-flex align-items-center justify-content-between border-top pt-3">
                <span class="text-muted fs-8"><i class="fas fa-calendar-alt me-1"></i> {{ $post->publish_date ? $post->publish_date->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-aura-outline rounded-pill">Read Article</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="pt-4 d-flex justify-content-center">
      {{ $posts->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
</main>
@endsection
