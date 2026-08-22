@extends('layouts.agent')

@section('page_title', 'Order ' . $order->order_number)

@section('content')
<div class="mb-3 d-flex align-items-center justify-content-between">
  <a href="{{ route('agent.orders.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to My Orders
  </a>
  <div class="d-flex gap-2">
    <a href="{{ route('agent.orders.invoice', $order) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3 fs-8">
      <i class="fas fa-print me-1"></i> Print Proforma Invoice
    </a>
    @if(in_array($order->status, ['pending', 'under_review']))
      <form action="{{ route('agent.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fs-8">
          <i class="fas fa-times me-1"></i> Cancel Order
        </button>
      </form>
    @endif
  </div>
</div>

<div class="row g-4">
  <!-- Order Items & Invoice Details -->
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5 mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
          <span class="badge bg-{{ $order->status_badge }} bg-opacity-10 text-{{ $order->status_badge }} border border-{{ $order->status_badge }} px-3 py-1 rounded-pill fs-8 fw-bold mb-2">
            Status: {{ ucfirst(str_replace('_', ' ', $order->status)) }}
          </span>
          <h4 class="fw-bold text-dark font-monospace mb-1">{{ $order->order_number }}</h4>
          <span class="fs-8 text-muted">Placed on {{ $order->created_at->format('M d, Y h:i A') }} &bull; Source: <span class="badge bg-light text-dark border">{{ ucfirst($order->order_source) }}</span></span>
        </div>
        <div class="text-end">
          <div class="fs-8 text-muted">Total Payable:</div>
          <div class="fs-3 fw-bold text-success font-monospace">${{ number_format($order->total_amount, 2) }} {{ $order->currency }}</div>
        </div>
      </div>

      <!-- Order Items Table -->
      <h6 class="fw-bold text-dark mb-3">Ordered Products</h6>
      <div class="table-responsive mb-4">
        <table class="table align-middle border fs-7 mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th class="text-center">Quantity (Cases)</th>
              <th class="text-end">Unit Price (USD)</th>
              <th class="text-end">Subtotal (USD)</th>
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
            @if($order->shipping_amount > 0)
              <tr>
                <td colspan="4" class="text-end text-muted">Shipping / Freight:</td>
                <td class="text-end font-monospace">${{ number_format($order->shipping_amount, 2) }}</td>
              </tr>
            @endif
            @if($order->tax_amount > 0)
              <tr>
                <td colspan="4" class="text-end text-muted">Taxes / Duties:</td>
                <td class="text-end font-monospace">${{ number_format($order->tax_amount, 2) }}</td>
              </tr>
            @endif
            <tr class="table-warning">
              <td colspan="4" class="text-end fw-bold fs-6">Grand Total:</td>
              <td class="text-end fw-bold fs-5 text-success font-monospace">${{ number_format($order->total_amount, 2) }}</td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Notes & Instructions -->
      <div class="row g-3 fs-8">
        @if($order->notes)
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 h-100">
              <strong class="text-dark d-block mb-1">Delivery / Packaging Instructions:</strong>
              <div class="text-secondary">{!! nl2br(e($order->notes)) !!}</div>
            </div>
          </div>
        @endif

        @if($order->financial_notes)
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 h-100">
              <strong class="text-dark d-block mb-1">Payment Reference & Terms:</strong>
              <div class="text-secondary">{!! nl2br(e($order->financial_notes)) !!}</div>
            </div>
          </div>
        @endif

        @if($order->admin_notes)
          <div class="col-12">
            <div class="p-3 bg-warning-subtle rounded-3 border border-warning">
              <strong class="text-dark d-block mb-1"><i class="fas fa-comment-dots text-warning me-1"></i> Aura Soaps Operations Update:</strong>
              <div class="text-dark font-sans">{!! nl2br(e($order->admin_notes)) !!}</div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Right Column: Buyer & Logistics Tracking -->
  <div class="col-lg-4">
    <!-- Order Status Progression Tracker -->
    <div class="agent-card p-4 mb-4">
      <h6 class="fw-bold text-dark mb-3">Order Status Progression</h6>
      
      @php
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
        $currentIdx = array_search($order->status, $statuses);
        if ($currentIdx === false && $order->status === 'under_review') $currentIdx = 0;
      @endphp

      @if($order->status === 'cancelled')
        <div class="alert alert-danger p-3 rounded-3 fs-8 mb-0">
          <i class="fas fa-times-circle me-1"></i> This order was cancelled.
        </div>
      @else
        <div class="d-flex flex-column gap-3">
          @foreach($statuses as $idx => $st)
            <div class="d-flex align-items-center gap-2.5">
              <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 {{ $idx <= $currentIdx ? 'bg-success text-white' : 'bg-light text-muted border' }}" style="width: 28px; height: 28px; font-size: 0.75rem;">
                @if($idx <= $currentIdx)
                  <i class="fas fa-check"></i>
                @else
                  {{ $idx + 1 }}
                @endif
              </div>
              <div>
                <div class="fw-bold fs-8 {{ $idx <= $currentIdx ? 'text-dark' : 'text-muted' }}">{{ ucfirst($st) }}</div>
                <div class="fs-9 text-muted">
                  @if($st === 'pending') Order submitted & logged
                  @elseif($st === 'confirmed') Approved & Proforma issued
                  @elseif($st === 'processing') Production / Warehouse packing
                  @elseif($st === 'shipped') In transit with carbon-neutral carrier
                  @elseif($st === 'delivered') Goods delivered to destination
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Buyer & Destination Details -->
    <div class="agent-card p-4">
      <h6 class="fw-bold text-dark mb-3">Delivery & Buyer Details</h6>

      <div class="fs-8 d-flex flex-column gap-2 mb-3">
        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Client / Buyer</span>
          <strong class="text-dark">{{ $order->client ? $order->client->name : 'Direct Principal Warehouse' }}</strong>
          @if($order->client && $order->client->company_name)
            <div class="text-muted">{{ $order->client->company_name }}</div>
          @endif
        </div>

        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Requested Delivery Date</span>
          <span class="text-dark fw-semibold">{{ $order->required_delivery_date ? $order->required_delivery_date->format('M d, Y') : 'Earliest Available' }}</span>
        </div>

        <div>
          <span class="text-muted fs-9 d-block text-uppercase fw-bold">Shipping Address</span>
          <div class="text-dark">{{ $order->shipping_address }}</div>
        </div>
      </div>

      @if($order->client)
        <a href="{{ route('agent.clients.show', $order->client) }}" class="btn btn-sm btn-light border w-100 rounded-pill fs-8">
          View Buyer CRM Record
        </a>
      @endif
    </div>
  </div>
</div>
@endsection
