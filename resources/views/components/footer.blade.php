<footer class="footer-aura pt-5 mt-5">
  <div class="container-custom">
    <div class="row gy-4 pb-5 border-bottom border-amber-light">
      <div class="col-lg-4 col-md-6">
        <a href="{{ route('home') }}" class="d-inline-block mb-3">
          <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="{{ App\Models\Setting::get('site_name', 'Aura Soaps') }}" class="footer-logo-img">
        </a>
        <p class="text-muted-custom fs-7 pe-lg-4">
          {{ App\Models\Setting::get('site_description', 'Handcrafted natural soaps and eco-friendly skincare created with cold-pressed organic botanical oils.') }}
        </p>
        <div class="d-flex gap-2 mt-3">
          @if(App\Models\Setting::get('social_facebook'))
            <a href="{{ App\Models\Setting::get('social_facebook') }}" target="_blank" class="social-icon-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          @endif
          @if(App\Models\Setting::get('social_instagram'))
            <a href="{{ App\Models\Setting::get('social_instagram') }}" target="_blank" class="social-icon-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          @endif
          @if(App\Models\Setting::get('social_linkedin'))
            <a href="{{ App\Models\Setting::get('social_linkedin') }}" target="_blank" class="social-icon-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          @endif
          @if(App\Models\Setting::get('social_youtube'))
            <a href="{{ App\Models\Setting::get('social_youtube') }}" target="_blank" class="social-icon-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
          @endif
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-6">
        <h5 class="font-heading mb-3 text-dark">Quick Links</h5>
        <ul class="list-unstyled footer-links fs-7 d-flex flex-column gap-2">
          <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Home</a></li>
          <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> About Us</a></li>
          <li><a href="{{ route('products.index') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Products</a></li>
          <li><a href="{{ route('ingredients.index') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Botanical Ingredients</a></li>
          <li><a href="{{ route('distributor') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Become Agent</a></li>
          <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Contact Us</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 col-6">
        <h5 class="font-heading mb-3 text-dark">Legal & Support</h5>
        <ul class="list-unstyled footer-links fs-7 d-flex flex-column gap-2">
          <li><a href="{{ route('faq') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> FAQs & Help</a></li>
          <li><a href="{{ route('policy.privacy') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Privacy Policy</a></li>
          <li><a href="{{ route('policy.terms') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Terms & Conditions</a></li>
          <li><a href="{{ route('policy.returns') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Return Policy</a></li>
          <li><a href="{{ route('policy.shipping') }}"><i class="fas fa-chevron-right me-1 fs-8"></i> Shipping Policy</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h5 class="font-heading mb-3 text-dark">Newsletter</h5>
        <p class="text-muted-custom fs-7 mb-3">Subscribe for exclusive wellness tips and new organic batch releases.</p>
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
      <p class="mb-0">&copy; {{ date('Y') }} {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}. All Rights Reserved. Pure Organic Botanical Skincare.</p>
    </div>
  </div>
</footer>
