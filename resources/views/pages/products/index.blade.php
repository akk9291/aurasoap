@extends('layouts.app')

@section('content')
<main>
  <!-- PAGE BANNER -->
  <section class="page-banner text-center">
    <div class="container-custom">
      <nav class="breadcrumb-aura mb-3">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">Products</span>
      </nav>
      <h1 class="page-banner-title">Our Crafted Product Collection</h1>
      <p class="page-banner-subtitle mx-auto">Explore our manufactured range of Bar Soaps (Laundry & Bath), Luxury Toilet Paper, Kitchen Paper Towels, and Antiperspirant Rollon Gel.</p>
    </div>
  </section>

<section class="py-5">
  <div class="container-custom">
    <!-- Category Filter Bar -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
      <a href="{{ route('products.index') }}" class="btn {{ !request('category') ? 'btn-aura-primary' : 'btn-aura-outline' }} rounded-pill px-4">All Products</a>
      @foreach($categories as $cat)
        <a href="{{ route('products.category', $cat->slug) }}" class="btn {{ (isset($category) && $category->id == $cat->id) || request('category') == $cat->slug ? 'btn-aura-primary' : 'btn-aura-outline' }} rounded-pill px-4">{{ $cat->name }}</a>
      @endforeach
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
      @forelse($products as $p)
        <div class="col-lg-4 col-md-6">
          <div class="card product-card-aura border-0 h-100">
            <div class="product-img-box position-relative overflow-hidden">
              @php
                $pImg = !empty($p->product_image) && file_exists(public_path($p->product_image)) ? asset($p->product_image) : asset('assets/images/aurasoap images/aurashop (18).jpeg');
              @endphp
              <img src="{{ $pImg }}" alt="{{ $p->name }}" class="card-img-top product-img">
              <span class="badge bg-amber position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill fs-8 fw-bold">100% Organic</span>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
              <div>
                <div class="text-amber fs-8 fw-bold text-uppercase mb-1">{{ $p->category ? $p->category->name : 'Natural Soap' }}</div>
                <h4 class="card-title font-heading mb-2">
                  <a href="{{ route('products.show', $p->slug) }}" class="text-decoration-none text-dark">{{ $p->name }}</a>
                </h4>
                <p class="text-muted-custom fs-7 mb-3">{{ $p->short_description }}</p>
              </div>
              <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-2">
                <span class="fw-bold text-secondary-orange fs-6">{{ $p->weight ?: '125g / 4.4 oz' }}</span>
                <a href="{{ route('products.show', $p->slug) }}" class="btn btn-sm btn-aura-outline rounded-pill">
                  <span>View Details</span>
                  <i class="fas fa-arrow-right fs-8 me-0"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <i class="fas fa-box-open fs-1 text-muted mb-3"></i>
          <h5>No products found in this category</h5>
          <a href="{{ route('products.index') }}" class="btn btn-aura-primary rounded-pill mt-3">View All Products</a>
        </div>
      @endforelse
    </div>

    <div class="pt-5 d-flex justify-content-center">
      {{ $products->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
</main>
@endsection
