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
      <h1 class="page-banner-title">Principal Agent Locator</h1>
      <p class="page-banner-subtitle mx-auto">Locate active wholesalers and retail agents inside our domestic and regional Great Lakes network.</p>
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
            <option value="all">All Markets (Rwanda & Regional)</option>
            <option value="rwanda">Rwanda Domestic Market</option>
            <option value="regional">Regional: Great Lakes Market</option>
            <option value="drc">DRC Only</option>
            <option value="uganda">Uganda Only</option>
            <option value="tanzania">Tanzania Only</option>
          </select>
        </div>
        <div class="col-lg-4 text-md-end text-start">
          <div class="text-muted fs-6">
            Total Target Agents: <span class="fw-bold text-success fs-5">{{ $totalAgents }} Agents</span> ({{ $rwandaAgents }} Domestic, {{ $regionalAgents }} Regional)
          </div>
        </div>
      </div>

      <!-- Locator Table -->
      <div class="glass-card p-4 shadow-sm border rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="locatorTable">
            <thead class="table-light text-dark font-heading">
              <tr>
                <th scope="col" style="width: 80px;">No.</th>
                <th scope="col">Market / Country</th>
                <th scope="col">Provincial City / Town</th>
                <th scope="col">Province / State</th>
                <th scope="col" class="text-end">Required Agents (Agent Shops)</th>
              </tr>
            </thead>
            <tbody>
              @forelse($agents as $agent)
                <tr class="locator-row" data-market="{{ $agent->market }}" data-country="{{ $agent->country }}">
                  <td class="fw-bold">{{ $loop->iteration }}</td>
                  <td>
                    @if($agent->country === 'rwanda')
                      <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill"><i class="fas fa-flag me-1"></i>Rwanda</span>
                    @elseif($agent->country === 'drc')
                      <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 rounded-pill"><i class="fas fa-globe me-1"></i>DR Congo</span>
                    @elseif($agent->country === 'uganda')
                      <span class="badge bg-warning bg-opacity-10 text-dark px-2.5 py-1 rounded-pill"><i class="fas fa-globe me-1"></i>Uganda</span>
                    @else
                      <span class="badge bg-info bg-opacity-10 text-info px-2.5 py-1 rounded-pill"><i class="fas fa-globe me-1"></i>Tanzania</span>
                    @endif
                  </td>
                  <td><strong>{{ $agent->city_town }}</strong></td>
                  <td>{{ $agent->province_state }}</td>
                  <td class="text-end fw-bold text-success fs-6">{{ $agent->agent_count }}</td>
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

  <!-- CALL TO ACTION -->
  <section class="py-6 bg-section text-center">
    <div class="container-custom">
      <h2 class="font-heading display-6 fw-bold mb-3">Interested in becoming a Principal Agent?</h2>
      <p class="text-muted-custom fs-5 max-w-700 mx-auto mb-4">Read our recruitment requirements, fill out the application form, and start distributing Aura products in your territory.</p>
      <a href="{{ route('distributor') }}" class="btn-aura-primary px-4 py-2.5">
        <span>Apply to Onboard</span>
        <i class="fas fa-file-contract ms-1.5"></i>
      </a>
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
