@extends('layouts.agent')

@section('page_title', $product->name . ' - Product Details')

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.products.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Product Catalogue
  </a>
</div>

<div class="agent-card p-4 p-md-5 mb-4">
  <div class="row g-4">
    <!-- Product Media -->
    <div class="col-lg-5">
      <div class="border rounded-4 p-3 bg-light text-center mb-3">
        @if($product->product_image)
          <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->name }}" class="img-fluid rounded-3 w-100 object-fit-contain" style="max-height: 350px;" onerror="this.onerror=null; this.src='https://placehold.co/500x400/f8fafc/0f172a?text=Aura+Soap';">
        @else
          <div class="d-flex align-items-center justify-content-center py-5 text-muted">
            <i class="fas fa-soap fs-1 text-warning"></i>
          </div>
        @endif
      </div>

      <!-- Pricing Box -->
      <div class="p-3.5 rounded-4 border border-warning bg-warning bg-opacity-10">
        <div class="d-flex align-items-baseline justify-content-between mb-2">
          <span class="fs-8 fw-bold text-dark text-uppercase">Principal Wholesale Rate:</span>
          <span class="fs-3 fw-bold text-success font-monospace">${{ number_format($product->wholesale_price, 2) }}</span>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-3 fs-8 text-muted">
          <span>Minimum Order Quantity (MOQ):</span>
          <strong class="text-dark">{{ $product->min_order_qty ?? 1 }} Master Case(s)</strong>
        </div>
        @if($product->wholesale_notes)
          <div class="p-2 bg-white rounded-3 fs-8 text-secondary mb-3">
            <i class="fas fa-info-circle text-warning me-1"></i> {{ $product->wholesale_notes }}
          </div>
        @endif
        <a href="{{ route('agent.orders.create') }}" class="btn btn-aura w-100 rounded-pill py-2.5 fs-7 fw-bold">
          <i class="fas fa-cart-plus me-1"></i> Place Order for this Product
        </a>
      </div>
    </div>

    <!-- Product Details & Specs -->
    <div class="col-lg-7">
      <div class="mb-2">
        <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill fs-8 fw-bold">{{ $product->category->name ?? 'Soap' }}</span>
        @if($product->sku)
          <span class="badge bg-light text-muted border px-2.5 py-1 rounded-pill fs-8 font-monospace ms-1">SKU: {{ $product->sku }}</span>
        @endif
      </div>

      <h3 class="fw-bold text-dark font-heading mb-3">{{ $product->name }}</h3>
      <p class="fs-7 text-secondary mb-4">{{ $product->short_description }}</p>

      <!-- Specifications Grid -->
      <div class="row g-3 fs-8 mb-4">
        @if($product->weight)
          <div class="col-sm-6">
            <div class="p-3 bg-light rounded-3">
              <span class="text-muted text-uppercase fs-9 fw-bold d-block">Unit Weight / Size</span>
              <strong class="text-dark fs-7">{{ $product->weight }}</strong>
            </div>
          </div>
        @endif

        @if($product->packaging_info)
          <div class="col-sm-6">
            <div class="p-3 bg-light rounded-3">
              <span class="text-muted text-uppercase fs-9 fw-bold d-block">Master Case Packaging</span>
              <strong class="text-dark fs-7">{{ $product->packaging_info }}</strong>
            </div>
          </div>
        @endif
      </div>

      @if($product->description)
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-2">Product Overview & Key Features</h6>
          <div class="fs-7 text-secondary lh-lg">{!! nl2br(e($product->description)) !!}</div>
        </div>
      @endif

      @if($product->benefits)
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-2">Retail & Consumer Benefits</h6>
          <div class="fs-7 text-secondary lh-lg">{!! nl2br(e($product->benefits)) !!}</div>
        </div>
      @endif

      @if($product->ingredients && $product->ingredients->count() > 0)
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-2">Botanical & Natural Ingredients</h6>
          <div class="d-flex flex-wrap gap-2">
            @foreach($product->ingredients as $ing)
              <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill fs-8">
                <i class="fas fa-leaf me-1"></i> {{ $ing->name }}
              </span>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
