@extends('layouts.admin')

@section('page_title', 'Website Settings & SEO Manager')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="fw-bold text-dark mb-1">Website Settings & SEO Manager</h5>
    <p class="text-muted fs-7 mb-0">Manage branding assets, page content sections, and page-wise SEO details separately in organized tabs.</p>
  </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <!-- Tab Navigation Bar -->
  <div class="admin-card p-2 mb-4">
    <ul class="nav nav-pills nav-fill gap-2" id="settingsTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold py-2.5 rounded-3 fs-7" id="tab-general" data-bs-toggle="tab" data-bs-target="#content-general" type="button" role="tab">
          <i class="fas fa-store me-1.5 text-amber"></i> General & Branding
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold py-2.5 rounded-3 fs-7" id="tab-contact" data-bs-toggle="tab" data-bs-target="#content-contact" type="button" role="tab">
          <i class="fas fa-phone-alt me-1.5 text-primary"></i> Contact & Social
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold py-2.5 rounded-3 fs-7" id="tab-about" data-bs-toggle="tab" data-bs-target="#content-about" type="button" role="tab">
          <i class="fas fa-heart me-1.5 text-danger"></i> About Us CMS & SEO
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold py-2.5 rounded-3 fs-7" id="tab-policy" data-bs-toggle="tab" data-bs-target="#content-policy" type="button" role="tab">
          <i class="fas fa-file-contract me-1.5 text-success"></i> Policies CMS & SEO
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold py-2.5 rounded-3 fs-7" id="tab-all-seo" data-bs-toggle="tab" data-bs-target="#content-all-seo" type="button" role="tab">
          <i class="fas fa-search me-1.5 text-info"></i> Page-Wise SEO Manager
        </button>
      </li>
    </ul>
  </div>

  <!-- Tab Content -->
  <div class="tab-content" id="settingsTabContent">
    
    <!-- TAB 1: General & Branding -->
    <div class="tab-pane fade show active" id="content-general" role="tabpanel">
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-image text-warning me-1.5"></i> Logo & Favicon Branding
            </h6>

            <!-- Logo Upload & Preview -->
            <div class="mb-4 p-3 bg-light rounded-3 border">
              <label class="form-label fs-7 fw-bold text-dark d-block">Website Logo</label>
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-white p-2 rounded border text-center d-flex align-items-center justify-content-center" style="width: 140px; height: 60px;">
                  @if(!empty($settings['site_logo']))
                    <img src="{{ asset($settings['site_logo']) }}" id="logoPreview" alt="Logo" class="img-fluid" style="max-height: 48px;">
                  @else
                    <span class="text-muted fs-8" id="logoPreviewText">No Logo</span>
                  @endif
                </div>
                <div class="flex-grow-1">
                  <label class="form-label fs-8 text-muted mb-1">Upload New Logo (PNG, SVG, WEBP)</label>
                  <input type="file" name="site_logo_file" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'logoPreview')">
                </div>
              </div>
              <div>
                <label class="form-label fs-8 text-muted mb-1">Or Direct Logo Image Path / URL</label>
                <input type="text" name="site_logo" class="form-control form-control-sm" value="{{ $settings['site_logo'] ?? 'assets/images/logo.png' }}">
              </div>
            </div>

            <!-- Favicon Upload & Preview -->
            <div class="mb-4 p-3 bg-light rounded-3 border">
              <label class="form-label fs-7 fw-bold text-dark d-block">Website Favicon</label>
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-white p-2 rounded border text-center d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                  @if(!empty($settings['site_favicon']))
                    <img src="{{ asset($settings['site_favicon']) }}" id="faviconPreview" alt="Favicon" class="img-fluid" style="max-height: 36px;">
                  @else
                    <span class="text-muted fs-8" id="faviconPreviewText">No Icon</span>
                  @endif
                </div>
                <div class="flex-grow-1">
                  <label class="form-label fs-8 text-muted mb-1">Upload New Favicon (PNG, ICO, SVG)</label>
                  <input type="file" name="site_favicon_file" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'faviconPreview')">
                </div>
              </div>
              <div>
                <label class="form-label fs-8 text-muted mb-1">Or Direct Favicon Path / URL</label>
                <input type="text" name="site_favicon" class="form-control form-control-sm" value="{{ $settings['site_favicon'] ?? 'assets/images/logo.png' }}">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Website Name <span class="text-danger">*</span></label>
              <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'Aura Soaps' }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Website Tagline</label>
              <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? 'Natural Care • Pure Touch' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Global Description</label>
              <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? 'Aura Soaps offers crafted natural soaps and eco-friendly skincare.' }}</textarea>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-search text-info me-1.5"></i> Homepage SEO Details (`home`)
            </h6>
            @php $homeSeo = $seoMetas['home'] ?? null; @endphp
            
            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Homepage Meta Title</label>
              <input type="text" name="seo[home][title]" class="form-control" value="{{ $homeSeo->title ?? 'Aura Soaps | Natural Care • Pure Touch' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Homepage Meta Description</label>
              <textarea name="seo[home][meta_description]" class="form-control" rows="3">{{ $homeSeo->meta_description ?? 'Crafted natural soaps, botanical skincare, and cold-processed organic bath products.' }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Focus Keyword</label>
              <input type="text" name="seo[home][focus_keyword]" class="form-control" value="{{ $homeSeo->focus_keyword ?? 'natural soaps' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Canonical URL</label>
              <input type="url" name="seo[home][canonical_url]" class="form-control" value="{{ $homeSeo->canonical_url ?? '' }}" placeholder="Auto-generated if empty">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Meta Robots</label>
              <select name="seo[home][robots]" class="form-select">
                <option value="index, follow" {{ ($homeSeo->robots ?? '') === 'index, follow' ? 'selected' : '' }}>index, follow</option>
                <option value="noindex, follow" {{ ($homeSeo->robots ?? '') === 'noindex, follow' ? 'selected' : '' }}>noindex, follow</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Homepage Hero Section CMS -->
        <div class="col-12">
          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-magic text-warning me-1.5"></i> Homepage Hero Section & Counters CMS
            </h6>

            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label fs-7 fw-bold">Hero Badge Text</label>
                <input type="text" name="hero_badge" class="form-control" value="{{ $settings['hero_badge'] ?? '100% Organic & Crafted' }}">
              </div>

              <div class="col-md-4">
                <label class="form-label fs-7 fw-bold">Hero Heading Title</label>
                <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? 'Pure Nature, <span>Perfect Care.</span>' }}">
              </div>

              <div class="col-md-4">
                <label class="form-label fs-7 fw-bold">Hero Main Image Path</label>
                <input type="text" name="hero_img" class="form-control" value="{{ $settings['hero_img'] ?? 'assets/images/aurasoap images/aurashop (5).jpeg' }}">
              </div>

              <div class="col-12">
                <label class="form-label fs-7 fw-bold">Hero Description</label>
                <textarea name="hero_desc" class="form-control" rows="2">{{ $settings['hero_desc'] ?? 'Natural crafted soaps made with skin-loving ingredients that cleanse, nourish, and refresh every day. Experience luxury organic bathing rituals.' }}</textarea>
              </div>

              <div class="col-12 border-top pt-3">
                <h6 class="fw-bold fs-7 text-secondary">Homepage Statistics / Counters (4 Numbers)</h6>
              </div>

              <div class="col-md-3">
                <label class="form-label fs-8 fw-semibold">Years Experience</label>
                <input type="text" name="stat_years" class="form-control form-control-sm" value="{{ $settings['stat_years'] ?? '12' }}">
              </div>

              <div class="col-md-3">
                <label class="form-label fs-8 fw-semibold">Happy Customers (K+)</label>
                <input type="text" name="stat_customers" class="form-control form-control-sm" value="{{ $settings['stat_customers'] ?? '150' }}">
              </div>

              <div class="col-md-3">
                <label class="form-label fs-8 fw-semibold">Natural Lipids (%)</label>
                <input type="text" name="stat_natural" class="form-control form-control-sm" value="{{ $settings['stat_natural'] ?? '100' }}">
              </div>

              <div class="col-md-3">
                <label class="form-label fs-8 fw-semibold">Countries Served (+)</label>
                <input type="text" name="stat_countries" class="form-control form-control-sm" value="{{ $settings['stat_countries'] ?? '35' }}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 2: Contact & Social -->
    <div class="tab-pane fade" id="content-contact" role="tabpanel">
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-headset text-primary me-1.5"></i> Contact & Support Details
            </h6>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Primary Contact Email <span class="text-danger">*</span></label>
              <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'hello@aurasoaps.com' }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Phone Number</label>
              <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '+1 (800) 555-2872' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">WhatsApp Support Number</label>
              <input type="text" name="contact_whatsapp" class="form-control" value="{{ $settings['contact_whatsapp'] ?? '+1 (800) 555-2872' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Physical Address</label>
              <input type="text" name="contact_address" class="form-control" value="{{ $settings['contact_address'] ?? '108 Pure Botanical Way, CA 90210' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Working Hours</label>
              <input type="text" name="working_hours" class="form-control" value="{{ $settings['working_hours'] ?? 'Mon - Sat: 9:00 AM - 6:00 PM EST' }}">
            </div>
          </div>

          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-share-alt text-info me-1.5"></i> Social Media Handles
            </h6>
            <div class="mb-3">
              <label class="form-label fs-7 fw-semibold"><i class="fab fa-facebook text-primary me-1"></i> Facebook URL</label>
              <input type="url" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? '' }}">
            </div>
            <div class="mb-3">
              <label class="form-label fs-7 fw-semibold"><i class="fab fa-instagram text-danger me-1"></i> Instagram URL</label>
              <input type="url" name="social_instagram" class="form-control" value="{{ $settings['social_instagram'] ?? '' }}">
            </div>
            <div class="mb-3">
              <label class="form-label fs-7 fw-semibold"><i class="fab fa-linkedin text-info me-1"></i> LinkedIn URL</label>
              <input type="url" name="social_linkedin" class="form-control" value="{{ $settings['social_linkedin'] ?? '' }}">
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-search text-info me-1.5"></i> Contact Page SEO (`contact`)
            </h6>
            @php $contactSeo = $seoMetas['contact'] ?? null; @endphp

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Contact Page Title</label>
              <input type="text" name="seo[contact][title]" class="form-control" value="{{ $contactSeo->title ?? 'Contact Us | Customer Support & Wholesale Enquiries' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Meta Description</label>
              <textarea name="seo[contact][meta_description]" class="form-control" rows="3">{{ $contactSeo->meta_description ?? 'Get in touch with the Aura Soaps support team for product guidance and partnership requests.' }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Focus Keyword</label>
              <input type="text" name="seo[contact][focus_keyword]" class="form-control" value="{{ $contactSeo->focus_keyword ?? 'contact aura soaps' }}">
            </div>
          </div>

          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-search text-info me-1.5"></i> Distributor Page SEO (`become-a-distributor`)
            </h6>
            @php $distSeo = $seoMetas['become-a-distributor'] ?? null; @endphp

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Distributor Page Title</label>
              <input type="text" name="seo[become-a-distributor][title]" class="form-control" value="{{ $distSeo->title ?? 'Become a Distributor | Global Wholesale Partnership' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Meta Description</label>
              <textarea name="seo[become-a-distributor][meta_description]" class="form-control" rows="3">{{ $distSeo->meta_description ?? 'Join Aura Soaps global distributor network. Expand your store with premium organic soaps.' }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Focus Keyword</label>
              <input type="text" name="seo[become-a-distributor][focus_keyword]" class="form-control" value="{{ $distSeo->focus_keyword ?? 'soap distributor' }}">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 3: About Us CMS & SEO -->
    <div class="tab-pane fade" id="content-about" role="tabpanel">
      <div class="row g-4">
        <div class="col-lg-7">
          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-heart text-danger me-1.5"></i> About Us Page Content
            </h6>

            <div class="row g-3">
              <div class="col-md-6 mb-3">
                <label class="form-label fs-7 fw-bold">Banner Title</label>
                <input type="text" name="about_banner_title" class="form-control" value="{{ $settings['about_banner_title'] ?? 'Our Heritage & Story' }}">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label fs-7 fw-bold">Banner Subtitle</label>
                <input type="text" name="about_banner_subtitle" class="form-control" value="{{ $settings['about_banner_subtitle'] ?? 'Crafting pure, eco-conscious bathing rituals with organic botanicals.' }}">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label fs-7 fw-bold">Story Section Title</label>
                <input type="text" name="about_story_title" class="form-control" value="{{ $settings['about_story_title'] ?? 'Manufacturing & Distribution Excellence' }}">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label fs-7 fw-bold">Story Image Path</label>
                <input type="text" name="about_story_image" class="form-control" value="{{ $settings['about_story_image'] ?? 'assets/images/aura-shop (5).jpeg' }}">
              </div>

              <div class="col-12 mb-3">
                <label class="form-label fs-7 fw-bold">Story Paragraphs</label>
                <textarea name="about_story_p1" class="form-control" rows="4">{{ $settings['about_story_p1'] ?? "AURA SOAPS specializes in the manufacturing and distribution of essential PERSONAL CARE, SANITATION, and HYGIENE products..." }}</textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label fs-7 fw-bold">Mission Title</label>
                <input type="text" name="about_mission_title" class="form-control" value="{{ $settings['about_mission_title'] ?? 'Our Mission' }}">
                <label class="form-label fs-7 fw-bold mt-2">Mission Text</label>
                <textarea name="about_mission_desc" class="form-control" rows="3">{{ $settings['about_mission_desc'] ?? 'A boutique & Design-Forward Company (The Premium Visual Brand)...' }}</textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label fs-7 fw-bold">Vision Title</label>
                <input type="text" name="about_vision_title" class="form-control" value="{{ $settings['about_vision_title'] ?? 'Our Vision' }}">
                <label class="form-label fs-7 fw-bold mt-2">Vision Text</label>
                <textarea name="about_vision_desc" class="form-control" rows="3">{{ $settings['about_vision_desc'] ?? 'Becoming the Regional Hallmark for sustainable, luxurious, and accessible eco-friendly FMCGs...' }}</textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
              <i class="fas fa-search text-info me-1.5"></i> About Us Page SEO (`about-us`)
            </h6>
            @php $aboutSeo = $seoMetas['about-us'] ?? null; @endphp

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">SEO Title</label>
              <input type="text" name="seo[about-us][title]" class="form-control" value="{{ $aboutSeo->title ?? 'About Us | Artisanal Organic Bath Care • Aura Soaps' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Meta Description</label>
              <textarea name="seo[about-us][meta_description]" class="form-control" rows="4">{{ $aboutSeo->meta_description ?? 'Learn about our cold-process formulation, 6-week curing process, and ethical sourcing.' }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Focus Keyword</label>
              <input type="text" name="seo[about-us][focus_keyword]" class="form-control" value="{{ $aboutSeo->focus_keyword ?? 'artisanal soap maker' }}">
            </div>

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Canonical URL</label>
              <input type="url" name="seo[about-us][canonical_url]" class="form-control" value="{{ $aboutSeo->canonical_url ?? '' }}">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 4: Policies CMS & SEO -->
    <div class="tab-pane fade" id="content-policy" role="tabpanel">
      <div class="row g-4">
        <!-- Privacy Policy -->
        <div class="col-lg-6">
          <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="fas fa-user-shield me-1"></i> Privacy Policy (`/privacy-policy`)</h6>
            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Page Content (WYSIWYG Rich Editor)</label>
              <textarea name="policy_privacy" class="form-control rich-editor" rows="5">{{ $settings['policy_privacy'] ?? '' }}</textarea>
            </div>
            @php $privSeo = $seoMetas['privacy-policy'] ?? null; @endphp
            <div class="mb-2">
              <label class="form-label fs-8 fw-semibold text-muted">SEO Title</label>
              <input type="text" name="seo[privacy-policy][title]" class="form-control form-control-sm" value="{{ $privSeo->title ?? 'Privacy Policy | Aura Soaps' }}">
            </div>
            <div>
              <label class="form-label fs-8 fw-semibold text-muted">Meta Description</label>
              <input type="text" name="seo[privacy-policy][meta_description]" class="form-control form-control-sm" value="{{ $privSeo->meta_description ?? 'Official Privacy Policy of Aura Soaps.' }}">
            </div>
          </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="col-lg-6">
          <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="fas fa-file-contract me-1"></i> Terms & Conditions (`/terms-and-conditions`)</h6>
            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Page Content (WYSIWYG Rich Editor)</label>
              <textarea name="policy_terms" class="form-control rich-editor" rows="5">{{ $settings['policy_terms'] ?? '' }}</textarea>
            </div>
            @php $termsSeo = $seoMetas['terms-and-conditions'] ?? null; @endphp
            <div class="mb-2">
              <label class="form-label fs-8 fw-semibold text-muted">SEO Title</label>
              <input type="text" name="seo[terms-and-conditions][title]" class="form-control form-control-sm" value="{{ $termsSeo->title ?? 'Terms & Conditions | Aura Soaps' }}">
            </div>
            <div>
              <label class="form-label fs-8 fw-semibold text-muted">Meta Description</label>
              <input type="text" name="seo[terms-and-conditions][meta_description]" class="form-control form-control-sm" value="{{ $termsSeo->meta_description ?? 'Official Terms of Service of Aura Soaps.' }}">
            </div>
          </div>
        </div>

        <!-- Return Policy -->
        <div class="col-lg-6">
          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="fas fa-undo me-1"></i> Return Policy (`/return-policy`)</h6>
            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Page Content (WYSIWYG Rich Editor)</label>
              <textarea name="policy_returns" class="form-control rich-editor" rows="5">{{ $settings['policy_returns'] ?? '' }}</textarea>
            </div>
            @php $retSeo = $seoMetas['return-policy'] ?? null; @endphp
            <div class="mb-2">
              <label class="form-label fs-8 fw-semibold text-muted">SEO Title</label>
              <input type="text" name="seo[return-policy][title]" class="form-control form-control-sm" value="{{ $retSeo->title ?? 'Return Policy | Aura Soaps' }}">
            </div>
            <div>
              <label class="form-label fs-8 fw-semibold text-muted">Meta Description</label>
              <input type="text" name="seo[return-policy][meta_description]" class="form-control form-control-sm" value="{{ $retSeo->meta_description ?? 'Official Return & Refund Policy of Aura Soaps.' }}">
            </div>
          </div>
        </div>

        <!-- Shipping Policy -->
        <div class="col-lg-6">
          <div class="admin-card p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="fas fa-truck me-1"></i> Shipping Policy (`/shipping-policy`)</h6>
            <div class="mb-3">
              <label class="form-label fs-7 fw-bold">Page Content (WYSIWYG Rich Editor)</label>
              <textarea name="policy_shipping" class="form-control rich-editor" rows="5">{{ $settings['policy_shipping'] ?? '' }}</textarea>
            </div>
            @php $shipSeo = $seoMetas['shipping-policy'] ?? null; @endphp
            <div class="mb-2">
              <label class="form-label fs-8 fw-semibold text-muted">SEO Title</label>
              <input type="text" name="seo[shipping-policy][title]" class="form-control form-control-sm" value="{{ $shipSeo->title ?? 'Shipping Policy | Aura Soaps' }}">
            </div>
            <div>
              <label class="form-label fs-8 fw-semibold text-muted">Meta Description</label>
              <input type="text" name="seo[shipping-policy][meta_description]" class="form-control form-control-sm" value="{{ $shipSeo->meta_description ?? 'Official Dispatch & Shipping Policy of Aura Soaps.' }}">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 5: All Pages SEO Manager -->
    <div class="tab-pane fade" id="content-all-seo" role="tabpanel">
      <div class="admin-card p-4">
        <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">
          <i class="fas fa-globe text-primary me-1.5"></i> Page-Wise Meta Title & Description Overview
        </h6>

        @php
          $allPages = [
            'home' => 'Homepage',
            'about-us' => 'About Us Page',
            'products' => 'Products Catalog',
            'ingredients' => 'Ingredients Directory',
            'blog' => 'Blog & Articles',
            'become-a-distributor' => 'Become a Distributor',
            'faq' => 'FAQ Page',
            'contact' => 'Contact Us Page',
          ];
        @endphp

        <div class="row g-4">
          @foreach($allPages as $routeKey => $pageLabel)
            @php $pSeo = $seoMetas[$routeKey] ?? null; @endphp
            <div class="col-md-6">
              <div class="p-3 bg-light rounded-3 border">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <span class="fw-bold text-dark fs-7">{{ $pageLabel }}</span>
                  <span class="badge bg-secondary-subtle text-secondary font-monospace fs-8">/{{ $routeKey === 'home' ? '' : $routeKey }}</span>
                </div>
                <div class="mb-2">
                  <label class="form-label fs-8 text-muted mb-1">Title</label>
                  <input type="text" name="seo[{{ $routeKey }}][title]" class="form-control form-control-sm" value="{{ $pSeo->title ?? '' }}" placeholder="Default Site Title">
                </div>
                <div class="mb-2">
                  <label class="form-label fs-8 text-muted mb-1">Meta Description</label>
                  <textarea name="seo[{{ $routeKey }}][meta_description]" class="form-control form-control-sm" rows="2" placeholder="Default Description">{{ $pSeo->meta_description ?? '' }}</textarea>
                </div>
                <div>
                  <label class="form-label fs-8 text-muted mb-1">Focus Keyword</label>
                  <input type="text" name="seo[{{ $routeKey }}][focus_keyword]" class="form-control form-control-sm" value="{{ $pSeo->focus_keyword ?? '' }}">
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>

  <!-- Global Floating Save Bar -->
  <div class="mt-4 text-end">
    <button type="submit" class="btn btn-aura px-4 py-2.5 shadow-sm">
      <i class="fas fa-save me-1.5"></i> Save All Settings & SEO Details
    </button>
  </div>
</form>

@push('scripts')
<script>
  function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        if (preview) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush
@endsection
