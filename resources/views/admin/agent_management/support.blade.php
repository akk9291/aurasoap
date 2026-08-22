@extends('layouts.admin')

@section('page_title', 'Agent Support Helpdesk')

@section('content')
<div class="admin-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">Agent Support Inquiries & Requests</h4>
      <span class="fs-7 text-muted">Respond to Principal Agent support tickets, logistics inquiries, and marketing material requests</span>
    </div>
  </div>

  <!-- Filter -->
  <div class="mt-4 pt-3 border-top">
    <form action="{{ route('admin.agent_management.support') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-md-4">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Ticket Statuses</option>
          <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
          <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
          <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
          <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
      </div>
    </form>
  </div>
</div>

<div class="admin-card p-4">
  @if($tickets->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Ticket #</th>
            <th>Principal Agent</th>
            <th>Subject</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Last Reply</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tickets as $tck)
            <tr>
              <td class="fw-bold font-monospace">
                <a href="{{ route('admin.agent_management.support.show', $tck) }}" class="text-dark text-decoration-none">
                  {{ $tck->ticket_number }}
                </a>
              </td>
              <td>
                <div class="fw-semibold text-dark">{{ $tck->user->name ?? 'Agent' }}</div>
                <div class="fs-9 text-muted">{{ $tck->user->agentProfile->company_name ?? '-' }}</div>
              </td>
              <td>
                <div class="text-dark fw-semibold">{{ $tck->subject }}</div>
              </td>
              <td>
                <span class="badge bg-{{ $tck->priority_badge }} bg-opacity-10 text-{{ $tck->priority_badge }} border border-{{ $tck->priority_badge }} px-2 py-0.5 rounded-pill fs-9">
                  {{ ucfirst($tck->priority) }}
                </span>
              </td>
              <td>
                <span class="badge bg-{{ $tck->status_badge }} bg-opacity-10 text-{{ $tck->status_badge }} border border-{{ $tck->status_badge }} px-2.5 py-1 rounded-pill fs-8">
                  {{ ucfirst(str_replace('_', ' ', $tck->status)) }}
                </span>
              </td>
              <td class="text-muted fs-8">{{ $tck->last_reply_at ? $tck->last_reply_at->diffForHumans() : '-' }}</td>
              <td class="text-end">
                <a href="{{ route('admin.agent_management.support.show', $tck) }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1 fs-8 text-primary">
                  <i class="fas fa-reply me-1"></i> Respond
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $tickets->links() }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-headset text-muted fs-1 mb-3"></i>
      <h5 class="fw-bold text-dark">No support tickets found.</h5>
    </div>
  @endif
</div>
@endsection
