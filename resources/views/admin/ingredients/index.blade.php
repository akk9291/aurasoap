@extends('layouts.admin')

@section('page_title', 'Botanical Ingredients')

@section('content')
<div class="row g-4">
  <div class="col-md-4">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-amber me-1"></i> Add Botanical Ingredient</h6>
      <form action="{{ route('admin.ingredients.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Ingredient Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Raw Unrefined Shea Butter" required>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Image Path</label>
          <input type="text" name="image" class="form-control form-control-sm" placeholder="assets/images/ing_shea.jpg">
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Short Summary</label>
          <textarea name="short_description" class="form-control form-control-sm" rows="2" placeholder="Ethically harvested African shea butter..."></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Key Benefits</label>
          <input type="text" name="benefits" class="form-control form-control-sm" placeholder="Restores moisture, Soothes redness">
        </div>
        <div class="form-check mb-3">
          <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" checked>
          <label class="form-check-label fs-7 fw-semibold" for="is_featured">Feature on Homepage</label>
        </div>
        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold rounded-pill"><i class="fas fa-save me-1"></i> Save Ingredient</button>
      </form>
    </div>
  </div>

  <div class="col-md-8">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-leaf text-success me-1"></i> Ingredients List</h6>
      @if($ingredients->count())
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
              <tr>
                <th>Ingredient</th>
                <th>Benefits</th>
                <th>Featured</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ingredients as $ing)
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <img src="{{ asset($ing->image ?: 'assets/images/ing_shea.jpg') }}" alt="{{ $ing->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                      <div>
                        <div class="fw-bold text-dark">{{ $ing->name }}</div>
                        <div class="text-muted fs-8">{{ Str::limit($ing->short_description, 45) }}</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="badge bg-light text-dark border">{{ Str::limit($ing->benefits, 30) }}</span></td>
                  <td>
                    @if($ing->is_featured)
                      <span class="badge bg-warning-subtle text-warning"><i class="fas fa-star me-1"></i> Featured</span>
                    @else
                      <span class="text-muted">Standard</span>
                    @endif
                  </td>
                  <td class="text-end">
                    <form action="{{ route('admin.ingredients.destroy', $ing->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this ingredient?');">
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
        <p class="text-muted text-center py-4 fs-7 mb-0">No botanical ingredients created yet.</p>
      @endif
    </div>
  </div>
</div>
@endsection
