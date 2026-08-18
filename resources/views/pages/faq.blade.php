@extends('layouts.app')

@section('content')
<section class="py-5 bg-section pt-6">
  <div class="container-custom text-center">
    <span class="badge-subtitle mb-2"><i class="fas fa-question-circle text-amber"></i> Assistance & Guidance</span>
    <h1 class="section-title">Frequently Asked Questions</h1>
    <p class="text-muted-custom max-w-700 mx-auto">Find answers regarding ingredients, soap care, shipping, and agency applications.</p>
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
@endsection
