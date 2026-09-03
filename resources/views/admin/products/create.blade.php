@extends('layouts.admin')

@section('page_title', 'Create Product')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h5 class="fw-bold mb-0">Add New Soap Product</h5>
  <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill"><i class="fas fa-arrow-left me-1"></i> Back to List</a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-card p-4">
  @csrf
  <div class="row g-3">
    <div class="col-md-8">
      <div class="mb-3">
        <label class="form-label fw-semibold fs-7">Product Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" placeholder="e.g. Pure Honey & Oatmeal Artisan Soap" value="{{ old('name') }}" required>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">Custom Slug (Optional)</label>
          <input type="text" name="slug" class="form-control" placeholder="auto-generated-if-empty" value="{{ old('slug') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">SKU / Code</label>
          <input type="text" name="sku" class="form-control" placeholder="AURA-HON-01" value="{{ old('sku') }}">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold fs-7">Short Description</label>
        <textarea name="short_description" class="form-control" rows="2" placeholder="Gentle exfoliating soap bar infused with raw mountain honey...">{{ old('short_description') }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold fs-7">Full Product Description</label>
        <textarea name="description" class="form-control" rows="5" placeholder="Detailed storytelling description, sensory notes, skin feeling...">{{ old('description') }}</textarea>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">Key Benefits (Bullet points supported)</label>
          <textarea name="benefits" class="form-control" rows="3" placeholder="Deeply hydrating, soothing eczema, 100% natural...">{{ old('benefits') }}</textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-7">Usage Instructions</label>
          <textarea name="usage_instructions" class="form-control" rows="3" placeholder="Lather between palms with warm water...">{{ old('usage_instructions') }}</textarea>
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
              <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold fs-7">Status</label>
          <select name="status" class="form-select">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
            <option value="archived">Archived</option>
          </select>
        </div>

        <div class="form-check mb-3">
          <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
          <label class="form-check-label fw-semibold fs-7" for="is_featured">Feature on Homepage</label>
        </div>
      </div>

      <div class="p-3 bg-light rounded border mb-3">
        <label class="form-label fw-semibold fs-7 d-block mb-2">Product Image</label>
        
        <!-- Live Image Preview Card -->
        <div class="position-relative text-center p-2 mb-3 bg-white rounded-3 border" style="min-height: 160px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
          <img id="imagePreview" 
               src="{{ old('product_image') ? asset(old('product_image')) : asset('assets/images/placeholder.png') }}" 
               alt="Product Preview" 
               class="img-fluid rounded-2 shadow-xs" 
               style="max-height: 150px; max-width: 100%; object-fit: contain; {{ !old('product_image') ? 'display:none;' : '' }}"
               onerror="this.src='{{ asset('assets/images/aurasoap images/aurashop (18).jpeg') }}';">
          <div id="imagePlaceholder" class="text-muted text-center py-4" style="{{ old('product_image') ? 'display:none;' : '' }}">
            <i class="fas fa-image fa-3x mb-2 text-secondary opacity-50"></i>
            <div class="fs-8">No image selected yet</div>
          </div>
        </div>

        <!-- Hidden input storing selected image path -->
        <input type="hidden" name="product_image" id="productImageInput" value="{{ old('product_image') }}">

        <!-- Image Selection Actions -->
        <div class="d-grid gap-2 mb-2">
          <button type="button" class="btn btn-sm btn-primary rounded-pill py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#imageGalleryModal">
            <i class="fas fa-images me-1.5"></i> Select from Photo Gallery
          </button>
          
          <label class="btn btn-sm btn-outline-secondary rounded-pill py-2 fw-semibold mb-0 cursor-pointer text-center">
            <i class="fas fa-cloud-upload-alt me-1.5"></i> Upload from Computer
            <input type="file" name="product_image_file" id="productImageFile" accept="image/*" class="d-none" onchange="previewUploadedFile(this)">
          </label>
        </div>

        <div class="d-flex align-items-center justify-content-between pt-1">
          <span class="text-muted fs-9 text-truncate me-2" id="currentImagePathLabel">
            {{ old('product_image') ?: 'No file chosen' }}
          </span>
          <button type="button" class="btn btn-link text-danger fs-9 p-0 text-decoration-none" onclick="clearSelectedImage()">
            <i class="fas fa-trash-alt me-0.5"></i> Clear
          </button>
        </div>

        <div class="row g-2 mt-3 mb-3">
          <div class="col-6">
            <label class="form-label fw-semibold fs-7">Weight</label>
            <input type="text" name="weight" class="form-control" placeholder="125g / 4.4 oz" value="{{ old('weight') }}">
          </div>
          <div class="col-6">
            <label class="form-label fw-semibold fs-7">Tags</label>
            <input type="text" name="tags" class="form-control" placeholder="honey, oats, dry skin" value="{{ old('tags') }}">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold fs-7">Packaging Info</label>
          <input type="text" name="packaging_info" class="form-control" placeholder="100% Recycled Paper Box" value="{{ old('packaging_info') }}">
        </div>
      </div>

      <div class="p-3 bg-light rounded border mb-3">
        <label class="form-label fw-semibold fs-7">Botanical Ingredients</label>
        <div class="d-flex flex-column gap-1 overflow-auto" style="max-height: 180px;">
          @foreach($ingredients as $ing)
            <div class="form-check fs-7">
              <input type="checkbox" name="ingredients[]" value="{{ $ing->id }}" class="form-check-input" id="ing_{{ $ing->id }}">
              <label class="form-check-label" for="ing_{{ $ing->id }}">{{ $ing->name }}</label>
            </div>
          @endforeach
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill"><i class="fas fa-save me-1"></i> Save Product</button>
    </div>
  </div>
</form>

<!-- Image Selection Modal -->
<div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-light border-bottom px-4 py-3">
        <div>
          <h5 class="modal-title fw-bold text-dark" id="imageGalleryModalLabel">
            <i class="fas fa-images text-warning me-2"></i>Select Product Image from Gallery
          </h5>
          <p class="text-muted fs-8 mb-0">Click on any image to instantly select it for this product.</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <!-- Search filter input -->
        <div class="mb-4">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
            <input type="text" id="gallerySearchInput" class="form-control border-start-0" placeholder="Search images by name..." onkeyup="filterGalleryImages()">
          </div>
        </div>

        <!-- Gallery Grid -->
        <div class="row g-3" id="galleryImagesGrid">
          @forelse($galleryImages as $img)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 gallery-img-item" data-filename="{{ strtolower(basename($img)) }}">
              <div class="card h-100 border shadow-xs text-center cursor-pointer gallery-card position-relative overflow-hidden" 
                   onclick="selectGalleryImage('{{ $img }}', '{{ asset($img) }}')"
                   style="transition: all 0.2s ease; cursor: pointer; border-radius: 12px;">
                <div class="p-2 bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                  <img src="{{ asset($img) }}" alt="{{ basename($img) }}" class="img-fluid rounded" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <div class="card-footer bg-white p-1.5 border-top">
                  <span class="d-block fs-9 text-truncate text-muted" title="{{ basename($img) }}">{{ basename($img) }}</span>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-5 text-muted">
              <i class="fas fa-images fa-3x mb-2 text-secondary opacity-50"></i>
              <p class="mb-0">No images found in gallery folder.</p>
            </div>
          @endforelse
        </div>
      </div>

      <div class="modal-footer bg-light border-top px-4 py-2.5">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function selectGalleryImage(relPath, fullUrl) {
    document.getElementById('productImageInput').value = relPath;
    const imgPreview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('imagePlaceholder');
    const label = document.getElementById('currentImagePathLabel');
    
    imgPreview.src = fullUrl;
    imgPreview.style.display = 'block';
    if (placeholder) placeholder.style.display = 'none';
    if (label) label.textContent = relPath.split('/').pop();

    // Reset file input if gallery selected
    const fileInput = document.getElementById('productImageFile');
    if (fileInput) fileInput.value = '';

    // Close modal
    const modalEl = document.getElementById('imageGalleryModal');
    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modal.hide();
  }

  function previewUploadedFile(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const imgPreview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('imagePlaceholder');
        const label = document.getElementById('currentImagePathLabel');
        
        imgPreview.src = e.target.result;
        imgPreview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
        if (label) label.textContent = 'Upload: ' + input.files[0].name;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  function clearSelectedImage() {
    document.getElementById('productImageInput').value = '';
    const fileInput = document.getElementById('productImageFile');
    if (fileInput) fileInput.value = '';
    
    const imgPreview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('imagePlaceholder');
    const label = document.getElementById('currentImagePathLabel');
    
    imgPreview.src = '';
    imgPreview.style.display = 'none';
    if (placeholder) placeholder.style.display = 'block';
    if (label) label.textContent = 'No image selected';
  }

  function filterGalleryImages() {
    const q = document.getElementById('gallerySearchInput').value.toLowerCase();
    const items = document.querySelectorAll('.gallery-img-item');
    items.forEach(item => {
      const filename = item.getAttribute('data-filename');
      if (filename.includes(q)) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  }
</script>
@endpush
@endsection
