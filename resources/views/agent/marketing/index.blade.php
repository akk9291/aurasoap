@extends('layouts.agent')

@section('page_title', 'Marketing & Sales Collateral')

@section('content')
<div class="agent-card p-4 mb-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <h4 class="fw-bold text-dark mb-1">Marketing & Educational Materials</h4>
      <span class="fs-7 text-muted">Download high-resolution product catalogues, store posters, training guides and wholesale brochures</span>
    </div>
  </div>

  <!-- Filter by category -->
  <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top">
    <a href="{{ route('agent.marketing.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-dark' : 'btn-light border' }} rounded-pill px-3 fs-8">
      All Resources ({{ $materials->count() }})
    </a>
    @foreach($categories as $catKey => $catName)
      <a href="{{ route('agent.marketing.index', ['category' => $catKey]) }}" class="btn btn-sm {{ request('category') == $catKey ? 'btn-dark' : 'btn-light border' }} rounded-pill px-3 fs-8">
        {{ $catName }}
      </a>
    @endforeach
  </div>
</div>

<div class="row g-4">
  @forelse($materials as $mat)
    <div class="col-md-6 col-xl-4">
      <div class="agent-card p-4 h-100 d-flex flex-column justify-content-between">
        <div>
          <div class="d-flex align-items-start gap-3 mb-3">
            <div class="bg-light rounded-3 p-3 text-center flex-shrink-0" style="width: 54px; height: 54px;">
              <i class="fas {{ $mat->icon }} fs-3"></i>
            </div>
            <div>
              <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-0.5 rounded-pill fs-9 mb-1">
                {{ $mat->category_label }}
              </span>
              <h6 class="fw-bold text-dark fs-7 mb-0">{{ $mat->title }}</h6>
            </div>
          </div>

          <p class="text-muted fs-8 mb-3">{{ $mat->description }}</p>
        </div>

        <div class="pt-3 border-top d-flex align-items-center justify-content-between">
          <span class="fs-9 text-muted font-monospace"><i class="fas fa-file me-1"></i> {{ strtoupper($mat->file_type ?? 'PDF') }} &bull; {{ $mat->formatted_size }}</span>
          <a href="{{ route('agent.marketing.download', $mat) }}" class="btn btn-sm btn-aura rounded-pill px-3 fs-8">
            <i class="fas fa-download me-1"></i> Download
          </a>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="agent-card p-5 text-center">
        <i class="fas fa-folder-open text-muted fs-1 mb-3"></i>
        <h5 class="fw-bold text-dark">No marketing materials found.</h5>
        <p class="text-muted fs-7">Management will publish new promotional assets and catalogues soon.</p>
      </div>
    </div>
  @endforelse
</div>
@endsection
