@extends('layouts.agent')

@section('page_title', 'Open Support Ticket')

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.support.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Support Desk
  </a>
</div>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5">
      <div class="mb-4 pb-3 border-bottom">
        <h4 class="fw-bold text-dark mb-1">Open Support Request</h4>
        <span class="fs-7 text-muted">Send a message or inquiry directly to Aura Soaps commercial & logistics management</span>
      </div>

      <form action="{{ route('agent.support.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-4">
          <div class="col-md-8">
            <label class="form-label fw-bold fs-7 text-dark">Subject / Topic *</label>
            <input type="text" name="subject" class="form-control" placeholder="e.g. Request for store banner materials / Delivery inquiry for Order #AS-ORD..." value="{{ old('subject') }}" required>
          </div>

          <div class="col-md-4">
            <label class="form-label fw-bold fs-7 text-dark">Priority Level *</label>
            <select name="priority" class="form-select" required>
              <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
              <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High Priority</option>
              <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
              <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low / General Question</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label fw-bold fs-7 text-dark">Your Message / Request *</label>
            <textarea name="message" class="form-control" rows="5" placeholder="Please provide clear details regarding your request so our team can assist promptly." required>{{ old('message') }}</textarea>
          </div>

          <div class="col-12">
            <label class="form-label fw-bold fs-7 text-dark">Attachment (Optional)</label>
            <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.docx,.zip">
            <div class="form-text fs-9">Attach purchase orders, store display photos, or supporting documentation (Max 10MB).</div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('agent.support.index') }}" class="btn btn-light rounded-pill px-3">Cancel</a>
          <button type="submit" class="btn btn-aura rounded-pill px-4">
            <i class="fas fa-paper-plane me-1"></i> Send Request
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
