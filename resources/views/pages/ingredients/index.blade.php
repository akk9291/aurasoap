@extends('layouts.app')

@section('content')
<main>
  <!-- PAGE BANNER -->
  <section class="page-banner text-center">
    <div class="container-custom">
      <nav class="breadcrumb-aura mb-3">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">Botanical Ingredients</span>
      </nav>
      <h1 class="page-banner-title">Organic Botanical Ingredients</h1>
      <p class="page-banner-subtitle mx-auto">Discover the cold-pressed plant oils, essential flowers, and nutrient-rich clays used in Aura Soaps.</p>
    </div>
  </section>

<section class="py-5">
  <div class="container-custom">
    <div class="row g-4">
      @foreach($ingredients as $ing)
        <div class="col-lg-4 col-md-6">
          <div class="glass-card p-4 h-100 text-center">
            <img src="{{ asset($ing->image ?: 'assets/images/aurasoap images/aurashop (18).jpeg') }}" alt="{{ $ing->name }}" class="rounded-circle mb-3 border border-amber" style="width: 110px; height: 110px; object-fit: cover;">
            <h4 class="font-heading mb-2">{{ $ing->name }}</h4>
            <p class="text-muted-custom fs-7 mb-3">{{ $ing->short_description }}</p>
            <span class="badge bg-warning-subtle text-warning border border-amber px-3 py-1 rounded-pill fs-8">{{ $ing->benefits }}</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
</main>
@endsection
