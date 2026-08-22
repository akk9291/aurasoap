@extends('layouts.app')

@section('content')
<section class="py-5 bg-section pt-6">
  <div class="container-custom text-center">
    <span class="badge-subtitle mb-2"><i class="fas fa-camera text-danger"></i> Artisanal Gallery</span>
    <h1 class="section-title">Behind The Botanical Craft</h1>
    <p class="text-muted-custom max-w-700 mx-auto">Visual glimpses of our precision formulation process, natural organic ingredients, and crafted personal care & sanitation products.</p>
  </div>
</section>

<section class="py-5">
  <div class="container-custom">
    <div class="row g-4">
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/about_artisan.jpg') }}" alt="Artisan Crafting" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/prod_honey.jpg') }}" alt="Honey Soap" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/prod_lavender.jpg') }}" alt="Lavender Soap" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/ing_shea.jpg') }}" alt="Shea Butter" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/ing_olive.jpg') }}" alt="Virgin Olive Oil" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/prod_charcoal.jpg') }}" alt="Activated Charcoal Soap" class="img-fluid rounded-xl shadow border border-amber">
      </div>
    </div>
  </div>
</section>
@endsection
