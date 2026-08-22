@extends('layouts.app')

@section('content')
<main class="py-5 bg-light" style="min-height: 80vh;">
  <div class="container-custom">
    <div class="max-w-600 mx-auto">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white text-center">
        
        <div class="mb-4">
          <div class="bg-warning-subtle text-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 72px; height: 72px;">
            <i class="fas fa-clock fs-2"></i>
          </div>
        </div>

        <h3 class="font-heading fw-bold text-dark mb-2">Application Under Review</h3>
        
        <div class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold fs-7 mb-3">
          Status: {{ ucfirst(str_replace('_', ' ', $profile->application_status ?? 'Pending')) }}
        </div>

        <p class="text-muted fs-7 mb-4">
          Thank you for applying, <strong>{{ $user->name }}</strong> ({{ $profile->company_name ?? 'Principal Agent Applicant' }}). Your application has been logged into our system and assigned to the Aura Soaps Commercial Operations team for verification.
        </p>

        <!-- Progress Timeline -->
        <div class="bg-light p-3.5 rounded-4 text-start mb-4">
          <h6 class="fw-bold fs-8 text-uppercase text-muted mb-3">Verification Process Tracker</h6>
          
          <div class="d-flex align-items-start gap-3 mb-3">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 24px; height: 24px; font-size: 0.75rem;">
              <i class="fas fa-check"></i>
            </div>
            <div>
              <div class="fw-bold fs-7 text-dark">1. Application Received</div>
              <div class="fs-8 text-muted">Personal, business, and distribution requirements logged.</div>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-3">
            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold" style="width: 24px; height: 24px; font-size: 0.75rem;">
              2
            </div>
            <div>
              <div class="fw-bold fs-7 text-dark">2. Commercial Team Assessment</div>
              <div class="fs-8 text-muted">Evaluating territory capacity and distributor documentation.</div>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-3">
            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 24px; height: 24px; font-size: 0.75rem;">
              3
            </div>
            <div>
              <div class="fw-bold fs-7 text-secondary">3. Territory Meeting / Verification</div>
              <div class="fs-8 text-muted">Store/warehouse inspection and territory agreement signing.</div>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3">
            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 24px; height: 24px; font-size: 0.75rem;">
              4
            </div>
            <div>
              <div class="fw-bold fs-7 text-secondary">4. Principal Agent Activation</div>
              <div class="fs-8 text-muted">Agent ID assignment and wholesale pricing portal unlocking.</div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
          <form action="{{ route('agent.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-secondary rounded-pill px-4">
              <i class="fas fa-sign-out-alt me-1"></i> Log Out
            </button>
          </form>
          <a href="{{ route('home') }}" class="btn btn-dark rounded-pill px-4">
            Return to Homepage
          </a>
        </div>

      </div>
    </div>
  </div>
</main>
@endsection
