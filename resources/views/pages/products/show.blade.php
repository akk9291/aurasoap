@extends('layouts.app')

@section('content')
<section class="py-5 pt-6">
  <div class="container-custom">
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb fs-7">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-muted">Products</a></li>
        <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $product->name }}</li>
      </ol>
    </nav>

    <div class="row gy-5">
      <div class="col-lg-6">
        <div class="p-3 bg-white rounded-4 border shadow-sm text-center">
          @php
            $prodImg = !empty($product->product_image) && file_exists(public_path($product->product_image)) 
              ? asset($product->product_image) 
              : asset('assets/images/beauty_soap.jpg');
          @endphp
          <img src="{{ $prodImg }}" alt="{{ $product->name }}" class="img-fluid rounded-4 w-100" style="max-height: 480px; object-fit: contain;">
        </div>
      </div>

      <div class="col-lg-6">
        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fs-8 fw-bold mb-2">{{ $product->category ? $product->category->name : 'Essential Personal Care' }}</span>
        <h1 class="font-heading section-title mb-2 fs-2 fw-bold text-dark">{{ $product->name }}</h1>
        <p class="text-muted fs-6 mb-4">{{ $product->short_description }}</p>

        <div class="p-3 bg-light rounded-4 border mb-4">
          <div class="row g-3 fs-7">
            <div class="col-6"><strong>Specification:</strong> {{ $product->weight ?: 'Standard' }}</div>
            <div class="col-6"><strong>SKU Code:</strong> <code class="text-dark">{{ $product->sku ?: 'AUR-PRD' }}</code></div>
            <div class="col-6"><strong>Packaging:</strong> {{ $product->packaging_info ?: 'Master Case' }}</div>
            <div class="col-6"><strong>Availability:</strong> <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> In Stock & Ready</span></div>
          </div>
        </div>

        @if($product->description)
          <h5 class="font-heading fw-bold text-dark mb-2">Product Description & Formulation:</h5>
          <div class="text-muted fs-7 mb-4 line-height-lg">{!! nl2br(e($product->description)) !!}</div>
        @endif

        @if($product->benefits)
          <h5 class="font-heading fw-bold text-dark mb-2">Key Benefits & Features:</h5>
          <div class="text-secondary fs-7 mb-4">{!! nl2br(e($product->benefits)) !!}</div>
        @endif

        <div class="pt-4 border-top d-flex flex-wrap gap-3">
          <a href="{{ route('distributor') }}" class="btn-aura-primary px-4 py-2.5">
            <span>Inquire Wholesale Agency</span>
            <i class="fas fa-handshake ms-1"></i>
          </a>
          <a href="{{ route('agent.locator') }}" class="btn btn-outline-dark rounded-pill px-4 py-2.5 fs-7 fw-semibold">
            <span>Find Local Agent Shop</span>
            <i class="fas fa-map-marker-alt ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
