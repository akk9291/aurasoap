@extends('layouts.agent')

@section('page_title', 'Product Catalogue & Wholesale')

@section('content')
<div class="agent-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">Aura Master Product Catalogue</h4>
      <span class="fs-7 text-muted">Complete master product catalogue across Soaps (Laundry & Bath), Luxury Toilet Paper, Kitchen Towel Paper, and Rollon Gel</span>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('agent.wholesale-prices') }}" class="btn btn-outline-dark rounded-pill px-3 fs-8 fw-semibold">
        <i class="fas fa-table me-1 text-warning"></i> Wholesale Price Matrix
      </a>
      <a href="{{ route('agent.orders.create') }}" class="btn btn-aura rounded-pill px-3 fs-8">
        <i class="fas fa-cart-plus me-1"></i> Place Order
      </a>
    </div>
  </div>

  <!-- Filters & Search -->
  <div class="mt-4 pt-3 border-top">
    <form action="{{ route('agent.products.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
          <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, SKU or description..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-md-4">
        <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Filter</button>
        @if(request()->hasAny(['search', 'category']))
          <a href="{{ route('agent.products.index') }}" class="btn btn-sm btn-light border rounded-3 px-3 text-danger">Reset</a>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Products Grid -->
<div class="row g-4">
  @forelse($products as $prod)
    <div class="col-md-6 col-xl-4">
      <div class="agent-card p-3.5 h-100 d-flex flex-column justify-content-between">
        <div>
          <!-- Image -->
          <div class="position-relative mb-3">
            @if($prod->product_image)
              <img src="{{ asset('storage/' . $prod->product_image) }}" alt="{{ $prod->name }}" class="img-fluid rounded-3 w-100 object-fit-cover" style="height: 180px;" onerror="this.onerror=null; this.src='https://placehold.co/400x250/f8fafc/0f172a?text=Aura+Soap';">
            @else
              <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="height: 180px;">
                <i class="fas fa-soap fs-1 text-warning"></i>
              </div>
            @endif

            @if($prod->sku)
              <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-75 text-white font-monospace fs-9">
                SKU: {{ $prod->sku }}
              </span>
            @endif
          </div>

          <div class="mb-2">
            <span class="badge bg-warning-subtle text-warning-emphasis fs-9 fw-semibold">{{ $prod->category->name ?? 'Soap' }}</span>
            @if($prod->weight)
              <span class="badge bg-light text-muted border fs-9">{{ $prod->weight }}</span>
            @endif
          </div>

          <h5 class="fw-bold text-dark fs-6 mb-2">{{ $prod->name }}</h5>
          <p class="text-muted fs-8 mb-3">{{ Str::limit($prod->short_description, 95) }}</p>

          <!-- Specifications Highlights -->
          @if($prod->packaging_info)
            <div class="bg-light p-2 rounded-3 fs-9 text-muted mb-3">
              <i class="fas fa-box-open me-1 text-warning"></i> <strong>Packaging:</strong> {{ $prod->packaging_info }}
            </div>
          @endif
        </div>

        <!-- Pricing and Action Footer -->
        <div class="pt-3 border-top mt-2">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <span class="fs-8 text-muted">Wholesale Rate:</span>
            <span class="fs-5 fw-bold text-success font-monospace">${{ number_format($prod->wholesale_price, 2) }}</span>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fs-9 text-muted">Minimum Order (MOQ):</span>
            <span class="fs-8 fw-semibold text-dark">{{ $prod->min_order_qty ?? 1 }} Case(s)</span>
          </div>

          <div class="d-flex gap-2">
            <a href="{{ route('agent.products.show', $prod) }}" class="btn btn-sm btn-light border rounded-pill flex-grow-1 fs-8">
              <i class="fas fa-info-circle me-1 text-primary"></i> Specifications
            </a>
            <a href="{{ route('agent.orders.create') }}" class="btn btn-sm btn-aura rounded-pill px-3 fs-8">
              <i class="fas fa-cart-plus me-1"></i> Order
            </a>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="agent-card p-5 text-center">
        <i class="fas fa-search text-muted fs-1 mb-3"></i>
        <h5 class="fw-bold text-dark">No products found matching your search.</h5>
        <p class="text-muted fs-7">Try resetting your filter parameters or search keyword.</p>
        <a href="{{ route('agent.products.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">Clear Filters</a>
      </div>
    </div>
  @endforelse
</div>

<div class="mt-4">
  {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection
