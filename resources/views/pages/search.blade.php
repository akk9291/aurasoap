@extends('layouts.app')

@section('content')
<section class="py-5 bg-section pt-6">
  <div class="container-custom text-center">
    <h1 class="section-title">Search Results</h1>
    <p class="text-muted-custom">Showing results for: <strong>"{{ $q }}"</strong></p>
  </div>
</section>

<section class="py-5">
  <div class="container-custom">
    @if($products->count())
      <div class="row g-4">
        @foreach($products as $p)
          <div class="col-lg-4 col-md-6">
            <div class="card product-card-aura border-0 h-100">
              <div class="product-img-box position-relative overflow-hidden">
                <img src="{{ asset($p->product_image ?: 'assets/images/aurasoap images/aurashop (18).jpeg') }}" alt="{{ $p->name }}" class="card-img-top product-img">
              </div>
              <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                  <h4 class="card-title font-heading mb-2">
                    <a href="{{ route('products.show', $p->slug) }}" class="text-decoration-none text-dark">{{ $p->name }}</a>
                  </h4>
                  <p class="text-muted-custom fs-7 mb-3">{{ $p->short_description }}</p>
                </div>
                <div class="border-top pt-3 mt-2">
                  <a href="{{ route('products.show', $p->slug) }}" class="btn btn-sm btn-aura-outline rounded-pill w-100">View Details</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center py-5">
        <i class="fas fa-search fs-1 text-muted mb-3"></i>
        <h5>No products matched your search term.</h5>
        <a href="{{ route('products.index') }}" class="btn btn-aura-primary rounded-pill mt-3">Browse Full Catalog</a>
      </div>
    @endif
  </div>
</section>
@endsection
