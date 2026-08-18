@extends('layouts.admin')

@section('page_title', 'Edit Product')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h5 class="fw-bold mb-0">Edit Product: {{ $product->name }}</h5>
  <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill"><i class="fas fa-arrow-left me-1"></i> Back to List</a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="admin-card p-4">
  @csrf
  @method('PUT')
  <div class="row g-3">
    <div class="col-md-8">
      <div class="mb-3">
        <label class="form-label fw-semibold fs-7">Product Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">Custom Slug</label>
          <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">SKU / Code</label>
          <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold fs-7">Short Description</label>
        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold fs-7">Full Product Description</label>
        <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">Key Benefits</label>
          <textarea name="benefits" class="form-control" rows="3">{{ old('benefits', $product->benefits) }}</textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">Usage Instructions</label>
          <textarea name="usage_instructions" class="form-control" rows="3">{{ old('usage_instructions', $product->usage_instructions) }}</textarea>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="p-3 bg-light rounded border mb-3">
        <div class="mb-3">
          <label class="form-label fw-semibold fs-7">Category <span class="text-danger">*</span></label>
          <select name="category_id" class="form-select" required>
            <option value="">Select Category</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold fs-7">Status</label>
          <select name="status" class="form-select">
            <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
          </select>
        </div>

        <div class="form-check mb-3">
          <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
          <label class="form-check-label fw-semibold fs-7" for="is_featured">Feature on Homepage</label>
        </div>
      </div>

      <div class="p-3 bg-light rounded border mb-3">
        <div class="mb-3">
          <label class="form-label fw-semibold fs-7">Main Product Image URL / Path</label>
          <input type="text" name="product_image" class="form-control" value="{{ old('product_image', $product->product_image) }}">
        </div>

        <div class="row g-2 mb-3">
          <div class="col-6">
            <label class="form-label fw-semibold fs-7">Weight</label>
            <input type="text" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}">
          </div>
          <div class="col-6">
            <label class="form-label fw-semibold fs-7">Tags</label>
            <input type="text" name="tags" class="form-control" value="{{ old('tags', $product->tags) }}">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold fs-7">Packaging Info</label>
          <input type="text" name="packaging_info" class="form-control" value="{{ old('packaging_info', $product->packaging_info) }}">
        </div>
      </div>

      <div class="p-3 bg-light rounded border mb-3">
        <label class="form-label fw-semibold fs-7">Botanical Ingredients</label>
        <div class="d-flex flex-column gap-1 overflow-auto" style="max-height: 180px;">
          @php $selectedIngredients = $product->ingredients->pluck('id')->toArray(); @endphp
          @foreach($ingredients as $ing)
            <div class="form-check fs-7">
              <input type="checkbox" name="ingredients[]" value="{{ $ing->id }}" class="form-check-input" id="ing_{{ $ing->id }}" {{ in_array($ing->id, $selectedIngredients) ? 'checked' : '' }}>
              <label class="form-check-label" for="ing_{{ $ing->id }}">{{ $ing->name }}</label>
            </div>
          @endforeach
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill"><i class="fas fa-sync me-1"></i> Update Product</button>
    </div>
  </div>
</form>
@endsection
