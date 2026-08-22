@extends('layouts.admin')

@section('page_title', 'Support Ticket ' . $ticket->ticket_number)

@section('content')
<div class="mb-3">
  <a href="{{ route('admin.agent_management.support') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Agent Support Desk
  </a>
</div>

<div class="row g-4">
  <!-- Conversation Thread -->
  <div class="col-lg-8">
    <div class="admin-card p-4 p-md-5 mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
          <span class="badge bg-{{ $ticket->status_badge }} bg-opacity-10 text-{{ $ticket->status_badge }} border border-{{ $ticket->status_badge }} px-3 py-1 rounded-pill fs-8 fw-bold mb-2">
            Status: {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
          </span>
          <h4 class="fw-bold text-dark mb-1">{{ $ticket->subject }}</h4>
          <span class="fs-8 text-muted">From Agent: <strong>{{ $ticket->user->name ?? 'Agent' }}</strong> ({{ $ticket->user->agentProfile->company_name ?? 'Principal Agent' }})</span>
        </div>
        <span class="badge bg-{{ $ticket->priority_badge }} px-3 py-1.5 rounded-pill fs-8">
          {{ ucfirst($ticket->priority) }} Priority
        </span>
      </div>

      <!-- Messages Thread -->
      <div class="d-flex flex-column gap-3 mb-4">
        @foreach($ticket->messages as $msg)
          <div class="p-3.5 rounded-4 {{ $msg->is_admin_reply ? 'bg-primary-subtle border border-primary me-4' : 'bg-light ms-4 border' }}">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold fs-8 {{ $msg->is_admin_reply ? 'bg-primary text-white' : 'bg-secondary text-white' }}" style="width: 28px; height: 28px;">
                  {{ $msg->is_admin_reply ? 'M' : strtoupper(substr($msg->user->name ?? 'A', 0, 1)) }}
                </div>
                <strong class="fs-7 text-dark">{{ $msg->is_admin_reply ? 'Aura Soaps Management' : ($msg->user->name ?? 'Agent') }}</strong>
                @if($msg->is_admin_reply)
                  <span class="badge bg-primary text-white fs-9">Admin Reply</span>
                @endif
              </div>
              <span class="text-muted fs-9">{{ $msg->created_at->format('M d, Y h:i A') }}</span>
            </div>

            <div class="fs-7 text-dark lh-lg mb-2">{!! nl2br(e($msg->message)) !!}</div>

            @if($msg->attachment_path)
              <div class="pt-2 border-top mt-2">
                <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="fs-8 text-decoration-none text-primary fw-semibold">
                  <i class="fas fa-paperclip me-1"></i> View Attached File
                </a>
              </div>
            @endif
          </div>
        @endforeach
      </div>

      <!-- Reply Box -->
      <div class="pt-4 border-top">
        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-reply text-warning me-2"></i>Send Response to Agent</h6>
        <form action="{{ route('admin.agent_management.support.reply', $ticket) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <textarea name="message" class="form-control fs-7" rows="4" placeholder="Write response message to agent..." required></textarea>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fs-8 text-muted fw-bold">Update Ticket Status</label>
              <select name="status" class="form-select form-select-sm" required>
                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Keep Open</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fs-8 text-muted fw-bold">Attach File (Optional)</label>
              <input type="file" name="attachment" class="form-control form-control-sm">
            </div>
          </div>

          <button type="submit" class="btn btn-aura rounded-pill px-4">
            <i class="fas fa-paper-plane me-1"></i> Post Response
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Ticket Meta Info -->
  <div class="col-lg-4">
    <div class="admin-card p-4 mb-4">
      <h6 class="fw-bold text-dark mb-3">Agent Profile</h6>
      <div class="fs-8 d-flex flex-column gap-2.5">
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Representative Name</span>
          <strong class="text-dark">{{ $ticket->user->name ?? '-' }}</strong>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Company / Warehouse</span>
          <span class="text-dark">{{ $ticket->user->agentProfile->company_name ?? '-' }}</span>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Agent ID Code</span>
          <span class="badge bg-warning text-dark font-monospace">{{ $ticket->user->agentProfile->agent_code ?? 'Pending' }}</span>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Contact Phone</span>
          <a href="tel:{{ $ticket->user->phone }}" class="text-dark text-decoration-none">{{ $ticket->user->phone ?? '-' }}</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
