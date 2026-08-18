@extends('layouts.app')

@section('content')
<main>
  <!-- PAGE BANNER -->
  <section class="page-banner text-center">
    <div class="container-custom">
      <nav class="breadcrumb-aura mb-3">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">About Us</span>
      </nav>
      <h1 class="page-banner-title">{{ App\Models\Setting::get('about_banner_title', 'Our Heritage & Story') }}</h1>
      <p class="page-banner-subtitle mx-auto">{{ App\Models\Setting::get('about_banner_subtitle', 'Crafting pure, eco-conscious bathing rituals with organic botanicals, unrefined shea butter, and essential oils.') }}</p>
    </div>
  </section>

  <!-- COMPANY STORY SECTION -->
  <section class="py-6">
    <div class="container-custom">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="about-img-frame">
            <img src="{{ asset(App\Models\Setting::get('about_story_image', 'assets/images/aura-shop (5).jpeg')) }}" alt="Aura Soaps Manufacturing" class="about-img shadow-lg rounded-4 w-100">
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <span class="badge-subtitle"><i class="fas fa-seedling"></i> Essential Personal Care</span>
          <h2 class="section-title">{{ App\Models\Setting::get('about_story_title', 'Manufacturing & Distribution Excellence') }}</h2>
          
          <div class="text-muted-custom fs-6 line-height-lg mb-4">
            {!! nl2br(e(App\Models\Setting::get('about_story_p1', "AURA SOAPS specializes in the manufacturing and distribution of essential PERSONAL CARE, SANITATION, and HYGIENE products in Rwanda, Eastern DRC, and South – West Uganda.\n\nOur product catalog includes well-packaged Bar Soaps (Laundry & Bath), Luxury Toilet Paper Rolls, Kitchen Hand Towels, and a Luxurious Antiperspirant/Deodorant Combo Rollon.\n\nWe pride ourselves in Product Quality, Cost-effective Pricing, and the Best Packaging. Quality – All – Round."))) !!}
          </div>

          <div class="row g-3 pt-2">
            <div class="col-6">
              <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
                <i class="fas fa-leaf text-primary-green fs-3"></i>
                <div>
                  <div class="fw-bold text-dark fs-6">{{ App\Models\Setting::get('about_highlight_1_title', '100% Vegan') }}</div>
                  <div class="text-muted fs-8">{{ App\Models\Setting::get('about_highlight_1_sub', 'Plant-based oils') }}</div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
                <i class="fas fa-hand-holding-heart text-primary-green fs-3"></i>
                <div>
                  <div class="fw-bold text-dark fs-6">{{ App\Models\Setting::get('about_highlight_2_title', 'Cruelty Free') }}</div>
                  <div class="text-muted fs-8">{{ App\Models\Setting::get('about_highlight_2_sub', 'Never tested on animals') }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MISSION & VISION SECTION -->
  <section class="py-6 bg-section">
    <div class="container-custom">
      <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
        <span class="badge-subtitle"><i class="fas fa-compass"></i> Guiding Principles</span>
        <h2 class="section-title">Driven By Design, Quality & Regional Coverage</h2>
      </div>
      <div class="row g-4 mb-4">
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="glass-card p-4 p-md-5 h-100">
            <div class="why-icon-box mb-3">
              <i class="fas fa-bullseye"></i>
            </div>
            <h3 class="font-heading text-primary-green fs-3 mb-2">{{ App\Models\Setting::get('about_mission_title', 'Our Mission') }}</h3>
            <p class="text-muted-custom line-height-lg fs-6 mb-3">
              {{ App\Models\Setting::get('about_mission_desc', 'A boutique & Design-Forward Company (The Premium Visual Brand). Elevating ordinary, utility-driven bathroom and kitchen products into artistic home décor items.') }}
            </p>
          </div>
        </div>
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="glass-card p-4 p-md-5 h-100">
            <div class="why-icon-box mb-3">
              <i class="fas fa-eye"></i>
            </div>
            <h3 class="font-heading text-primary-green fs-3 mb-2">{{ App\Models\Setting::get('about_vision_title', 'Our Vision') }}</h3>
            <p class="text-muted-custom line-height-lg fs-6 mb-0">
              {{ App\Models\Setting::get('about_vision_desc', 'Becoming the Regional Hallmark for sustainable, luxurious, and accessible eco-friendly fast-moving consumer goods (FMCGs) related to skincare, hygiene, sanitation, and good health.') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MANUFACTURING FACILITY (ARTISANAL PROCESS) -->
  @if($processSteps->count())
  <section class="py-6">
    <div class="container-custom">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6" data-aos="fade-right">
          <span class="badge-subtitle"><i class="fas fa-industry"></i> Artisanal Process</span>
          <h2 class="section-title">The Art of Cold-Process Saponification</h2>
          <p class="text-muted-custom fs-6 line-height-lg mb-4">
            Unlike commercial soap manufacturers that boil out natural glycerin to sell separately, our eco-facility employs a slow cold-cure process.
          </p>
          <ul class="list-unstyled d-flex flex-column gap-3 mb-4">
            @foreach($processSteps as $step)
              <li class="d-flex align-items-start gap-3">
                <i class="fas fa-check-circle text-primary-green fs-5 mt-1"></i>
                <div>
                  <strong>{{ $step->title }}:</strong> {{ $step->description }}
                </div>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="row g-3">
            <div class="col-6">
              <img src="{{ asset('assets/images/aura-shop (6).jpeg') }}" alt="Artisanal Soap Mold" class="img-fluid rounded-4 shadow mb-3">
              <img src="{{ asset('assets/images/aura-shop (7).jpeg') }}" alt="Essential Oil Infusion" class="img-fluid rounded-4 shadow">
            </div>
            <div class="col-6 pt-4">
              <img src="{{ asset('assets/images/aura-shop (8).jpeg') }}" alt="Cured Soap Stacks" class="img-fluid rounded-4 shadow">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- CERTIFICATIONS / COUNTERS -->
  <section class="py-6 bg-section">
    <div class="container-custom text-center">
      <span class="badge-subtitle mb-2"><i class="fas fa-shield-alt"></i> Tested & Trusted</span>
      <h2 class="section-title mb-5">Certified Quality You Can Rely On</h2>
      <div class="row g-4 justify-content-center">
        <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
          <div class="stats-card p-4 bg-white rounded-4 shadow-sm border">
            <i class="fas fa-award text-primary-green fs-1 mb-3"></i>
            <h5 class="fw-bold mb-1">{{ App\Models\Setting::get('about_stat_1_title', 'Dermatologist Approved') }}</h5>
            <span class="text-muted fs-8">{{ App\Models\Setting::get('about_stat_1_sub', '100% Hypoallergenic') }}</span>
          </div>
        </div>
        <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
          <div class="stats-card p-4 bg-white rounded-4 shadow-sm border">
            <i class="fas fa-leaf text-primary-green fs-1 mb-3"></i>
            <h5 class="fw-bold mb-1">{{ App\Models\Setting::get('about_stat_2_title', 'USDA Organic') }}</h5>
            <span class="text-muted fs-8">{{ App\Models\Setting::get('about_stat_2_sub', 'Certified Botanicals') }}</span>
          </div>
        </div>
        <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
          <div class="stats-card p-4 bg-white rounded-4 shadow-sm border">
            <i class="fas fa-ban text-primary-green fs-1 mb-3"></i>
            <h5 class="fw-bold mb-1">{{ App\Models\Setting::get('about_stat_3_title', 'Paraben & SLS Free') }}</h5>
            <span class="text-muted fs-8">{{ App\Models\Setting::get('about_stat_3_sub', 'Zero Harsh Detergents') }}</span>
          </div>
        </div>
        <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="400">
          <div class="stats-card p-4 bg-white rounded-4 shadow-sm border">
            <i class="fas fa-recycle text-primary-green fs-1 mb-3"></i>
            <h5 class="fw-bold mb-1">{{ App\Models\Setting::get('about_stat_4_title', 'Zero Waste') }}</h5>
            <span class="text-muted fs-8">{{ App\Models\Setting::get('about_stat_4_sub', 'Biodegradable Packaging') }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="py-6">
    <div class="container-custom">
      <div class="distributor-banner text-center position-relative overflow-hidden p-5 rounded-5" data-aos="fade-up" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);">
        <h2 class="font-heading text-white display-5 fw-bold mb-3">{{ App\Models\Setting::get('about_cta_title', 'Partner With Aura Soaps') }}</h2>
        <p class="fs-5 text-white-50 max-w-600 mx-auto mb-4">{{ App\Models\Setting::get('about_cta_subtitle', 'Join our growing network of international eco-retailers and wholesale distributors.') }}</p>
        <a href="{{ route(App\Models\Setting::get('about_cta_btn_url', 'distributor')) }}" class="btn-aura-primary">
          <span>{{ App\Models\Setting::get('about_cta_btn_text', 'Apply For Wholesale') }}</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>
</main>
@endsection
