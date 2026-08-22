@extends('layouts.agent')

@section('page_title', 'Wholesale Price Book')

@section('content')
<div class="agent-card p-4 p-md-5 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
    <div>
      <span class="badge bg-warning bg-opacity-20 text-dark border border-warning px-3 py-1 rounded-pill fw-bold fs-8 mb-2">
        <i class="fas fa-lock me-1 text-warning"></i> CONFIDENTIAL &bull; PRINCIPAL AGENT ONLY
      </span>
      <h4 class="fw-bold text-dark mb-1">Official Wholesale Price Book</h4>
      <span class="fs-7 text-muted">Aura Soaps standard wholesale case prices, packaging configurations and MOQs</span>
    </div>
    <div class="d-flex gap-2">
      <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-3 fs-8 fw-semibold">
        <i class="fas fa-print me-1"></i> Print / Save PDF
      </button>
      <a href="{{ route('agent.orders.create') }}" class="btn btn-aura rounded-pill px-4 fs-8">
        <i class="fas fa-cart-plus me-1"></i> Place Order
      </a>
    </div>
  </div>

  @foreach($categories as $cat)
    @if($cat->products->count() > 0)
      <div class="mb-5">
        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center gap-2">
          <i class="fas fa-layer-group text-warning fs-6"></i>
          <span>{{ $cat->name }}</span>
          <span class="badge bg-light text-muted border fs-9 fw-normal ms-auto">{{ $cat->products->count() }} Product(s)</span>
        </h5>

        <div class="table-responsive">
          <table class="table table-hover align-middle border fs-7 mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 35%;">Product Item</th>
                <th>Specifications / Weight</th>
                <th>Master Packaging</th>
                <th>MOQ (Cases)</th>
                <th class="text-end" style="width: 15%;">Wholesale Price (USD)</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cat->products as $prod)
                <tr>
                  <td>
                    <div class="fw-bold text-dark">{{ $prod->name }}</div>
                    @if($prod->sku)
                      <span class="font-monospace fs-9 text-muted">SKU: {{ $prod->sku }}</span>
                    @endif
                  </td>
                  <td class="text-secondary">{{ $prod->weight ?? 'Standard bar' }}</td>
                  <td class="text-secondary">{{ $prod->packaging_info ?? '24 units / box' }}</td>
                  <td>
                    <span class="badge bg-light text-dark border font-monospace">{{ $prod->min_order_qty ?? 1 }} Cases</span>
                  </td>
                  <td class="text-end">
                    <span class="fw-bold text-success fs-6 font-monospace">${{ number_format($prod->wholesale_price, 2) }}</span>
                    <span class="fs-9 text-muted d-block">per case</span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
  @endforeach

  <!-- Terms and Commercial Notes -->
  <div class="bg-light p-4 rounded-4 mt-4 border">
    <h6 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle text-warning me-1"></i> Commercial Terms & Ordering Conditions</h6>
    <ul class="fs-8 text-secondary mb-0 ps-3">
      <li>All prices are quoted in <strong>USD</strong> Ex-Works / FOB Aura Soaps Distribution Warehouse.</li>
      <li>Orders are packed in standard corrugated master export cartons.</li>
      <li>Volume rebate structures for container-load and full-truckload (FTL) orders are subject to regional contract agreements.</li>
      <li>Orders can be placed directly through the portal, or via our official WhatsApp and Phone order desks.</li>
    </ul>
  </div>
</div>
@endsection
