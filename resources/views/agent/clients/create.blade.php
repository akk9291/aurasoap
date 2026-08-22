@extends('layouts.agent')

@section('page_title', 'Add New Client / Buyer')

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.clients.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Clients CRM
  </a>
</div>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5">
      <div class="mb-4 pb-3 border-bottom">
        <h4 class="fw-bold text-dark mb-1">Add New Buyer / Retailer Profile</h4>
        <span class="fs-7 text-muted">Record client business details to manage wholesale orders and enquiries</span>
      </div>

      <form action="{{ route('agent.clients.store') }}" method="POST">
        @csrf

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Contact Person / Buyer Name *</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Simba Supermarket Nyarugenge" value="{{ old('name') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Company / Shop / Warehouse Name</label>
            <input type="text" name="company_name" class="form-control" placeholder="e.g. Simba Supermarkets Ltd" value="{{ old('company_name') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Buyer Category Type *</label>
            <select name="client_type" class="form-select" required>
              <option value="retailer" {{ old('client_type') == 'retailer' ? 'selected' : '' }}>Retailer / Supermarket / Shop</option>
              <option value="wholesaler" {{ old('client_type') == 'wholesaler' ? 'selected' : '' }}>Regional Wholesaler / Stockist</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Phone Number (Calling) *</label>
            <input type="text" name="phone" class="form-control" placeholder="e.g. +250 788 000 111" value="{{ old('phone') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">WhatsApp Number</label>
            <input type="text" name="whatsapp" class="form-control" placeholder="e.g. +250 788 000 111" value="{{ old('whatsapp') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="e.g. procurement@buyer.com" value="{{ old('email') }}">
          </div>

          <div class="col-md-12">
            <label class="form-label fw-bold fs-7 text-dark">Physical Store / Delivery Address</label>
            <input type="text" name="address" class="form-control" placeholder="e.g. City Center Branch, KN 4 Ave" value="{{ old('address') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">City / District</label>
            <input type="text" name="city" class="form-control" placeholder="e.g. Kigali / Rubavu" value="{{ old('city') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Country *</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', 'Rwanda') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Client Status *</label>
            <select name="status" class="form-select" required>
              <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active Buyer</option>
              <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive / Prospect</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label fw-bold fs-7 text-dark">Internal Notes / Payment Terms / Delivery Instructions</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Add any specific client requirements, preferred bar sizes, or payment terms.">{{ old('notes') }}</textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('agent.clients.index') }}" class="btn btn-light rounded-pill px-3">Cancel</a>
          <button type="submit" class="btn btn-aura rounded-pill px-4">
            <i class="fas fa-save me-1"></i> Save Buyer Profile
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
