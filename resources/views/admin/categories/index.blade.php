@extends('layouts.admin')

@section('page_title', 'Product Categories')

@section('content')
<div class="row g-4">
  <div class="col-md-4">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-amber me-1"></i> Add New Category</h6>
      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Category Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Organic Bar Soaps" required>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Custom Slug</label>
          <input type="text" name="slug" class="form-control form-control-sm" placeholder="organic-bar-soaps">
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Description</label>
          <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Category highlights..."></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Image Path</label>
          <input type="text" name="image" class="form-control form-control-sm" placeholder="assets/images/cat_bar_soaps.jpg">
        </div>
        <div class="form-check mb-3">
          <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
          <label class="form-check-label fs-7 fw-semibold" for="is_active">Active Category</label>
        </div>
        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold rounded-pill"><i class="fas fa-save me-1"></i> Save Category</button>
      </form>
    </div>
  </div>

  <div class="col-md-8">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-layer-group text-info me-1"></i> Product Categories List</h6>
      @if($categories->count())
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
              <tr>
                <th>Category</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($categories as $c)
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <img src="{{ asset($c->image ?: 'assets/images/aurasoap images/aurashop (20).jpeg') }}" alt="{{ $c->name }}" style="width: 36px; height: 36px; object-fit: cover; border-radius: 6px;">
                      <span class="fw-bold text-dark">{{ $c->name }}</span>
                    </div>
                  </td>
                  <td><code>{{ $c->slug }}</code></td>
                  <td><span class="badge bg-secondary">{{ $c->products_count }} Products</span></td>
                  <td>
                    @if($c->is_active)
                      <span class="badge bg-success-subtle text-success">Active</span>
                    @else
                      <span class="badge bg-danger-subtle text-danger">Inactive</span>
                    @endif
                  </td>
                  <td class="text-end">
                    <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-muted text-center py-4 fs-7 mb-0">No categories created yet.</p>
      @endif
    </div>
  </div>
</div>
@endsection
