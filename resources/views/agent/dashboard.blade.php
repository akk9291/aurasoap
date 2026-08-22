@extends('layouts.agent')

@section('page_title', 'Agent Dashboard')

@push('styles')
<style>
  /* Dashboard Specific Styling */
  .hero-agent-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.05);
  }

  .hero-agent-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 320px;
    height: 100%;
    background: radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.07) 0%, transparent 70%);
    pointer-events: none;
  }

  .hero-avatar-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: #FFFFFF;
    font-size: 1.5rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
    position: relative;
  }

  .hero-avatar-badge {
    position: absolute;
    bottom: -4px;
    right: -4px;
    background: #10B981;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
  }

  /* Metric KPI Cards */
  .kpi-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 18px;
    padding: 1.35rem 1.4rem;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.08);
    border-color: #CBD5E1;
  }

  .kpi-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
  }

  .kpi-link {
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
  }

  .kpi-link:hover i {
    transform: translateX(4px);
  }

  .kpi-link i {
    transition: transform 0.2s ease;
  }

  /* Quick Shortcut Button */
  .shortcut-btn {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    padding: 0.85rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
    color: #1E293B;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.2s ease;
  }

  .shortcut-btn:hover {
    background: #FFFFFF;
    border-color: #CBD5E1;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
    transform: translateY(-2px);
    color: #0F172A;
  }

  .shortcut-btn:hover .shortcut-arrow {
    transform: translateX(3px);
    color: #F59E0B;
  }

  .shortcut-arrow {
    transition: transform 0.2s ease, color 0.2s ease;
  }

  /* Table Custom */
  .agent-table th {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 700;
    color: #64748B;
    padding: 0.85rem 1rem;
    background: #F8FAFC;
    border-bottom: 1px solid #E2E8F0;
  }

  .agent-table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #F1F5F9;
  }

  .agent-table tr:last-child td {
    border-bottom: none;
  }

  .agent-table tr:hover td {
    background-color: #F8FAFC;
  }

  /* Product Card */
  .product-catalog-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 1.1rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.25s ease;
  }

  .product-catalog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -4px rgba(15, 23, 42, 0.08);
    border-color: #CBD5E1;
  }

  .product-img-wrap {
    height: 140px;
    border-radius: 12px;
    overflow: hidden;
    background: #F8FAFC;
    position: relative;
  }

  .product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .product-catalog-card:hover .product-img-wrap img {
    transform: scale(1.05);
  }
</style>
@endpush

@section('content')
<!-- Agent Welcome Hero Header -->
<div class="hero-agent-card p-4 mb-4">
  <div class="row align-items-center g-3">
    <div class="col-lg-8">
      <div class="d-flex align-items-center gap-3">
        <div class="hero-avatar-wrapper flex-shrink-0">
          {{ strtoupper(substr($user->name, 0, 1)) }}
          <span class="hero-avatar-badge" title="Verified Principal Agent">
            <i class="fas fa-check"></i>
          </span>
        </div>
        <div>
          <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
            <h3 class="fw-bold text-dark mb-0 fs-4">{{ $user->name }}</h3>
            <span class="badge badge-soft-success px-2.5 py-1 rounded-pill fw-bold fs-9">
              <i class="fas fa-shield-alt me-1"></i> {{ $profile->agent_code ?? 'AS-AGT-1001' }}
            </span>
            <span class="badge badge-soft-primary px-2.5 py-1 rounded-pill fw-bold fs-9">
              <i class="fas fa-store me-1"></i> {{ ucfirst($profile->business_type ?? 'Wholesaler') }}
            </span>
          </div>
          <p class="text-muted fs-7 mb-0 d-flex align-items-center gap-2 flex-wrap">
            <span>
              <i class="fas fa-building text-warning me-1"></i>
              <strong class="text-dark">{{ $profile->company_name }}</strong>
            </span>
            <span class="text-muted">&bull;</span>
            <span>
              <i class="fas fa-map-marker-alt text-danger me-1"></i>
              {{ $profile->city }}, {{ $profile->country }}
            </span>
            <span class="text-muted">&bull;</span>
            <span class="text-secondary fs-8">
              <i class="fas fa-check-circle text-success me-1"></i> Aura Verified Partner
            </span>
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 text-lg-end">
      <div class="d-flex justify-content-lg-end gap-2.5 flex-wrap">
        <a href="{{ route('agent.orders.create') }}" class="btn-aura">
          <i class="fas fa-cart-plus"></i>
          <span>Place New Order</span>
        </a>
        <a href="{{ route('agent.wholesale-prices') }}" class="btn-aura-outline fs-8">
          <i class="fas fa-tags text-warning"></i>
          <span>Wholesale Sheet</span>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Metrics / Statistics Row -->
<div class="row g-3 mb-4">
  <!-- Card 1: My Buyers / Clients -->
  <div class="col-sm-6 col-xl-3">
    <div class="kpi-card">
      <div>
        <div class="d-flex align-items-start justify-content-between mb-2">
          <div>
            <span class="text-muted fs-9 fw-bold text-uppercase letter-spacing-1">My Buyers / Clients</span>
            <h2 class="fw-bolder text-dark mt-1 mb-0">{{ $clientsCount }}</h2>
          </div>
          <div class="kpi-icon-box" style="background-color: #EFF6FF; color: #2563EB;">
            <i class="fas fa-users"></i>
          </div>
        </div>
        <div class="fs-8 text-secondary">
          <i class="fas fa-network-wired text-muted me-1"></i> Wholesalers & Retailers
        </div>
      </div>
      <div class="mt-3 pt-2.5 border-top">
        <a href="{{ route('agent.clients.index') }}" class="kpi-link text-primary">
          <span>Manage Buyer CRM</span>
          <i class="fas fa-chevron-right fs-9"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- Card 2: Active Enquiries -->
  <div class="col-sm-6 col-xl-3">
    <div class="kpi-card">
      <div>
        <div class="d-flex align-items-start justify-content-between mb-2">
          <div>
            <span class="text-muted fs-9 fw-bold text-uppercase letter-spacing-1">Active Enquiries</span>
            <h2 class="fw-bolder text-dark mt-1 mb-0">{{ $enquiriesCount }}</h2>
          </div>
          <div class="kpi-icon-box" style="background-color: #F0F9FF; color: #0284C7;">
            <i class="fas fa-comments"></i>
          </div>
        </div>
        <div class="fs-8 text-secondary">
          <i class="fas fa-filter text-muted me-1"></i> Client sales pipeline
        </div>
      </div>
      <div class="mt-3 pt-2.5 border-top">
        <a href="{{ route('agent.enquiries.index') }}" class="kpi-link text-info">
          <span>View Enquiry Pipeline</span>
          <i class="fas fa-chevron-right fs-9"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- Card 3: Pending Orders -->
  <div class="col-sm-6 col-xl-3">
    <div class="kpi-card">
      <div>
        <div class="d-flex align-items-start justify-content-between mb-2">
          <div>
            <span class="text-muted fs-9 fw-bold text-uppercase letter-spacing-1">Pending Orders</span>
            <h2 class="fw-bolder text-warning mt-1 mb-0">{{ $pendingOrdersCount }}</h2>
          </div>
          <div class="kpi-icon-box" style="background-color: #FFFBEB; color: #D97706;">
            <i class="fas fa-truck-loading"></i>
          </div>
        </div>
        <div class="fs-8 text-secondary">
          <i class="fas fa-box text-muted me-1"></i> {{ $totalOrdersCount }} Total Orders Placed
        </div>
      </div>
      <div class="mt-3 pt-2.5 border-top">
        <a href="{{ route('agent.orders.index', ['status' => 'pending']) }}" class="kpi-link text-warning">
          <span>Track Order Status</span>
          <i class="fas fa-chevron-right fs-9"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- Card 4: Total Order Value -->
  <div class="col-sm-6 col-xl-3">
    <div class="kpi-card">
      <div>
        <div class="d-flex align-items-start justify-content-between mb-2">
          <div>
            <span class="text-muted fs-9 fw-bold text-uppercase letter-spacing-1">Total Order Value</span>
            <h2 class="fw-bolder text-success mt-1 mb-0">${{ number_format($totalOrderValue, 2) }}</h2>
          </div>
          <div class="kpi-icon-box" style="background-color: #ECFDF5; color: #059669;">
            <i class="fas fa-file-invoice-dollar"></i>
          </div>
        </div>
        <div class="fs-8 text-secondary">
          <i class="fas fa-gem text-muted me-1"></i> Aura Soaps Wholesale
        </div>
      </div>
      <div class="mt-3 pt-2.5 border-top">
        <a href="{{ route('agent.orders.index') }}" class="kpi-link text-success">
          <span>View Invoices & Orders</span>
          <i class="fas fa-chevron-right fs-9"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Main Row: Recent Orders & Pipeline -->
<div class="row g-4 mb-4">
  <!-- Recent Orders Table -->
  <div class="col-lg-8">
    <div class="agent-card p-4 h-100 d-flex flex-column justify-content-between">
      <div>
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
          <div>
            <h5 class="fw-bold text-dark mb-0 fs-6">Recent Orders Placed</h5>
            <span class="fs-8 text-muted">Wholesale purchase orders dispatched under your Principal Agent account</span>
          </div>
          <a href="{{ route('agent.orders.index') }}" class="btn btn-sm btn-light border rounded-pill px-3 fs-8 fw-semibold text-secondary">
            View All <i class="fas fa-arrow-right ms-1 fs-9"></i>
          </a>
        </div>

        @if($recentOrders->count() > 0)
          <div class="table-responsive">
            <table class="table agent-table align-middle fs-7 mb-0">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Buyer / Client</th>
                  <th>Date</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentOrders as $order)
                  <tr>
                    <td>
                      <a href="{{ route('agent.orders.show', $order) }}" class="fw-bold text-decoration-none text-dark font-monospace fs-8 bg-light px-2 py-1 rounded-2 border">
                        {{ $order->order_number }}
                      </a>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark">{{ $order->client->name ?? 'Direct Warehouse Order' }}</div>
                      <div class="fs-9 text-muted">{{ $order->client->company_name ?? 'Agent Stock' }}</div>
                    </td>
                    <td class="text-muted fs-8">
                      <i class="far fa-calendar-alt me-1 text-muted"></i> {{ $order->created_at->format('M d, Y') }}
                    </td>
                    <td class="fw-bold text-success fs-7">${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                      <span class="badge badge-soft-{{ $order->status_badge == 'warning' ? 'warning' : ($order->status_badge == 'success' ? 'success' : 'primary') }} px-2.5 py-1 rounded-pill fs-9 fw-semibold">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                      </span>
                    </td>
                    <td class="text-end">
                      <a href="{{ route('agent.orders.show', $order) }}" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 fs-8 text-secondary">
                        <i class="fas fa-eye me-1"></i> Details
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex p-3 mb-3 text-muted">
              <i class="fas fa-box-open fs-2"></i>
            </div>
            <h6 class="fw-bold text-dark">No orders placed yet</h6>
            <p class="text-muted fs-8 mb-3">Create your first wholesale order to supply your clients or stock your warehouse.</p>
            <a href="{{ route('agent.orders.create') }}" class="btn-aura btn-sm">
              <i class="fas fa-plus"></i> Create First Order
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Recent Enquiries & Quick Actions -->
  <div class="col-lg-4">
    <!-- Quick Actions Card -->
    <div class="agent-card p-4 mb-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold text-dark mb-0">Quick Agent Shortcuts</h6>
        <span class="badge badge-soft-warning rounded-pill fs-9">Actions</span>
      </div>
      <div class="d-flex flex-column gap-2">
        <a href="{{ route('agent.orders.create') }}" class="btn-aura text-start w-100 justify-content-between p-2.5 rounded-3">
          <span><i class="fas fa-cart-plus me-2"></i> Place Wholesale Order</span>
          <i class="fas fa-arrow-right fs-8"></i>
        </a>
        <a href="{{ route('agent.clients.create') }}" class="shortcut-btn">
          <span><i class="fas fa-user-plus me-2 text-primary"></i> Add New Buyer / Client</span>
          <i class="fas fa-arrow-right fs-8 text-muted shortcut-arrow"></i>
        </a>
        <a href="{{ route('agent.enquiries.create') }}" class="shortcut-btn">
          <span><i class="fas fa-comment-medical me-2 text-info"></i> Record Client Enquiry</span>
          <i class="fas fa-arrow-right fs-8 text-muted shortcut-arrow"></i>
        </a>
        <a href="{{ route('agent.marketing.index') }}" class="shortcut-btn">
          <span><i class="fas fa-download me-2 text-danger"></i> Sales Catalogues & Posters</span>
          <i class="fas fa-arrow-right fs-8 text-muted shortcut-arrow"></i>
        </a>
      </div>
    </div>

    <!-- Active Enquiries Summary -->
    <div class="agent-card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h6 class="fw-bold text-dark mb-0">Recent Enquiries</h6>
          <span class="fs-9 text-muted">Buyer lead pipeline</span>
        </div>
        <a href="{{ route('agent.enquiries.index') }}" class="fs-8 text-decoration-none text-warning fw-semibold">
          View All <i class="fas fa-chevron-right fs-9"></i>
        </a>
      </div>

      @if($recentEnquiries->count() > 0)
        <div class="d-flex flex-column gap-2">
          @foreach($recentEnquiries as $enq)
            <a href="{{ route('agent.enquiries.show', $enq) }}" class="p-2.5 rounded-3 text-decoration-none text-dark d-flex align-items-center justify-content-between border bg-light bg-opacity-50 hover-bg transition">
              <div class="overflow-hidden pe-2">
                <div class="fw-bold fs-8 text-truncate">{{ $enq->title }}</div>
                <div class="fs-9 text-muted d-flex align-items-center gap-1">
                  <i class="fas fa-user text-muted"></i> {{ $enq->client->name ?? 'Prospect Client' }}
                </div>
              </div>
              <span class="badge badge-soft-{{ $enq->status_badge == 'warning' ? 'warning' : ($enq->status_badge == 'success' ? 'success' : 'info') }} fs-9 rounded-pill flex-shrink-0">
                {{ ucfirst($enq->status) }}
              </span>
            </a>
          @endforeach
        </div>
      @else
        <div class="text-center py-3">
          <i class="far fa-comments text-muted fs-3 mb-1"></i>
          <p class="text-muted fs-8 mb-0">No active client enquiries logged.</p>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Featured Products with Wholesale Pricing -->
<div class="agent-card p-4">
  <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
    <div>
      <h5 class="fw-bold text-dark mb-0 fs-6">Featured Aura Products Catalogue</h5>
      <span class="fs-8 text-muted">Exclusive Principal Agent wholesale rates across Soaps, Toilet Paper, Kitchen Towels & Rollon Gel</span>
    </div>
    <a href="{{ route('agent.products.index') }}" class="btn btn-sm btn-light border rounded-pill px-3 fs-8 fw-semibold text-secondary">
      Full Catalogue <i class="fas fa-arrow-right ms-1 fs-9"></i>
    </a>
  </div>

  <div class="row g-3">
    @foreach($featuredProducts as $prod)
      <div class="col-sm-6 col-md-3">
        <div class="product-catalog-card">
          <div>
            <div class="product-img-wrap mb-2.5">
              @if($prod->product_image)
                <img src="{{ asset('storage/' . $prod->product_image) }}" alt="{{ $prod->name }}" onerror="this.onerror=null; this.src='https://placehold.co/300x200/f8fafc/0f172a?text=Aura+Product';">
              @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                  <i class="fas fa-box-open fs-1 text-warning opacity-50"></i>
                </div>
              @endif
            </div>
            <div class="d-flex align-items-center justify-content-between mb-1">
              <span class="badge badge-soft-secondary fs-9 fw-semibold">{{ $prod->category->name ?? 'Aura Product' }}</span>
              <span class="fs-9 text-muted"><i class="fas fa-box me-0.5"></i> MOQ: {{ $prod->min_order_qty ?? 1 }}</span>
            </div>
            <h6 class="fw-bold text-dark fs-7 mb-1 text-truncate" title="{{ $prod->name }}">{{ $prod->name }}</h6>
            <p class="text-muted fs-9 mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 32px;">
              {{ $prod->short_description ?? 'Premium crafted personal care, sanitation, and hygiene product.' }}
            </p>
          </div>
          <div class="pt-2 border-top mt-2">
            <div class="d-flex justify-content-between align-items-baseline mb-2.5">
              <span class="fs-9 text-muted fw-semibold">Wholesale Rate:</span>
              <span class="fw-bolder text-success fs-6">${{ number_format($prod->wholesale_price, 2) }}</span>
            </div>
            <a href="{{ route('agent.orders.create') }}" class="btn btn-sm btn-outline-warning text-dark w-100 rounded-pill fs-8 fw-semibold d-flex align-items-center justify-content-center gap-1">
              <i class="fas fa-cart-plus text-warning"></i> Order Product
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
