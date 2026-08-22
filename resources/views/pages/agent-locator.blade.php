@extends('layouts.app')

@section('content')
<main>
  <!-- PAGE BANNER -->
  <section class="page-banner text-center">
    <div class="container-custom">
      <nav class="breadcrumb-aura mb-3">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">Find a Principal Agent</span>
      </nav>
      <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-2">
        <i class="fas fa-network-wired me-1"></i> Regional Distribution Network
      </span>
      <h1 class="page-banner-title">Principal Agent Locator</h1>
      <p class="page-banner-subtitle mx-auto">Aura Soaps business strategy operates through Principal Agents and Retail Agents. More than 100 National and Regional Agents serving as Wholesalers and Retailers across Rwanda and the Great Lakes Region.</p>
    </div>
  </section>

  <!-- COUNTRY HEADS & EXECUTIVE STRUCTURE -->
  <section class="py-5 bg-white border-bottom">
    <div class="container-custom">
      <div class="text-center max-w-700 mx-auto mb-4">
        <span class="badge-subtitle"><i class="fas fa-user-tie"></i> Territory Leadership</span>
        <h3 class="font-heading text-dark fw-bold">Regional Country Sales Heads</h3>
        <p class="text-muted fs-7">Supervising Principal Agent recruitment, regional allocations, and order fulfilment.</p>
      </div>

      <div class="row g-4 justify-content-center">
        <div class="col-md-4">
          <div class="card p-4 rounded-4 border shadow-sm text-center h-100 bg-light">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-4 mx-auto mb-3" style="width: 54px; height: 54px;">
              <i class="fas fa-flag"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Country Head (Rwanda)</h5>
            <div class="badge bg-success bg-opacity-10 text-success mb-2 fs-8">National Sales Executive</div>
            <p class="fs-8 text-muted mb-0">Direct oversight of 84 Principal Agent locations across Kigali City, Southern, Western, Northern, and Eastern Provinces.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card p-4 rounded-4 border shadow-sm text-center h-100 bg-light">
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-4 mx-auto mb-3" style="width: 54px; height: 54px;">
              <i class="fas fa-globe-africa"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Country Head (DRC)</h5>
            <div class="badge bg-primary bg-opacity-10 text-primary mb-2 fs-8">Senior Sales Executive</div>
            <p class="fs-8 text-muted mb-0">Direct oversight of Eastern DRC cross-border distribution across Goma, Bukavu, Uvira, and Bunia.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card p-4 rounded-4 border shadow-sm text-center h-100 bg-light">
            <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-4 mx-auto mb-3" style="width: 54px; height: 54px;">
              <i class="fas fa-map-marked-alt"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Country Head (Western Uganda)</h5>
            <div class="badge bg-warning bg-opacity-20 text-dark mb-2 fs-8">Senior Sales Executive</div>
            <p class="fs-8 text-muted mb-0">Direct oversight of Western Uganda distribution across Kabale, Kisoro, Mbarara, Rukungiri, and surrounding districts.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- AGENT DATABASE SECTION -->
  <section class="py-6">
    <div class="container-custom">
      
      <!-- Search & Filter Controls -->
      <div class="row align-items-center mb-5 gy-3">
        <div class="col-lg-4 col-md-6">
          <div class="search-box-aura position-relative">
            <i class="fas fa-search search-box-icon position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
            <input type="text" class="form-control ps-5 py-2.5 rounded-pill border" id="locatorSearch" placeholder="Search City, Town or District...">
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <select class="form-select py-2.5 rounded-pill border" id="locatorCountry">
            <option value="all">All Markets (Rwanda & Regional Great Lakes)</option>
            <option value="rwanda">Rwanda Domestic Market (84 Agents Target)</option>
            <option value="regional">Regional: Great Lakes Market (36 Agents Target)</option>
            <option value="drc">DR Congo Only</option>
            <option value="uganda">Western Uganda Only</option>
            <option value="tanzania">Tanzania (Rusumo) Only</option>
          </select>
        </div>
        <div class="col-lg-4 text-md-end text-start">
          <div class="text-muted fs-7">
            Required Agents: <strong class="text-success fs-5">120 Total</strong> (84 Rwanda Domestic + 36 Regional)
          </div>
        </div>
      </div>

      <!-- Locator Table -->
      <div class="glass-card p-4 shadow-sm border rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="locatorTable">
            <thead class="table-light text-dark font-heading">
              <tr>
                <th scope="col" style="width: 70px;">No.</th>
                <th scope="col">Market / Territory</th>
                <th scope="col">Provincial City / Town</th>
                <th scope="col">Province / District</th>
                <th scope="col" class="text-end">Shopping Centres / Required Agents</th>
              </tr>
            </thead>
            <tbody>
              @forelse($agents as $agent)
                <tr class="locator-row" data-market="{{ $agent->market }}" data-country="{{ $agent->country }}">
                  <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                  <td>
                    @if($agent->country === 'rwanda')
                      <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill"><i class="fas fa-flag me-1"></i>Rwanda Domestic</span>
                    @elseif($agent->country === 'drc')
                      <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 rounded-pill"><i class="fas fa-globe-africa me-1"></i>DR Congo</span>
                    @elseif($agent->country === 'uganda')
                      <span class="badge bg-warning bg-opacity-20 text-dark px-2.5 py-1 rounded-pill"><i class="fas fa-globe-africa me-1"></i>Uganda</span>
                    @else
                      <span class="badge bg-info bg-opacity-10 text-info px-2.5 py-1 rounded-pill"><i class="fas fa-globe-africa me-1"></i>Tanzania</span>
                    @endif
                  </td>
                  <td><strong class="text-dark">{{ $agent->city_town }}</strong></td>
                  <td class="text-secondary">{{ $agent->province_state }}</td>
                  <td class="text-end fw-bold text-success font-monospace fs-6">{{ $agent->agent_count }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">No agents listed yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>

  <!-- 5-STEP ORDER PLACEMENT INSTRUCTIONS -->
  <section class="py-5 bg-section">
    <div class="container-custom">
      <div class="text-center max-w-700 mx-auto mb-5">
        <span class="badge-subtitle"><i class="fas fa-shopping-cart"></i> Direct Wholesale Ordering</span>
        <h2 class="section-title">How To Place Product Orders</h2>
        <p class="text-muted-custom">Principal Agents, Wholesalers & Retailers can place orders in 5 simple steps:</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card p-4 rounded-4 border shadow-sm h-100 bg-white">
            <div class="badge bg-warning text-dark rounded-circle p-2 fs-6 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">1</div>
            <h5 class="fw-bold text-dark mb-2">Phone Factory Direct</h5>
            <p class="fs-7 text-muted mb-2">Call our central sales desk directly for immediate inventory allocation:</p>
            <a href="tel:+250795602083" class="fw-bold text-success text-decoration-none fs-6"><i class="fas fa-phone me-1"></i> +250 795 602 083</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card p-4 rounded-4 border shadow-sm h-100 bg-white">
            <div class="badge bg-warning text-dark rounded-circle p-2 fs-6 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">2</div>
            <h5 class="fw-bold text-dark mb-2">WhatsApp Factory Direct</h5>
            <p class="fs-7 text-muted mb-2">Send your order list and quantities via official WhatsApp dispatch:</p>
            <a href="https://wa.me/250795602083" target="_blank" class="fw-bold text-success text-decoration-none fs-6"><i class="fab fa-whatsapp me-1"></i> +250 795 602 083</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card p-4 rounded-4 border shadow-sm h-100 bg-white">
            <div class="badge bg-warning text-dark rounded-circle p-2 fs-6 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">3</div>
            <h5 class="fw-bold text-dark mb-2">Email Factory Directly</h5>
            <p class="fs-7 text-muted mb-2">Send formal purchase orders to our commercial email addresses:</p>
            <div class="fs-8">
              <div><a href="mailto:sales1@aura-soaps.com" class="text-primary text-decoration-none">sales1@aura-soaps.com</a></div>
              <div><a href="mailto:sales2@aura-soaps.com" class="text-primary text-decoration-none">sales2@aura-soaps.com</a></div>
              <div><a href="mailto:sales3@aura-soaps.com" class="text-primary text-decoration-none">sales3@aura-soaps.com</a></div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card p-4 rounded-4 border shadow-sm h-100 bg-white">
            <div class="badge bg-warning text-dark rounded-circle p-2 fs-6 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">4</div>
            <h5 class="fw-bold text-dark mb-2">Locate Principal Agent (Near Your Address)</h5>
            <p class="fs-7 text-muted mb-0">Use the agent locator directory above to connect with the authorized wholesale stockist in your district for immediate store supply.</p>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card p-4 rounded-4 border shadow-sm h-100 bg-white">
            <div class="badge bg-warning text-dark rounded-circle p-2 fs-6 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">5</div>
            <h5 class="fw-bold text-dark mb-2">Provide Required Order Details</h5>
            <p class="fs-7 text-muted mb-0">Specify Buyer Name, Company/Shop, Delivery Address, Contact Phone/WhatsApp, and Required Quantities across Laundry Soap, Toilet Soap, Toilet Paper, Rollon, and Beauty Soap.</p>
          </div>
        </div>
      </div>

      <div class="alert alert-success border-0 rounded-4 p-3 mt-4 text-center">
        <i class="fas fa-truck-moving me-1"></i> <strong>Delivery Note:</strong> AURA SOAPS DOES THE DELIVERY TO THE FINAL DESTINATION (Standard distance charges may apply).
      </div>
    </div>
  </section>

  <!-- CALL TO ACTION -->
  <section class="py-6 text-center">
    <div class="container-custom">
      <h2 class="font-heading display-6 fw-bold mb-3">Interested in becoming a Principal Agent?</h2>
      <p class="text-muted-custom fs-5 max-w-700 mx-auto mb-4">Read our recruitment requirements, fill out the application form, and start distributing Aura products in your territory.</p>
      <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('agent.register') }}" class="btn-aura-primary px-4 py-2.5">
          <span>Apply as Principal Agent</span>
          <i class="fas fa-file-contract ms-1.5"></i>
        </a>
        <a href="{{ route('agent.portal') }}" class="btn btn-outline-dark rounded-pill px-4 py-2.5 fs-7 fw-semibold">
          <span>Agent Portal Login</span>
          <i class="fas fa-lock ms-1"></i>
        </a>
      </div>
    </div>
  </section>
</main>

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("locatorSearch");
    const countrySelect = document.getElementById("locatorCountry");
    const rows = document.querySelectorAll(".locator-row");

    function filterTable() {
      const query = searchInput.value.toLowerCase().trim();
      const countryVal = countrySelect.value;

      rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const countryAttr = row.getAttribute("data-country");
        const marketAttr = row.getAttribute("data-market");

        let matchText = text.includes(query);
        let matchCountry = false;

        if (countryVal === "all") {
          matchCountry = true;
        } else if (countryVal === "rwanda" && marketAttr === "rwanda") {
          matchCountry = true;
        } else if (countryVal === "regional" && marketAttr === "regional") {
          matchCountry = true;
        } else if (countryVal === countryAttr) {
          matchCountry = true;
        }

        if (matchText && matchCountry) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    }

    if (searchInput) searchInput.addEventListener("input", filterTable);
    if (countrySelect) countrySelect.addEventListener("change", filterTable);
  });
</script>
@endpush
@endsection
