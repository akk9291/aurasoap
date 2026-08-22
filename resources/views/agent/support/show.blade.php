@extends('layouts.agent')

@section('page_title', 'Ticket ' . $ticket->ticket_number . ' - ' . $ticket->subject)

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.support.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Support Desk
  </a>
</div>

<div class="row g-4">
  <!-- Conversation Thread -->
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5 mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
          <span class="badge bg-{{ $ticket->status_badge }} bg-opacity-10 text-{{ $ticket->status_badge }} border border-{{ $ticket->status_badge }} px-3 py-1 rounded-pill fs-8 fw-bold mb-2">
            Status: {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
          </span>
          <h4 class="fw-bold text-dark mb-1">{{ $ticket->subject }}</h4>
          <span class="fs-8 text-muted">Ticket Number: <span class="font-monospace fw-bold text-dark">{{ $ticket->ticket_number }}</span></span>
        </div>
        <span class="badge bg-{{ $ticket->priority_badge }} px-3 py-1.5 rounded-pill fs-8">
          {{ ucfirst($ticket->priority) }} Priority
        </span>
      </div>

      <!-- Messages Thread -->
      <div class="d-flex flex-column gap-3 mb-4">
        @foreach($ticket->messages as $msg)
          <div class="p-3.5 rounded-4 {{ $msg->is_admin_reply ? 'bg-warning-subtle border border-warning ms-4' : 'bg-light me-4 border' }}">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold fs-8 {{ $msg->is_admin_reply ? 'bg-warning text-dark' : 'bg-primary text-white' }}" style="width: 28px; height: 28px;">
                  {{ $msg->is_admin_reply ? 'A' : strtoupper(substr($msg->user->name ?? 'A', 0, 1)) }}
                </div>
                <strong class="fs-7 text-dark">{{ $msg->is_admin_reply ? 'Aura Soaps Management' : ($msg->user->name ?? 'You') }}</strong>
                @if($msg->is_admin_reply)
                  <span class="badge bg-dark text-white fs-9">Official Response</span>
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
      @if($ticket->status !== 'closed')
        <div class="pt-4 border-top">
          <h6 class="fw-bold text-dark mb-3"><i class="fas fa-reply text-warning me-2"></i>Post Reply</h6>
          <form action="{{ route('agent.support.reply', $ticket) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <textarea name="message" class="form-control fs-7" rows="4" placeholder="Write your reply here..." required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fs-8 text-muted fw-bold">Attach Supporting Document (Optional)</label>
              <input type="file" name="attachment" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png,.docx,.zip">
            </div>
            <button type="submit" class="btn btn-aura rounded-pill px-4">
              <i class="fas fa-paper-plane me-1"></i> Send Reply
            </button>
          </form>
        </div>
      @else
        <div class="alert alert-secondary p-3 rounded-4 fs-8 text-center mb-0">
          <i class="fas fa-lock me-1"></i> This support ticket has been closed by Aura Soaps Management.
        </div>
      @endif
    </div>
  </div>

  <!-- Ticket Meta Info -->
  <div class="col-lg-4">
    <div class="agent-card p-4 mb-4">
      <h6 class="fw-bold text-dark mb-3">Ticket Information</h6>
      <div class="fs-8 d-flex flex-column gap-2.5">
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Ticket Number</span>
          <strong class="text-dark font-monospace">{{ $ticket->ticket_number }}</strong>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Created On</span>
          <span class="text-dark">{{ $ticket->created_at->format('M d, Y h:i A') }}</span>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Last Reply</span>
          <span class="text-dark">{{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : '-' }}</span>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Priority Status</span>
          <span class="badge bg-{{ $ticket->priority_badge }} px-2 py-0.5 rounded-pill">{{ ucfirst($ticket->priority) }}</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
