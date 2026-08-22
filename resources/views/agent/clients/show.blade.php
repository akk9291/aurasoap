@extends('layouts.agent')

@section('page_title', $client->name . ' - Buyer Profile')

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.clients.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Clients CRM
  </a>
</div>

<div class="row g-4">
  <!-- Client Profile Overview -->
  <div class="col-lg-4">
    <div class="agent-card p-4 text-center mb-4">
      <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-3 mb-3" style="width: 64px; height: 64px;">
        {{ strtoupper(substr($client->name, 0, 1)) }}
      </div>
      <h5 class="fw-bold text-dark mb-1">{{ $client->name }}</h5>
      <p class="text-muted fs-8 mb-2">{{ $client->company_name ?? 'Independent Stockist' }}</p>
      
      <div class="d-flex justify-content-center gap-2 mb-3">
        <span class="badge bg-{{ $client->client_type === 'wholesaler' ? 'primary' : 'info' }} bg-opacity-10 text-{{ $client->client_type === 'wholesaler' ? 'primary' : 'info' }} border border-{{ $client->client_type === 'wholesaler' ? 'primary' : 'info' }} px-3 py-1 rounded-pill fs-8">
          {{ ucfirst($client->client_type) }}
        </span>
        <span class="badge bg-{{ $client->status === 'active' ? 'success' : 'secondary' }} px-3 py-1 rounded-pill fs-8">
          {{ ucfirst($client->status) }}
        </span>
      </div>

      <div class="d-grid gap-2 pt-3 border-top">
        <a href="{{ route('agent.orders.create', ['client_id' => $client->id]) }}" class="btn btn-aura rounded-pill fs-8">
          <i class="fas fa-cart-plus me-1"></i> Place Order for Client
        </a>
        <a href="{{ route('agent.enquiries.create', ['client_id' => $client->id]) }}" class="btn btn-outline-info rounded-pill fs-8 text-dark">
          <i class="fas fa-comment-medical me-1"></i> Log Client Enquiry
        </a>
        <a href="{{ route('agent.clients.edit', $client) }}" class="btn btn-light border rounded-pill fs-8">
          <i class="fas fa-edit me-1"></i> Edit Details
        </a>
      </div>
    </div>

    <!-- Contact Info Card -->
    <div class="agent-card p-4">
      <h6 class="fw-bold text-dark mb-3">Contact Information</h6>
      <div class="d-flex flex-column gap-2.5 fs-8">
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Phone Number</span>
          <a href="tel:{{ $client->phone }}" class="text-dark fw-semibold text-decoration-none"><i class="fas fa-phone me-1 text-primary"></i> {{ $client->phone }}</a>
        </div>
        @if($client->whatsapp)
          <div>
            <span class="text-muted fs-9 d-block text-uppercase fw-bold">WhatsApp</span>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client->whatsapp) }}" target="_blank" class="text-success fw-semibold text-decoration-none"><i class="fab fa-whatsapp me-1"></i> {{ $client->whatsapp }}</a>
          </div>
        @endif
        @if($client->email)
          <div>
            <span class="text-muted fs-9 d-block text-uppercase fw-bold">Email Address</span>
            <a href="mailto:{{ $client->email }}" class="text-dark fw-semibold text-decoration-none"><i class="fas fa-envelope me-1 text-info"></i> {{ $client->email }}</a>
          </div>
        @endif
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Delivery Location</span>
          <div class="text-dark">{{ $client->address ?? 'Not specified' }}, {{ $client->city ?? '-' }}, {{ $client->country }}</div>
        </div>
        @if($client->notes)
          <div class="pt-2 border-top">
            <span class="text-muted fs-9 d-block text-uppercase fw-bold mb-1">Commercial Notes</span>
            <div class="p-2 bg-light rounded-3 text-secondary">{{ $client->notes }}</div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Client Activity Tabs: Orders & Enquiries -->
  <div class="col-lg-8">
    <!-- Orders History -->
    <div class="agent-card p-4 mb-4">
      <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
        <h5 class="fw-bold text-dark mb-0">Client Orders ({{ $client->orders->count() }})</h5>
        <a href="{{ route('agent.orders.create', ['client_id' => $client->id]) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fs-8">
          <i class="fas fa-plus me-1"></i> New Order
        </a>
      </div>

      @if($client->orders->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-8 mb-0">
            <thead class="table-light">
              <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($client->orders as $ord)
                <tr>
                  <td class="fw-bold font-monospace">{{ $ord->order_number }}</td>
                  <td class="text-muted">{{ $ord->created_at->format('M d, Y') }}</td>
                  <td class="fw-bold text-success">${{ number_format($ord->total_amount, 2) }}</td>
                  <td>
                    <span class="badge bg-{{ $ord->status_badge }} bg-opacity-10 text-{{ $ord->status_badge }} border border-{{ $ord->status_badge }} px-2 py-0.5 rounded-pill fs-9">
                      {{ ucfirst($ord->status) }}
                    </span>
                  </td>
                  <td class="text-end">
                    <a href="{{ route('agent.orders.show', $ord) }}" class="btn btn-sm btn-light border rounded-pill px-2.5 py-0.5 fs-9">
                      View
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-muted fs-8 text-center my-4">No orders placed for this client yet.</p>
      @endif
    </div>

    <!-- Enquiries History -->
    <div class="agent-card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
        <h5 class="fw-bold text-dark mb-0">Logged Enquiries ({{ $client->enquiries->count() }})</h5>
        <a href="{{ route('agent.enquiries.create', ['client_id' => $client->id]) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fs-8">
          <i class="fas fa-plus me-1"></i> Log Enquiry
        </a>
      </div>

      @if($client->enquiries->count() > 0)
        <div class="d-flex flex-column gap-2.5">
          @foreach($client->enquiries as $enq)
            <div class="p-3 bg-light rounded-3 d-flex align-items-start justify-content-between">
              <div>
                <a href="{{ route('agent.enquiries.show', $enq) }}" class="fw-bold text-dark text-decoration-none fs-7 d-block mb-1">
                  {{ $enq->title }}
                </a>
                <div class="fs-8 text-muted mb-1">{{ $enq->description }}</div>
                <div class="fs-9 text-muted">Interest: <strong>{{ $enq->product_interests ?? 'General range' }}</strong> &bull; {{ $enq->created_at->format('M d, Y') }}</div>
              </div>
              <span class="badge bg-{{ $enq->status_badge }} bg-opacity-10 text-{{ $enq->status_badge }} border border-{{ $enq->status_badge }} px-2 py-1 rounded-pill fs-8">
                {{ ucfirst($enq->status) }}
              </span>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted fs-8 text-center my-4">No enquiries recorded for this client.</p>
      @endif
    </div>
  </div>
</div>
@endsection
