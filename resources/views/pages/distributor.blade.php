@extends('layouts.app')

@section('content')
<section class="py-5 bg-section pt-6">
  <div class="container-custom text-center">
    <span class="badge-subtitle mb-2"><i class="fas fa-handshake text-warning"></i> Agent Recruitment</span>
    <h1 class="section-title">Become a Principal Agent</h1>
    <p class="text-muted-custom max-w-700 mx-auto">Join our authorized commercial distribution network across Rwanda and the Great Lakes Region. Receive protected territory quotas, wholesale margins, marketing support, and final destination logistics.</p>
  </div>
</section>

<section class="py-5">
  <div class="container-custom max-w-900">
    
    <!-- Requirements Card from Addendum 2 -->
    <div class="card p-4 p-md-5 rounded-4 border shadow-sm mb-5 bg-white">
      <h3 class="font-heading text-dark fw-bold mb-3"><i class="fas fa-clipboard-check text-warning me-2"></i>Principal Agent Requirements</h3>
      <p class="text-muted fs-7 mb-4">To become a Principal Agent (PA), a Business or Business Person needs to meet the following requirements:</p>

      <div class="row g-3">
        <div class="col-md-6">
          <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 h-100">
            <span class="badge bg-dark text-white rounded-circle p-2 fs-8 flex-shrink-0" style="width: 28px; height: 28px;">1</span>
            <div class="fs-8"><strong>Sign Principal Agent Contract:</strong> Execute official commercial distribution agreement.</div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 h-100">
            <span class="badge bg-dark text-white rounded-circle p-2 fs-8 flex-shrink-0" style="width: 28px; height: 28px;">2</span>
            <div class="fs-8"><strong>Territory Location:</strong> Must be located in designated Province/District/Town from our target map.</div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 h-100">
            <span class="badge bg-dark text-white rounded-circle p-2 fs-8 flex-shrink-0" style="width: 28px; height: 28px;">3</span>
            <div class="fs-8"><strong>Premises & Network:</strong> Have shop(s)/warehouse(s) or active buyer clients (Supermarkets, Wholesalers, Retailers).</div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 h-100">
            <span class="badge bg-dark text-white rounded-circle p-2 fs-8 flex-shrink-0" style="width: 28px; height: 28px;">4</span>
            <div class="fs-8"><strong>Financial Terms:</strong> 60% Cash on Delivery (CoD) & 40% within 30 Days for Rwanda; 100% pre-delivery for Great Lakes Regional.</div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 h-100">
            <span class="badge bg-dark text-white rounded-circle p-2 fs-8 flex-shrink-0" style="width: 28px; height: 28px;">5</span>
            <div class="fs-8"><strong>Minimum Order Quantity (MOQ):</strong> Meet case-load minimums per product category.</div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 h-100">
            <span class="badge bg-dark text-white rounded-circle p-2 fs-8 flex-shrink-0" style="width: 28px; height: 28px;">6</span>
            <div class="fs-8"><strong>Fill Application Form:</strong> Complete official onboarding form with verification documents.</div>
          </div>
        </div>

        <div class="col-12">
          <div class="d-flex align-items-start gap-3 p-3 bg-warning-subtle rounded-3 border border-warning">
            <span class="badge bg-warning text-dark rounded-circle p-2 fs-8 flex-shrink-0" style="width: 28px; height: 28px;">7</span>
            <div class="fs-8 text-dark"><strong>Aura Soaps Management Approval:</strong> Final authorization granted following a formal meeting and warehouse facility inspection visit.</div>
          </div>
        </div>
      </div>

      <div class="mt-4 text-center">
        <a href="{{ route('agent.register') }}" class="btn btn-aura px-5 py-3 fs-6 rounded-pill fw-bold shadow">
          <span>Complete Full Principal Agent Application</span>
          <i class="fas fa-arrow-right ms-2"></i>
        </a>
      </div>
    </div>

    <!-- Quick Inquiry Form -->
    <div class="card p-4 p-md-5 rounded-4 border bg-white shadow-sm">
      <h3 class="font-heading mb-2 text-center text-dark fw-bold">General Distributor & Agency Inquiry</h3>
      <p class="text-muted fs-7 text-center mb-4">Have questions prior to submitting formal registration? Send our commercial desk a message:</p>

      <form action="{{ route('distributor.store') }}" method="POST">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Full Legal Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control rounded-pill px-3" placeholder="e.g. Jean-Paul Habimana" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Company / Trading / Shop Name</label>
            <input type="text" name="company" class="form-control rounded-pill px-3" placeholder="e.g. Habimana Wholesale Stockists Ltd">
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Country / Territory <span class="text-danger">*</span></label>
            <input type="text" name="country" class="form-control rounded-pill px-3" placeholder="Rwanda (Kigali / Huye / Musanze), DRC, Uganda..." required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Phone / WhatsApp <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control rounded-pill px-3" placeholder="+250 788 000 000" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="agent@company.com" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fs-7 fw-semibold">Estimated Monthly Order Volume</label>
            <select name="estimated_order_volume" class="form-select rounded-pill px-3">
              <option value="500 - 1,000 units">500 - 1,000 Cases</option>
              <option value="1,000 - 5,000 units">1,000 - 5,000 Cases</option>
              <option value="5,000+ units">5,000+ Cases (Container Load)</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fs-7 fw-semibold">Business Background, Retail Stores & Buyer Network</label>
            <textarea name="message" class="form-control rounded-4 p-3" rows="4" placeholder="Tell us about your warehouse facilities, retail stores, or wholesale distribution experience..."></textarea>
          </div>
        </div>

        <div class="mt-4 text-center">
          <button type="submit" class="btn-aura-primary px-5 py-3 fs-6">
            <span>Submit Agency Inquiry</span>
            <i class="fas fa-paper-plane ms-1"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
