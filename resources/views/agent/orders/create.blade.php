@extends('layouts.agent')

@section('page_title', 'Place Wholesale Order')

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.orders.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Orders
  </a>
</div>

<form action="{{ route('agent.orders.store') }}" method="POST" id="orderForm">
  @csrf

  <div class="row g-4">
    <!-- Left Column: Products Order Table -->
    <div class="col-lg-8">
      <div class="agent-card p-4 p-md-5 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
          <div>
            <h4 class="fw-bold text-dark mb-1">Select Products & Quantities</h4>
            <span class="fs-7 text-muted">Build your multi-item wholesale order. Prices are applied automatically based on your Principal Agent contract.</span>
          </div>
          <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3 fs-8" id="addProductRowBtn">
            <i class="fas fa-plus me-1 text-warning"></i> Add Product Line
          </button>
        </div>

        @if($errors->any())
          <div class="alert alert-danger border-0 rounded-3 mb-4">
            <ul class="mb-0 fs-8 ps-3">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="table-responsive mb-3">
          <table class="table align-middle fs-7 mb-0" id="orderItemsTable">
            <thead class="table-light">
              <tr>
                <th style="width: 45%;">Product Line</th>
                <th style="width: 18%;">Wholesale (USD)</th>
                <th style="width: 17%;">Quantity (Cases)</th>
                <th style="width: 15%;" class="text-end">Subtotal (USD)</th>
                <th style="width: 5%;"></th>
              </tr>
            </thead>
            <tbody id="orderItemsBody">
              <!-- Default Initial Row -->
              <tr class="order-item-row" data-row-index="0">
                <td>
                  <select name="items[0][product_id]" class="form-select form-select-sm product-select" required>
                    <option value="">-- Choose Product --</option>
                    @foreach($products as $prod)
                      <option value="{{ $prod->id }}" data-price="{{ $prod->wholesale_price }}" data-moq="{{ $prod->min_order_qty ?? 1 }}">
                        {{ $prod->name }} (MOQ: {{ $prod->min_order_qty ?? 1 }} cs) - ${{ number_format($prod->wholesale_price, 2) }}
                      </option>
                    @endforeach
                  </select>
                </td>
                <td>
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control item-price bg-light font-monospace" value="0.00" readonly>
                  </div>
                </td>
                <td>
                  <input type="number" name="items[0][quantity]" class="form-control form-control-sm item-qty font-monospace" min="1" value="10" required>
                </td>
                <td class="text-end fw-bold text-success font-monospace item-subtotal fs-7">
                  $0.00
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm text-danger remove-row-btn" title="Remove line" style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 fs-8 mt-2" id="addProductRowBtn2">
          <i class="fas fa-plus me-1 text-warning"></i> Add Another Product Line
        </button>

        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
          <span class="fs-6 fw-bold text-dark">Order Subtotal:</span>
          <span class="fs-4 fw-bold text-success font-monospace" id="displayTotalAmount">$0.00</span>
        </div>
      </div>

      <!-- Financial & Logistics Notes Card -->
      <div class="agent-card p-4">
        <h5 class="fw-bold text-dark fs-6 mb-3"><i class="fas fa-sticky-note me-2 text-warning"></i>Order & Logistics Instructions</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold fs-8 text-dark">Special Delivery Instructions / Packaging Notes</label>
            <textarea name="notes" class="form-control fs-8" rows="3" placeholder="e.g. Palletized wrapping required. Delivery between 8am and 12pm.">{{ old('notes') }}</textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold fs-8 text-dark">Payment Reference / Financial Notes</label>
            <textarea name="financial_notes" class="form-control fs-8" rows="3" placeholder="e.g. 30% advance via Bank Wire, 70% against Bill of Lading.">{{ old('financial_notes') }}</textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Buyer & Shipping Info -->
    <div class="col-lg-4">
      <div class="agent-card p-4 mb-4">
        <h5 class="fw-bold text-dark fs-6 mb-3"><i class="fas fa-user-check me-2 text-primary"></i>Buyer & Destination</h5>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7 text-dark">Select Buyer / Retail Client</label>
          <select name="client_id" id="clientSelect" class="form-select">
            <option value="">-- Direct Agent / Warehouse Order --</option>
            @foreach($clients as $c)
              <option value="{{ $c->id }}" data-address="{{ $c->address ?? '' }}" data-city="{{ $c->city ?? '' }}" data-country="{{ $c->country }}" {{ old('client_id', $selectedClientId) == $c->id ? 'selected' : '' }}>
                {{ $c->name }} ({{ $c->company_name ?? ucfirst($c->client_type) }})
              </option>
            @endforeach
          </select>
          <div class="form-text fs-9">Select client to link invoice and record to their CRM history.</div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7 text-dark">Required Delivery Date</label>
          <input type="date" name="required_delivery_date" class="form-control" value="{{ old('required_delivery_date', date('Y-m-d', strtotime('+7 days'))) }}" min="{{ date('Y-m-d') }}">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7 text-dark">Shipping Destination Address *</label>
          <textarea name="shipping_address" id="shippingAddress" class="form-control" rows="3" placeholder="Enter warehouse or store address..." required>{{ old('shipping_address', auth()->user()->agentProfile->business_address . ', ' . auth()->user()->agentProfile->city . ', ' . auth()->user()->agentProfile->country) }}</textarea>
        </div>

        <div class="pt-3 border-top mt-3">
          <div class="d-flex justify-content-between align-items-center mb-2 fs-8">
            <span class="text-muted">Payment Currency:</span>
            <strong class="text-dark">USD ($)</strong>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3 fs-8">
            <span class="text-muted">Order Channel:</span>
            <span class="badge bg-success bg-opacity-10 text-success">Principal Agent Portal</span>
          </div>

          <button type="submit" class="btn btn-aura w-100 py-3 rounded-pill fs-7 fw-bold shadow">
            <i class="fas fa-check-circle me-1"></i> Submit Wholesale Order
          </button>
        </div>
      </div>

      <!-- Help Card -->
      <div class="agent-card p-3.5 bg-light">
        <h6 class="fw-bold fs-8 text-dark mb-1"><i class="fas fa-question-circle text-warning me-1"></i> Need Phone or WhatsApp Ordering?</h6>
        <p class="fs-9 text-muted mb-2">You can also place urgent or custom container load orders directly via our sales hotline.</p>
        <div class="fs-9 fw-semibold text-dark">
          <i class="fab fa-whatsapp text-success me-1"></i> {{ App\Models\Setting::get('contact_phone', '+250 788 123 456') }}
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const tableBody = document.getElementById('orderItemsBody');
  const addBtn1 = document.getElementById('addProductRowBtn');
  const addBtn2 = document.getElementById('addProductRowBtn2');
  const totalDisplay = document.getElementById('displayTotalAmount');
  let rowCount = 1;

  const productsOptions = `
    <option value="">-- Choose Product --</option>
    @foreach($products as $prod)
      <option value="{{ $prod->id }}" data-price="{{ $prod->wholesale_price }}" data-moq="{{ $prod->min_order_qty ?? 1 }}">
        {{ $prod->name }} (MOQ: {{ $prod->min_order_qty ?? 1 }} cs) - ${{ number_format($prod->wholesale_price, 2) }}
      </option>
    @endforeach
  `;

  function calculateTotals() {
    let grandTotal = 0;
    const rows = tableBody.querySelectorAll('.order-item-row');

    rows.forEach(row => {
      const select = row.querySelector('.product-select');
      const priceInput = row.querySelector('.item-price');
      const qtyInput = row.querySelector('.item-qty');
      const subtotalDisplay = row.querySelector('.item-subtotal');
      const removeBtn = row.querySelector('.remove-row-btn');

      if (rows.length > 1) {
        removeBtn.style.display = 'inline-block';
      } else {
        removeBtn.style.display = 'none';
      }

      const selectedOption = select.options[select.selectedIndex];
      const price = selectedOption && selectedOption.dataset.price ? parseFloat(selectedOption.dataset.price) : 0;
      const moq = selectedOption && selectedOption.dataset.moq ? parseInt(selectedOption.dataset.moq) : 1;
      const qty = parseInt(qtyInput.value) || 0;

      priceInput.value = price.toFixed(2);
      const subtotal = price * qty;
      subtotalDisplay.textContent = '$' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

      grandTotal += subtotal;
    });

    totalDisplay.textContent = '$' + grandTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  }

  function addRow() {
    const tr = document.createElement('tr');
    tr.className = 'order-item-row';
    tr.dataset.rowIndex = rowCount;
    tr.innerHTML = `
      <td>
        <select name="items[${rowCount}][product_id]" class="form-select form-select-sm product-select" required>
          ${productsOptions}
        </select>
      </td>
      <td>
        <div class="input-group input-group-sm">
          <span class="input-group-text">$</span>
          <input type="text" class="form-control item-price bg-light font-monospace" value="0.00" readonly>
        </div>
      </td>
      <td>
        <input type="number" name="items[${rowCount}][quantity]" class="form-control form-control-sm item-qty font-monospace" min="1" value="10" required>
      </td>
      <td class="text-end fw-bold text-success font-monospace item-subtotal fs-7">
        $0.00
      </td>
      <td class="text-center">
        <button type="button" class="btn btn-sm text-danger remove-row-btn" title="Remove line">
          <i class="fas fa-trash-alt"></i>
        </button>
      </td>
    `;

    tableBody.appendChild(tr);
    rowCount++;
    calculateTotals();
  }

  if (addBtn1) addBtn1.addEventListener('click', addRow);
  if (addBtn2) addBtn2.addEventListener('click', addRow);

  tableBody.addEventListener('change', function(e) {
    if (e.target.classList.contains('product-select')) {
      const row = e.target.closest('.order-item-row');
      const selectedOption = e.target.options[e.target.selectedIndex];
      if (selectedOption && selectedOption.dataset.moq) {
        const qtyInput = row.querySelector('.item-qty');
        if (parseInt(qtyInput.value) < parseInt(selectedOption.dataset.moq)) {
          qtyInput.value = selectedOption.dataset.moq;
        }
      }
      calculateTotals();
    }
  });

  tableBody.addEventListener('input', function(e) {
    if (e.target.classList.contains('item-qty')) {
      calculateTotals();
    }
  });

  tableBody.addEventListener('click', function(e) {
    const btn = e.target.closest('.remove-row-btn');
    if (btn) {
      const row = btn.closest('.order-item-row');
      if (tableBody.querySelectorAll('.order-item-row').length > 1) {
        row.remove();
        calculateTotals();
      }
    }
  });

  // Client Selection auto-fill address
  const clientSelect = document.getElementById('clientSelect');
  const shippingAddress = document.getElementById('shippingAddress');

  if (clientSelect && shippingAddress) {
    clientSelect.addEventListener('change', function() {
      const opt = this.options[this.selectedIndex];
      if (opt && opt.value) {
        const addr = opt.dataset.address;
        const city = opt.dataset.city;
        const country = opt.dataset.country;
        if (addr || city) {
          shippingAddress.value = (addr ? addr + ', ' : '') + (city ? city + ', ' : '') + country;
        }
      }
    });
  }

  // Initial calculation
  calculateTotals();
});
</script>
@endpush
