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
        <div class="p-3 bg-white rounded-xl border border-amber">
          <img src="{{ asset($product->product_image ?: 'assets/images/prod_honey.jpg') }}" alt="{{ $product->name }}" class="img-fluid rounded-xl w-100">
        </div>
      </div>
      <div class="col-lg-6">
        <span class="badge bg-amber text-white px-3 py-2 rounded-pill fs-8 fw-bold mb-2">{{ $product->category ? $product->category->name : 'Organic Soap Bar' }}</span>
        <h1 class="font-heading section-title mb-3">{{ $product->name }}</h1>
        <p class="text-muted-custom fs-6 mb-4">{{ $product->short_description }}</p>

        <div class="p-3 bg-section rounded-md border mb-4">
          <div class="row g-3 fs-7">
            <div class="col-6"><strong>Weight:</strong> {{ $product->weight ?: '125g / 4.4 oz' }}</div>
            <div class="col-6"><strong>SKU:</strong> <code>{{ $product->sku ?: 'AURA-BAR-01' }}</code></div>
            <div class="col-6"><strong>Packaging:</strong> {{ $product->packaging_info ?: '100% Eco Recycled Box' }}</div>
            <div class="col-6"><strong>Status:</strong> In Stock & Freshly Cured</div>
          </div>
        </div>

        <h5 class="font-heading mb-2">Key Skin Benefits:</h5>
        <p class="text-muted-custom fs-7 mb-4">{{ $product->benefits ?: 'Provides humectant hydration and restores natural skin radiance.' }}</p>

        <h5 class="font-heading mb-2">Usage Instructions:</h5>
        <p class="text-muted-custom fs-7 mb-4">{{ $product->usage_instructions ?: 'Lather with warm water, gently massage over skin, and rinse thoroughly.' }}</p>

        @if($product->ingredients->count())
          <h5 class="font-heading mb-2">Botanical Ingredients Included:</h5>
          <div class="d-flex flex-wrap gap-2 mb-4">
            @foreach($product->ingredients as $ing)
              <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fs-8"><i class="fas fa-leaf text-success me-1"></i> {{ $ing->name }}</span>
            @endforeach
          </div>
        @endif

        <div class="pt-3 border-top">
          <a href="{{ route('distributor') }}" class="btn-aura-primary px-4 py-3">
            <span>Inquire Bulk / Wholesale Agency</span>
            <i class="fas fa-handshake"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
