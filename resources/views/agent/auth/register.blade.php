@extends('layouts.app')

@section('content')
<main class="py-5 bg-light" style="min-height: 85vh;">
  <div class="container-custom">
    
    <div class="max-w-900 mx-auto">
      
      <!-- Application Header Banner -->
      <div class="text-center mb-5">
        <nav class="breadcrumb-aura mb-3">
          <a href="{{ route('home') }}">Home</a>
          <span class="separator"><i class="fas fa-chevron-right"></i></span>
          <a href="{{ route('distributor') }}">Become an Agent</a>
          <span class="separator"><i class="fas fa-chevron-right"></i></span>
          <span class="current">Agent Application</span>
        </nav>
        <div>
          <span class="badge bg-warning bg-opacity-20 text-dark border border-warning px-3 py-1.5 rounded-pill fw-bold fs-7 mb-2">
            <i class="fas fa-handshake me-1 text-warning"></i> OFFICIAL APPLICATION
          </span>
        </div>
        <h1 class="font-heading display-6 fw-bold text-dark mb-2">Apply to Become an Aura Soaps Principal Agent</h1>
        <p class="text-muted fs-6 max-w-700 mx-auto">
          Join our growing regional network of authorized Principal Agents. Distribute premium cold-process and artisan laundry, bath, and botanical beauty soaps with exclusive wholesale pricing and marketing support.
        </p>
      </div>

      <!-- Application Workflow Steps Visual -->
      <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 bg-white">
        <h6 class="fw-bold text-dark text-uppercase fs-8 letter-spacing-1 mb-3 text-center text-muted">Application & Activation Workflow</h6>
        <div class="row text-center g-3">
          <div class="col-6 col-md-3">
            <div class="p-3 bg-light rounded-3 h-100">
              <div class="badge bg-warning text-dark rounded-circle p-2 mb-2" style="width: 28px; height: 28px;">1</div>
              <h6 class="fw-bold fs-8 mb-1">Submit Application</h6>
              <p class="fs-9 text-muted mb-0">Fill in details and upload identity documents</p>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="p-3 bg-light rounded-3 h-100">
              <div class="badge bg-secondary text-white rounded-circle p-2 mb-2" style="width: 28px; height: 28px;">2</div>
              <h6 class="fw-bold fs-8 mb-1">Management Review</h6>
              <p class="fs-9 text-muted mb-0">Aura Soaps evaluates distribution capacity</p>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="p-3 bg-light rounded-3 h-100">
              <div class="badge bg-secondary text-white rounded-circle p-2 mb-2" style="width: 28px; height: 28px;">3</div>
              <h6 class="fw-bold fs-8 mb-1">Verification & Approval</h6>
              <p class="fs-9 text-muted mb-0">Store / warehouse verification and agreement</p>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="p-3 bg-light rounded-3 h-100">
              <div class="badge bg-secondary text-white rounded-circle p-2 mb-2" style="width: 28px; height: 28px;">4</div>
              <h6 class="fw-bold fs-8 mb-1">Agent Portal Access</h6>
              <p class="fs-9 text-muted mb-0">Agent ID assigned and dashboard activated</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Application Form Card -->
      <div class="card border-0 shadow rounded-4 p-4 p-md-5 bg-white">
        
        @if($errors->any())
          <div class="alert alert-danger border-0 rounded-3 mb-4">
            <strong class="d-block mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Please correct the errors below:</strong>
            <ul class="mb-0 fs-8 ps-3">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('agent.register.submit') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- 1. PERSONAL INFORMATION -->
          <div class="mb-4 pb-3 border-bottom">
            <h5 class="fw-bold text-dark font-heading mb-3 d-flex align-items-center gap-2">
              <span class="badge bg-warning text-dark rounded-circle" style="width: 24px; height: 24px; font-size: 0.75rem;">1</span>
              Personal & Representative Information
            </h5>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Full Legal Name *</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Jean-Paul Habimana" value="{{ old('name') }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Email Address *</label>
                <input type="email" name="email" class="form-control" placeholder="e.g. agent@domain.com" value="{{ old('email') }}" required>
                <div class="form-text fs-9">This email will be used for your Agent Portal login.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Phone Number (Calling) *</label>
                <input type="text" name="phone" class="form-control" placeholder="e.g. +250 788 123 456" value="{{ old('phone') }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">WhatsApp Number</label>
                <input type="text" name="whatsapp_number" class="form-control" placeholder="e.g. +250 788 123 456" value="{{ old('whatsapp_number') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">National ID / Passport Number *</label>
                <input type="text" name="national_id_number" class="form-control" placeholder="Enter National ID or Passport No." value="{{ old('national_id_number') }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Create Account Password *</label>
                <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Confirm Password *</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
              </div>
            </div>
          </div>

          <!-- 2. BUSINESS INFORMATION -->
          <div class="mb-4 pb-3 border-bottom">
            <h5 class="fw-bold text-dark font-heading mb-3 d-flex align-items-center gap-2">
              <span class="badge bg-warning text-dark rounded-circle" style="width: 24px; height: 24px; font-size: 0.75rem;">2</span>
              Business & Location Information
            </h5>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Company / Business / Shop / Warehouse Name *</label>
                <input type="text" name="company_name" class="form-control" placeholder="e.g. Great Lakes Distribution Ltd" value="{{ old('company_name') }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Business Entity Type *</label>
                <select name="business_type" class="form-select" required>
                  <option value="wholesaler" {{ old('business_type') == 'wholesaler' ? 'selected' : '' }}>Wholesaler (Regional / Bulk)</option>
                  <option value="distributor" {{ old('business_type') == 'distributor' ? 'selected' : '' }}>Distributor / Supply Company</option>
                  <option value="retailer" {{ old('business_type') == 'retailer' ? 'selected' : '' }}>Retail Chain / Supermarket Stockist</option>
                  <option value="independent_agent" {{ old('business_type') == 'independent_agent' ? 'selected' : '' }}>Independent Principal Agent</option>
                </select>
              </div>

              <div class="col-md-12">
                <label class="form-label fw-bold fs-7 text-dark">Business / Warehouse Physical Address *</label>
                <input type="text" name="business_address" class="form-control" placeholder="e.g. Plot 45, Nyarugenge Commercial District, KN 7 Ave" value="{{ old('business_address') }}" required>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold fs-7 text-dark">City / Town *</label>
                <input type="text" name="city" class="form-control" placeholder="e.g. Kigali / Huye / Musanze" value="{{ old('city') }}" required>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold fs-7 text-dark">Province / District</label>
                <input type="text" name="province_state" class="form-control" placeholder="e.g. Kigali City / Southern / Western" value="{{ old('province_state') }}">
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold fs-7 text-dark">Country *</label>
                <select name="country" class="form-select" required>
                  <option value="Rwanda" {{ old('country') == 'Rwanda' || !old('country') ? 'selected' : '' }}>Rwanda</option>
                  <option value="DR Congo" {{ old('country') == 'DR Congo' ? 'selected' : '' }}>DR Congo</option>
                  <option value="Uganda" {{ old('country') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                  <option value="Tanzania" {{ old('country') == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                  <option value="Burundi" {{ old('country') == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                  <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                </select>
              </div>

              <div class="col-md-12">
                <label class="form-label fw-bold fs-7 text-dark">Existing Buyer & Customer Network Details</label>
                <textarea name="buyer_network_info" class="form-control" rows="2" placeholder="Briefly describe your existing wholesale buyers, retail outlets, supermarkets or institutions that you currently supply.">{{ old('buyer_network_info') }}</textarea>
              </div>
            </div>
          </div>

          <!-- 3. REQUIRED PRODUCT TYPES & ESTIMATED QUANTITIES (FROM ADDENDUM 2) -->
          <div class="mb-4 pb-3 border-bottom">
            <h5 class="fw-bold text-dark font-heading mb-3 d-flex align-items-center gap-2">
              <span class="badge bg-warning text-dark rounded-circle" style="width: 24px; height: 24px; font-size: 0.75rem;">3</span>
              Required Product Types & Initial Estimated Quantities
            </h5>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold fs-8 text-dark">i. Laundry Bar Soap (1 Kg & 250gm)</label>
                <input type="text" name="product_qty_laundry" class="form-control form-control-sm" placeholder="e.g. 50 Cases / Month" value="{{ old('product_qty_laundry') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-8 text-dark">ii. Toilet (Bath) Soap (High TFM)</label>
                <input type="text" name="product_qty_toilet" class="form-control form-control-sm" placeholder="e.g. 30 Cases / Month" value="{{ old('product_qty_toilet') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-8 text-dark">iii. Luxury Toilet Paper (1 & 2-Ply Rolls)</label>
                <input type="text" name="product_qty_paper" class="form-control form-control-sm" placeholder="e.g. 100 Packs / Month" value="{{ old('product_qty_paper') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-8 text-dark">iv. Kitchen Towel Paper (Hand & Table)</label>
                <input type="text" name="product_qty_kitchen_towel" class="form-control form-control-sm" placeholder="e.g. 50 Packs / Month" value="{{ old('product_qty_kitchen_towel') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-8 text-dark">v. Antiperspirant / Deodorant Rollon (Gel)</label>
                <input type="text" name="product_qty_rollon" class="form-control form-control-sm" placeholder="e.g. 20 Boxes (Men & Women)" value="{{ old('product_qty_rollon') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-8 text-dark">Total Expected Monthly Order Volume *</label>
                <select name="expected_order_volume" class="form-select form-select-sm" required>
                  <option value="100 - 500 cases / month" {{ old('expected_order_volume') == '100 - 500 cases / month' ? 'selected' : '' }}>100 - 500 cases / month</option>
                  <option value="500 - 1,500 cases / month" {{ old('expected_order_volume') == '500 - 1,500 cases / month' ? 'selected' : '' }}>500 - 1,500 cases / month</option>
                  <option value="1,500 - 3,000 cases / month" {{ old('expected_order_volume') == '1,500 - 3,000 cases / month' ? 'selected' : '' }}>1,500 - 3,000 cases / month</option>
                  <option value="3,000+ cases / container loads" {{ old('expected_order_volume') == '3,000+ cases / container loads' ? 'selected' : '' }}>3,000+ cases / container loads</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold fs-7 text-dark">Notes on Financial Ability & Working Capital *</label>
                <textarea name="distribution_requirements" class="form-control fs-8" rows="2" placeholder="Note your ability to meet financial terms (60% Cash on Delivery, 40% within 30 Days for Rwanda domestic; 100% pre-delivery for Great Lakes Regional).">{{ old('distribution_requirements') }}</textarea>
              </div>
            </div>
          </div>

          <!-- 4. DOCUMENTS UPLOAD -->
          <div class="mb-4 pb-3 border-bottom">
            <h5 class="fw-bold text-dark font-heading mb-3 d-flex align-items-center gap-2">
              <span class="badge bg-warning text-dark rounded-circle" style="width: 24px; height: 24px; font-size: 0.75rem;">4</span>
              Verification Documents
            </h5>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Identity Card / Passport Copy *</label>
                <input type="file" name="id_card_doc" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                <div class="form-text fs-9">Clear PDF or JPG scan of national ID card or passport.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold fs-7 text-dark">Business Registration / Certificate (if applicable)</label>
                <input type="file" name="business_reg_doc" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <div class="form-text fs-9">RDB / Commercial register certificate or municipal trading license.</div>
              </div>
            </div>
          </div>

          <!-- 5. GOVERNMENT TENDER & POLICY ACKNOWLEDGMENT -->
          <div class="card border-warning border-2 bg-warning-subtle p-3 mb-4 rounded-4">
            <div class="d-flex align-items-start gap-2">
              <i class="fas fa-exclamation-triangle text-dark fs-5 mt-1"></i>
              <div>
                <h6 class="fw-bold text-dark mb-1">Important Compliance Rule: Government Tender Prohibition</h6>
                <p class="fs-8 text-dark mb-2">
                  Aura Soaps Principal Agents are <strong>strictly prohibited</strong> from bidding, participating in, or representing themselves in Government Tenders without express written authorization and official power of attorney from Aura Soaps Management.
                </p>
                
                <div class="form-check">
                  <input class="form-check-input border-dark" type="checkbox" name="acknowledge_tender_restriction" id="acknowledgeTender" required>
                  <label class="form-check-label fw-bold text-dark fs-8" for="acknowledgeTender">
                    I understand and agree that I will not participate in any government tenders under the Aura Soaps brand without prior written approval from Aura Soaps Management. *
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="accept_terms" id="acceptTerms" required>
            <label class="form-check-label fs-8 text-dark" for="acceptTerms">
              I certify that all information submitted is accurate and understand that agent account activation is subject to management verification. *
            </label>
          </div>

          <button type="submit" class="btn btn-aura w-100 py-3 fs-6 rounded-pill fw-bold shadow">
            <span>Submit Principal Agent Application</span>
            <i class="fas fa-paper-plane ms-2"></i>
          </button>
        </form>

      </div>
    </div>
  </div>
</main>
@endsection
