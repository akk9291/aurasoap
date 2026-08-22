<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - {{ $order->order_number }} | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #F8FAFC;
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
      color: #1E293B;
      padding: 2rem;
    }
    .invoice-card {
      background: #FFF;
      border-radius: 16px;
      padding: 3rem;
      max-width: 850px;
      margin: 0 auto;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      border: 1px solid #E2E8F0;
    }
    @media print {
      body { background: #FFF; padding: 0; }
      .invoice-card { box-shadow: none; border: none; padding: 1.5rem; max-width: 100%; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>

  <div class="no-print text-center mb-4 max-w-850 mx-auto">
    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 me-2">
      Print / Save PDF
    </button>
    <a href="{{ route('agent.orders.show', $order) }}" class="btn btn-outline-secondary rounded-pill px-3">
      Back to Order
    </a>
  </div>

  <div class="invoice-card">
    <!-- Invoice Header -->
    <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
      <div>
        <h2 class="fw-bold text-dark mb-1">{{ App\Models\Setting::get('site_name', 'AURA SOAPS LTD') }}</h2>
        <div class="fs-7 text-muted">Artisan & Cold-Process Soap Manufacturers</div>
        <div class="fs-8 text-secondary mt-2">
          <div>{{ App\Models\Setting::get('contact_address', 'KN 7 Ave, Nyarugenge District, Kigali, Rwanda') }}</div>
          <div>Phone: {{ App\Models\Setting::get('contact_phone', '+250 788 123 456') }} | Email: {{ App\Models\Setting::get('contact_email', 'orders@aurasoaps.com') }}</div>
        </div>
      </div>
      <div class="text-end">
        <h4 class="fw-bold text-warning mb-1">PROFORMA INVOICE</h4>
        <div class="font-monospace fw-bold fs-5 text-dark">{{ $order->order_number }}</div>
        <div class="fs-8 text-muted mt-1">Date: {{ $order->created_at->format('M d, Y') }}</div>
        <div class="badge bg-success bg-opacity-10 text-success border border-success mt-2">
          Status: {{ strtoupper($order->status) }}
        </div>
      </div>
    </div>

    <!-- Agent & Buyer Details -->
    <div class="row g-4 mb-4">
      <div class="col-6">
        <h6 class="fw-bold fs-8 text-uppercase text-muted mb-2">Principal Agent / Distributor</h6>
        <div class="fw-bold fs-6 text-dark">{{ $order->user->name }}</div>
        <div class="fs-7 text-secondary">{{ $order->user->agentProfile->company_name ?? 'Principal Agent' }}</div>
        <div class="fs-8 text-muted">Agent ID: <span class="font-monospace fw-bold text-dark">{{ $order->user->agentProfile->agent_code ?? 'AS-AGT' }}</span></div>
        <div class="fs-8 text-muted">Phone: {{ $order->user->phone }} | Email: {{ $order->user->email }}</div>
      </div>

      <div class="col-6">
        <h6 class="fw-bold fs-8 text-uppercase text-muted mb-2">Ship To / Buyer</h6>
        @if($order->client)
          <div class="fw-bold fs-6 text-dark">{{ $order->client->name }}</div>
          <div class="fs-7 text-secondary">{{ $order->client->company_name ?? ucfirst($order->client->client_type) }}</div>
          <div class="fs-8 text-muted">{{ $order->shipping_address }}</div>
          <div class="fs-8 text-muted">Phone: {{ $order->client->phone }}</div>
        @else
          <div class="fw-bold fs-6 text-dark">Direct Warehouse Stocking</div>
          <div class="fs-8 text-muted">{{ $order->shipping_address }}</div>
        @endif
      </div>
    </div>

    <!-- Items Table -->
    <table class="table align-middle border fs-7 mb-4">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Product Description</th>
          <th class="text-center">Quantity (Cases)</th>
          <th class="text-end">Unit Wholesale (USD)</th>
          <th class="text-end">Total Amount (USD)</th>
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
            <td class="text-end fw-bold font-monospace">${{ number_format($item->subtotal, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="table-light">
        <tr>
          <td colspan="4" class="text-end fw-bold">Subtotal:</td>
          <td class="text-end fw-bold font-monospace">${{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
          <td colspan="4" class="text-end fw-bold fs-6 text-dark">Total Amount Due (USD):</td>
          <td class="text-end fw-bold fs-5 text-success font-monospace">${{ number_format($order->total_amount, 2) }}</td>
        </tr>
      </tfoot>
    </table>

    <!-- Payment & Commercial Notes -->
    <div class="border rounded-3 p-3 bg-light fs-8 text-secondary mb-4">
      <div class="fw-bold text-dark mb-1">Commercial Terms & Wire Details:</div>
      <div>Bank: Bank of Kigali | Account Name: Aura Soaps Ltd | Currency: USD</div>
      @if($order->financial_notes)
        <div class="mt-1"><strong>Payment Notes:</strong> {{ $order->financial_notes }}</div>
      @endif
      @if($order->notes)
        <div class="mt-1"><strong>Delivery Notes:</strong> {{ $order->notes }}</div>
      @endif
    </div>

    <!-- Signatures -->
    <div class="row pt-4 text-center fs-8">
      <div class="col-6">
        <div class="border-top pt-2 mx-4">
          <strong>Authorized by Aura Soaps Management</strong>
        </div>
      </div>
      <div class="col-6">
        <div class="border-top pt-2 mx-4">
          <strong>Principal Agent Acceptance</strong>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
