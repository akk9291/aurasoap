@extends('layouts.agent')

@section('page_title', 'My Orders')

@section('content')
<div class="agent-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">My Orders Management</h4>
      <span class="fs-7 text-muted">Track order processing, dispatch status, invoices and delivery confirmations</span>
    </div>
    <a href="{{ route('agent.orders.create') }}" class="btn btn-aura rounded-pill px-4 fs-8">
      <i class="fas fa-cart-plus me-1"></i> Place New Wholesale Order
    </a>
  </div>

  <!-- Filter Pipeline -->
  <div class="mt-4 pt-3 border-top">
    <form action="{{ route('agent.orders.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
          <input type="text" name="search" class="form-control border-start-0" placeholder="Search by Order # or Buyer name..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-md-4">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Order Statuses</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Management Review</option>
          <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed / Invoiced</option>
          <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing / Production</option>
          <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped / Dispatched</option>
          <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered / Completed</option>
          <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>

      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Filter</button>
        @if(request()->hasAny(['search', 'status']))
          <a href="{{ route('agent.orders.index') }}" class="btn btn-sm btn-light border rounded-3 px-3 text-danger">Reset</a>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Orders Table -->
<div class="agent-card p-4">
  @if($orders->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Order #</th>
            <th>Buyer / Client</th>
            <th>Items Placed</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $ord)
            <tr>
              <td>
                <a href="{{ route('agent.orders.show', $ord) }}" class="fw-bold font-monospace text-decoration-none text-dark">
                  {{ $ord->order_number }}
                </a>
              </td>
              <td>
                @if($ord->client)
                  <div class="fw-semibold text-dark">{{ $ord->client->name }}</div>
                  <div class="fs-9 text-muted">{{ $ord->client->company_name ?? 'Independent' }}</div>
                @else
                  <span class="badge bg-light text-muted border">Direct Agent Order</span>
                @endif
              </td>
              <td>
                <span class="badge bg-light text-dark border font-monospace">{{ $ord->items->count() }} product line(s)</span>
              </td>
              <td class="text-muted fs-8">{{ $ord->created_at->format('M d, Y') }}</td>
              <td class="text-secondary fs-8">{{ $ord->required_delivery_date ? $ord->required_delivery_date->format('M d, Y') : 'Immediate' }}</td>
              <td class="fw-bold text-success font-monospace fs-6">${{ number_format($ord->total_amount, 2) }}</td>
              <td>
                <span class="badge bg-{{ $ord->status_badge }} bg-opacity-10 text-{{ $ord->status_badge }} border border-{{ $ord->status_badge }} px-2 py-0.5 rounded-pill fs-8">
                  {{ ucfirst(str_replace('_', ' ', $ord->status)) }}
                </span>
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('agent.orders.show', $ord) }}" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 fs-8">
                    <i class="fas fa-eye me-1 text-primary"></i> View
                  </a>
                  <a href="{{ route('agent.orders.invoice', $ord) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 fs-8" title="Print Proforma Invoice">
                    <i class="fas fa-print text-muted"></i>
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $orders->links('pagination::bootstrap-5') }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-box-open text-muted fs-1 mb-3"></i>
      <h5 class="fw-bold text-dark">No orders found.</h5>
      <p class="text-muted fs-7 mb-3">Place orders directly for your clients or for stocking your regional warehouse.</p>
      <a href="{{ route('agent.orders.create') }}" class="btn btn-aura rounded-pill px-4">
        <i class="fas fa-cart-plus me-1"></i> Place First Order
      </a>
    </div>
  @endif
</div>
@endsection
