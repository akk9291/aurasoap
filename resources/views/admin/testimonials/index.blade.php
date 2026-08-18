@extends('layouts.admin')

@section('page_title', 'Customer Testimonials Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="fw-bold text-dark mb-1">Testimonials</h5>
    <p class="text-muted fs-7 mb-0">Manage customer reviews and testimonials displayed on the homepage.</p>
  </div>
  <button type="button" class="btn btn-aura" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
    <i class="fas fa-plus me-1.5"></i> Add Testimonial
  </button>
</div>

<div class="admin-card p-4">
  @if($testimonials->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead>
          <tr class="text-muted text-uppercase fs-8 border-top-0">
            <th>Customer</th>
            <th>Country / Role</th>
            <th>Rating</th>
            <th>Testimonial Quote</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($testimonials as $item)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2.5">
                  @if($item->profile_image)
                    <img src="{{ asset($item->profile_image) }}" alt="" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                  @else
                    <div class="bg-warning-subtle text-warning rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 0.8rem;">
                      {{ strtoupper(substr($item->customer_name, 0, 1)) }}
                    </div>
                  @endif
                  <span class="fw-bold text-dark">{{ $item->customer_name }}</span>
                </div>
              </td>
              <td>{{ $item->country ?: 'Global' }} {{ $item->designation ? '• '.$item->designation : '' }}</td>
              <td>
                <span class="text-warning">
                  @for($i=1; $i<=$item->rating; $i++) <i class="fas fa-star fs-8"></i> @endfor
                </span>
              </td>
              <td class="text-muted" style="max-width: 300px;">"{{ Str::limit($item->testimonial, 90) }}"</td>
              <td>
                @if($item->status)
                  <span class="badge bg-success-subtle text-success rounded-pill px-2.5">Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5">Hidden</span>
                @endif
              </td>
              <td class="text-end">
                <form action="{{ route('admin.testimonials.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-light border rounded-circle text-danger" title="Delete Testimonial">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-star text-muted fs-1 mb-3 d-block"></i>
      <h6 class="fw-bold text-dark mb-1">No Testimonials Added</h6>
      <p class="text-muted fs-7 mb-3">Add customer feedback to showcase social proof on your website.</p>
      <button type="button" class="btn btn-aura" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
        <i class="fas fa-plus me-1.5"></i> Add Testimonial
      </button>
    </div>
  @endif
</div>

<!-- Modal: Create Testimonial -->
<div class="modal fade" id="createTestimonialModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom">
        <h6 class="modal-title fw-bold">Add New Testimonial</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.testimonials.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Customer Name <span class="text-danger">*</span></label>
            <input type="text" name="customer_name" class="form-control" placeholder="e.g. Sophia Martinez" required>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label fw-semibold fs-7">Country</label>
              <input type="text" name="country" class="form-control" placeholder="e.g. United Kingdom">
            </div>
            <div class="col-6 mb-3">
              <label class="form-label fw-semibold fs-7">Rating (1 to 5)</label>
              <select name="rating" class="form-select">
                <option value="5">5 Stars ★★★★★</option>
                <option value="4">4 Stars ★★★★☆</option>
                <option value="3">3 Stars ★★★☆☆</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Designation / Role</label>
            <input type="text" name="designation" class="form-control" placeholder="e.g. Verified Buyer, Spa Enthusiast">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Testimonial Quote <span class="text-danger">*</span></label>
            <textarea name="testimonial" rows="4" class="form-control" placeholder="Customer review text..." required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Profile Image URL</label>
            <input type="text" name="profile_image" class="form-control" placeholder="assets/images/testimonial-1.jpg">
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-aura">Save Testimonial</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
