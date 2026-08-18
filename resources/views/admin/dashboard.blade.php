@extends('layouts.admin')

@section('page_title', 'CMS Overview Dashboard')

@section('content')
<!-- Quick Action Banner -->
<div class="row mb-4">
  <div class="col-12">
    <div class="admin-card p-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);">
      <div class="d-md-flex align-items-center justify-content-between position-relative z-1">
        <div>
          <span class="badge bg-warning text-dark font-mono px-3 py-1.5 rounded-pill mb-2 fw-semibold">Aura Soaps Core CMS</span>
          <h3 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name ?? 'Administrator' }}! 👋</h3>
          <p class="text-white-50 mb-0 fs-7">Manage your products, botanical ingredients, distributors, and SEO performance in one unified panel.</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
          <a href="{{ route('admin.products.create') }}" class="btn btn-aura">
            <i class="fas fa-plus me-1.5"></i> Add Product
          </a>
          <a href="{{ route('admin.blog.create') }}" class="btn btn-light text-dark fw-semibold rounded-3 border-0">
            <i class="fas fa-pen me-1.5 text-warning"></i> Write Post
          </a>
        </div>
      </div>
      <div class="position-absolute end-0 bottom-0 opacity-10 pe-4 pb-2" style="font-size: 8rem; color: #FFF; pointer-events: none;">
        <i class="fas fa-soap"></i>
      </div>
    </div>
  </div>
</div>

<!-- Stats Grid -->
<div class="row g-3 mb-4">
  <div class="col-xl-3 col-md-6 col-12">
    <div class="admin-card p-3 d-flex align-items-center justify-content-between">
      <div>
        <div class="text-muted fs-7 fw-semibold mb-1">Total Products</div>
        <h3 class="fw-extrabold mb-1 text-dark">{{ $stats['total_products'] }}</h3>
        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-8">
          <i class="fas fa-check-circle me-1"></i> {{ $stats['published_products'] }} Published
        </span>
      </div>
      <div class="stat-card-icon bg-amber-subtle text-warning">
        <i class="fas fa-box"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="admin-card p-3 d-flex align-items-center justify-content-between">
      <div>
        <div class="text-muted fs-7 fw-semibold mb-1">Categories</div>
        <h3 class="fw-extrabold mb-1 text-dark">{{ $stats['total_categories'] }}</h3>
        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill fs-8">
          <i class="fas fa-layer-group me-1"></i> Active Catalog
        </span>
      </div>
      <div class="stat-card-icon bg-info-subtle text-info">
        <i class="fas fa-layer-group"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="admin-card p-3 d-flex align-items-center justify-content-between">
      <div>
        <div class="text-muted fs-7 fw-semibold mb-1">Agent Applications</div>
        <h3 class="fw-extrabold mb-1 text-dark">{{ $stats['total_distributors'] }}</h3>
        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fs-8">
          <i class="fas fa-globe me-1"></i> Global Leads
        </span>
      </div>
      <div class="stat-card-icon bg-warning-subtle text-warning">
        <i class="fas fa-user-tie"></i>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 col-12">
    <div class="admin-card p-3 d-flex align-items-center justify-content-between">
      <div>
        <div class="text-muted fs-7 fw-semibold mb-1">Contact Messages</div>
        <h3 class="fw-extrabold mb-1 text-dark">{{ $stats['total_enquiries'] }}</h3>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill fs-8">
          <i class="fas fa-envelope me-1"></i> Inquiries
        </span>
      </div>
      <div class="stat-card-icon bg-primary-subtle text-primary">
        <i class="fas fa-envelope"></i>
      </div>
    </div>
  </div>
</div>

<!-- Recent Tables -->
<div class="row g-4">
  <div class="col-lg-6">
    <div class="admin-card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
        <div class="d-flex align-items-center gap-2">
          <div class="bg-warning-subtle text-warning rounded-circle p-2 fs-7 d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
            <i class="fas fa-user-tie"></i>
          </div>
          <h6 class="fw-bold mb-0 text-dark">Recent Distributor Applications</h6>
        </div>
        <a href="{{ route('admin.distributors.index') }}" class="fs-7 text-decoration-none fw-semibold text-warning">
          View All <i class="fas fa-arrow-right ms-1"></i>
        </a>
      </div>

      @if($recentDistributors->count())
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-7 mb-0">
            <thead>
              <tr class="text-muted text-uppercase fs-8 border-top-0">
                <th>Applicant</th>
                <th>Company / Country</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentDistributors as $d)
                <tr>
                  <td class="fw-bold text-dark">{{ $d->name }}</td>
                  <td class="text-secondary">{{ $d->company ?: 'N/A' }} <span class="badge bg-light text-dark ms-1">{{ $d->country ?: 'N/A' }}</span></td>
                  <td>
                    @if($d->status == 'approved')
                      <span class="badge bg-success-subtle text-success rounded-pill px-2.5">Approved</span>
                    @elseif($d->status == 'new')
                      <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5">New</span>
                    @else
                      <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5">{{ ucfirst($d->status) }}</span>
                    @endif
                  </td>
                  <td class="text-muted fs-8">{{ $d->created_at->format('M d, Y') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-center py-4">
          <i class="fas fa-inbox text-muted fs-3 mb-2 d-block"></i>
          <p class="text-muted fs-7 mb-0">No distributor applications submitted yet.</p>
        </div>
      @endif
    </div>
  </div>

  <div class="col-lg-6">
    <div class="admin-card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
        <div class="d-flex align-items-center gap-2">
          <div class="bg-primary-subtle text-primary rounded-circle p-2 fs-7 d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
            <i class="fas fa-envelope"></i>
          </div>
          <h6 class="fw-bold mb-0 text-dark">Recent Contact Messages</h6>
        </div>
        <a href="{{ route('admin.enquiries.index') }}" class="fs-7 text-decoration-none fw-semibold text-warning">
          View All <i class="fas fa-arrow-right ms-1"></i>
        </a>
      </div>

      @if($recentEnquiries->count())
        <div class="table-responsive">
          <table class="table table-hover align-middle fs-7 mb-0">
            <thead>
              <tr class="text-muted text-uppercase fs-8 border-top-0">
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentEnquiries as $e)
                <tr>
                  <td class="fw-bold text-dark">{{ $e->name }}</td>
                  <td class="text-secondary">{{ $e->email }}</td>
                  <td>
                    @if($e->status == 'new')
                      <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5">New</span>
                    @elseif($e->status == 'replied')
                      <span class="badge bg-success-subtle text-success rounded-pill px-2.5">Replied</span>
                    @else
                      <span class="badge bg-info-subtle text-info rounded-pill px-2.5">{{ ucfirst($e->status) }}</span>
                    @endif
                  </td>
                  <td class="text-muted fs-8">{{ $e->created_at->format('M d, Y') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-center py-4">
          <i class="fas fa-comment-slash text-muted fs-3 mb-2 d-block"></i>
          <p class="text-muted fs-7 mb-0">No contact enquiries received yet.</p>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
