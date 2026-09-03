@extends('layouts.admin')

@section('page_title', 'Principal Agent Marketing Collateral CMS')

@section('content')
<div class="row g-4">
  <!-- Upload New Material -->
  <div class="col-lg-4">
    <div class="admin-card p-4">
      <h5 class="fw-bold text-dark mb-3"><i class="fas fa-upload text-warning me-2"></i>Publish Marketing Material</h5>
      <p class="fs-8 text-muted mb-3">Upload brochures, product spec sheets, promotional posters (PDF/JPG) or training manuals for authorized Agents to download.</p>

      <form action="{{ route('admin.agent_management.marketing.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label class="form-label fw-bold fs-8 text-dark">Resource Title *</label>
          <input type="text" name="title" class="form-control form-control-sm" placeholder="e.g. Aura Soaps 2026 Master Catalogue" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-8 text-dark">Category *</label>
          <select name="category" class="form-select form-select-sm" required>
            <option value="catalogue">Product Catalogue</option>
            <option value="poster">Promotional Poster</option>
            <option value="spec_sheet">Pricing & Specification Sheet</option>
            <option value="training">Training / Sales Manual</option>
            <option value="brochure">Sales Brochure</option>
            <option value="photo">Photo Assets Pack</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-8 text-dark">Description</label>
          <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Brief summary of the document..."></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-8 text-dark">Upload File * (Max 50MB)</label>
          <input type="file" name="file" class="form-control form-control-sm" required>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" name="is_active" id="isActive" checked>
          <label class="form-check-label fs-8" for="isActive">Publish immediately for Agents</label>
        </div>

        <button type="submit" class="btn btn-sm btn-aura w-100 rounded-pill">
          <i class="fas fa-cloud-upload-alt me-1"></i> Upload & Publish
        </button>
      </form>
    </div>
  </div>

  <!-- Published Materials List -->
  <div class="col-lg-8">
    <div class="admin-card p-4">
      <h5 class="fw-bold text-dark mb-3">Published Resources ({{ $materials->total() }})</h5>

      @if($materials->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
              <tr>
                <th>Resource</th>
                <th>Category</th>
                <th>Format / Size</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($materials as $mat)
                <tr>
                  <td>
                    <div class="fw-bold text-dark">{{ $mat->title }}</div>
                    <div class="fs-9 text-muted">{{ Str::limit($mat->description, 60) }}</div>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border fs-9">{{ $mat->category_label }}</span>
                  </td>
                  <td class="font-monospace fs-9 text-muted">
                    {{ strtoupper($mat->file_type ?? 'PDF') }} &bull; {{ $mat->formatted_size }}
                  </td>
                  <td>
                    <span class="badge bg-{{ $mat->is_active ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $mat->is_active ? 'success' : 'secondary' }} px-2 py-0.5 rounded-pill fs-9">
                      {{ $mat->is_active ? 'Active' : 'Draft' }}
                    </span>
                  </td>
                  <td class="text-end">
                    <form action="{{ route('admin.agent_management.marketing.destroy', $mat) }}" method="POST" onsubmit="return confirm('Delete this marketing collateral?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm text-danger" title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-3">
          {{ $materials->links('pagination::bootstrap-5') }}
        </div>
      @else
        <p class="text-muted fs-8 text-center my-4">No marketing assets uploaded yet.</p>
      @endif
    </div>
  </div>
</div>
@endsection
