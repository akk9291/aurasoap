@extends('layouts.app')

@section('content')
<main class="py-6 bg-light" style="min-height: 80vh;">
  <div class="container-custom">
    
    <!-- LOGIN SECTION -->
    <div id="portalLogin" class="max-w-500 mx-auto py-5" data-aos="zoom-in">
      <div class="glass-card p-4 p-md-5 text-dark shadow border bg-white rounded-4">
        <div class="text-center mb-4">
          <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="Aura Soaps Logo" style="height: 54px; width: auto;" class="mb-3">
          <h2 class="font-heading fw-bold text-dark">Agent Portal</h2>
          <p class="text-muted fs-7">Please log in with your portal password to access exclusive wholesale pricing, brochures, and order entry.</p>
        </div>

        <form id="loginForm">
          <div class="mb-3">
            <label class="form-label fw-bold fs-7">Portal Password *</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
              <input type="password" class="form-control" id="portalPassword" placeholder="Enter password (hint: aura2026)" required>
            </div>
            <div class="invalid-feedback d-none text-danger mt-1 fs-8" id="loginError">
              <i class="fas fa-exclamation-circle me-1"></i>Incorrect password. Please try again.
            </div>
          </div>
          
          <button type="submit" class="btn btn-aura w-100 py-3 mt-3">
            <span>Log In to Dashboard</span>
            <i class="fas fa-sign-in-alt ms-1.5"></i>
          </button>
        </form>
      </div>
    </div>

    <!-- DASHBOARD SECTION (Hidden by default) -->
    <div id="portalDashboard" class="d-none">
      
      <!-- Welcome Header -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gy-3">
        <div>
          <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold mb-2">
            <i class="fas fa-check-circle me-1"></i> PRINCIPAL AGENT ACCESS
          </span>
          <h1 class="font-heading display-6 fw-bold text-dark mb-0">Agent Control Panel</h1>
        </div>
        <div>
          <button class="btn btn-outline-danger btn-sm rounded-pill px-3" id="portalLogout">
            <i class="fas fa-sign-out-alt me-1"></i> Log Out
          </button>
        </div>
      </div>

      <div class="row g-4">
        <!-- Left Column: Prices & Collateral -->
        <div class="col-lg-7">
          
          <!-- Wholesale Pricing Table -->
          <div class="glass-card p-4 shadow-sm border mb-4 text-dark bg-white rounded-4">
            <h4 class="font-heading text-dark mb-3"><i class="fas fa-tag me-2 text-warning"></i>Product Pricing (Wholesale & Retail)</h4>
            <p class="text-muted fs-7 mb-4">Prices in USD and Regional Currencies. Special commission structures apply according to regional contracts.</p>
            
            <div class="table-responsive">
              <table class="table align-middle table-sm border fs-7 mb-0">
                <thead class="table-light">
                  <tr>
                    <th scope="col">Product Item</th>
                    <th scope="col">Specifications</th>
                    <th scope="col" class="text-end">Wholesale (PA Box)</th>
                    <th scope="col" class="text-end">MSRP (Unit)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>Laundry Bar Soap (Blue)</strong></td>
                    <td>1 Kg / Bar</td>
                    <td class="text-end fw-semibold text-success">$18.50 (Case of 24)</td>
                    <td class="text-end">$1.20</td>
                  </tr>
                  <tr>
                    <td><strong>Laundry Bar Soap (Yellow)</strong></td>
                    <td>250gm / Bar</td>
                    <td class="text-end fw-semibold text-success">$15.00 (Case of 48)</td>
                    <td class="text-end">$0.50</td>
                  </tr>
                  <tr>
                    <td><strong>Toilet Bath Soap</strong></td>
                    <td>High TFM 70-76%</td>
                    <td class="text-end fw-semibold text-success">$24.00 (Case of 36)</td>
                    <td class="text-end">$1.00</td>
                  </tr>
                  <tr>
                    <td><strong>Turmeric Natural Beauty Soap</strong></td>
                    <td>Anti-acne bar</td>
                    <td class="text-end fw-semibold text-success">$30.00 (Case of 24)</td>
                    <td class="text-end">$2.00</td>
                  </tr>
                  <tr>
                    <td><strong>Shea Butter Natural Soap</strong></td>
                    <td>Cellular moisture bar</td>
                    <td class="text-end fw-semibold text-success">$30.00 (Case of 24)</td>
                    <td class="text-end">$2.00</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Marketing Collateral & Downloads -->
          <div class="glass-card p-4 shadow-sm border text-dark bg-white rounded-4">
            <h4 class="font-heading text-dark mb-3"><i class="fas fa-download me-2 text-primary"></i>Marketing & Educational Materials</h4>
            <p class="text-muted fs-7 mb-4">Download files, posters, and product certifications to train your staff and support local stores.</p>
            
            <div class="row g-3">
              <div class="col-md-6">
                <div class="p-3 border rounded-3 bg-light d-flex align-items-center gap-3">
                  <i class="fas fa-file-pdf text-danger fs-3"></i>
                  <div>
                    <h6 class="fw-bold mb-1 fs-7">Product Details Catalog</h6>
                    <a href="#" class="text-decoration-none fs-8 text-primary fw-semibold"><i class="fas fa-download me-1"></i>Download PDF</a>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="p-3 border rounded-3 bg-light d-flex align-items-center gap-3">
                  <i class="fas fa-file-image text-primary fs-3"></i>
                  <div>
                    <h6 class="fw-bold mb-1 fs-7">Promotional Poster (A3)</h6>
                    <a href="#" class="text-decoration-none fs-8 text-primary fw-semibold"><i class="fas fa-download me-1"></i>Download JPG</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Right Column: Order Placement Guide & Order Form -->
        <div class="col-lg-5">
          <div class="glass-card p-4 shadow-sm border mb-4 text-dark bg-white rounded-4">
            <h4 class="font-heading text-dark mb-3"><i class="fas fa-truck-loading me-2 text-warning"></i>Order Placement Steps</h4>
            
            <ol class="list-unstyled d-flex flex-column gap-2 fs-7 mb-0">
              <li class="d-flex align-items-start gap-2 border-bottom pb-2">
                <span class="badge bg-warning text-dark rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 22px; height: 22px;">1</span>
                <div><strong>Phone Factory Direct:</strong> Call sales direct at <a href="tel:{{ App\Models\Setting::get('contact_phone', '+18005552872') }}" class="fw-bold text-decoration-none text-dark">{{ App\Models\Setting::get('contact_phone', '+18005552872') }}</a>.</div>
              </li>
              <li class="d-flex align-items-start gap-2 border-bottom pb-2">
                <span class="badge bg-warning text-dark rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 22px; height: 22px;">2</span>
                <div><strong>Email Factory Directly:</strong> Send specs to <a href="mailto:{{ App\Models\Setting::get('contact_email', 'hello@aurasoaps.com') }}" class="fw-bold text-decoration-none text-dark">{{ App\Models\Setting::get('contact_email', 'hello@aurasoaps.com') }}</a>.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <span class="badge bg-warning text-dark rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 22px; height: 22px;">3</span>
                <div><strong>Locate Nearest Agent:</strong> Check regional availability on the <a href="{{ route('agent.locator') }}" class="text-primary font-semibold">Agent Locator</a>.</div>
              </li>
            </ol>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const passwordInput = document.getElementById("portalPassword");
    const errorDiv = document.getElementById("loginError");
    const loginSection = document.getElementById("portalLogin");
    const dashboardSection = document.getElementById("portalDashboard");
    const logoutBtn = document.getElementById("portalLogout");

    if (sessionStorage.getItem("paLoggedIn") === "true") {
      loginSection.classList.add("d-none");
      dashboardSection.classList.remove("d-none");
    }

    if (loginForm) {
      loginForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const pwd = passwordInput.value.trim();

        if (pwd === "aura2026") {
          errorDiv.classList.add("d-none");
          sessionStorage.setItem("paLoggedIn", "true");
          loginSection.classList.add("d-none");
          dashboardSection.classList.remove("d-none");
        } else {
          errorDiv.classList.remove("d-none");
          passwordInput.classList.add("is-invalid");
        }
      });
    }

    if (logoutBtn) {
      logoutBtn.addEventListener("click", function() {
        sessionStorage.removeItem("paLoggedIn");
        passwordInput.value = "";
        passwordInput.classList.remove("is-invalid");
        dashboardSection.classList.add("d-none");
        loginSection.classList.remove("d-none");
      });
    }
  });
</script>
@endpush
@endsection
