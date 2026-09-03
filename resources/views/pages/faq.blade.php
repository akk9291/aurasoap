@extends('layouts.app')

@section('content')
<main>
  <!-- PAGE BANNER -->
  <section class="page-banner text-center">
    <div class="container-custom">
      <nav class="breadcrumb-aura mb-3">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">FAQs</span>
      </nav>
      <h1 class="page-banner-title">Frequently Asked Questions</h1>
      <p class="page-banner-subtitle mx-auto">Find answers regarding ingredients, soap care, shipping, and agency applications.</p>
    </div>
  </section>

<section class="py-5">
  <div class="container-custom max-w-800">
    <div class="accordion accordion-aura" id="faqAccordion">
      @foreach($faqs as $index => $faq)
        <div class="accordion-item mb-3 border rounded-xl overflow-hidden shadow-sm">
          <h2 class="accordion-header" id="heading{{ $faq->id }}">
            <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }} fw-bold font-heading fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
              {{ $faq->question }}
            </button>
          </h2>
          <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
            <div class="accordion-body text-muted-custom fs-7 p-4">
              {{ $faq->answer }}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
</main>
@endsection
