@extends('layouts.app')

@section('content')
<main>
  <!-- PAGE BANNER -->
  <section class="page-banner text-center">
    <div class="container-custom">
      <nav class="breadcrumb-aura mb-3">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ $title }}</span>
      </nav>
      <h1 class="page-banner-title">{{ $title }}</h1>
      <p class="page-banner-subtitle mx-auto">Official Legal & Operational Policies of {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}</p>
    </div>
  </section>

  <!-- CONTENT SECTION -->
  <section class="py-6">
    <div class="container-custom max-w-900 mx-auto">
      <div class="legal-content-card bg-white p-4 p-md-5 rounded-4 shadow-sm border text-muted-custom fs-6 line-height-lg">
        {!! $content !!}
      </div>

      <div class="mt-4 text-center">
        <a href="{{ route('home') }}" class="btn btn-aura-outline py-2 px-4 rounded-pill">
          <i class="fas fa-arrow-left me-1.5"></i> Back to Homepage
        </a>
      </div>
    </div>
  </section>
</main>
@endsection
