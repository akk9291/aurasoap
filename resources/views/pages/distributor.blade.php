@extends('layouts.app')

@section('content')
<section class="py-5 bg-section pt-6">
  <div class="container-custom text-center">
    <span class="badge-subtitle mb-2"><i class="fas fa-handshake text-warning"></i> Global Network</span>
    <h1 class="section-title">Become an Official Aura Soap Distributor</h1>
    <p class="text-muted-custom max-w-700 mx-auto">Partner with an established eco-luxury soap brand. We support authorized agents with wholesale pricing, regional exclusivity, and promotional assets.</p>
  </div>
</section>

<section class="py-5">
  <div class="container-custom max-w-800">
    <div class="card p-4 p-md-5 rounded-xl border border-amber shadow-lg">
      <h3 class="font-heading mb-4 text-center">Distributor Application Form</h3>

      <form action="{{ route('distributor.store') }}" method="POST">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control rounded-pill px-3" placeholder="John Doe" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Company / Trading Name</label>
            <input type="text" name="company" class="form-control rounded-pill px-3" placeholder="Eco Wellness Ltd">
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Country / Territory <span class="text-danger">*</span></label>
            <input type="text" name="country" class="form-control rounded-pill px-3" placeholder="United States, Germany, India..." required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Phone / WhatsApp <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control rounded-pill px-3" placeholder="+1 (555) 000-1122" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="agent@company.com" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Estimated Monthly Order Volume</label>
            <select name="estimated_order_volume" class="form-select rounded-pill px-3">
              <option value="500 - 1,000 units">500 - 1,000 units</option>
              <option value="1,000 - 5,000 units">1,000 - 5,000 units</option>
              <option value="5,000+ units">5,000+ units</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fs-7 fw-semibold">Business Background & Message</label>
            <textarea name="message" class="form-control rounded-xl p-3" rows="4" placeholder="Tell us about your distribution channels or retail stores..."></textarea>
          </div>
        </div>

        <div class="mt-4 text-center">
          <button type="submit" class="btn-aura-primary px-5 py-3 fs-6">
            <span>Submit Agent Application</span>
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
