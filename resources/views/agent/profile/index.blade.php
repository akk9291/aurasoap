@extends('layouts.agent')

@section('page_title', 'My Profile')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="agent-card p-4 p-md-5">
      <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
          <h4 class="fw-bold text-dark mb-1">Personal Profile</h4>
          <span class="fs-7 text-muted">Update your agent contact details and portal credentials</span>
        </div>
        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1.5 rounded-pill fs-8 fw-bold">
          <i class="fas fa-id-badge me-1"></i> {{ $profile->agent_code ?? 'PRINCIPAL AGENT' }}
        </span>
      </div>

      <form action="{{ route('agent.profile.update') }}" method="POST">
        @csrf

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Full Legal Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Email Address (Login ID)</label>
            <input type="email" class="form-control bg-light text-muted" value="{{ $user->email }}" readonly>
            <div class="form-text fs-9">To change your registered email, contact Aura Soaps Management.</div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">Phone Number (Calling) *</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">WhatsApp Number</label>
            <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $profile->whatsapp_number ?? $user->phone) }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold fs-7 text-dark">National ID / Passport Number</label>
            <input type="text" class="form-control bg-light text-muted" value="{{ $profile->national_id_number ?? 'Verified' }}" readonly>
            <div class="form-text fs-9">Verified document information cannot be changed online.</div>
          </div>
        </div>

        <div class="pt-3 border-top mb-4">
          <h5 class="fw-bold text-dark fs-6 mb-3"><i class="fas fa-lock me-2 text-warning"></i>Change Portal Password</h5>
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label fw-bold fs-7 text-dark">Current Password</label>
              <input type="password" name="current_password" class="form-control" placeholder="Required only if changing password">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold fs-7 text-dark">New Password</label>
              <input type="password" name="new_password" class="form-control" placeholder="Minimum 8 characters">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold fs-7 text-dark">Confirm New Password</label>
              <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password">
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-aura rounded-pill px-4 py-2">
            <i class="fas fa-save me-1"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
