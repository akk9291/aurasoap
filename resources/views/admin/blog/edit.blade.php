@extends('layouts.admin')

@section('page_title', 'Edit Blog Article')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="fw-bold text-dark mb-1">Edit Article</h5>
    <p class="text-muted fs-7 mb-0">Update article content, metadata, and publishing settings.</p>
  </div>
  <a href="{{ route('admin.blog.index') }}" class="btn btn-light border rounded-pill px-3 fs-7 fw-semibold">
    <i class="fas fa-arrow-left me-1.5"></i> Back to Articles
  </a>
</div>

<form action="{{ route('admin.blog.update', $blog) }}" method="POST">
  @csrf
  @method('PUT')
  
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="admin-card p-4 mb-4">
        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Article Title <span class="text-danger">*</span></label>
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">URL Slug <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $blog->slug) }}" required>
          @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Excerpt / Short Summary</label>
          <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt', $blog->excerpt) }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Full Article Content <span class="text-danger">*</span></label>
          <textarea name="content" rows="12" class="form-control rich-editor @error('content') is-invalid @enderror">{{ old('content', $blog->content) }}</textarea>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="admin-card p-4 mb-4">
        <h6 class="fw-bold mb-3 border-bottom pb-2">Publishing Options</h6>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Category <span class="text-danger">*</span></label>
          <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id', $blog->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
          </select>
          @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Publish Date</label>
          <input type="datetime-local" name="publish_date" class="form-control" value="{{ old('publish_date', $blog->publish_date ? $blog->publish_date->format('Y-m-d\TH:i') : '') }}">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Featured Image URL</label>
          <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image', $blog->featured_image) }}">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold fs-7">Tags</label>
          <input type="text" name="tags" class="form-control" value="{{ old('tags', $blog->tags) }}">
        </div>

        <div class="form-check form-switch mb-4">
          <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
          <label class="form-check-label fw-semibold fs-7" for="is_featured">Feature on Homepage</label>
        </div>

        <button type="submit" class="btn btn-aura w-100 py-2.5">
          <i class="fas fa-save me-1.5"></i> Update Article
        </button>
      </div>
    </div>
  </div>
</form>
@endsection
