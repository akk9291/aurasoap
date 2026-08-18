@extends('layouts.app')

@section('content')
<section class="py-5 my-5 text-center">
  <div class="container-custom max-w-700">
    <div class="status-card">
      <div class="status-icon-box">
        <i class="fas fa-soap text-amber"></i>
      </div>
      <h1 class="font-heading display-3 fw-bold text-dark">404</h1>
      <h3 class="font-heading mb-3">Page Not Found</h3>
      <p class="text-muted-custom mb-4">The botanical page you are looking for might have been moved or is temporarily unavailable.</p>
      
      <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('home') }}" class="btn-aura-primary px-4 py-3">
          <span>Back to Home</span>
          <i class="fas fa-home me-0"></i>
        </a>
        <a href="{{ route('products.index') }}" class="btn-aura-outline px-4 py-3">
          <span>Explore Products</span>
          <i class="fas fa-box-open me-0"></i>
        </a>
      </div>
    </div>
  </div>
</section>
@endsection
