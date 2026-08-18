@extends('layouts.admin')

@section('page_title', 'Users & Role Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h5 class="fw-bold mb-0">Admin Accounts & User Roles</h5>
    <p class="text-muted fs-7 mb-0">Assign role-based access control (Super Admin, Content Manager, SEO Manager, Enquiry Manager)</p>
  </div>
</div>

<div class="admin-card p-3">
  @if($users->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>User</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Joined</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $u)
            <tr>
              <td class="fw-bold text-dark">
                <i class="fas fa-user-circle me-1 text-secondary"></i> {{ $u->name }}
              </td>
              <td>{{ $u->email }}</td>
              <td>
                @foreach($u->roles as $r)
                  <span class="badge bg-warning-subtle text-dark border">{{ $r->name }}</span>
                @endforeach
              </td>
              <td>
                @if($u->status === 'active')
                  <span class="badge bg-success-subtle text-success">Active</span>
                @else
                  <span class="badge bg-danger-subtle text-danger">Inactive</span>
                @endif
              </td>
              <td>{{ $u->created_at->format('M d, Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <p class="text-muted text-center py-4 fs-7 mb-0">No users found.</p>
  @endif
</div>
@endsection
