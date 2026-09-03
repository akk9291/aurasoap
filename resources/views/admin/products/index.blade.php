@extends('layouts.admin')

@section('page_title', 'Product Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h5 class="fw-bold mb-0">Products Catalog</h5>
    <p class="text-muted fs-7 mb-0">Manage crafted product lines (Bar Soaps, Toilet Paper, Kitchen Towel Paper, Antiperspirant Rollon Gel), SKU, pricing, and publishing status</p>
  </div>
  <a href="{{ route('admin.products.create') }}" class="btn btn-warning rounded-pill fw-bold text-dark px-3">
    <i class="fas fa-plus me-1"></i> Add New Product
  </a>
</div>

<div class="admin-card p-3 mb-4">
  <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name, SKU..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
      <select name="category_id" class="form-select form-select-sm">
        <option value="">All Categories</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <select name="status" class="form-select form-select-sm">
        <option value="">All Statuses</option>
        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-sm btn-dark w-100"><i class="fas fa-filter me-1"></i> Filter</button>
    </div>
  </form>
</div>

<div class="admin-card p-3">
  @if($products->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Product</th>
            <th>Category</th>
            <th>SKU</th>
            <th>Status</th>
            <th>Featured</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $p)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <img src="{{ asset($p->product_image ?: 'assets/images/aurasoap images/aurashop (18).jpeg') }}" alt="{{ $p->name }}" style="width: 42px; height: 42px; object-fit: cover; border-radius: 8px;">
                  <div>
                    <div class="fw-bold text-dark">{{ $p->name }}</div>
                    <div class="text-muted fs-8">{{ $p->weight ?: '125g' }}</div>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-secondary-subtle text-dark">{{ $p->category ? $p->category->name : 'Uncategorized' }}</span></td>
              <td><code>{{ $p->sku ?: 'N/A' }}</code></td>
              <td>
                @if($p->status === 'published')
                  <span class="badge bg-success-subtle text-success">Published</span>
                @else
                  <span class="badge bg-warning-subtle text-warning">Draft</span>
                @endif
              </td>
              <td>
                @if($p->is_featured)
                  <i class="fas fa-star text-warning"></i> Yes
                @else
                  <span class="text-muted">No</span>
                @endif
              </td>
              <td class="text-end">
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('products.show', $p->slug) }}" target="_blank" class="btn btn-outline-secondary" title="View"><i class="fas fa-eye"></i></a>
                  <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('admin.products.duplicate', $p->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning" title="Duplicate"><i class="fas fa-copy"></i></button>
                  </form>
                  <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product permanently?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="pt-3">
      {{ $products->links() }}
    </div>
  @else
    <p class="text-muted text-center py-4 fs-7 mb-0">No products found matching your filter criteria.</p>
  @endif
</div>
@endsection
