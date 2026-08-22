<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('page_title', 'Dashboard') | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }} CMS</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <style>
    :root {
      --admin-sidebar-bg: #0F172A;
      --admin-sidebar-text: #94A3B8;
      --admin-sidebar-active: #F59E0B;
      --admin-topbar-bg: #FFFFFF;
      --admin-main-bg: #F8FAFC;
    }

    body {
      background-color: var(--admin-main-bg);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: #1E293B;
    }

    /* Fixed & Scrollable Sidebar */
    .admin-sidebar {
      width: 270px;
      height: 100vh;
      background: var(--admin-sidebar-bg);
      color: #FFF;
      position: fixed;
      top: 0; left: 0;
      z-index: 1040;
      display: flex;
      flex-direction: column;
      box-shadow: 4px 0 25px rgba(15, 23, 42, 0.15);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-sidebar-header {
      padding: 1.5rem 1.25rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      background: #0B1120;
    }

    .admin-sidebar-brand {
      font-size: 1.2rem;
      font-weight: 800;
      color: #F59E0B;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      letter-spacing: -0.02em;
    }

    .admin-sidebar-brand i {
      width: 36px;
      height: 36px;
      background: rgba(245, 158, 11, 0.15);
      color: #F59E0B;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
    }

    /* Scrollable Container for Navigation */
    .admin-sidebar-nav {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 1rem 0 2rem 0;
    }

    .admin-sidebar-nav::-webkit-scrollbar {
      width: 5px;
    }
    .admin-sidebar-nav::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.02);
    }
    .admin-sidebar-nav::-webkit-scrollbar-thumb {
      background: rgba(245, 158, 11, 0.25);
      border-radius: 4px;
    }
    .admin-sidebar-nav::-webkit-scrollbar-thumb:hover {
      background: rgba(245, 158, 11, 0.5);
    }

    .admin-nav-section-title {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #64748B;
      margin: 1.25rem 0 0.5rem 0;
      padding: 0 1.25rem;
    }

    .admin-nav-link {
      color: var(--admin-sidebar-text);
      display: flex;
      align-items: center;
      gap: 0.85rem;
      padding: 0.75rem 1.25rem;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.9rem;
      margin: 0.15rem 0.75rem;
      border-radius: 10px;
      transition: all 0.2s ease;
    }

    .admin-nav-link i {
      font-size: 1rem;
      width: 22px;
      text-align: center;
      color: #64748B;
      transition: color 0.2s ease;
    }

    .admin-nav-link:hover {
      color: #F8FAFC;
      background: rgba(255, 255, 255, 0.06);
    }
    .admin-nav-link:hover i {
      color: #F59E0B;
    }

    .admin-nav-link.active {
      color: #FFFFFF;
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.15) 100%);
      font-weight: 600;
      border-left: 3px solid #F59E0B;
    }
    .admin-nav-link.active i {
      color: #F59E0B;
    }

    /* Main Content Area */
    .admin-wrapper {
      margin-left: 270px;
      min-height: 100vh;
      padding: 2rem;
      transition: all 0.3s ease;
    }

    /* Top Navbar */
    .admin-header {
      background: #FFFFFF;
      border-radius: 16px;
      padding: 1rem 1.5rem;
      border: 1px solid #E2E8F0;
      box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03);
      margin-bottom: 2rem;
    }

    .admin-card {
      background: #FFFFFF;
      border-radius: 16px;
      border: 1px solid #E2E8F0;
      box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .admin-card:hover {
      box-shadow: 0 10px 25px -4px rgba(15, 23, 42, 0.07);
    }

    .stat-card-icon {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.35rem;
    }

    .btn-aura {
      background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
      color: #FFF;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      padding: 0.6rem 1.25rem;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
    }
    .btn-aura:hover {
      color: #FFF;
      opacity: 0.95;
      transform: translateY(-1px);
    }

    /* CKEditor Custom Styling */
    .ck-editor__editable_inline {
      min-height: 200px;
      border-bottom-left-radius: 10px !important;
      border-bottom-right-radius: 10px !important;
    }
    .ck-toolbar {
      border-top-left-radius: 10px !important;
      border-top-right-radius: 10px !important;
      background: #F8FAFC !important;
    }

    /* Sidebar Mobile Overlay */
    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(4px);
      z-index: 1030;
    }

    @media (max-width: 991.98px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }
      .admin-sidebar.show {
        transform: translateX(0);
      }
      .sidebar-overlay.show {
        display: block;
      }
      .admin-wrapper {
        margin-left: 0;
        padding: 1.25rem;
      }
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- Mobile Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- Scrollable Fixed Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-header d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand">
        <i class="fas fa-soap"></i>
        <span>Aura CMS</span>
      </a>
      <button class="btn btn-sm text-white-50 d-lg-none" id="closeSidebarBtn">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <nav class="admin-sidebar-nav">
      <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-pie"></i>
        <span>Dashboard</span>
      </a>

      @if(auth()->user()->hasRole(['super-admin', 'admin', 'content-manager']))
        <div class="admin-nav-section-title">Catalog Management</div>
        <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
          <i class="fas fa-box"></i>
          <span>Products</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
          <i class="fas fa-layer-group"></i>
          <span>Categories</span>
        </a>
        <a href="{{ route('admin.ingredients.index') }}" class="admin-nav-link {{ request()->routeIs('admin.ingredients.*') ? 'active' : '' }}">
          <i class="fas fa-leaf"></i>
          <span>Ingredients</span>
        </a>

        <div class="admin-nav-section-title">Content & Marketing</div>
        <a href="{{ route('admin.blog.index') }}" class="admin-nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
          <i class="fas fa-newspaper"></i>
          <span>Blog Articles</span>
        </a>
        <a href="{{ route('admin.faqs.index') }}" class="admin-nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
          <i class="fas fa-question-circle"></i>
          <span>FAQs</span>
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="admin-nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
          <i class="fas fa-star"></i>
          <span>Testimonials</span>
        </a>
        <a href="{{ route('admin.agents.index') }}" class="admin-nav-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
          <i class="fas fa-map-marked-alt"></i>
          <span>Principal Agents</span>
        </a>
      @endif

      @if(auth()->user()->hasRole(['super-admin', 'admin', 'enquiry-manager']))
        <div class="admin-nav-section-title">Agent Portal Management</div>
        <a href="{{ route('admin.agent_management.index') }}" class="admin-nav-link {{ request()->routeIs('admin.agent_management.index') || request()->routeIs('admin.agent_management.show') ? 'active' : '' }}">
          <i class="fas fa-id-card-alt"></i>
          <span>Agent Accounts</span>
        </a>
        <a href="{{ route('admin.agent_management.orders') }}" class="admin-nav-link {{ request()->routeIs('admin.agent_management.orders*') ? 'active' : '' }}">
          <i class="fas fa-file-invoice-dollar"></i>
          <span>Agent Orders</span>
        </a>
        <a href="{{ route('admin.agent_management.marketing') }}" class="admin-nav-link {{ request()->routeIs('admin.agent_management.marketing*') ? 'active' : '' }}">
          <i class="fas fa-bullhorn"></i>
          <span>Agent Marketing CMS</span>
        </a>
        <a href="{{ route('admin.agent_management.support') }}" class="admin-nav-link {{ request()->routeIs('admin.agent_management.support*') ? 'active' : '' }}">
          <i class="fas fa-headset"></i>
          <span>Agent Support Desk</span>
        </a>

        <div class="admin-nav-section-title">Enquiries & Leads</div>
        <a href="{{ route('admin.distributors.index') }}" class="admin-nav-link {{ request()->routeIs('admin.distributors.*') ? 'active' : '' }}">
          <i class="fas fa-user-tie"></i>
          <span>Distributor Applications</span>
        </a>
        <a href="{{ route('admin.enquiries.index') }}" class="admin-nav-link {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
          <i class="fas fa-envelope"></i>
          <span>Contact Messages</span>
        </a>
        <a href="{{ route('admin.subscribers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
          <i class="fas fa-paper-plane"></i>
          <span>Newsletter Subscribers</span>
        </a>
      @endif

      @if(auth()->user()->hasRole(['super-admin', 'admin', 'seo-manager']))
        <div class="admin-nav-section-title">SEO & Media</div>
        <a href="{{ route('admin.seo.index') }}" class="admin-nav-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
          <i class="fas fa-search"></i>
          <span>SEO Meta Manager</span>
        </a>
        <a href="{{ route('admin.media.index') }}" class="admin-nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
          <i class="fas fa-images"></i>
          <span>Media Library</span>
        </a>
        <a href="{{ route('admin.redirects.index') }}" class="admin-nav-link {{ request()->routeIs('admin.redirects.*') ? 'active' : '' }}">
          <i class="fas fa-exchange-alt"></i>
          <span>301 Redirects</span>
        </a>
      @endif

      @if(auth()->user()->hasRole('super-admin'))
        <div class="admin-nav-section-title">System Administration</div>
        <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
          <i class="fas fa-users-cog"></i>
          <span>Users & Roles</span>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
          <i class="fas fa-cog"></i>
          <span>Website Settings</span>
        </a>
      @endif
    </nav>
  </aside>

  <!-- Main Workspace -->
  <div class="admin-wrapper">
    <!-- Topbar Header -->
    <header class="admin-header d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light d-lg-none border rounded-3 px-2 py-1" id="toggleSidebarBtn">
          <i class="fas fa-bars"></i>
        </button>
        <h4 class="mb-0 fw-bold text-dark fs-5">@yield('page_title', 'Dashboard')</h4>
      </div>

      <div class="d-flex align-items-center gap-3">
        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-3 fw-semibold text-secondary">
          <i class="fas fa-external-link-alt me-1.5 text-warning"></i> View Website
        </a>

        <div class="dropdown">
          <button class="btn btn-light dropdown-toggle border rounded-pill px-3 py-1.5 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-weight: 700; font-size: 0.8rem;">
              {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <span class="fw-semibold text-dark fs-7">{{ auth()->user()->name ?? 'Admin' }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2 p-2">
            <li><a class="dropdown-item rounded-3 fs-7" href="{{ route('admin.profile') }}"><i class="fas fa-id-card me-2 text-muted"></i> Profile & Password</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li>
              <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="dropdown-item rounded-3 fs-7 text-danger" type="submit"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- CKEditor 5 CDN -->
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('adminSidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const toggleBtn = document.getElementById('toggleSidebarBtn');
      const closeBtn = document.getElementById('closeSidebarBtn');

      if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
          sidebar.classList.add('show');
          overlay.classList.add('show');
        });
      }

      function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
      }

      if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
      if (overlay) overlay.addEventListener('click', closeSidebar);

      // Initialize CKEditor on all .rich-editor elements
      document.querySelectorAll('.rich-editor').forEach(function(element) {
        ClassicEditor
          .create(element, {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
          })
          .catch(error => {
            console.error(error);
          });
      });
    });
  </script>
  @stack('scripts')
</body>
</html>
