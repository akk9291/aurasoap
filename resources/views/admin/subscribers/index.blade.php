@extends('layouts.admin')

@section('page_title', 'Newsletter Subscribers')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h5 class="fw-bold mb-0">Newsletter Subscribers</h5>
    <p class="text-muted fs-7 mb-0">Export and manage email marketing subscribers</p>
  </div>
  <a href="{{ route('admin.subscribers.export') }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold">
    <i class="fas fa-file-csv me-1"></i> Export Subscribers CSV
  </a>
</div>

<div class="admin-card p-3">
  @if($subscribers->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Email</th>
            <th>Source</th>
            <th>Status</th>
            <th>Subscribed Date</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($subscribers as $s)
            <tr>
              <td class="fw-bold text-dark">{{ $s->email }}</td>
              <td><code>{{ $s->source }}</code></td>
              <td><span class="badge bg-success-subtle text-success">{{ ucfirst($s->status) }}</span></td>
              <td>{{ $s->created_at->format('M d, Y H:i') }}</td>
              <td class="text-end">
                <form action="{{ route('admin.subscribers.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete subscriber?');">
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
      {{ $subscribers->links() }}
    </div>
  @else
    <p class="text-muted text-center py-4 fs-7 mb-0">No subscribers collected yet.</p>
  @endif
</div>
@endsection
