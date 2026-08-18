@extends('layouts.admin')

@section('page_title', 'Admin Profile & Security')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="admin-card p-4">
      <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="fas fa-id-card text-amber me-1"></i> Update Admin Account Credentials</h6>

      <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Full Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Email Address <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">Phone Number</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <hr class="my-4">

        <h6 class="fw-bold mb-3"><i class="fas fa-lock text-danger me-1"></i> Change Password (Leave blank to keep current)</h6>

        <div class="mb-3">
          <label class="form-label fs-7 fw-semibold">New Password</label>
          <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters">
        </div>

        <div class="mb-4">
          <label class="form-label fs-7 fw-semibold">Confirm New Password</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type new password">
        </div>

        <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill"><i class="fas fa-save me-1"></i> Update Profile & Password</button>
      </form>
    </div>
  </div>
</div>
@endsection
