@extends('layouts.admin')

@section('page_title', 'Contact Messages & Lead Enquiries')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h5 class="fw-bold mb-0">Contact Messages</h5>
    <p class="text-muted fs-7 mb-0">Review messages submitted through the website contact form</p>
  </div>
</div>

<div class="admin-card p-3">
  @if($enquiries->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Email / Phone</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Submitted</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($enquiries as $e)
            <tr>
              <td class="fw-bold text-dark">{{ $e->name }}</td>
              <td>
                <div>{{ $e->email }}</div>
                <div class="text-muted fs-8">{{ $e->phone ?: 'No phone provided' }}</div>
              </td>
              <td>{{ Str::limit($e->subject ?: 'General Enquiry', 35) }}</td>
              <td>
                <span class="badge bg-info-subtle text-info">{{ ucfirst($e->status) }}</span>
              </td>
              <td>{{ $e->created_at->format('M d, Y H:i') }}</td>
              <td class="text-end">
                <a href="{{ route('admin.enquiries.show', $e->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye me-1"></i> View</a>
                <form action="{{ route('admin.enquiries.destroy', $e->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this enquiry?');">
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
      {{ $enquiries->links('pagination::bootstrap-5') }}
    </div>
  @else
    <p class="text-muted text-center py-4 fs-7 mb-0">No contact messages received yet.</p>
  @endif
</div>
@endsection
