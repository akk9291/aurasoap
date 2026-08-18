<header>
  <nav class="navbar navbar-expand-lg navbar-aura" id="mainNavbar">
    <div class="container-custom d-flex align-items-center justify-content-between">
      
      <!-- Logo -->
      <a class="navbar-brand-aura" href="{{ route('home') }}" id="brandLogo">
        <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="{{ App\Models\Setting::get('site_name', 'Aura Soaps') }}" class="brand-logo-img">
      </a>

      <!-- Mobile Toggler -->
      <button class="navbar-toggler navbar-toggler-aura d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Desktop Navigation -->
      <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end align-items-center">
        <ul class="navbar-nav me-4 gap-1">
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a></li>
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a></li>
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('ingredients.*') ? 'active' : '' }}" href="{{ route('ingredients.index') }}">Ingredients</a></li>
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('agent.locator') ? 'active' : '' }}" href="{{ route('agent.locator') }}">Find Agent</a></li>
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('agent.portal') ? 'active' : '' }}" href="{{ route('agent.portal') }}">Agent Portal</a></li>
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a></li>
          <li class="nav-item"><a class="nav-link nav-link-aura {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
        </ul>
        <a href="{{ route('distributor') }}" class="btn-aura-primary">
          <span>Become Agent</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>

    </div>
  </nav>
</header>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-end offcanvas-aura" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
  <div class="offcanvas-header border-bottom">
    <div class="d-flex align-items-center gap-2">
      <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="{{ App\Models\Setting::get('site_name', 'Aura Soaps') }}" style="height: 42px; width: auto;">
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column justify-content-between py-4">
    <ul class="navbar-nav gap-3">
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" data-bs-dismiss="offcanvas">Home</a></li>
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}" data-bs-dismiss="offcanvas">About Us</a></li>
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}" data-bs-dismiss="offcanvas">Products</a></li>
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('ingredients.*') ? 'active' : '' }}" href="{{ route('ingredients.index') }}" data-bs-dismiss="offcanvas">Ingredients</a></li>
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('agent.locator') ? 'active' : '' }}" href="{{ route('agent.locator') }}" data-bs-dismiss="offcanvas">Find Agent</a></li>
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('agent.portal') ? 'active' : '' }}" href="{{ route('agent.portal') }}" data-bs-dismiss="offcanvas">Agent Portal</a></li>
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}" data-bs-dismiss="offcanvas">Blog</a></li>
      <li class="nav-item"><a class="nav-link nav-link-aura fs-5 {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}" data-bs-dismiss="offcanvas">Contact Us</a></li>
    </ul>
    <div class="pt-4 border-top">
      <a href="{{ route('distributor') }}" class="btn-aura-primary w-100 text-center">
        <span>Become Agent</span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</div>
