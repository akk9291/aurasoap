@extends('layouts.agent')

@section('page_title', 'Support Helpdesk')

@section('content')
<div class="agent-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">Agent Support Helpdesk</h4>
      <span class="fs-7 text-muted">Direct communication channel with Aura Soaps commercial operations and logistics management</span>
    </div>
    <a href="{{ route('agent.support.create') }}" class="btn btn-aura rounded-pill px-4 fs-8">
      <i class="fas fa-plus me-1"></i> Open Support Ticket
    </a>
  </div>
</div>

<div class="agent-card p-4">
  @if($tickets->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Ticket #</th>
            <th>Subject</th>
            <th>Priority</th>
            <th>Messages</th>
            <th>Status</th>
            <th>Last Activity</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tickets as $tck)
            <tr>
              <td>
                <a href="{{ route('agent.support.show', $tck) }}" class="fw-bold font-monospace text-decoration-none text-dark">
                  {{ $tck->ticket_number }}
                </a>
              </td>
              <td>
                <div class="fw-semibold text-dark">{{ $tck->subject }}</div>
              </td>
              <td>
                <span class="badge bg-{{ $tck->priority_badge }} bg-opacity-10 text-{{ $tck->priority_badge }} border border-{{ $tck->priority_badge }} px-2 py-0.5 rounded-pill fs-9">
                  {{ ucfirst($tck->priority) }}
                </span>
              </td>
              <td>
                <span class="badge bg-light text-dark border font-monospace">{{ $tck->messages_count }} message(s)</span>
              </td>
              <td>
                <span class="badge bg-{{ $tck->status_badge }} bg-opacity-10 text-{{ $tck->status_badge }} border border-{{ $tck->status_badge }} px-2 py-0.5 rounded-pill fs-8">
                  {{ ucfirst(str_replace('_', ' ', $tck->status)) }}
                </span>
              </td>
              <td class="text-muted fs-8">{{ $tck->updated_at->diffForHumans() }}</td>
              <td class="text-end">
                <a href="{{ route('agent.support.show', $tck) }}" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 fs-8">
                  <i class="fas fa-comments me-1 text-primary"></i> View Thread
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
      <h5 class="fw-bold text-dark">No support tickets opened.</h5>
      <p class="text-muted fs-7 mb-3">Need assistance with orders, custom pricing, shelf displays or marketing collateral?</p>
      <a href="{{ route('agent.support.create') }}" class="btn btn-aura rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> Contact Aura Soaps Team
      </a>
    </div>
  @endif
</div>
@endsection
