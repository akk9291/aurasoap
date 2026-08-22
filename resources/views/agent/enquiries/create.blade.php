@extends('layouts.agent')

@section('page_title', 'Record Client Enquiry')

@section('content')
<div class="mb-3">
  <a href="{{ route('agent.enquiries.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Enquiries
  </a>
</div>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5">
      <div class="mb-4 pb-3 border-bottom">
        <h4 class="fw-bold text-dark mb-1">Record New Customer / Buyer Enquiry</h4>
        <span class="fs-7 text-muted">Log buyer inquiries received via Phone, WhatsApp, In-Person meetings or Email</span>
      </div>

      <form action="{{ route('agent.enquiries.store') }}" method="POST">
        @csrf

        <div class="row g-3 mb-4">
          <div class="col-md-12">
            <label class="form-label fw-bold fs-7 text-dark">Link to Registered Buyer / Client</label>
            <select name="client_id" class="form-select">
              <option value="">-- Independent / New Prospect (No Registered Client Profile) --</option>
              @foreach($clients as $c)
                <option value="{{ $c->id }}" {{ old('client_id', $selectedClientId) == $c->id ? 'selected' : '' }}>
                  {{ $c->name }} ({{ $c->company_name ?? ucfirst($c->client_type) }}) - {{ $c->city ?? 'Rwanda' }}
                </option>
              @endforeach
            </select>
            <div class="form-text fs-9">Or <a href="{{ route('agent.clients.create') }}" class="text-warning fw-semibold">create a new buyer profile first</a>.</div>
          </div>

          <div class="col-md-12">
            <label class="form-label fw-bold fs-7 text-dark">Enquiry Subject / Summary *</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Price inquiry for 200 cases Laundry Bar Soap (1Kg)" value="{{ old('title') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Product Interests</label>
            <input type="text" name="product_interests" class="form-control" placeholder="e.g. Laundry 1kg, Turmeric Bar, Shea Butter" value="{{ old('product_interests') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Estimated Quantity</label>
            <input type="text" name="estimated_quantity" class="form-control" placeholder="e.g. 50 - 150 Cases" value="{{ old('estimated_quantity') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Pipeline Stage *</label>
            <select name="status" class="form-select" required>
              <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New Enquiry</option>
              <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted / Quotation Sent</option>
              <option value="follow_up" {{ old('status') == 'follow_up' ? 'selected' : '' }}>Follow-up Scheduled</option>
              <option value="converted" {{ old('status') == 'converted' ? 'selected' : '' }}>Converted to Confirmed Order</option>
              <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed / Inactive</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label fw-bold fs-7 text-dark">Enquiry Details & Buyer Request</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Describe the client's questions, delivery timeline expectations or volume requirements.">{{ old('description') }}</textarea>
          </div>

          <div class="col-12">
            <label class="form-label fw-bold fs-7 text-dark">Action Plan / Follow-up Notes</label>
            <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Agreed to deliver sample box on Thursday morning.">{{ old('notes') }}</textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('agent.enquiries.index') }}" class="btn btn-light rounded-pill px-3">Cancel</a>
          <button type="submit" class="btn btn-aura rounded-pill px-4">
            <i class="fas fa-save me-1"></i> Save Enquiry
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
