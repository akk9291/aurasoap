@extends('layouts.admin')

@section('page_title', 'Manage Order ' . $order->order_number)

@section('content')
<div class="mb-3 d-flex align-items-center justify-content-between">
  <a href="{{ route('admin.agent_management.orders') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Agent Orders
  </a>
</div>

<div class="row g-4">
  <!-- Order Items & Invoice Details -->
  <div class="col-lg-8">
    <div class="admin-card p-4 p-md-5 mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
          <span class="badge bg-{{ $order->status_badge }} bg-opacity-10 text-{{ $order->status_badge }} border border-{{ $order->status_badge }} px-3 py-1 rounded-pill fs-8 fw-bold mb-2">
            Status: {{ ucfirst(str_replace('_', ' ', $order->status)) }}
          </span>
          <h3 class="fw-bold text-dark font-monospace mb-1">{{ $order->order_number }}</h3>
          <span class="fs-7 text-muted">Principal Agent: <strong>{{ $order->user->name ?? 'N/A' }}</strong> ({{ $order->user->agentProfile->company_name ?? 'N/A' }})</span>
        </div>
        <div class="text-end">
          <div class="fs-8 text-muted">Total Value:</div>
          <div class="fs-3 fw-bold text-success font-monospace">${{ number_format($order->total_amount, 2) }} {{ $order->currency }}</div>
        </div>
      </div>

      <!-- Items Table -->
      <h6 class="fw-bold text-dark mb-3">Order Line Items</h6>
      <div class="table-responsive mb-4">
        <table class="table align-middle border fs-7 mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th class="text-center">Quantity (Cases)</th>
              <th class="text-end">Unit Price</th>
              <th class="text-end">Line Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $idx => $item)
              <tr>
                <td class="text-muted fs-8">{{ $idx + 1 }}</td>
                <td>
                  <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                  @if($item->product && $item->product->packaging_info)
                    <div class="fs-9 text-muted">{{ $item->product->packaging_info }}</div>
                  @endif
                </td>
                <td class="text-center font-monospace">{{ $item->quantity }}</td>
                <td class="text-end font-monospace">${{ number_format($item->unit_price, 2) }}</td>
                <td class="text-end fw-bold text-dark font-monospace">${{ number_format($item->subtotal, 2) }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot class="table-light">
            <tr>
              <td colspan="4" class="text-end fw-bold">Subtotal:</td>
              <td class="text-end fw-bold font-monospace">${{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr class="table-warning">
              <td colspan="4" class="text-end fw-bold fs-6">Total Amount:</td>
              <td class="text-end fw-bold fs-5 text-success font-monospace">${{ number_format($order->total_amount, 2) }}</td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Order Notes -->
      <div class="row g-3 fs-8">
        @if($order->notes)
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 h-100">
              <strong class="text-dark d-block mb-1">Agent Delivery Notes:</strong>
              <div class="text-secondary">{!! nl2br(e($order->notes)) !!}</div>
            </div>
          </div>
        @endif

        @if($order->financial_notes)
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 h-100">
              <strong class="text-dark d-block mb-1">Payment Reference:</strong>
              <div class="text-secondary">{!! nl2br(e($order->financial_notes)) !!}</div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Right Column: Status Updater & Logistics -->
  <div class="col-lg-4">
    <!-- Status Update Card -->
    <div class="admin-card p-4 mb-4 border-2 border-warning">
      <h6 class="fw-bold text-dark mb-3">Update Order Status</h6>
      <form action="{{ route('admin.agent_management.orders.update_status', $order) }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-8 text-muted fw-bold">Order Status</label>
          <select name="status" class="form-select form-select-sm" required>
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending Review</option>
            <option value="under_review" {{ $order->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed / Proforma Issued</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing / Factory Packaging</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped / Dispatched</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered / Completed</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fs-8 text-muted fw-bold">Operations / Dispatch Notes for Agent</label>
          <textarea name="admin_notes" class="form-control form-control-sm" rows="3" placeholder="e.g. Dispatched via Truck #RAC 450B. Driver contact: +250 788 999 000.">{{ $order->admin_notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-sm btn-aura w-100 rounded-pill">
          <i class="fas fa-sync-alt me-1"></i> Update Order Status
        </button>
      </form>
    </div>

    <!-- Logistics Destination -->
    <div class="admin-card p-4">
      <h6 class="fw-bold text-dark mb-3">Logistics & Buyer Info</h6>
      <div class="fs-8 d-flex flex-column gap-2">
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Buyer Name</span>
          <strong class="text-dark">{{ $order->client->name ?? 'Direct Agent Stock' }}</strong>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Requested Delivery Date</span>
          <span class="text-dark">{{ $order->required_delivery_date ? $order->required_delivery_date->format('M d, Y') : 'Immediate' }}</span>
        </div>
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Destination Address</span>
          <div class="text-dark">{{ $order->shipping_address }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
