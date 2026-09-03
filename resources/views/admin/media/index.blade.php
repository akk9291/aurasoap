@extends('layouts.admin')

@section('page_title', 'Media Library & Assets')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h5 class="fw-bold mb-0">Media Library</h5>
    <p class="text-muted fs-7 mb-0">Upload and manage reusable product imagery, banners, and icons</p>
  </div>
</div>

<div class="admin-card p-3 mb-4">
  <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
    @csrf
    <div class="col-md-9">
      <input type="file" name="files[]" multiple class="form-control form-control-sm" required>
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-sm btn-warning w-100 fw-bold rounded-pill"><i class="fas fa-upload me-1"></i> Upload Files</button>
    </div>
  </form>
</div>

<div class="admin-card p-3">
  @if($mediaFiles->count())
    <div class="row g-3">
      @foreach($mediaFiles as $m)
        <div class="col-md-2 col-4">
          <div class="card h-100 shadow-sm border text-center p-2">
            <img src="{{ asset($m->file_path) }}" alt="{{ $m->alt_text }}" class="card-img-top rounded mb-2" style="height: 110px; object-fit: cover;">
            <div class="fs-8 fw-semibold text-truncate mb-1" title="{{ $m->original_name }}">{{ $m->original_name }}</div>
            <div class="d-flex justify-content-center gap-1">
              <button onclick="navigator.clipboard.writeText('{{ asset($m->file_path) }}'); alert('Asset URL copied to clipboard!');" class="btn btn-xs btn-outline-secondary p-1" title="Copy URL"><i class="fas fa-copy"></i></button>
              <form action="{{ route('admin.media.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete media file?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-xs btn-outline-danger p-1" title="Delete"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="pt-3">
      {{ $mediaFiles->links('pagination::bootstrap-5') }}
    </div>
  @else
    <p class="text-muted text-center py-4 fs-7 mb-0">No media files uploaded yet.</p>
  @endif
</div>
@endsection
