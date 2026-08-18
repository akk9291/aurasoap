@extends('layouts.admin')

@section('page_title', '301 / 302 URL Redirect Manager')

@section('content')
<div class="row g-4">
  <div class="col-md-4">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-amber me-1"></i> Add URL Redirect Rule</h6>
      <form action="{{ route('admin.redirects.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Old Path / Source URL <span class="text-danger">*</span></label>
          <input type="text" name="old_url" class="form-control form-control-sm" placeholder="/old-soap-page" required>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">New Path / Target URL <span class="text-danger">*</span></label>
          <input type="text" name="new_url" class="form-control form-control-sm" placeholder="/products" required>
        </div>
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">HTTP Redirect Type</label>
          <select name="status_code" class="form-select form-select-sm">
            <option value="301">301 (Permanent Redirect)</option>
            <option value="302">302 (Temporary Redirect)</option>
          </select>
        </div>
        <div class="form-check mb-3">
          <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
          <label class="form-check-label fs-7 fw-semibold" for="is_active">Enable Redirect Rule</label>
        </div>
        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold rounded-pill"><i class="fas fa-save me-1"></i> Save Redirect Rule</button>
      </form>
    </div>
  </div>

  <div class="col-md-8">
    <div class="admin-card p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-exchange-alt text-info me-1"></i> Active Redirect Rules</h6>
      @if($redirects->count())
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
              <tr>
                <th>Old URL</th>
                <th>Target URL</th>
                <th>Status Code</th>
                <th>State</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($redirects as $r)
                <tr>
                  <td><code>{{ $r->old_url }}</code></td>
                  <td><code>{{ $r->new_url }}</code></td>
                  <td><span class="badge bg-secondary">{{ $r->status_code }}</span></td>
                  <td>
                    @if($r->is_active)
                      <span class="badge bg-success-subtle text-success">Active</span>
                    @else
                      <span class="badge bg-danger-subtle text-danger">Disabled</span>
                    @endif
                  </td>
                  <td class="text-end">
                    <form action="{{ route('admin.redirects.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this redirect rule?');">
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
        <p class="text-muted text-center py-4 fs-7 mb-0">No active 301/302 URL redirects configured yet.</p>
      @endif
    </div>
  </div>
</div>
@endsection
