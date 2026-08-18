@extends('layouts.admin')

@section('page_title', 'Blog Articles Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="fw-bold text-dark mb-1">Blog Articles</h5>
    <p class="text-muted fs-7 mb-0">Create, edit, and publish content articles for Aura Soaps website.</p>
  </div>
  <a href="{{ route('admin.blog.create') }}" class="btn btn-aura">
    <i class="fas fa-plus me-1.5"></i> Create New Article
  </a>
</div>

<div class="admin-card p-4">
  @if($posts->count())
    <div class="table-responsive">
      <table class="table table-hover align-middle fs-7 mb-0">
        <thead>
          <tr class="text-muted text-uppercase fs-8 border-top-0">
            <th>Article Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Publish Date</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($posts as $post)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-3">
                  @if($post->featured_image)
                    <img src="{{ asset($post->featured_image) }}" alt="" class="rounded-3 object-fit-cover" style="width: 48px; height: 48px;">
                  @else
                    <div class="bg-light text-muted rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                      <i class="fas fa-newspaper"></i>
                    </div>
                  @endif
                  <div>
                    <a href="{{ route('admin.blog.edit', $post) }}" class="fw-bold text-dark text-decoration-none d-block mb-0">{{ $post->title }}</a>
                    <span class="text-muted fs-8">/blog/{{ $post->slug }}</span>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge bg-light text-dark border">{{ $post->category->name ?? 'Uncategorized' }}</span>
              </td>
              <td class="text-secondary fw-semibold">{{ $post->author->name ?? 'Admin' }}</td>
              <td class="text-muted fs-8">{{ $post->publish_date ? $post->publish_date->format('M d, Y') : 'N/A' }}</td>
              <td>
                @if($post->status === 'published')
                  <span class="badge bg-success-subtle text-success rounded-pill px-2.5">Published</span>
                @else
                  <span class="badge bg-warning-subtle text-warning rounded-pill px-2.5">Draft</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex align-items-center justify-content-end gap-2">
                  <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-light border rounded-circle text-muted" title="Preview Article">
                    <i class="fas fa-external-link-alt"></i>
                  </a>
                  <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-light border rounded-circle text-primary" title="Edit Article">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-light border rounded-circle text-danger" title="Delete Article">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $posts->links() }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-newspaper text-muted fs-1 mb-3 d-block"></i>
      <h6 class="fw-bold text-dark mb-1">No Blog Articles Found</h6>
      <p class="text-muted fs-7 mb-3">Get started by publishing your first article for Aura Soaps.</p>
      <a href="{{ route('admin.blog.create') }}" class="btn btn-aura">
        <i class="fas fa-plus me-1.5"></i> Create New Article
      </a>
    </div>
  @endif
</div>
@endsection
