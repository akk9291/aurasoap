@extends('layouts.admin')

@section('page_title', 'SEO Manager & Metadata')

@section('content')
<div class="row g-4">
  <div class="col-md-4">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-amber me-1"></i> Add Page SEO Rule</h6>
      <form action="{{ route('admin.seo.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Page Route Key <span class="text-danger">*</span></label>
          <input type="text" name="page_route" class="form-control form-control-sm" placeholder="e.g. home, products, contact" required>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">SEO Title <span class="text-danger">*</span></label>
          <input type="text" name="title" class="form-control form-control-sm" placeholder="Aura Soaps | Premium Natural Skincare" required>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Meta Description</label>
          <textarea name="meta_description" class="form-control form-control-sm" rows="3" placeholder="Handcrafted organic soaps..."></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Focus Keyword</label>
          <input type="text" name="focus_keyword" class="form-control form-control-sm" placeholder="organic soaps, natural skincare">
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Robots Meta</label>
          <input type="text" name="robots" class="form-control form-control-sm" value="index, follow">
        </div>
        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold rounded-pill"><i class="fas fa-save me-1"></i> Save SEO Metadata</button>
      </form>
    </div>
  </div>

  <div class="col-md-8">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-search text-info me-1"></i> Configured SEO Metadata</h6>
      @if($seoMetas->count())
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
              <tr>
                <th>Page Route</th>
                <th>SEO Title</th>
                <th>Focus Keyword</th>
                <th>Robots</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($seoMetas as $s)
                <tr>
                  <td><code>{{ $s->page_route ?: 'Global Default' }}</code></td>
                  <td class="fw-semibold text-dark">{{ Str::limit($s->title, 30) }}</td>
                  <td><span class="badge bg-light text-dark border">{{ $s->focus_keyword ?: 'None' }}</span></td>
                  <td><span class="badge bg-success-subtle text-success">{{ $s->robots ?: 'index, follow' }}</span></td>
                  <td class="text-end">
                    <form action="{{ route('admin.seo.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this SEO rule?');">
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
        <p class="text-muted text-center py-4 fs-7 mb-0">No custom page SEO rules added yet. Standard sensible defaults are active.</p>
      @endif
    </div>
  </div>
</div>
@endsection
