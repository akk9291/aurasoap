@extends('layouts.agent')

@section('page_title', 'Enquiry Details - ' . $enquiry->title)

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.enquiries.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Enquiries
  </a>
</div>

<div class="row g-4">
  <!-- Enquiry Details Card -->
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5 mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
          <span class="badge bg-{{ $enquiry->status_badge }} bg-opacity-10 text-{{ $enquiry->status_badge }} border border-{{ $enquiry->status_badge }} px-3 py-1 rounded-pill fs-8 fw-bold mb-2">
            Status: {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
          </span>
          <h4 class="fw-bold text-dark mb-1">{{ $enquiry->title }}</h4>
          <span class="fs-8 text-muted">Logged on {{ $enquiry->created_at->format('M d, Y h:i A') }}</span>
        </div>

        <div class="d-flex gap-2">
          @if($enquiry->client)
            <a href="{{ route('agent.orders.create', ['client_id' => $enquiry->client->id]) }}" class="btn btn-aura rounded-pill px-3 fs-8">
              <i class="fas fa-cart-plus me-1"></i> Convert to Order
            </a>
          @else
            <a href="{{ route('agent.orders.create') }}" class="btn btn-aura rounded-pill px-3 fs-8">
              <i class="fas fa-cart-plus me-1"></i> Convert to Order
            </a>
          @endif
        </div>
      </div>

      <div class="row g-3 fs-7 mb-4">
        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Product Interests</label>
          <div class="fw-bold text-dark fs-6">{{ $enquiry->product_interests ?? 'General Soap line' }}</div>
        </div>

        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Estimated Quantity</label>
          <div class="fw-bold text-dark fs-6 font-monospace">{{ $enquiry->estimated_quantity ?? 'Not specified' }}</div>
        </div>

        @if($enquiry->description)
          <div class="col-12">
            <label class="text-muted fs-8 text-uppercase fw-bold">Customer Enquiry Content</label>
            <div class="p-3 bg-light rounded-3 text-secondary lh-lg">{!! nl2br(e($enquiry->description)) !!}</div>
          </div>
        @endif

        @if($enquiry->notes)
          <div class="col-12">
            <label class="text-muted fs-8 text-uppercase fw-bold">Internal Notes & History</label>
            <div class="p-3 bg-light rounded-3 text-secondary font-monospace fs-8">{!! nl2br(e($enquiry->notes)) !!}</div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Status Progression & Buyer Info -->
  <div class="col-lg-4">
    <!-- Quick Status Update Card -->
    <div class="agent-card p-4 mb-4">
      <h6 class="fw-bold text-dark mb-3">Update Pipeline Stage</h6>
      <form action="{{ route('agent.enquiries.update-status', $enquiry) }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-8 text-muted fw-bold">Pipeline Stage</label>
          <select name="status" class="form-select form-select-sm" required>
            <option value="new" {{ $enquiry->status == 'new' ? 'selected' : '' }}>New Enquiry</option>
            <option value="contacted" {{ $enquiry->status == 'contacted' ? 'selected' : '' }}>Contacted / Quotation Sent</option>
            <option value="follow_up" {{ $enquiry->status == 'follow_up' ? 'selected' : '' }}>Follow-up Scheduled</option>
            <option value="converted" {{ $enquiry->status == 'converted' ? 'selected' : '' }}>Converted to Confirmed Order</option>
            <option value="closed" {{ $enquiry->status == 'closed' ? 'selected' : '' }}>Closed / Inactive</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fs-8 text-muted fw-bold">Add Note to History</label>
          <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="e.g. Quoted $18.50 per box. Delivery on Friday."></textarea>
        </div>

        <button type="submit" class="btn btn-sm btn-dark w-100 rounded-pill">
          <i class="fas fa-sync-alt me-1"></i> Update Stage
        </button>
      </form>
    </div>

    <!-- Client Link Card -->
    <div class="agent-card p-4">
      <h6 class="fw-bold text-dark mb-3">Associated Buyer Profile</h6>
      @if($enquiry->client)
        <div class="d-flex align-items-center gap-2 mb-3">
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-6" style="width: 40px; height: 40px;">
            {{ strtoupper(substr($enquiry->client->name, 0, 1)) }}
          </div>
          <div>
            <div class="fw-bold fs-7 text-dark">{{ $enquiry->client->name }}</div>
            <div class="fs-9 text-muted">{{ $enquiry->client->company_name ?? ucfirst($enquiry->client->client_type) }}</div>
          </div>
        </div>

        <div class="fs-8 d-flex flex-column gap-2 mb-3">
          <div><i class="fas fa-phone text-muted me-1"></i> {{ $enquiry->client->phone }}</div>
          @if($enquiry->client->email)
            <div><i class="fas fa-envelope text-muted me-1"></i> {{ $enquiry->client->email }}</div>
          @endif
          <div><i class="fas fa-map-marker-alt text-muted me-1"></i> {{ $enquiry->client->city ?? 'Rwanda' }}</div>
        </div>

        <a href="{{ route('agent.clients.show', $enquiry->client) }}" class="btn btn-sm btn-light border w-100 rounded-pill fs-8">
          View Full Client Profile
        </a>
      @else
        <p class="fs-8 text-muted mb-3">This enquiry is not linked to an existing buyer profile.</p>
        <a href="{{ route('agent.clients.create') }}" class="btn btn-sm btn-outline-dark rounded-pill w-100 fs-8">
          <i class="fas fa-user-plus me-1"></i> Create Client Profile
        </a>
      @endif
    </div>
  </div>
</div>
@endsection
