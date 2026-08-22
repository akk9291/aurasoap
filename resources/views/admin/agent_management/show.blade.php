@extends('layouts.admin')

@section('page_title', 'Agent Review - ' . ($agent->company_name ?? 'Principal Agent'))

@section('content')
<div class="mb-3 d-flex align-items-center justify-content-between">
  <a href="{{ route('admin.agent_management.index') }}" class="fs-8 text-decoration-none text-muted">
    <i class="fas fa-arrow-left me-1"></i> Back to Agent Applications
  </a>

  <!-- Action Badges / Controls -->
  <div class="d-flex gap-2">
    @if($agent->application_status === 'pending' || $agent->application_status === 'under_review')
      <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fs-8 fw-semibold" data-bs-toggle="modal" data-bs-target="#approveModal">
        <i class="fas fa-check-circle me-1"></i> Approve Agent
      </button>
      <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 fs-8 fw-semibold" data-bs-toggle="modal" data-bs-target="#rejectModal">
        <i class="fas fa-times-circle me-1"></i> Reject Application
      </button>
    @elseif($agent->application_status === 'approved')
      <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3 fs-8 fw-semibold" data-bs-toggle="modal" data-bs-target="#suspendModal">
        <i class="fas fa-ban me-1"></i> Suspend Account
      </button>
    @elseif($agent->application_status === 'suspended')
      <form action="{{ route('admin.agent_management.reactivate', $agent) }}" method="POST" onsubmit="return confirm('Reactivate this agent account?');">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3 fs-8 fw-semibold">
          <i class="fas fa-sync-alt me-1"></i> Reactivate Agent
        </button>
      </form>
    @endif
  </div>
</div>

<div class="row g-4">
  <!-- Left Column: Agent Profile & Verification Info -->
  <div class="col-lg-8">
    <div class="admin-card p-4 p-md-5 mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
          <span class="badge bg-{{ $agent->status_badge }} bg-opacity-10 text-{{ $agent->status_badge }} border border-{{ $agent->status_badge }} px-3 py-1 rounded-pill fs-8 fw-bold mb-2">
            Status: {{ ucfirst(str_replace('_', ' ', $agent->application_status)) }}
          </span>
          <h3 class="fw-bold text-dark mb-1">{{ $agent->company_name }}</h3>
          <span class="fs-7 text-muted">Representative: <strong>{{ $user->name ?? 'N/A' }}</strong> &bull; Applied: {{ $agent->created_at->format('M d, Y') }}</span>
        </div>

        @if($agent->agent_code)
          <div class="text-end">
            <span class="fs-9 text-muted text-uppercase d-block fw-bold">Agent ID Code</span>
            <span class="badge bg-warning text-dark font-monospace fs-6 px-3 py-1.5 rounded-pill">{{ $agent->agent_code }}</span>
          </div>
        @endif
      </div>

      <!-- Information Grid -->
      <h6 class="fw-bold text-dark mb-3">1. Personal & Representative Details</h6>
      <div class="row g-3 fs-7 mb-4 bg-light p-3 rounded-4">
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">Full Legal Name</span>
          <strong class="text-dark">{{ $user->name ?? '-' }}</strong>
        </div>
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">Email Address</span>
          <a href="mailto:{{ $user->email }}" class="text-primary text-decoration-none">{{ $user->email ?? '-' }}</a>
        </div>
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">Calling Phone</span>
          <a href="tel:{{ $user->phone }}" class="text-dark text-decoration-none">{{ $user->phone ?? '-' }}</a>
        </div>
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">WhatsApp Number</span>
          <span class="text-success">{{ $agent->whatsapp_number ?? $user->phone }}</span>
        </div>
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">National ID / Passport No.</span>
          <span class="text-dark font-monospace">{{ $agent->national_id_number ?? 'Not specified' }}</span>
        </div>
      </div>

      <h6 class="fw-bold text-dark mb-3">2. Business & Warehouse Location</h6>
      <div class="row g-3 fs-7 mb-4 bg-light p-3 rounded-4">
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">Business Entity Type</span>
          <span class="badge bg-light text-dark border">{{ ucfirst(str_replace('_', ' ', $agent->business_type)) }}</span>
        </div>
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">City & Territory</span>
          <span class="text-dark">{{ $agent->city }}, {{ $agent->province_state ? $agent->province_state . ', ' : '' }}{{ $agent->country }}</span>
        </div>
        <div class="col-12">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">Physical Warehouse Address</span>
          <span class="text-dark">{{ $agent->business_address }}</span>
        </div>
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">Expected Monthly Volume</span>
          <strong class="text-dark">{{ $agent->expected_order_volume ?? 'Standard' }}</strong>
        </div>
        <div class="col-sm-6">
          <span class="text-muted fs-8 text-uppercase fw-bold d-block">Requested Product Lines</span>
          <span class="text-secondary">{{ $agent->distribution_requirements ?? 'Full Soap Line' }}</span>
        </div>
        @if($agent->business_details)
          <div class="col-12">
            <span class="text-muted fs-8 text-uppercase fw-bold d-block">Business Details</span>
            <div class="text-secondary">{{ $agent->business_details }}</div>
          </div>
        @endif
        @if($agent->buyer_network_info)
          <div class="col-12">
            <span class="text-muted fs-8 text-uppercase fw-bold d-block">Existing Buyer & Distribution Network</span>
            <div class="text-secondary">{{ $agent->buyer_network_info }}</div>
          </div>
        @endif
      </div>

      <!-- 3. Uploaded Documents -->
      <h6 class="fw-bold text-dark mb-3">3. Verification Documents Uploaded</h6>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <div class="border rounded-3 p-3 bg-white d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-id-card text-primary fs-4"></i>
              <div>
                <strong class="fs-8 d-block text-dark">Identity Card / Passport</strong>
                <span class="fs-9 text-muted">{{ $agent->id_card_doc ? 'Document Attached' : 'Not uploaded' }}</span>
              </div>
            </div>
            @if($agent->id_card_doc)
              <a href="{{ route('admin.agent_management.doc_download', ['agent' => $agent, 'type' => 'id_card']) }}" class="btn btn-sm btn-light border rounded-pill px-3 fs-9">
                <i class="fas fa-download me-1"></i> Download
              </a>
            @endif
          </div>
        </div>

        <div class="col-md-6">
          <div class="border rounded-3 p-3 bg-white d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-certificate text-warning fs-4"></i>
              <div>
                <strong class="fs-8 d-block text-dark">Business Registration</strong>
                <span class="fs-9 text-muted">{{ $agent->business_reg_doc ? 'Document Attached' : 'Not uploaded' }}</span>
              </div>
            </div>
            @if($agent->business_reg_doc)
              <a href="{{ route('admin.agent_management.doc_download', ['agent' => $agent, 'type' => 'business_reg']) }}" class="btn btn-sm btn-light border rounded-pill px-3 fs-9">
                <i class="fas fa-download me-1"></i> Download
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- 4. Agent Activity: Clients & Orders History -->
      <h6 class="fw-bold text-dark mb-3">4. Agent Activity & Performance</h6>
      <ul class="nav nav-pills mb-3" id="agentTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active fs-8 rounded-pill py-1.5 px-3" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders-tab-pane" type="button">Orders ({{ $orders->count() }})</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-8 rounded-pill py-1.5 px-3" id="clients-tab" data-bs-toggle="pill" data-bs-target="#clients-tab-pane" type="button">Buyers CRM ({{ $clients->count() }})</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-8 rounded-pill py-1.5 px-3" id="tickets-tab" data-bs-toggle="pill" data-bs-target="#tickets-tab-pane" type="button">Support ({{ $tickets->count() }})</button>
        </li>
      </ul>

      <div class="tab-content" id="agentTabContent">
        <div class="tab-pane fade show active" id="orders-tab-pane">
          @if($orders->count() > 0)
            <div class="table-responsive">
              <table class="table table-sm align-middle fs-8">
                <thead><tr><th>Order #</th><th>Buyer</th><th>Date</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                  @foreach($orders as $ord)
                    <tr>
                      <td class="font-monospace fw-bold"><a href="{{ route('admin.agent_management.orders.show', $ord) }}">{{ $ord->order_number }}</a></td>
                      <td>{{ $ord->client->name ?? 'Direct' }}</td>
                      <td>{{ $ord->created_at->format('M d, Y') }}</td>
                      <td class="fw-bold text-success">${{ number_format($ord->total_amount, 2) }}</td>
                      <td><span class="badge bg-{{ $ord->status_badge }}">{{ ucfirst($ord->status) }}</span></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <p class="text-muted fs-8 my-2">No orders recorded yet for this agent.</p>
          @endif
        </div>

        <div class="tab-pane fade" id="clients-tab-pane">
          @if($clients->count() > 0)
            <div class="table-responsive">
              <table class="table table-sm align-middle fs-8">
                <thead><tr><th>Client Name</th><th>Type</th><th>Phone</th><th>City</th><th>Orders</th></tr></thead>
                <tbody>
                  @foreach($clients as $cl)
                    <tr>
                      <td class="fw-bold">{{ $cl->name }}</td>
                      <td>{{ ucfirst($cl->client_type) }}</td>
                      <td>{{ $cl->phone }}</td>
                      <td>{{ $cl->city ?? '-' }}</td>
                      <td>{{ $cl->orders_count }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <p class="text-muted fs-8 my-2">No clients recorded yet in agent CRM.</p>
          @endif
        </div>

        <div class="tab-pane fade" id="tickets-tab-pane">
          @if($tickets->count() > 0)
            <div class="table-responsive">
              <table class="table table-sm align-middle fs-8">
                <thead><tr><th>Ticket #</th><th>Subject</th><th>Priority</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                  @foreach($tickets as $tck)
                    <tr>
                      <td class="font-monospace fw-bold">{{ $tck->ticket_number }}</td>
                      <td>{{ $tck->subject }}</td>
                      <td><span class="badge bg-{{ $tck->priority_badge }}">{{ ucfirst($tck->priority) }}</span></td>
                      <td><span class="badge bg-{{ $tck->status_badge }}">{{ ucfirst($tck->status) }}</span></td>
                      <td><a href="{{ route('admin.agent_management.support.show', $tck) }}" class="btn btn-sm btn-light border py-0 px-2 fs-9">Reply</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <p class="text-muted fs-8 my-2">No support tickets recorded for this agent.</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column: Tender Permission & Internal Notes -->
  <div class="col-lg-4">
    <!-- Government Tender Permission Control -->
    <div class="admin-card p-4 mb-4 border-2 border-warning">
      <div class="d-flex align-items-center gap-2 mb-3">
        <i class="fas fa-gavel text-warning fs-5"></i>
        <h6 class="fw-bold text-dark mb-0">Government Tender Permission</h6>
      </div>

      <form action="{{ route('admin.agent_management.tender_permission', $agent) }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fs-8 text-muted fw-bold">Authorization Status</label>
          <select name="gov_tender_permission" class="form-select form-select-sm" required>
            <option value="not_permitted" {{ $agent->gov_tender_permission == 'not_permitted' ? 'selected' : '' }}>Not Permitted (Default Policy)</option>
            <option value="requested" {{ $agent->gov_tender_permission == 'requested' ? 'selected' : '' }}>Permission Requested by Agent</option>
            <option value="approved" {{ $agent->gov_tender_permission == 'approved' ? 'selected' : '' }}>Approved / Authorized for Tenders</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fs-8 text-muted fw-bold">Management Authorization Notes</label>
          <textarea name="tender_notes" class="form-control form-control-sm" rows="3" placeholder="Add specific tender reference numbers or certificate constraints.">{{ $agent->gov_tender_notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-sm btn-dark w-100 rounded-pill">
          <i class="fas fa-save me-1"></i> Update Tender Permission
        </button>
      </form>
    </div>

    <!-- Internal Admin Notes -->
    <div class="admin-card p-4">
      <h6 class="fw-bold text-dark mb-3"><i class="fas fa-sticky-note text-primary me-2"></i>Internal Management Notes</h6>
      <form action="{{ route('admin.agent_management.notes', $agent) }}" method="POST">
        @csrf
        <div class="mb-3">
          <textarea name="admin_internal_notes" class="form-control fs-8" rows="6" placeholder="Add confidential internal notes regarding verification, warehouse inspection, territory performance, or contract details.">{{ $agent->admin_internal_notes }}</textarea>
        </div>
        <button type="submit" class="btn btn-sm btn-aura w-100 rounded-pill">
          <i class="fas fa-save me-1"></i> Save Internal Notes
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Approve Agent -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header border-bottom">
        <h5 class="modal-title fw-bold text-success"><i class="fas fa-check-circle me-2"></i>Approve Principal Agent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.agent_management.approve', $agent) }}" method="POST">
        @csrf
        <div class="modal-body">
          <p class="fs-7 text-dark mb-3">Approving this application will activate the Agent Portal access for <strong>{{ $user->name ?? 'Applicant' }}</strong> and assign the Principal Agent role.</p>
          <div class="mb-3">
            <label class="form-label fw-bold fs-8">Internal Verification Notes</label>
            <textarea name="admin_notes" class="form-control form-control-sm" rows="3" placeholder="e.g. Commercial registration verified, warehouse capacity confirmed."></textarea>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success rounded-pill px-4">Confirm & Approve</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Reject Agent -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header border-bottom">
        <h5 class="modal-title fw-bold text-danger"><i class="fas fa-times-circle me-2"></i>Reject Agent Application</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.agent_management.reject', $agent) }}" method="POST">
        @csrf
        <div class="modal-body">
          <p class="fs-7 text-dark mb-3">Please specify the reason for rejecting this agent application:</p>
          <div class="mb-3">
            <label class="form-label fw-bold fs-8">Rejection Reason / Notes *</label>
            <textarea name="admin_notes" class="form-control form-control-sm" rows="3" placeholder="e.g. Territory currently saturated / documentation incomplete." required></textarea>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger rounded-pill px-4">Confirm Rejection</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Suspend Agent -->
<div class="modal fade" id="suspendModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header border-bottom">
        <h5 class="modal-title fw-bold text-warning"><i class="fas fa-ban me-2"></i>Suspend Principal Agent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.agent_management.suspend', $agent) }}" method="POST">
        @csrf
        <div class="modal-body">
          <p class="fs-7 text-dark mb-3">Suspended agents will be blocked from logging into the Agent Portal until reactivated.</p>
          <div class="mb-3">
            <label class="form-label fw-bold fs-8">Reason for Suspension *</label>
            <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="e.g. Contract compliance audit in progress." required></textarea>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning rounded-pill px-4">Confirm Suspension</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
