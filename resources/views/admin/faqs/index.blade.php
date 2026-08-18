@extends('layouts.admin')

@section('page_title', 'FAQ Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="fw-bold text-dark mb-1">Frequently Asked Questions</h5>
    <p class="text-muted fs-7 mb-0">Manage customer FAQs displayed on the website and generate FAQ schema.</p>
  </div>
  <button type="button" class="btn btn-aura" data-bs-toggle="modal" data-bs-target="#createFaqModal">
    <i class="fas fa-plus me-1.5"></i> Add New FAQ
  </button>
</div>

<div class="admin-card p-4">
  @if($faqs->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead>
          <tr class="text-muted text-uppercase fs-8 border-top-0">
            <th>Category</th>
            <th>Question</th>
            <th>Answer</th>
            <th>Sort Order</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($faqs as $faq)
            <tr>
              <td><span class="badge bg-light text-dark border">{{ $faq->category }}</span></td>
              <td class="fw-bold text-dark" style="max-width: 250px;">{{ $faq->question }}</td>
              <td class="text-muted" style="max-width: 350px;">{{ Str::limit($faq->answer, 80) }}</td>
              <td><span class="badge bg-secondary-subtle text-secondary">{{ $faq->sort_order }}</span></td>
              <td>
                @if($faq->status)
                  <span class="badge bg-success-subtle text-success rounded-pill px-2.5">Active</span>
                @else
                  <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5">Disabled</span>
                @endif
              </td>
              <td class="text-end">
                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this FAQ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-light border rounded-circle text-danger" title="Delete FAQ">
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
      <i class="fas fa-question-circle text-muted fs-1 mb-3 d-block"></i>
      <h6 class="fw-bold text-dark mb-1">No FAQs Added Yet</h6>
      <p class="text-muted fs-7 mb-3">Add common questions and answers to help your customers.</p>
      <button type="button" class="btn btn-aura" data-bs-toggle="modal" data-bs-target="#createFaqModal">
        <i class="fas fa-plus me-1.5"></i> Add New FAQ
      </button>
    </div>
  @endif
</div>

<!-- Modal: Create FAQ -->
<div class="modal fade" id="createFaqModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom">
        <h6 class="modal-title fw-bold">Add New FAQ</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Category</label>
            <input type="text" name="category" class="form-control" placeholder="e.g. Products, Shipping, General" value="General" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Question</label>
            <input type="text" name="question" class="form-control" placeholder="e.g. Are Aura Soaps 100% natural?" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Answer</label>
            <textarea name="answer" rows="4" class="form-control" placeholder="Provide a helpful and concise answer..." required></textarea>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label fw-semibold fs-7">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="0">
            </div>
            <div class="col-6 mb-3">
              <label class="form-label fw-semibold fs-7">Status</label>
              <select name="status" class="form-select">
                <option value="1">Active</option>
                <option value="0">Disabled</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-aura">Save FAQ</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
