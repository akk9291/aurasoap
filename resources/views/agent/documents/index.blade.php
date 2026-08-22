@extends('layouts.agent')

@section('page_title', 'My Documents Vault')

@section('content')
<div class="agent-card p-4 p-md-5 mb-4">
  <div class="mb-4 pb-3 border-bottom">
    <h4 class="fw-bold text-dark mb-1">Account & Compliance Documents</h4>
    <span class="fs-7 text-muted">Access your verified identity documents, business registration certificates, and Aura Soaps distribution contracts</span>
  </div>

  <div class="row g-4">
    <!-- Principal Agent Contract -->
    <div class="col-md-6 col-xl-4">
      <div class="border rounded-4 p-4 h-100 bg-light d-flex flex-column justify-content-between">
        <div>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-success text-white rounded-3 p-3 text-center" style="width: 48px; height: 48px;">
              <i class="fas fa-file-contract fs-4"></i>
            </div>
            <div>
              <h6 class="fw-bold text-dark fs-7 mb-0">Principal Agent Agreement</h6>
              <span class="badge bg-success bg-opacity-10 text-success border border-success fs-9">Active Contract</span>
            </div>
          </div>
          <p class="fs-8 text-muted mb-3">Official distribution agreement between Aura Soaps Ltd and {{ $profile->company_name }}.</p>
        </div>
        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
          <span class="fs-9 text-muted font-monospace">Agent ID: {{ $profile->agent_code ?? 'AS-AGT' }}</span>
          <a href="{{ route('agent.documents.download', 'agreement') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fs-8">
            <i class="fas fa-download me-1"></i> Download
          </a>
        </div>
      </div>
    </div>

    <!-- National ID / Passport Copy -->
    <div class="col-md-6 col-xl-4">
      <div class="border rounded-4 p-4 h-100 bg-light d-flex flex-column justify-content-between">
        <div>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-primary text-white rounded-3 p-3 text-center" style="width: 48px; height: 48px;">
              <i class="fas fa-id-card fs-4"></i>
            </div>
            <div>
              <h6 class="fw-bold text-dark fs-7 mb-0">Identity Document Copy</h6>
              <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fs-9">Verified</span>
            </div>
          </div>
          <p class="fs-8 text-muted mb-3">National Identification / Passport copy submitted during registration.</p>
        </div>
        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
          <span class="fs-9 text-muted font-monospace">ID: {{ $profile->national_id_number ?? 'Verified' }}</span>
          @if($profile->id_card_doc)
            <a href="{{ route('agent.documents.download', 'id_card') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fs-8">
              <i class="fas fa-download me-1"></i> Download
            </a>
          @else
            <span class="fs-9 text-muted">On file</span>
          @endif
        </div>
      </div>
    </div>

    <!-- Business Registration Certificate -->
    <div class="col-md-6 col-xl-4">
      <div class="border rounded-4 p-4 h-100 bg-light d-flex flex-column justify-content-between">
        <div>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-warning text-dark rounded-3 p-3 text-center" style="width: 48px; height: 48px;">
              <i class="fas fa-certificate fs-4"></i>
            </div>
            <div>
              <h6 class="fw-bold text-dark fs-7 mb-0">Commercial Registration Certificate</h6>
              <span class="badge bg-warning bg-opacity-20 text-dark border border-warning fs-9">Corporate License</span>
            </div>
          </div>
          <p class="fs-8 text-muted mb-3">Company certificate of incorporation / domestic business register document.</p>
        </div>
        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
          <span class="fs-9 text-muted">{{ $profile->company_name }}</span>
          @if($profile->business_reg_doc)
            <a href="{{ route('agent.documents.download', 'business_reg') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fs-8">
              <i class="fas fa-download me-1"></i> Download
            </a>
          @else
            <span class="fs-9 text-muted">Not uploaded</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
