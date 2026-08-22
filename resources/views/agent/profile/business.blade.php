@extends('layouts.agent')

@section('page_title', 'My Business Information')

@section('content')
<div class="row g-4">
  <!-- Business Details Card -->
  <div class="col-lg-7">
    <div class="agent-card p-4 p-md-5">
      <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
          <h4 class="fw-bold text-dark mb-1">Registered Business Entity</h4>
          <span class="fs-7 text-muted">Official commercial profile registered with Aura Soaps</span>
        </div>
        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1.5 rounded-pill fs-8 fw-bold">
          <i class="fas fa-check-circle me-1"></i> VERIFIED BUSINESS
        </span>
      </div>

      <div class="row g-3 fs-7 mb-4">
        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Company / Warehouse Name</label>
          <div class="fw-bold text-dark fs-6">{{ $profile->company_name }}</div>
        </div>

        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Agent ID Code</label>
          <div class="fw-bold text-warning font-monospace fs-6">{{ $profile->agent_code ?? 'Pending' }}</div>
        </div>

        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Business Entity Type</label>
          <div class="fw-semibold text-dark">{{ ucfirst(str_replace('_', ' ', $profile->business_type)) }}</div>
        </div>

        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Country & Territory</label>
          <div class="fw-semibold text-dark">{{ $profile->city }}, {{ $profile->province_state ? $profile->province_state . ', ' : '' }}{{ $profile->country }}</div>
        </div>

        <div class="col-12">
          <label class="text-muted fs-8 text-uppercase fw-bold">Physical Warehouse / Store Address</label>
          <div class="fw-semibold text-dark">{{ $profile->business_address }}</div>
        </div>

        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Expected Monthly Volume</label>
          <div class="fw-semibold text-dark">{{ $profile->expected_order_volume ?? 'Standard Wholesale Volume' }}</div>
        </div>

        <div class="col-sm-6">
          <label class="text-muted fs-8 text-uppercase fw-bold">Approval Date</label>
          <div class="fw-semibold text-dark">{{ $profile->approved_at ? $profile->approved_at->format('M d, Y') : 'Active' }}</div>
        </div>

        @if($profile->business_details)
          <div class="col-12">
            <label class="text-muted fs-8 text-uppercase fw-bold">Business Background</label>
            <div class="p-3 bg-light rounded-3 text-secondary">{{ $profile->business_details }}</div>
          </div>
        @endif

        @if($profile->buyer_network_info)
          <div class="col-12">
            <label class="text-muted fs-8 text-uppercase fw-bold">Buyer / Retail Network</label>
            <div class="p-3 bg-light rounded-3 text-secondary">{{ $profile->buyer_network_info }}</div>
          </div>
        @endif
      </div>

      <div class="alert alert-info border-0 rounded-4 p-3 fs-8 mb-0">
        <i class="fas fa-info-circle me-1"></i> To modify verified legal business registration details, please submit an official update request via the <a href="{{ route('agent.support.create') }}" class="fw-bold text-dark">Support Helpdesk</a>.
      </div>
    </div>
  </div>

  <!-- Government Tender Policy & Authorization Card -->
  <div class="col-lg-5">
    <div class="agent-card p-4 mb-4 border-2 {{ $profile->gov_tender_permission === 'approved' ? 'border-success' : 'border-warning' }}">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="bg-warning text-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
          <i class="fas fa-gavel"></i>
        </div>
        <h5 class="fw-bold text-dark mb-0">Government Tender Status</h5>
      </div>

      <div class="mb-3">
        <label class="fs-8 text-muted text-uppercase fw-bold d-block">Current Authorization Status</label>
        @if($profile->gov_tender_permission === 'approved')
          <span class="badge bg-success px-3 py-1.5 rounded-pill fs-7 fw-bold">
            <i class="fas fa-check-circle me-1"></i> Authorized for Government Tenders
          </span>
        @elseif($profile->gov_tender_permission === 'requested')
          <span class="badge bg-info text-dark px-3 py-1.5 rounded-pill fs-7 fw-bold">
            <i class="fas fa-hourglass-half me-1"></i> Authorization Requested (Under Review)
          </span>
        @else
          <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-1.5 rounded-pill fs-7 fw-bold">
            <i class="fas fa-ban me-1"></i> Not Permitted (Default Policy)
          </span>
        @endif
      </div>

      <p class="fs-8 text-muted mb-3">
        In accordance with Aura Soaps commercial bylaws, Principal Agents may not bid or supply under government institutional tenders without a dedicated Certificate of Authority and Power of Attorney issued by Aura Soaps Management.
      </p>

      @if($profile->gov_tender_notes)
        <div class="p-3 bg-light rounded-3 mb-3 fs-8 text-dark">
          <strong class="d-block mb-1 text-muted fs-9 text-uppercase">Management Notes / History:</strong>
          <pre class="mb-0 text-wrap font-sans fs-8" style="white-space: pre-line;">{{ $profile->gov_tender_notes }}</pre>
        </div>
      @endif

      @if($profile->gov_tender_permission !== 'approved')
        <button type="button" class="btn btn-aura w-100 rounded-pill py-2.5 fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#tenderRequestModal">
          <i class="fas fa-file-signature me-1"></i> Request Tender Authorization
        </button>
      @endif
    </div>

    <!-- Verified Verification Documents -->
    <div class="agent-card p-4">
      <h6 class="fw-bold text-dark mb-3"><i class="fas fa-folder-open text-warning me-2"></i>Official Agent Documents</h6>
      <div class="d-flex flex-column gap-2">
        <a href="{{ route('agent.documents.index') }}" class="p-2.5 bg-light rounded-3 text-decoration-none text-dark d-flex align-items-center justify-content-between hover-bg">
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-file-pdf text-danger fs-5"></i>
            <div>
              <div class="fw-bold fs-8">Principal Agent Agreement</div>
              <div class="fs-9 text-muted">Aura Soaps Regional Distribution</div>
            </div>
          </div>
          <i class="fas fa-chevron-right text-muted fs-9"></i>
        </a>

        <a href="{{ route('agent.documents.index') }}" class="p-2.5 bg-light rounded-3 text-decoration-none text-dark d-flex align-items-center justify-content-between hover-bg">
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-id-card text-primary fs-5"></i>
            <div>
              <div class="fw-bold fs-8">Uploaded Identification & Licenses</div>
              <div class="fs-9 text-muted">Verified compliance files</div>
            </div>
          </div>
          <i class="fas fa-chevron-right text-muted fs-9"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Request Tender Authorization -->
<div class="modal fade" id="tenderRequestModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header border-bottom">
        <h5 class="modal-title fw-bold text-dark"><i class="fas fa-gavel text-warning me-2"></i>Request Tender Authorization</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('agent.business.tender-request') }}" method="POST">
        @csrf
        <div class="modal-body">
          <p class="fs-8 text-muted mb-3">Provide the details of the institutional tender you wish to participate in. Aura Soaps commercial leadership will review and issue formal written authorization.</p>

          <div class="mb-3">
            <label class="form-label fw-bold fs-7">Procuring Ministry / Entity *</label>
            <input type="text" name="procuring_entity" class="form-control" placeholder="e.g. Ministry of Health / Rwanda Correctional Service" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold fs-7">Tender Title / Reference No. *</label>
            <input type="text" name="tender_title" class="form-control" placeholder="e.g. Supply of Toilet & Laundry Soap 2026/02" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold fs-7">Estimated Volume / Value (USD / RWF)</label>
            <input type="text" name="estimated_value" class="form-control" placeholder="e.g. 5,000 cases ($100,000)">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold fs-7">Business Justification & Delivery Plan *</label>
            <textarea name="justification" class="form-control" rows="3" placeholder="Explain your logistics capacity and timeline for delivery upon award." required></textarea>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-aura rounded-pill px-4">Submit Authorization Request</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
