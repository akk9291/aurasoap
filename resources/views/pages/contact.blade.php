@extends('layouts.app')

@section('content')
<section class="py-5 bg-section pt-6">
  <div class="container-custom text-center">
    <span class="badge-subtitle mb-2"><i class="fas fa-envelope text-primary"></i> Factory & Commercial Desk</span>
    <h1 class="section-title">Contact Aura Soaps & Factory Location</h1>
    <p class="text-muted-custom max-w-700 mx-auto">Connect directly with our manufacturing headquarters, central sales desk, or locate your nearest regional Principal Agent.</p>
  </div>
</section>

<section class="py-5">
  <div class="container-custom">
    <div class="row g-5">
      <!-- Contact Info Card -->
      <div class="col-lg-5">
        <div class="glass-card p-4 p-md-5 h-100 bg-white border rounded-4 shadow-sm">
          <h3 class="font-heading mb-4 text-dark fw-bold">Factory & Sales Desk</h3>
          
          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="why-icon-box m-0 bg-warning-subtle text-warning" style="width: 44px; height: 44px;"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <h6 class="fw-bold text-dark mb-1">Factory Headquarters</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('contact_address', 'Kigali Special Economic Zone / Nyarugenge Commercial District, Kigali, Rwanda') }}</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="why-icon-box m-0 bg-success-subtle text-success" style="width: 44px; height: 44px;"><i class="fas fa-phone-alt"></i></div>
            <div>
              <h6 class="fw-bold text-dark mb-1">Phone Factory Direct</h6>
              <a href="tel:+250795602083" class="text-dark fw-semibold text-decoration-none fs-7 d-block">{{ App\Models\Setting::get('contact_phone', '+250 795 602 083') }}</a>
              <span class="text-muted fs-9">Mon - Sat: 8:00 AM - 6:00 PM (CAT)</span>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="why-icon-box m-0 bg-success-subtle text-success" style="width: 44px; height: 44px;"><i class="fab fa-whatsapp"></i></div>
            <div>
              <h6 class="fw-bold text-dark mb-1">WhatsApp Factory Direct</h6>
              <a href="https://wa.me/250795602083" target="_blank" class="text-success fw-semibold text-decoration-none fs-7 d-block">+250 795 602 083</a>
              <span class="text-muted fs-9">Instant dispatch & order confirmations</span>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="why-icon-box m-0 bg-primary-subtle text-primary" style="width: 44px; height: 44px;"><i class="fas fa-envelope"></i></div>
            <div>
              <h6 class="fw-bold text-dark mb-1">Email Factory Directly</h6>
              <div class="fs-8">
                <div><a href="mailto:sales1@aura-soaps.com" class="text-primary text-decoration-none fw-semibold">sales1@aura-soaps.com</a></div>
                <div><a href="mailto:sales2@aura-soaps.com" class="text-primary text-decoration-none fw-semibold">sales2@aura-soaps.com</a></div>
                <div><a href="mailto:sales3@aura-soaps.com" class="text-primary text-decoration-none fw-semibold">sales3@aura-soaps.com</a></div>
              </div>
            </div>
          </div>

          <div class="pt-3 border-top">
            <a href="{{ route('agent.locator') }}" class="btn btn-outline-dark rounded-pill w-100 py-2 fs-7 fw-semibold mb-2">
              <i class="fas fa-search-location me-1"></i> Locate Nearest Principal Agent
            </a>
            <a href="{{ route('agent.register') }}" class="btn btn-aura rounded-pill w-100 py-2 fs-7 fw-semibold">
              <i class="fas fa-handshake me-1"></i> Become a Principal Agent
            </a>
          </div>
        </div>
      </div>

      <!-- Contact Message Form -->
      <div class="col-lg-7">
        <div class="card p-4 p-md-5 rounded-4 border bg-white shadow-sm">
          <h3 class="font-heading text-dark mb-2 fw-bold">Send Message to Sales Desk</h3>
          <p class="text-muted fs-7 mb-4">Fill out the inquiry form below and our operations team will respond promptly.</p>

          <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fs-7 fw-bold">Your Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control rounded-pill px-3" placeholder="e.g. Jean-Baptiste" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fs-7 fw-bold">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="e.g. buyer@company.com" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fs-7 fw-bold">Phone Number / WhatsApp</label>
                <input type="text" name="phone" class="form-control rounded-pill px-3" placeholder="+250 788 000 000">
              </div>
              <div class="col-md-6">
                <label class="form-label fs-7 fw-bold">Subject / Product Interest</label>
                <input type="text" name="subject" class="form-control rounded-pill px-3" placeholder="e.g. Bulk order for Laundry Bar Soap">
              </div>
              <div class="col-12">
                <label class="form-label fs-7 fw-bold">Message / Order Requirements <span class="text-danger">*</span></label>
                <textarea name="message" class="form-control rounded-4 p-3" rows="5" placeholder="Specify required products, target delivery destination, and quantity estimates..." required></textarea>
              </div>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn-aura-primary px-5 py-3 fs-6">
                <span>Send Message</span>
                <i class="fas fa-paper-plane ms-1"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
