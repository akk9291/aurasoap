@extends('layouts.app')

@section('content')
<!-- SECTION 1: HERO SECTION -->
<section id="hero" class="hero-section">
  <canvas id="leafCanvas"></canvas>
  
  <div class="container-custom position-relative hero-content">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6">
        <div class="hero-badge-wrap mb-3">
          <span class="badge-subtitle">
            <i class="fas fa-seedling"></i> {{ App\Models\Setting::get('hero_badge', '100% Organic & Handcrafted') }}
          </span>
        </div>
        
        <h1 class="hero-title">
          {!! App\Models\Setting::get('hero_title', 'Pure Nature, <span>Perfect Care.</span>') !!}
        </h1>
        
        <p class="hero-desc">
          {{ App\Models\Setting::get('hero_desc', 'Natural handcrafted soaps made with skin-loving ingredients that cleanse, nourish, and refresh every day. Experience luxury organic bathing rituals.') }}
        </p>
        
        <div class="hero-btns d-flex flex-wrap gap-3">
          <a href="{{ route('products.index') }}" class="btn-aura-primary">
            <span>Explore Products</span>
            <i class="fas fa-box-open"></i>
          </a>
          <a href="{{ route('distributor') }}" class="btn-aura-outline">
            <span>Become Distributor</span>
            <i class="fas fa-handshake"></i>
          </a>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="hero-img-wrapper text-center">
          @php
            $heroPath = App\Models\Setting::get('hero_img', 'assets/images/aura-shop (5).jpeg');
            $heroImg = file_exists(public_path($heroPath)) ? asset($heroPath) : asset('assets/images/aura-shop (5).jpeg');
          @endphp
          <img src="{{ $heroImg }}" alt="Aura Handcrafted Soap Lifestyle" class="hero-img-main img-fluid rounded-4 shadow-lg">
          
          <!-- Floating Glass Badges -->
          <div class="floating-badge badge-hero-1">
            <i class="fas fa-award text-aqua fs-3"></i>
            <div class="text-start">
              <div class="fw-bold text-primary-green" style="font-size: 0.95rem;">{{ App\Models\Setting::get('hero_badge1_title', 'Dermatologist Approved') }}</div>
              <div class="text-muted-custom" style="font-size: 0.78rem;">{{ App\Models\Setting::get('hero_badge1_sub', '100% Safe for Sensitive Skin') }}</div>
            </div>
          </div>

          <div class="floating-badge badge-hero-2">
            <i class="fas fa-leaf text-leaf-green fs-3"></i>
            <div class="text-start">
              <div class="fw-bold text-primary-green" style="font-size: 0.95rem;">{{ App\Models\Setting::get('hero_badge2_title', 'Zero Harmful Chemicals') }}</div>
              <div class="text-muted-custom" style="font-size: 0.78rem;">{{ App\Models\Setting::get('hero_badge2_sub', 'Paraben & SLS Free') }}</div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Scroll Indicator -->
  <a href="#about" class="scroll-indicator" aria-label="Scroll Down">
    <span>Scroll</span>
    <i class="fas fa-chevron-down"></i>
  </a>
</section>

<!-- SECTION 2: ABOUT SECTION -->
<section id="about" class="py-5 my-lg-4">
  <div class="container-custom">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6" data-aos="fade-right">
        <div class="about-img-frame">
          @php
            $storyPath = App\Models\Setting::get('about_story_image', 'assets/images/about_artisan.jpg');
            $storyImg = file_exists(public_path($storyPath)) ? asset($storyPath) : asset('assets/images/about_artisan.jpg');
          @endphp
          <img src="{{ $storyImg }}" alt="Aura Soap Artisans Crafting Natural Soaps" class="about-img rounded-4 shadow">
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <span class="badge-subtitle mb-2">
          <i class="fas fa-heart text-danger"></i> Our Story & Heritage
        </span>
        <h2 class="section-title">{{ App\Models\Setting::get('about_story_title', 'Crafting Pure Botanical Wellness Since Day One') }}</h2>
        <div class="text-muted-custom mb-4 fs-6 line-height-lg">
          {!! nl2br(e(App\Models\Setting::get('about_story_p1', 'At Aura Soaps, we believe true luxury comes directly from nature. Founded with a passion for holistic skincare, we blend cold-pressed organic botanical oils, soothing plant extracts, and essential oils into small artisanal batches that respect both your skin and the earth.'))) !!}
        </div>
        
        <div class="row g-4 mb-4">
          <div class="col-sm-6">
            <div class="d-flex align-items-start gap-3">
              <div class="why-icon-box m-0" style="width: 48px; height: 48px; font-size: 1.2rem;">
                <i class="fas fa-bullseye text-aqua"></i>
              </div>
              <div>
                <h5 class="mb-1 font-heading text-primary-green">{{ App\Models\Setting::get('about_mission_title', 'Our Mission') }}</h5>
                <p class="text-muted-custom fs-7 mb-0">{{ Str::limit(App\Models\Setting::get('about_mission_desc', 'To formulate uncompromised natural soap solutions that nourish skin without synthetic chemicals.'), 110) }}</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-start gap-3">
              <div class="why-icon-box m-0" style="width: 48px; height: 48px; font-size: 1.2rem;">
                <i class="fas fa-eye text-leaf-green"></i>
              </div>
              <div>
                <h5 class="mb-1 font-heading text-primary-green">{{ App\Models\Setting::get('about_vision_title', 'Our Vision') }}</h5>
                <p class="text-muted-custom fs-7 mb-0">{{ Str::limit(App\Models\Setting::get('about_vision_desc', 'Becoming the global hallmark for sustainable, luxurious, and accessible eco-friendly skincare.'), 110) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Statistics Counters -->
        <div class="row g-3">
          <div class="col-6 col-md-3">
            <div class="stats-card p-3 text-center bg-white rounded-3 border">
              <div class="counter-num fw-bold fs-3 text-primary-green" data-count="{{ (int) App\Models\Setting::get('stat_years', 12) }}" data-suffix="+">{{ App\Models\Setting::get('stat_years', '12') }}+</div>
              <div class="counter-label fs-8 text-muted">Years Experience</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stats-card p-3 text-center bg-white rounded-3 border">
              <div class="counter-num fw-bold fs-3 text-primary-green" data-count="{{ (int) App\Models\Setting::get('stat_customers', 150) }}" data-suffix="K+">{{ App\Models\Setting::get('stat_customers', '150') }}K+</div>
              <div class="counter-label fs-8 text-muted">Happy Customers</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stats-card p-3 text-center bg-white rounded-3 border">
              <div class="counter-num fw-bold fs-3 text-primary-green" data-count="{{ (int) App\Models\Setting::get('stat_natural', 100) }}" data-suffix="%">{{ App\Models\Setting::get('stat_natural', '100') }}%</div>
              <div class="counter-label fs-8 text-muted">Natural Lipids</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stats-card p-3 text-center bg-white rounded-3 border">
              <div class="counter-num fw-bold fs-3 text-primary-green" data-count="{{ (int) App\Models\Setting::get('stat_countries', 35) }}" data-suffix="+">{{ App\Models\Setting::get('stat_countries', '35') }}+</div>
              <div class="counter-label fs-8 text-muted">Countries Served</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- SECTION 3: PRODUCT CATEGORIES -->
@if($categories->count())
<section id="categories" class="py-5 bg-section">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
      <span class="badge-subtitle">
        <i class="fas fa-th-large"></i> Signature Ranges
      </span>
      <h2 class="section-title">Explore Our Product Categories</h2>
      <p class="text-muted-custom">Designed for every unique skin need—from daily moisture replenishment to specialized baby and therapeutic care.</p>
    </div>

    <div class="row g-4">
      @foreach($categories as $cat)
        @php
          $catImage = !empty($cat->image) && file_exists(public_path($cat->image)) 
            ? asset($cat->image) 
            : asset('assets/images/beauty_soap.jpg');
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
          <a href="{{ route('products.category', $cat->slug) }}" class="text-decoration-none d-block">
            <div class="category-card rounded-4 overflow-hidden shadow-sm position-relative">
              <div class="category-img-wrapper" style="height: 240px;">
                <img src="{{ $catImage }}" alt="{{ $cat->name }}" class="category-img w-100 h-100 object-fit-cover">
                <div class="category-overlay p-4 d-flex flex-column justify-content-end text-white">
                  <h3 class="category-title fw-bold fs-4 mb-1 text-white">{{ $cat->name }}</h3>
                  <span class="category-count fs-7 text-white-50"><i class="fas fa-arrow-right me-1"></i> Browse Range</span>
                </div>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- SECTION 4: FEATURED PRODUCTS -->
@if($featuredProducts->count())
<section id="products" class="py-5 my-lg-4">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-4" data-aos="fade-up">
      <span class="badge-subtitle">
        <i class="fas fa-sparkles"></i> Artisan Formulations
      </span>
      <h2 class="section-title">Our Featured Soap Collection</h2>
      <p class="text-muted-custom">Hand-cut artisanal bars enriched with essential plant oils, vitamins, and minerals.</p>
    </div>

    <!-- Product Cards Grid -->
    <div class="row g-4">
      @foreach($featuredProducts as $product)
        @php
          $prodImg = !empty($product->product_image) && file_exists(public_path($product->product_image)) 
            ? asset($product->product_image) 
            : asset('assets/images/beauty_soap.jpg');
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
          <div class="product-card bg-white rounded-4 border shadow-sm p-3 h-100 d-flex flex-column">
            <div class="product-img-box rounded-3 overflow-hidden mb-3 position-relative" style="height: 220px;">
              <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 fw-bold">{{ $product->category->name ?? 'Natural' }}</span>
              <img src="{{ $prodImg }}" alt="{{ $product->name }}" class="product-img w-100 h-100 object-fit-cover">
            </div>
            <div class="product-body flex-grow-1 d-flex flex-column">
              <h3 class="product-name fw-bold fs-5 text-dark mb-2">{{ $product->name }}</h3>
              <p class="product-desc text-muted fs-7 mb-3 flex-grow-1">{{ Str::limit($product->short_description ?: $product->description, 100) }}</p>
              
              <div class="product-meta d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
                <span class="text-success fw-bold fs-8"><i class="fas fa-check-circle me-1"></i> In Stock</span>
                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-aura-outline rounded-pill px-3 fs-7 fw-semibold">
                  View Details <i class="fas fa-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="text-center mt-5">
      <a href="{{ route('products.index') }}" class="btn-aura-primary px-4 py-2.5">
        <span>View Full Products Catalog</span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>
@endif

<!-- SECTION 5: WHY CHOOSE AURA -->
<section id="why-aura" class="py-5 bg-section">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
      <span class="badge-subtitle">
        <i class="fas fa-shield-alt"></i> The Aura Standard
      </span>
      <h2 class="section-title">Why Choose Aura Soaps?</h2>
      <p class="text-muted-custom">We set high standards in modern organic formulation and sustainable beauty practices.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="why-card p-4 bg-white rounded-4 border shadow-sm h-100">
          <div class="why-icon-box mb-3 text-warning fs-2"><i class="fas fa-leaf"></i></div>
          <h3 class="why-title font-heading text-primary-green fs-5 fw-bold mb-2">100% Natural</h3>
          <p class="text-muted-custom fs-7 mb-0">Formulated exclusively with pure plant lipids, botanical extracts, and essential oils without synthetic fillers.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="why-card p-4 bg-white rounded-4 border shadow-sm h-100">
          <div class="why-icon-box mb-3 text-warning fs-2"><i class="fas fa-user-md"></i></div>
          <h3 class="why-title font-heading text-primary-green fs-5 fw-bold mb-2">Dermatologically Tested</h3>
          <p class="text-muted-custom fs-7 mb-0">Clinically tested by independent dermatologists to ensure gentle efficacy across all skin sensitivity levels.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="why-card p-4 bg-white rounded-4 border shadow-sm h-100">
          <div class="why-icon-box mb-3 text-warning fs-2"><i class="fas fa-recycle"></i></div>
          <h3 class="why-title font-heading text-primary-green fs-5 fw-bold mb-2">Eco Friendly</h3>
          <p class="text-muted-custom fs-7 mb-0">Zero single-use plastic. Packed in 100% recyclable, biodegradable FSC certified paper wrap.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
        <div class="why-card p-4 bg-white rounded-4 border shadow-sm h-100">
          <div class="why-icon-box mb-3 text-warning fs-2"><i class="fas fa-paw"></i></div>
          <h3 class="why-title font-heading text-primary-green fs-5 fw-bold mb-2">Cruelty Free</h3>
          <p class="text-muted-custom fs-7 mb-0">We never test on animals at any stage of product development or ingredient sourcing.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
        <div class="why-card p-4 bg-white rounded-4 border shadow-sm h-100">
          <div class="why-icon-box mb-3 text-warning fs-2"><i class="fas fa-award"></i></div>
          <h3 class="why-title font-heading text-primary-green fs-5 fw-bold mb-2">Premium Ingredients</h3>
          <p class="text-muted-custom fs-7 mb-0">Ethically harvested cold-pressed oils, raw shea butter, and steam-distilled essential oils.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
        <div class="why-card p-4 bg-white rounded-4 border shadow-sm h-100">
          <div class="why-icon-box mb-3 text-warning fs-2"><i class="fas fa-check-double"></i></div>
          <h3 class="why-title font-heading text-primary-green fs-5 fw-bold mb-2">Trusted Quality</h3>
          <p class="text-muted-custom fs-7 mb-0">Manufactured under strict ISO & GMP quality standards in small artisanal batches.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 6: INGREDIENTS SECTION -->
@if($featuredIngredients->count())
<section id="ingredients" class="py-5 my-lg-4">
  <div class="container-custom">
    <div class="row align-items-center gy-5">
      <div class="col-lg-5" data-aos="fade-right">
        <span class="badge-subtitle mb-2">
          <i class="fas fa-seedling"></i> Nature's Finest
        </span>
        <h2 class="section-title">Skin-Loving Botanicals In Every Bar</h2>
        <p class="text-muted-custom mb-4">
          We select every plant extract for its specific bio-active skin benefits. Free from artificial colors, synthetic fragrances, Parabens, and SLS.
        </p>

        <div class="ingredient-list d-flex flex-column gap-3">
          @foreach($featuredIngredients as $ing)
            <div class="ingredient-item p-3 bg-white rounded-3 border shadow-sm d-flex align-items-center gap-3">
              <div class="ingredient-icon text-warning fs-3"><i class="fas fa-spa"></i></div>
              <div>
                <a href="{{ route('ingredients.show', $ing->slug) }}" class="fw-bold text-dark text-decoration-none fs-6 d-block mb-1">{{ $ing->name }}</a>
                <p class="text-muted fs-8 mb-0">{{ Str::limit($ing->short_description, 90) }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <div class="row g-3">
          <div class="col-sm-6">
            <img src="{{ asset('assets/images/about_artisan.jpg') }}" alt="Organic Ingredients" class="img-fluid rounded-4 shadow mb-3">
          </div>
          <div class="col-sm-6">
            <div class="glass-card p-4 text-center border bg-white rounded-4 shadow-sm">
              <i class="fas fa-leaf text-success fs-1 mb-2"></i>
              <h5 class="font-heading text-dark fw-bold mb-1">Clean Beauty Pledge</h5>
              <p class="text-muted fs-7 mb-0">0% Sulfates • 0% Parabens • 0% Synthetic Dyes • 100% Vegan</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- SECTION 7: MANUFACTURING PROCESS TIMELINE -->
@if($processSteps->count())
<section id="process" class="py-5 bg-section">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
      <span class="badge-subtitle">
        <i class="fas fa-cogs"></i> Craftsmanship & Precision
      </span>
      <h2 class="section-title">Our Artisanal Process</h2>
      <p class="text-muted-custom">How we craft cold-processed luxury soaps from farm-fresh harvest to your home.</p>
    </div>

    <div class="row g-4 justify-content-center">
      @foreach($processSteps as $step)
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
          <div class="timeline-step p-4 bg-white rounded-4 shadow-sm border text-center h-100">
            <div class="badge bg-warning-subtle text-warning fw-bold fs-7 mb-2">Step 0{{ $step->step_number }}</div>
            <h4 class="timeline-title fw-bold text-dark fs-5 mb-2">{{ $step->title }}</h4>
            <p class="text-muted fs-7 mb-0">{{ $step->description }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- SECTION 8: BECOME DISTRIBUTOR LEAD FORM -->
<section id="distributor" class="py-5 my-lg-4">
  <div class="container-custom">
    <div class="distributor-banner p-4 p-md-5 rounded-5" data-aos="zoom-in" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6" data-aos="fade-right">
          <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold mb-3">
            <i class="fas fa-handshake me-1"></i> B2B & GLOBAL PARTNERSHIPS
          </span>
          <h2 class="text-white font-heading display-5 fw-bold mb-3">Become An Authorized Aura Soaps Distributor</h2>
          <p class="text-white-50 fs-6 mb-4 line-height-lg">
            Join our expanding international network of premium retail partners, eco-boutiques, spas, and wellness distributors worldwide. Capitalize on the rapidly growing luxury organic skincare market.
          </p>

          <div class="row g-3 mb-4">
            <div class="col-sm-6">
              <div class="bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-10 text-white">
                <i class="fas fa-chart-line text-warning mb-1 fs-5"></i>
                <h6 class="mb-0 fw-bold">Marketing Support</h6>
                <span class="text-white-50 fs-8">High-res assets & POS units</span>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-10 text-white">
                <i class="fas fa-plane-departure text-warning mb-1 fs-5"></i>
                <h6 class="mb-0 fw-bold">Fast Global Logistics</h6>
                <span class="text-white-50 fs-8">Express freight shipping</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="bg-white p-4 p-md-5 rounded-4 shadow-lg text-dark">
            <h3 class="font-heading text-dark mb-1 fs-4 fw-bold">Apply For Partnership</h3>
            <p class="text-muted fs-7 mb-4">Complete the inquiry form to receive our official wholesale catalog & pricing tier list.</p>
            
            <form id="distributorForm" action="{{ route('distributor.store') }}" method="POST">
              @csrf
              <div class="row g-3">
                <div class="col-sm-6">
                  <label class="form-label fs-7 fw-bold">Full Name *</label>
                  <input type="text" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" required>
                </div>

                <div class="col-sm-6">
                  <label class="form-label fs-7 fw-bold">Company / Store Name *</label>
                  <input type="text" name="company_name" class="form-control" placeholder="e.g. Pure Botanical Spa" required>
                </div>

                <div class="col-sm-6">
                  <label class="form-label fs-7 fw-bold">Country / Region *</label>
                  <input type="text" name="country" class="form-control" placeholder="e.g. United Kingdom" required>
                </div>

                <div class="col-sm-6">
                  <label class="form-label fs-7 fw-bold">Phone Number *</label>
                  <input type="tel" name="phone" class="form-control" placeholder="+1 (555) 000-0000" required>
                </div>

                <div class="col-12">
                  <label class="form-label fs-7 fw-bold">Business Email *</label>
                  <input type="email" name="email" class="form-control" placeholder="sarah@botanicalspa.com" required>
                </div>

                <div class="col-12">
                  <label class="form-label fs-7 fw-bold">Message / Order Estimate</label>
                  <textarea name="message" class="form-control" rows="3" placeholder="Tell us about your store location and estimated order quantities..."></textarea>
                </div>

                <div class="col-12 mt-3">
                  <button type="submit" class="btn btn-aura w-100 py-2.5">
                    <span>Submit Application</span>
                    <i class="fas fa-paper-plane ms-1"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 9: TESTIMONIALS -->
@if($testimonials->count())
<section id="testimonials" class="py-5 bg-section">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
      <span class="badge-subtitle">
        <i class="fas fa-star text-warning"></i> Customer Love
      </span>
      <h2 class="section-title">What Skincare Enthusiasts Say</h2>
      <p class="text-muted-custom">Over 150,000 satisfied users adore Aura Soaps for daily bathing perfection.</p>
    </div>

    <div class="swiper testimonials-swiper" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper-wrapper">
        @foreach($testimonials as $item)
          <div class="swiper-slide">
            <div class="testimonial-card p-4 bg-white rounded-4 border shadow-sm">
              <div class="star-rating text-warning mb-3">
                @for($i=1; $i<=$item->rating; $i++) <i class="fas fa-star"></i> @endfor
              </div>
              <p class="testimonial-text text-muted fs-6 mb-4">"{{ $item->testimonial }}"</p>
              <div class="testimonial-user d-flex align-items-center gap-3 pt-3 border-top">
                <div class="user-avatar bg-warning-subtle text-warning rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                  {{ strtoupper(substr($item->customer_name, 0, 1)) }}
                </div>
                <div>
                  <div class="user-name fw-bold text-dark mb-0">{{ $item->customer_name }}</div>
                  <div class="user-role text-muted fs-8">{{ $item->country }} {{ $item->designation ? '• '.$item->designation : '' }}</div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="swiper-pagination mt-4"></div>
    </div>
  </div>
</section>
@endif

<!-- SECTION 10: BLOG SECTION -->
@if($latestBlogs->count())
<section id="blog" class="py-5 my-lg-4">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
      <span class="badge-subtitle">
        <i class="fas fa-book-open"></i> Botanical Journal
      </span>
      <h2 class="section-title">Latest From Our Skincare Blog</h2>
      <p class="text-muted-custom">Insights, eco-living advice, and formulation secrets from our master soap makers.</p>
    </div>

    <div class="row g-4">
      @foreach($latestBlogs as $post)
        @php
          $postImg = !empty($post->featured_image) && file_exists(public_path($post->featured_image)) 
            ? asset($post->featured_image) 
            : asset('assets/images/herbal_soap.jpg');
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
          <div class="blog-card bg-white rounded-4 border shadow-sm overflow-hidden h-100 d-flex flex-column">
            <div class="blog-img-box" style="height: 200px;">
              <img src="{{ $postImg }}" alt="{{ $post->title }}" class="blog-img w-100 h-100 object-fit-cover">
            </div>
            <div class="blog-body p-4 flex-grow-1 d-flex flex-column">
              <div class="blog-meta fs-8 text-muted mb-2 d-flex justify-content-between">
                <span><i class="fas fa-folder me-1 text-warning"></i>{{ $post->category->name ?? 'Skincare' }}</span>
                <span><i class="fas fa-calendar-alt me-1 text-success"></i>{{ $post->publish_date ? $post->publish_date->format('M d, Y') : '' }}</span>
              </div>
              <h3 class="blog-title fw-bold fs-5 text-dark mb-2">{{ $post->title }}</h3>
              <p class="text-muted fs-7 mb-3 flex-grow-1">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 90) }}</p>
              <div class="mt-auto pt-3 border-top">
                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-aura-outline rounded-pill px-3 fs-7 fw-semibold">
                  Read Article <i class="fas fa-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- SECTION 11: FAQ SECTION -->
@if($faqs->count())
<section id="faq" class="py-5 bg-section">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
      <span class="badge-subtitle">
        <i class="fas fa-question-circle"></i> Got Questions?
      </span>
      <h2 class="section-title">Frequently Asked Questions</h2>
      <p class="text-muted-custom">Find answers regarding product ingredients, suitability, shipping, and wholesale partnerships.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-9" data-aos="fade-up">
        <div class="accordion accordion-aura" id="faqAccordion">
          @foreach($faqs as $faq)
            <div class="accordion-item mb-3 border rounded-4 overflow-hidden shadow-sm">
              <h2 class="accordion-header" id="faqHeading{{ $faq->id }}">
                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-bold text-dark fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                  {{ $faq->question }}
                </button>
              </h2>
              <div id="faqCollapse{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-muted fs-6">
                  {{ $faq->answer }}
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- SECTION 12: CONTACT SECTION -->
<section id="contact" class="py-5 my-lg-4">
  <div class="container-custom">
    <div class="row gy-5">
      <div class="col-lg-5" data-aos="fade-right">
        <span class="badge-subtitle mb-2">
          <i class="fas fa-envelope"></i> Get In Touch
        </span>
        <h2 class="section-title">We’d Love To Hear From You</h2>
        <p class="text-muted-custom mb-4">Have questions about our ingredients, orders, or eco practices? Reach out to our dedicated support team.</p>

        <div class="contact-info-card mb-4">
          <div class="contact-detail-item p-3 bg-white rounded-3 border mb-3 d-flex align-items-center gap-3">
            <div class="contact-icon-box text-warning fs-3"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <h6 class="font-heading text-dark mb-1 fs-6 fw-bold">Headquarters</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('contact_address', '108 Pure Botanical Way, CA 90210') }}</p>
            </div>
          </div>

          <div class="contact-detail-item p-3 bg-white rounded-3 border mb-3 d-flex align-items-center gap-3">
            <div class="contact-icon-box text-warning fs-3"><i class="fas fa-phone-alt"></i></div>
            <div>
              <h6 class="font-heading text-dark mb-1 fs-6 fw-bold">Call Us</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('contact_phone', '+1 (800) 555-2872') }} / {{ App\Models\Setting::get('working_hours', 'Mon - Sat: 9am - 6pm') }}</p>
            </div>
          </div>

          <div class="contact-detail-item p-3 bg-white rounded-3 border mb-3 d-flex align-items-center gap-3">
            <div class="contact-icon-box text-warning fs-3"><i class="fas fa-paper-plane"></i></div>
            <div>
              <h6 class="font-heading text-dark mb-1 fs-6 fw-bold">Email Inquiries</h6>
              <p class="text-muted fs-7 mb-0">{{ App\Models\Setting::get('contact_email', 'hello@aurasoaps.com') }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
          <h3 class="font-heading text-dark mb-1 fs-4 fw-bold">Send Us A Message</h3>
          <p class="text-muted fs-7 mb-4">Fill out the form below and we will respond within 12 hours.</p>

          <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label fs-7 fw-bold">Your Name *</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Emma Watson" required>
              </div>

              <div class="col-sm-6">
                <label class="form-label fs-7 fw-bold">Email Address *</label>
                <input type="email" name="email" class="form-control" placeholder="emma@example.com" required>
              </div>

              <div class="col-sm-6">
                <label class="form-label fs-7 fw-bold">Phone Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
              </div>

              <div class="col-sm-6">
                <label class="form-label fs-7 fw-bold">Subject *</label>
                <select name="subject" class="form-select" required>
                  <option value="">Select a topic</option>
                  <option value="product">Product Inquiry</option>
                  <option value="order">Order Status</option>
                  <option value="press">Press & Media</option>
                  <option value="other">General Question</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label fs-7 fw-bold">Your Message *</label>
                <textarea name="message" class="form-control" rows="5" placeholder="How can we assist your natural skincare journey?" required></textarea>
              </div>

              <div class="col-12 mt-3">
                <button type="submit" class="btn btn-aura px-4 py-2.5">
                  <span>Send Message</span>
                  <i class="fas fa-paper-plane ms-1"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
