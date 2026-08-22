@extends('layouts.agent')

@section('page_title', 'Edit Client - ' . $client->name)

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.clients.show', $client) }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Client Profile
  </a>
</div>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5">
      <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
          <h4 class="fw-bold text-dark mb-1">Edit Buyer Profile</h4>
          <span class="fs-7 text-muted">{{ $client->name }}</span>
        </div>
        <form action="{{ route('agent.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this client record?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
            <i class="fas fa-trash me-1"></i> Delete
          </button>
        </form>
      </div>

      <form action="{{ route('agent.clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Contact Person / Buyer Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Company / Shop / Warehouse Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $client->company_name) }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Buyer Category Type *</label>
            <select name="client_type" class="form-select" required>
              <option value="retailer" {{ old('client_type', $client->client_type) == 'retailer' ? 'selected' : '' }}>Retailer / Supermarket / Shop</option>
              <option value="wholesaler" {{ old('client_type', $client->client_type) == 'wholesaler' ? 'selected' : '' }}>Regional Wholesaler / Stockist</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Phone Number *</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">WhatsApp Number</label>
            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $client->whatsapp) }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
          </div>

          <div class="col-md-12">
            <label class="form-label fw-bold fs-7 text-dark">Physical Store / Delivery Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $client->address) }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">City / District</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $client->city) }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Country *</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', $client->country) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Client Status *</label>
            <select name="status" class="form-select" required>
              <option value="active" {{ old('status', $client->status) == 'active' ? 'selected' : '' }}>Active Buyer</option>
              <option value="inactive" {{ old('status', $client->status) == 'inactive' ? 'selected' : '' }}>Inactive / Prospect</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label fw-bold fs-7 text-dark">Internal Notes / Payment Terms / Delivery Instructions</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $client->notes) }}</textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('agent.clients.show', $client) }}" class="btn btn-light rounded-pill px-3">Cancel</a>
          <button type="submit" class="btn btn-aura rounded-pill px-4">
            <i class="fas fa-save me-1"></i> Update Profile
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
