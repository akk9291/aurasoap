@extends('layouts.admin')

@section('page_title', 'Distributor & Agent Applications')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h5 class="fw-bold mb-0">Distributor Applications</h5>
    <p class="text-muted fs-7 mb-0">Manage global agency requests and wholesale partnership applications</p>
  </div>
  <a href="{{ route('admin.distributors.export') }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold">
    <i class="fas fa-file-csv me-1"></i> Export Applications CSV
  </a>
</div>

<div class="admin-card p-3">
  @if($applications->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Applicant Name</th>
            <th>Company / Country</th>
            <th>Contact Details</th>
            <th>Est. Order Vol.</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($applications as $app)
            <tr>
              <td class="fw-bold text-dark">{{ $app->name }}</td>
              <td>
                <div class="fw-semibold">{{ $app->company ?: 'Individual Agent' }}</div>
                <div class="text-muted fs-8"><i class="fas fa-globe me-1"></i> {{ $app->country ?: 'N/A' }}</div>
              </td>
              <td>
                <div>{{ $app->email }}</div>
                <div class="text-muted fs-8">{{ $app->phone }}</div>
              </td>
              <td><span class="badge bg-light text-dark border">{{ $app->estimated_order_volume ?: 'Not specified' }}</span></td>
              <td>
                <span class="badge bg-warning-subtle text-warning">{{ ucfirst($app->status) }}</span>
              </td>
              <td class="text-end">
                <a href="{{ route('admin.distributors.show', $app->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye me-1"></i> View</a>
                <form action="{{ route('admin.distributors.destroy', $app->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this application?');">
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

    <div class="pt-3">
      {{ $applications->links() }}
    </div>
  @else
    <p class="text-muted text-center py-4 fs-7 mb-0">No distributor applications submitted yet.</p>
  @endif
</div>
@endsection
