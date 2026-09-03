<footer class="footer-aura pt-5 mt-5" style="background: #111827; color: #FFFFFF;">
  <div class="container-custom">
    <div class="row gy-4 pb-5" style="border-bottom: 1px solid rgba(255, 255, 255, 0.12);">
      <!-- Column 1: Brand & Bio -->
      <div class="col-lg-4 col-md-6">
        <a href="{{ route('home') }}" class="d-inline-block mb-3 bg-white px-3 py-2 rounded-4 shadow-sm" style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
          <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="{{ App\Models\Setting::get('site_name', 'Aura Soaps') }}" class="footer-logo-img" style="height: 64px; width: auto; max-width: 250px; object-fit: contain;">
        </a>
        <div class="fw-bold text-white fs-6 mb-2" style="letter-spacing: 0.5px;">{{ App\Models\Setting::get('site_tagline', 'PURE NATURE.... PERFECT SKIN CARE....') }}</div>
        <p class="fs-7 pe-lg-4 mb-0" style="color: rgba(255, 255, 255, 0.85); line-height: 1.6;">
          Specializing in the manufacturing and regional distribution of essential Personal Care, Sanitation, and Hygiene products across Rwanda, Eastern DRC, and Western Uganda.
        </p>
      </div>

      <!-- Column 2: Quick Links -->
      <div class="col-lg-2 col-md-6 col-6">
        <h5 class="font-heading mb-3 text-white fw-bold" style="font-size: 1.15rem; letter-spacing: 0.3px;">Quick Links</h5>
        <ul class="list-unstyled footer-links fs-7 d-flex flex-column gap-2">
          <li><a href="{{ route('home') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Home</a></li>
          <li><a href="{{ route('about') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> About Us</a></li>
          <li><a href="{{ route('products.index') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Products</a></li>
          <li><a href="{{ route('ingredients.index') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Botanical Ingredients</a></li>
          <li><a href="{{ route('agent.locator') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Find Agent Locator</a></li>
          <li><a href="{{ route('contact') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Factory Contacts</a></li>
        </ul>
      </div>

      <!-- Column 3: Principal Agents -->
      <div class="col-lg-2 col-md-6 col-6">
        <h5 class="font-heading mb-3 text-white fw-bold" style="font-size: 1.15rem; letter-spacing: 0.3px;">Principal Agents</h5>
        <ul class="list-unstyled footer-links fs-7 d-flex flex-column gap-2">
          <li><a href="{{ route('agent.register') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Become Principal Agent</a></li>
          <li><a href="{{ route('agent.portal') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Principal Agent Portal</a></li>
          <li><a href="{{ route('agent.locator') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Regional Target Map (120)</a></li>
          <li><a href="{{ route('policy.privacy') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Privacy Policy</a></li>
          <li><a href="{{ route('policy.terms') }}" class="text-decoration-none" style="color: rgba(255, 255, 255, 0.85);"><i class="fas fa-chevron-right me-1 fs-8 text-warning"></i> Terms & Conditions</a></li>
        </ul>
      </div>

      <!-- Column 4: Address, Hotline & Social Links -->
      <div class="col-lg-4 col-md-6">
        <h5 class="font-heading mb-3 text-white fw-bold" style="font-size: 1.15rem; letter-spacing: 0.3px;">
          <i class="fas fa-map-marker-alt text-warning me-1"></i> Our Address & Contact
        </h5>
        <div class="d-flex align-items-start gap-2 mb-2">
          <i class="fas fa-building text-warning mt-1 fs-7"></i>
          <p class="fs-7 mb-0" style="color: rgba(255, 255, 255, 0.88); line-height: 1.5;">
            {{ App\Models\Setting::get('contact_address', 'Kigali Special Economic Zone / Nyarugenge Commercial District, Kigali, Rwanda') }}
          </p>
        </div>
        <div class="d-flex align-items-center gap-2 mb-3 fs-7" style="color: rgba(255, 255, 255, 0.85);">
          <i class="fas fa-clock text-warning fs-7"></i>
          <span>{{ App\Models\Setting::get('working_hours', 'Mon - Sat: 8:00 AM - 6:00 PM') }}</span>
        </div>

        <div class="fs-7 mb-4 d-flex flex-column gap-2" style="color: rgba(255, 255, 255, 0.9);">
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-phone-alt text-warning"></i>
            <strong class="text-white">Factory Hotline:</strong> 
            <a href="tel:+250795602083" class="text-white text-decoration-none" style="transition: color 0.2s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='#ffffff'">+250 795 602 083</a>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="fab fa-whatsapp text-success fs-6"></i>
            <strong class="text-white">WhatsApp:</strong> 
            <a href="https://wa.me/250795602083" target="_blank" class="text-white text-decoration-none" style="transition: color 0.2s;" onmouseover="this.style.color='#22c55e'" onmouseout="this.style.color='#ffffff'">+250 795 602 083</a>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-envelope text-info"></i>
            <strong class="text-white">Sales:</strong> 
            <a href="mailto:sales1@aura-soaps.com" class="text-white text-decoration-none" style="transition: color 0.2s;" onmouseover="this.style.color='#38bdf8'" onmouseout="this.style.color='#ffffff'">sales1@aura-soaps.com</a>
          </div>
        </div>

        <h5 class="font-heading mb-3 text-white fw-bold" style="font-size: 1.15rem; letter-spacing: 0.3px;">
          <i class="fas fa-share-alt text-warning me-1"></i> Follow & Connect
        </h5>
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <a href="{{ App\Models\Setting::get('social_facebook', 'https://facebook.com/aurasoaps') }}" target="_blank" rel="noopener noreferrer" class="social-icon-pill" title="Facebook" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="{{ App\Models\Setting::get('social_instagram', 'https://instagram.com/aurasoaps') }}" target="_blank" rel="noopener noreferrer" class="social-icon-pill" title="Instagram" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://wa.me/250795602083" target="_blank" rel="noopener noreferrer" class="social-icon-pill" title="WhatsApp" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="{{ App\Models\Setting::get('social_linkedin', 'https://linkedin.com/company/aurasoaps') }}" target="_blank" rel="noopener noreferrer" class="social-icon-pill" title="LinkedIn" aria-label="LinkedIn">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="{{ App\Models\Setting::get('social_youtube', 'https://youtube.com/@aurasoaps') }}" target="_blank" rel="noopener noreferrer" class="social-icon-pill" title="YouTube" aria-label="YouTube">
            <i class="fab fa-youtube"></i>
          </a>
          <a href="{{ App\Models\Setting::get('social_tiktok', 'https://tiktok.com/@aurasoaps') }}" target="_blank" rel="noopener noreferrer" class="social-icon-pill" title="TikTok" aria-label="TikTok">
            <i class="fab fa-tiktok"></i>
          </a>
        </div>
      </div>
    </div>

    <div class="py-4 text-center fs-7" style="color: rgba(255, 255, 255, 0.75);">
      <p class="mb-0">&copy; {{ date('Y') }} {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}. All Rights Reserved. Quality – All – Round.</p>
    </div>
  </div>
</footer>
