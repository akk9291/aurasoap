<footer class="footer-aura pt-5 mt-5">
  <div class="container-custom">
    <div class="row gy-4 pb-5 border-bottom border-amber-light">
      <div class="col-lg-4 col-md-6">
        <a href="{{ route('home') }}" class="d-inline-block mb-3">
          <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="{{ App\Models\Setting::get('site_name', 'Aura Soaps') }}" class="footer-logo-img">
        </a>
        <div class="fw-bold text-dark fs-6 mb-1">{{ App\Models\Setting::get('site_tagline', 'PURE NATURE.... PERFECT SKIN CARE....') }}</div>
        <p class="text-muted-custom fs-7 pe-lg-4 mb-3">
          Specializing in the manufacturing and regional distribution of essential Personal Care, Sanitation, and Hygiene products across Rwanda, Eastern DRC, and Western Uganda.
        </p>
        <div class="fs-8 text-secondary mb-2">
          <div><i class="fas fa-phone-alt text-warning me-2"></i><strong>Factory Hotline:</strong> <a href="tel:+250795602083" class="text-dark text-decoration-none">+250 795 602 083</a></div>
          <div><i class="fab fa-whatsapp text-success me-2"></i><strong>WhatsApp:</strong> <a href="https://wa.me/250795602083" target="_blank" class="text-dark text-decoration-none">+250 795 602 083</a></div>
          <div><i class="fas fa-envelope text-primary me-2"></i><strong>Sales:</strong> <a href="mailto:sales1@aura-soaps.com" class="text-dark text-decoration-none">sales1@aura-soaps.com</a></div>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-6">
        <h5 class="font-heading mb-3 text-dark">Quick Links</h5>
        <ul class="list-unstyled footer-links fs-7 d-flex flex-column gap-2">
          <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Home</a></li>
          <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> About Us</a></li>
          <li><a href="{{ route('products.index') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Products</a></li>
          <li><a href="{{ route('ingredients.index') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Botanical Ingredients</a></li>
          <li><a href="{{ route('agent.locator') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Find Agent Locator</a></li>
          <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Factory Contacts</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 col-6">
        <h5 class="font-heading mb-3 text-dark">Principal Agents</h5>
        <ul class="list-unstyled footer-links fs-7 d-flex flex-column gap-2">
          <li><a href="{{ route('agent.register') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Become Principal Agent</a></li>
          <li><a href="{{ route('agent.portal') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Principal Agent Portal</a></li>
          <li><a href="{{ route('agent.locator') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Regional Target Map (120)</a></li>
          <li><a href="{{ route('policy.privacy') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Privacy Policy</a></li>
          <li><a href="{{ route('policy.terms') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Terms & Conditions</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h5 class="font-heading mb-3 text-dark">Commercial Newsletter</h5>
        <p class="text-muted-custom fs-7 mb-3">Subscribe for wholesale supply updates, new FMCG product releases, and regional agent announcements.</p>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
          @csrf
          <div class="input-group">
            <input type="email" name="email" class="form-control rounded-pill-start" placeholder="Your email address" required>
            <button class="btn btn-aura-primary rounded-pill-end px-3" type="submit"><i class="fas fa-paper-plane"></i></button>
          </div>
        </form>
      </div>
    </div>

    <div class="py-4 text-center text-muted-custom fs-7">
      <p class="mb-0">&copy; {{ date('Y') }} {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}. All Rights Reserved. Quality – All – Round.</p>
    </div>
  </div>
</footer>
