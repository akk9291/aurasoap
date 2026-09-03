@extends('layouts.agent')

@section('page_title', 'My Enquiries Pipeline')

@section('content')
<div class="agent-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">Customer / Buyer Enquiries</h4>
      <span class="fs-7 text-muted">Track buyer requests, follow-ups, and convert prospective leads into confirmed orders</span>
    </div>
    <a href="{{ route('agent.enquiries.create') }}" class="btn btn-aura rounded-pill px-3 fs-8">
      <i class="fas fa-plus me-1"></i> Log New Enquiry
    </a>
  </div>

  <!-- Filter Pipeline -->
  <div class="mt-4 pt-3 border-top">
    <form action="{{ route('agent.enquiries.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
          <input type="text" name="search" class="form-control border-start-0" placeholder="Search by enquiry title or product interest..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-md-4">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Pipeline Stages</option>
          <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Enquiry</option>
          <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted / Pricing Sent</option>
          <option value="follow_up" {{ request('status') == 'follow_up' ? 'selected' : '' }}>Follow-up Scheduled</option>
          <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted to Order</option>
          <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
      </div>

      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Filter</button>
        @if(request()->hasAny(['search', 'status']))
          <a href="{{ route('agent.enquiries.index') }}" class="btn btn-sm btn-light border rounded-3 px-3 text-danger">Reset</a>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Enquiries List -->
<div class="agent-card p-4">
  @if($enquiries->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Enquiry Title</th>
            <th>Buyer / Client</th>
            <th>Product Interests</th>
            <th>Est. Quantity</th>
            <th>Stage</th>
            <th>Logged Date</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($enquiries as $enq)
            <tr>
              <td>
                <a href="{{ route('agent.enquiries.show', $enq) }}" class="fw-bold text-decoration-none text-dark">
                  {{ $enq->title }}
                </a>
              </td>
              <td>
                @if($enq->client)
                  <a href="{{ route('agent.clients.show', $enq->client) }}" class="fw-semibold text-primary text-decoration-none">
                    {{ $enq->client->name }}
                  </a>
                @else
                  <span class="text-muted">Unlinked Buyer</span>
                @endif
              </td>
              <td class="text-secondary">{{ $enq->product_interests ?? 'General Soap line' }}</td>
              <td class="font-monospace fs-8">{{ $enq->estimated_quantity ?? '-' }}</td>
              <td>
                <span class="badge bg-{{ $enq->status_badge }} bg-opacity-10 text-{{ $enq->status_badge }} border border-{{ $enq->status_badge }} px-2 py-0.5 rounded-pill fs-8">
                  {{ ucfirst(str_replace('_', ' ', $enq->status)) }}
                </span>
              </td>
              <td class="text-muted fs-8">{{ $enq->created_at->format('M d, Y') }}</td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('agent.enquiries.show', $enq) }}" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 fs-8">
                    <i class="fas fa-eye me-1 text-primary"></i> View
                  </a>
                  @if($enq->status !== 'converted')
                    <a href="{{ route('agent.orders.create', ['client_id' => $enq->client_id]) }}" class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-1 fs-8">
                      <i class="fas fa-cart-plus me-1"></i> Order
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $enquiries->links('pagination::bootstrap-5') }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-comments text-muted fs-1 mb-3"></i>
      <h5 class="fw-bold text-dark">No enquiries recorded in this pipeline stage.</h5>
      <p class="text-muted fs-7 mb-3">Keep track of every customer demand and question to maximize your order conversion.</p>
      <a href="{{ route('agent.enquiries.create') }}" class="btn btn-aura rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> Record New Enquiry
      </a>
    </div>
  @endif
</div>
@endsection
