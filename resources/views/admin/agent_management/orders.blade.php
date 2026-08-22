@extends('layouts.admin')

@section('page_title', 'Agent Orders Management')

@section('content')
<div class="admin-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">Agent Wholesale Orders</h4>
      <span class="fs-7 text-muted">Manage orders submitted by Principal Agents across Portal, Phone, WhatsApp and Email channels</span>
    </div>
  </div>

  <!-- Filter Pipeline -->
  <div class="mt-4 pt-3 border-top">
    <form action="{{ route('admin.agent_management.orders') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-md-4">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
          <input type="text" name="search" class="form-control border-start-0" placeholder="Search by Order # or Agent name..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-md-3">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
          <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
          <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
          <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
          <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>

      <div class="col-md-3">
        <select name="source" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Channels</option>
          <option value="portal" {{ request('source') == 'portal' ? 'selected' : '' }}>Portal</option>
          <option value="phone" {{ request('source') == 'phone' ? 'selected' : '' }}>Phone</option>
          <option value="whatsapp" {{ request('source') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
          <option value="email" {{ request('source') == 'email' ? 'selected' : '' }}>Email</option>
        </select>
      </div>

      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Filter</button>
        @if(request()->hasAny(['search', 'status', 'source']))
          <a href="{{ route('admin.agent_management.orders') }}" class="btn btn-sm btn-light border rounded-3 px-3 text-danger">Reset</a>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="admin-card p-4">
  @if($orders->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Order #</th>
            <th>Principal Agent</th>
            <th>Buyer / Client</th>
            <th>Source</th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $ord)
            <tr>
              <td class="fw-bold font-monospace">
                <a href="{{ route('admin.agent_management.orders.show', $ord) }}" class="text-dark text-decoration-none">
                  {{ $ord->order_number }}
                </a>
              </td>
              <td>
                <div class="fw-semibold text-dark">{{ $ord->user->name ?? 'Agent' }}</div>
                <div class="fs-9 text-muted">{{ $ord->user->agentProfile->company_name ?? '-' }} &bull; <span class="font-monospace text-warning">{{ $ord->user->agentProfile->agent_code ?? '' }}</span></div>
              </td>
              <td>
                <div class="text-dark">{{ $ord->client->name ?? 'Direct Warehouse Stock' }}</div>
              </td>
              <td>
                <span class="badge bg-light text-dark border fs-9">
                  <i class="fas fa-{{ $ord->order_source === 'portal' ? 'globe' : ($ord->order_source === 'whatsapp' ? 'comments' : ($ord->order_source === 'phone' ? 'phone' : 'envelope')) }} me-1"></i>
                  {{ ucfirst($ord->order_source) }}
                </span>
              </td>
              <td class="text-muted fs-8">{{ $ord->created_at->format('M d, Y') }}</td>
              <td class="fw-bold text-success font-monospace fs-6">${{ number_format($ord->total_amount, 2) }}</td>
              <td>
                <span class="badge bg-{{ $ord->status_badge }} bg-opacity-10 text-{{ $ord->status_badge }} border border-{{ $ord->status_badge }} px-2 py-0.5 rounded-pill fs-8">
                  {{ ucfirst($ord->status) }}
                </span>
              </td>
              <td class="text-end">
                <a href="{{ route('admin.agent_management.orders.show', $ord) }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1 fs-8 text-primary">
                  <i class="fas fa-eye me-1"></i> Manage
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $orders->links() }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-box-open text-muted fs-1 mb-3"></i>
      <h5 class="fw-bold text-dark">No orders found.</h5>
    </div>
  @endif
</div>
@endsection
