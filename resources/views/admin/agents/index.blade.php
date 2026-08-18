@extends('layouts.admin')

@section('title', 'Manage Principal Agents')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Principal Agents Network</h1>
    <p class="text-muted fs-7 mb-0">Manage regional wholesale distribution shops and agent locator entries.</p>
  </div>
  <button class="btn btn-primary-green btn-aura" data-bs-toggle="modal" data-bs-target="#createAgentModal">
    <i class="fas fa-plus me-1.5"></i> Add New Agent Location
  </button>
</div>

<!-- Filters Card -->
<div class="admin-card p-3 mb-4">
  <form action="{{ route('admin.agents.index') }}" method="GET" class="row g-2 align-items-center">
    <div class="col-md-5">
      <input type="text" name="search" class="form-control form-control-sm" placeholder="Search City, Town or Province..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
      <select name="country" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="all">All Countries</option>
        <option value="rwanda" {{ request('country') === 'rwanda' ? 'selected' : '' }}>Rwanda</option>
        <option value="drc" {{ request('country') === 'drc' ? 'selected' : '' }}>DR Congo</option>
        <option value="uganda" {{ request('country') === 'uganda' ? 'selected' : '' }}>Uganda</option>
        <option value="tanzania" {{ request('country') === 'tanzania' ? 'selected' : '' }}>Tanzania</option>
      </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
      <button type="submit" class="btn btn-sm btn-secondary flex-grow-1"><i class="fas fa-filter me-1"></i> Filter</button>
      <a href="{{ route('admin.agents.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
    </div>
  </form>
</div>

<!-- Agents Table -->
<div class="admin-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Country</th>
          <th>Market</th>
          <th>City / Town</th>
          <th>Province / State</th>
          <th class="text-center">Required Agent Shops</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($agents as $agent)
          <tr>
            <td>{{ $agent->id }}</td>
            <td>
              @if($agent->country === 'rwanda')
                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1"><i class="fas fa-flag me-1"></i>Rwanda</span>
              @elseif($agent->country === 'drc')
                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1"><i class="fas fa-globe me-1"></i>DR Congo</span>
              @elseif($agent->country === 'uganda')
                <span class="badge bg-warning bg-opacity-10 text-dark px-2 py-1"><i class="fas fa-globe me-1"></i>Uganda</span>
              @else
                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1"><i class="fas fa-globe me-1"></i>Tanzania</span>
              @endif
            </td>
            <td><span class="badge bg-light text-dark border">{{ ucfirst($agent->market) }}</span></td>
            <td class="fw-bold text-dark">{{ $agent->city_town }}</td>
            <td>{{ $agent->province_state }}</td>
            <td class="text-center fw-bold text-success fs-6">{{ $agent->agent_count }}</td>
            <td>
              @if($agent->status)
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-secondary">Inactive</span>
              @endif
            </td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editAgentModal{{ $agent->id }}">
                <i class="fas fa-edit"></i>
              </button>
              <form action="{{ route('admin.agents.destroy', $agent) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this agent location?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>

          <!-- Edit Modal -->
          <div class="modal fade" id="editAgentModal{{ $agent->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('admin.agents.update', $agent) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Agent Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body row g-3">
                    <div class="col-6">
                      <label class="form-label fs-7 fw-bold">Market</label>
                      <select name="market" class="form-select">
                        <option value="rwanda" {{ $agent->market === 'rwanda' ? 'selected' : '' }}>Rwanda Domestic</option>
                        <option value="regional" {{ $agent->market === 'regional' ? 'selected' : '' }}>Regional Great Lakes</option>
                      </select>
                    </div>
                    <div class="col-6">
                      <label class="form-label fs-7 fw-bold">Country</label>
                      <select name="country" class="form-select">
                        <option value="rwanda" {{ $agent->country === 'rwanda' ? 'selected' : '' }}>Rwanda</option>
                        <option value="drc" {{ $agent->country === 'drc' ? 'selected' : '' }}>DR Congo</option>
                        <option value="uganda" {{ $agent->country === 'uganda' ? 'selected' : '' }}>Uganda</option>
                        <option value="tanzania" {{ $agent->country === 'tanzania' ? 'selected' : '' }}>Tanzania</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label fs-7 fw-bold">City / Town Name *</label>
                      <input type="text" name="city_town" class="form-control" value="{{ $agent->city_town }}" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label fs-7 fw-bold">Province / State *</label>
                      <input type="text" name="province_state" class="form-control" value="{{ $agent->province_state }}" required>
                    </div>
                    <div class="col-6">
                      <label class="form-label fs-7 fw-bold">Agent Shops Count *</label>
                      <input type="number" name="agent_count" class="form-control" value="{{ $agent->agent_count }}" min="1" required>
                    </div>
                    <div class="col-6">
                      <label class="form-label fs-7 fw-bold">Sort Order</label>
                      <input type="number" name="sort_order" class="form-control" value="{{ $agent->sort_order }}">
                    </div>
                    <div class="col-12">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="editStatus{{ $agent->id }}" {{ $agent->status ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold fs-7" for="editStatus{{ $agent->id }}">Active Status</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-green">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @empty
          <tr>
            <td colspan="8" class="text-center py-4 text-muted">No principal agent locations found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="p-3 border-top">
    {{ $agents->links() }}
  </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createAgentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.agents.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Add New Agent Location</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-6">
            <label class="form-label fs-7 fw-bold">Market</label>
            <select name="market" class="form-select">
              <option value="rwanda">Rwanda Domestic</option>
              <option value="regional">Regional Great Lakes</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label fs-7 fw-bold">Country</label>
            <select name="country" class="form-select">
              <option value="rwanda">Rwanda</option>
              <option value="drc">DR Congo</option>
              <option value="uganda">Uganda</option>
              <option value="tanzania">Tanzania</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fs-7 fw-bold">City / Town Name *</label>
            <input type="text" name="city_town" class="form-control" placeholder="e.g. Kigali or Goma" required>
          </div>
          <div class="col-12">
            <label class="form-label fs-7 fw-bold">Province / State *</label>
            <input type="text" name="province_state" class="form-control" placeholder="e.g. Southern or North Kivu" required>
          </div>
          <div class="col-6">
            <label class="form-label fs-7 fw-bold">Agent Shops Count *</label>
            <input type="number" name="agent_count" class="form-control" value="1" min="1" required>
          </div>
          <div class="col-6">
            <label class="form-label fs-7 fw-bold">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="0">
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="status" id="createStatus" checked>
              <label class="form-check-label fw-bold fs-7" for="createStatus">Active Status</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary-green">Create Agent Location</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
