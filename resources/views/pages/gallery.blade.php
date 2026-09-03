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
        <img src="{{ asset('assets/images/aurasoap images/aurashop (18).jpeg') }}" alt="Aura Shea Butter & Sandalwood Soap" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (20).jpeg') }}" alt="Aura Crafted Artisan Soaps" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (15).jpeg') }}" alt="Aura Turmeric Botanical Soap" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (4).jpeg') }}" alt="Aura Women Antiperspirant Roll-On" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (5).jpeg') }}" alt="Aura Men Antiperspirant Roll-On" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (1).jpeg') }}" alt="Aura Luxury Toilet Paper 3-Pack" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (6).jpeg') }}" alt="Aura Blue Laundry Bar Soap" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (8).jpeg') }}" alt="Aura Multi-Purpose Soap Bars" class="img-fluid rounded-xl shadow border border-amber">
      </div>
      <div class="col-md-4 col-6">
        <img src="{{ asset('assets/images/aurasoap images/aurashop (10).jpeg') }}" alt="Aura Distribution Fleet Truck" class="img-fluid rounded-xl shadow border border-amber">
      </div>
    </div>
  </div>
</section>
@endsection
