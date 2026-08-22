@extends('layouts.agent')

@section('page_title', 'My Clients / Buyers')

@section('content')
<div class="agent-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">My Buyers & Client CRM</h4>
      <span class="fs-7 text-muted">Manage your regional wholesalers, supermarkets, retail stores and institutional clients</span>
    </div>
    <a href="{{ route('agent.clients.create') }}" class="btn btn-aura rounded-pill px-3 fs-8">
      <i class="fas fa-user-plus me-1"></i> Add New Buyer / Client
    </a>
  </div>

  <!-- Filter & Search -->
  <div class="mt-4 pt-3 border-top">
    <form action="{{ route('agent.clients.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
          <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, company, city, or phone..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-md-4">
        <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Buyer Types</option>
          <option value="wholesaler" {{ request('type') == 'wholesaler' ? 'selected' : '' }}>Wholesalers</option>
          <option value="retailer" {{ request('type') == 'retailer' ? 'selected' : '' }}>Retailers / Supermarkets</option>
        </select>
      </div>

      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Search</button>
        @if(request()->hasAny(['search', 'type']))
          <a href="{{ route('agent.clients.index') }}" class="btn btn-sm btn-light border rounded-3 px-3 text-danger">Reset</a>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Clients Table Card -->
<div class="agent-card p-4">
  @if($clients->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Client / Buyer Name</th>
            <th>Type</th>
            <th>Contact Details</th>
            <th>Location</th>
            <th>Orders</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($clients as $client)
            <tr>
              <td>
                <a href="{{ route('agent.clients.show', $client) }}" class="fw-bold text-decoration-none text-dark">
                  {{ $client->name }}
                </a>
                @if($client->company_name)
                  <div class="fs-9 text-muted">{{ $client->company_name }}</div>
                @endif
              </td>
              <td>
                <span class="badge bg-{{ $client->client_type === 'wholesaler' ? 'primary' : 'info' }} bg-opacity-10 text-{{ $client->client_type === 'wholesaler' ? 'primary' : 'info' }} border border-{{ $client->client_type === 'wholesaler' ? 'primary' : 'info' }} px-2 py-0.5 rounded-pill fs-8">
                  {{ ucfirst($client->client_type) }}
                </span>
              </td>
              <td>
                <div><i class="fas fa-phone text-muted me-1 fs-9"></i> {{ $client->phone }}</div>
                @if($client->email)
                  <div class="fs-9 text-muted"><i class="fas fa-envelope text-muted me-1"></i> {{ $client->email }}</div>
                @endif
              </td>
              <td class="text-secondary">
                {{ $client->city ?? '-' }}, {{ $client->country }}
              </td>
              <td>
                <span class="badge bg-light text-dark border font-monospace">{{ $client->orders_count }} order(s)</span>
              </td>
              <td>
                <span class="badge bg-{{ $client->status === 'active' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $client->status === 'active' ? 'success' : 'secondary' }} border border-{{ $client->status === 'active' ? 'success' : 'secondary' }} px-2 py-0.5 rounded-pill fs-9">
                  {{ ucfirst($client->status) }}
                </span>
              </td>
              <td class="text-end">
                <div class="dropdown">
                  <button class="btn btn-sm btn-light border rounded-pill px-2.5" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 fs-7">
                    <li><a class="dropdown-item" href="{{ route('agent.clients.show', $client) }}"><i class="fas fa-eye me-2 text-primary"></i> View Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('agent.orders.create', ['client_id' => $client->id]) }}"><i class="fas fa-cart-plus me-2 text-success"></i> Create Order</a></li>
                    <li><a class="dropdown-item" href="{{ route('agent.enquiries.create', ['client_id' => $client->id]) }}"><i class="fas fa-comment-medical me-2 text-info"></i> Log Enquiry</a></li>
                    <li><a class="dropdown-item" href="{{ route('agent.clients.edit', $client) }}"><i class="fas fa-edit me-2 text-warning"></i> Edit Details</a></li>
                  </ul>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $clients->links() }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-users-slash text-muted fs-1 mb-3"></i>
      <h5 class="fw-bold text-dark">No client records found.</h5>
      <p class="text-muted fs-7 mb-3">Add your retail stores, supermarkets and wholesale buyers to start logging enquiries and orders.</p>
      <a href="{{ route('agent.clients.create') }}" class="btn btn-aura rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> Add First Buyer
      </a>
    </div>
  @endif
</div>
@endsection
