@extends('layouts.app')

@section('content')
<section class="py-5 bg-section pt-6">
  <div class="container-custom text-center">
    <span class="badge-subtitle mb-2"><i class="fas fa-envelope text-primary"></i> Get In Touch</span>
    <h1 class="section-title">Contact Aura Soaps</h1>
    <p class="text-muted-custom max-w-700 mx-auto">Have questions about our botanical soap batches, retail inquiries, or ingredient sourcing? We'd love to hear from you.</p>
  </div>
</section>

<section class="py-5">
  <div class="container-custom">
    <div class="row g-5">
      <div class="col-lg-5">
        <div class="glass-card p-4 p-md-5 h-100">
          <h3 class="font-heading mb-4">Contact Information</h3>
          
          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="why-icon-box m-0" style="width: 44px; height: 44px;"><i class="fas fa-map-marker-alt text-amber"></i></div>
            <div>
              <h6 class="fw-bold mb-1">Our Headquarters</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('contact_address', '108 Pure Botanical Way, CA 90210') }}</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="why-icon-box m-0" style="width: 44px; height: 44px;"><i class="fas fa-envelope text-amber"></i></div>
            <div>
              <h6 class="fw-bold mb-1">Email Us</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('contact_email', 'hello@aurasoaps.com') }}</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="why-icon-box m-0" style="width: 44px; height: 44px;"><i class="fas fa-phone-alt text-amber"></i></div>
            <div>
              <h6 class="fw-bold mb-1">Call / WhatsApp</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('contact_phone', '+1 (800) 555-2872') }}</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3">
            <div class="why-icon-box m-0" style="width: 44px; height: 44px;"><i class="fas fa-clock text-amber"></i></div>
            <div>
              <h6 class="fw-bold mb-1">Working Hours</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('working_hours', 'Mon - Sat: 9:00 AM - 6:00 PM EST') }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card p-4 p-md-5 rounded-xl border border-amber shadow">
          <h3 class="font-heading mb-4">Send Us a Message</h3>

          <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fs-7 fw-semibold">Your Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control rounded-pill px-3" placeholder="Jane Doe" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fs-7 fw-semibold">Your Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="jane@example.com" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fs-7 fw-semibold">Phone Number</label>
                <input type="text" name="phone" class="form-control rounded-pill px-3" placeholder="+1 (555) 000-0000">
              </div>
              <div class="col-md-6">
                <label class="form-label fs-7 fw-semibold">Subject</label>
                <input type="text" name="subject" class="form-control rounded-pill px-3" placeholder="Inquiry regarding Honey Soap Bar">
              </div>
              <div class="col-12">
                <label class="form-label fs-7 fw-semibold">Message <span class="text-danger">*</span></label>
                <textarea name="message" class="form-control rounded-xl p-3" rows="5" placeholder="Write your message here..." required></textarea>
              </div>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn-aura-primary px-5 py-3 fs-6">
                <span>Send Message</span>
                <i class="fas fa-paper-plane"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
