@extends('layouts.admin')

@section('page_title', 'Principal Agent Management')

@section('content')
<div class="admin-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">Principal Agent Applications & Accounts</h4>
      <span class="fs-7 text-muted">Review agent registrations, verify distribution capacity, approve accounts and manage agent permissions</span>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.agent_management.orders') }}" class="btn btn-outline-dark rounded-pill px-3 fs-8">
        <i class="fas fa-file-invoice-dollar me-1 text-success"></i> Agent Orders
      </a>
      <a href="{{ route('admin.agent_management.marketing') }}" class="btn btn-outline-dark rounded-pill px-3 fs-8">
        <i class="fas fa-bullhorn me-1 text-primary"></i> Marketing CMS
      </a>
      <a href="{{ route('admin.agent_management.support') }}" class="btn btn-outline-dark rounded-pill px-3 fs-8">
        <i class="fas fa-headset me-1 text-warning"></i> Support Desk
      </a>
    </div>
  </div>

  <!-- Status Tabs -->
  <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
    <a href="{{ route('admin.agent_management.index') }}" class="btn btn-sm {{ !request('status') || request('status') == 'all' ? 'btn-dark' : 'btn-light border' }} rounded-pill px-3 fs-8">
      All Agents <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
    </a>
    <a href="{{ route('admin.agent_management.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning text-dark' : 'btn-light border' }} rounded-pill px-3 fs-8">
      Pending Review <span class="badge bg-dark text-white ms-1">{{ $counts['pending'] }}</span>
    </a>
    <a href="{{ route('admin.agent_management.index', ['status' => 'under_review']) }}" class="btn btn-sm {{ request('status') == 'under_review' ? 'btn-info text-dark' : 'btn-light border' }} rounded-pill px-3 fs-8">
      Under Review <span class="badge bg-dark text-white ms-1">{{ $counts['under_review'] }}</span>
    </a>
    <a href="{{ route('admin.agent_management.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') == 'approved' ? 'btn-success text-white' : 'btn-light border' }} rounded-pill px-3 fs-8">
      Approved Agents <span class="badge bg-light text-dark border ms-1">{{ $counts['approved'] }}</span>
    </a>
    <a href="{{ route('admin.agent_management.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-danger text-white' : 'btn-light border' }} rounded-pill px-3 fs-8">
      Rejected <span class="badge bg-light text-dark border ms-1">{{ $counts['rejected'] }}</span>
    </a>
    <a href="{{ route('admin.agent_management.index', ['status' => 'suspended']) }}" class="btn btn-sm {{ request('status') == 'suspended' ? 'btn-secondary text-white' : 'btn-light border' }} rounded-pill px-3 fs-8">
      Suspended <span class="badge bg-light text-dark border ms-1">{{ $counts['suspended'] }}</span>
    </a>
  </div>

  <!-- Search Filter -->
  <div class="mt-3">
    <form action="{{ route('admin.agent_management.index') }}" method="GET" class="row g-2 align-items-center">
      @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
      @endif
      <div class="col-md-6">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
          <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, company, agent ID, email or phone..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Search</button>
        @if(request()->hasAny(['search', 'status']))
          <a href="{{ route('admin.agent_management.index') }}" class="btn btn-sm btn-light border rounded-3 px-3 text-danger">Reset</a>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Agents Table -->
<div class="admin-card p-4">
  @if($agents->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead class="table-light">
          <tr>
            <th>Agent / Applicant</th>
            <th>Company / Warehouse</th>
            <th>Location</th>
            <th>Expected Volume</th>
            <th>Tender Permission</th>
            <th>Application Status</th>
            <th>Applied Date</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($agents as $agt)
            <tr>
              <td>
                <div class="fw-bold text-dark">{{ $agt->user->name ?? 'Unknown Applicant' }}</div>
                <div class="fs-9 text-muted">{{ $agt->user->email ?? '-' }} &bull; {{ $agt->user->phone ?? '-' }}</div>
                @if($agt->agent_code)
                  <span class="badge bg-light text-warning border border-warning font-monospace fs-9 mt-1">{{ $agt->agent_code }}</span>
                @endif
              </td>
              <td>
                <div class="fw-semibold text-dark">{{ $agt->company_name }}</div>
                <span class="badge bg-light text-muted border fs-9">{{ ucfirst(str_replace('_', ' ', $agt->business_type)) }}</span>
              </td>
              <td class="text-secondary fs-8">
                {{ $agt->city }}, {{ $agt->country }}
              </td>
              <td class="fs-8 text-secondary">
                {{ $agt->expected_order_volume ?? '-' }}
              </td>
              <td>
                @if($agt->gov_tender_permission === 'approved')
                  <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-0.5 rounded-pill fs-9">
                    <i class="fas fa-check-circle me-1"></i> Authorized
                  </span>
                @elseif($agt->gov_tender_permission === 'requested')
                  <span class="badge bg-info text-dark px-2 py-0.5 rounded-pill fs-9">
                    <i class="fas fa-hourglass-half me-1"></i> Requested
                  </span>
                @else
                  <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-2 py-0.5 rounded-pill fs-9">
                    Not Permitted
                  </span>
                @endif
              </td>
              <td>
                <span class="badge bg-{{ $agt->status_badge }} bg-opacity-10 text-{{ $agt->status_badge }} border border-{{ $agt->status_badge }} px-2.5 py-1 rounded-pill fs-8 fw-bold">
                  {{ ucfirst(str_replace('_', ' ', $agt->application_status)) }}
                </span>
              </td>
              <td class="text-muted fs-8">{{ $agt->created_at->format('M d, Y') }}</td>
              <td class="text-end">
                <a href="{{ route('admin.agent_management.show', $agt) }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1 fs-8 fw-semibold text-primary">
                  <i class="fas fa-search me-1"></i> Review
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $agents->links() }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-users-slash text-muted fs-1 mb-3"></i>
      <h5 class="fw-bold text-dark">No agents found in this tab.</h5>
      <p class="text-muted fs-7">Applications submitted by prospective Principal Agents will appear here for review.</p>
    </div>
  @endif
</div>
@endsection
