<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('page_title', 'Agent Portal') | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }} Principal Agent</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <style>
    :root {
      --agent-sidebar-bg: #090E1A;
      --agent-sidebar-border: rgba(255, 255, 255, 0.08);
      --agent-sidebar-text: #94A3B8;
      --agent-sidebar-hover: #F1F5F9;
      --agent-primary: #F59E0B;
      --agent-primary-dark: #D97706;
      --agent-primary-light: #FEF3C7;
      --agent-primary-glow: rgba(245, 158, 11, 0.25);
      --agent-main-bg: #F8FAFC;
      --agent-card-bg: #FFFFFF;
      --agent-card-border: #E2E8F0;
      --text-main: #0F172A;
      --text-muted: #64748B;
    }

    * {
      box-sizing: border-box;
    }

    body {
      background-color: var(--agent-main-bg);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: var(--text-main);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      overflow-x: hidden;
    }

    /* Typography Scale */
    .fs-7 { font-size: 0.875rem !important; }
    .fs-8 { font-size: 0.8125rem !important; }
    .fs-9 { font-size: 0.725rem !important; }
    .letter-spacing-1 { letter-spacing: 0.06em; }
    .letter-spacing-2 { letter-spacing: 0.1em; }

    /* Custom Badges */
    .badge-soft-success {
      background-color: #ECFDF5 !important;
      color: #065F46 !important;
      border: 1px solid #A7F3D0 !important;
    }
    .badge-soft-primary {
      background-color: #EFF6FF !important;
      color: #1E40AF !important;
      border: 1px solid #BFDBFE !important;
    }
    .badge-soft-warning {
      background-color: #FFFBEB !important;
      color: #92400E !important;
      border: 1px solid #FDE68A !important;
    }
    .badge-soft-info {
      background-color: #F0F9FF !important;
      color: #0369A1 !important;
      border: 1px solid #BAE6FD !important;
    }
    .badge-soft-secondary {
      background-color: #F1F5F9 !important;
      color: #475569 !important;
      border: 1px solid #CBD5E1 !important;
    }

    /* Fixed & Scrollable Sidebar */
    .agent-sidebar {
      width: 275px;
      height: 100vh;
      background: linear-gradient(180deg, #090E1A 0%, #0D1527 100%);
      color: #FFF;
      position: fixed;
      top: 0; left: 0;
      z-index: 1040;
      display: flex;
      flex-direction: column;
      border-right: 1px solid var(--agent-sidebar-border);
      box-shadow: 10px 0 35px rgba(0, 0, 0, 0.25);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .agent-sidebar-header {
      padding: 1.35rem 1.4rem;
      border-bottom: 1px solid var(--agent-sidebar-border);
      background: rgba(0, 0, 0, 0.2);
    }

    .agent-sidebar-brand {
      font-size: 1.12rem;
      font-weight: 800;
      color: #FFFFFF;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      letter-spacing: -0.02em;
    }

    .agent-brand-icon {
      width: 38px;
      height: 38px;
      background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
      color: #FFFFFF;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.05rem;
      box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
    }

    /* Agent User Card in Sidebar */
    .agent-sidebar-profile {
      margin: 1rem 1rem 0.5rem 1rem;
      padding: 0.85rem;
      border-radius: 14px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(8px);
      transition: background 0.2s ease, border-color 0.2s ease;
    }

    .agent-sidebar-profile:hover {
      background: rgba(255, 255, 255, 0.07);
      border-color: rgba(245, 158, 11, 0.35);
    }

    .agent-avatar-circle {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: linear-gradient(135deg, #F59E0B 0%, #B45309 100%);
      color: #FFF;
      font-weight: 800;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .agent-status-dot {
      position: absolute;
      bottom: -2px;
      right: -2px;
      width: 10px;
      height: 10px;
      background-color: #10B981;
      border: 2px solid #090E1A;
      border-radius: 50%;
    }

    .agent-code-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      background: rgba(245, 158, 11, 0.15);
      color: #FCD34D !important;
      border: 1px solid rgba(245, 158, 11, 0.35);
      border-radius: 6px;
      padding: 0.2rem 0.55rem;
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.04em;
    }

    .agent-sidebar-nav {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 0.75rem 0 2rem 0;
    }

    .agent-sidebar-nav::-webkit-scrollbar {
      width: 4px;
    }
    .agent-sidebar-nav::-webkit-scrollbar-thumb {
      background: rgba(245, 158, 11, 0.2);
      border-radius: 4px;
    }

    .agent-nav-section-title {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #64748B;
      margin: 1.25rem 0 0.4rem 0;
      padding: 0 1.5rem;
    }

    .agent-nav-link {
      color: var(--agent-sidebar-text);
      display: flex;
      align-items: center;
      gap: 0.85rem;
      padding: 0.65rem 1rem;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.86rem;
      margin: 0.15rem 0.85rem;
      border-radius: 10px;
      transition: all 0.2s ease;
      position: relative;
    }

    .agent-nav-link i {
      font-size: 0.95rem;
      width: 22px;
      text-align: center;
      color: #64748B;
      transition: all 0.2s ease;
    }

    .agent-nav-link:hover {
      color: var(--agent-sidebar-hover);
      background: rgba(255, 255, 255, 0.05);
      transform: translateX(3px);
    }
    .agent-nav-link:hover i {
      color: #FBBF24;
    }

    .agent-nav-link.active {
      color: #FFFFFF;
      background: linear-gradient(90deg, rgba(245, 158, 11, 0.22) 0%, rgba(245, 158, 11, 0.08) 100%);
      font-weight: 600;
      border: 1px solid rgba(245, 158, 11, 0.3);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .agent-nav-link.active i {
      color: #F59E0B;
    }

    .agent-nav-link.active::before {
      content: '';
      position: absolute;
      left: -0.85rem;
      top: 20%;
      bottom: 20%;
      width: 3.5px;
      background: #F59E0B;
      border-radius: 0 4px 4px 0;
      box-shadow: 0 0 10px #F59E0B;
    }

    /* Main Workspace */
    .agent-wrapper {
      margin-left: 275px;
      min-height: 100vh;
      padding: 1.75rem 2rem 3rem 2rem;
      transition: all 0.3s ease;
    }

    /* Topbar Header */
    .agent-header {
      background: #FFFFFF;
      border-radius: 16px;
      padding: 0.9rem 1.4rem;
      border: 1px solid var(--agent-card-border);
      box-shadow: 0 2px 10px -2px rgba(15, 23, 42, 0.04);
      margin-bottom: 1.5rem;
    }

    /* General Card Design */
    .agent-card {
      background: var(--agent-card-bg);
      border-radius: 18px;
      border: 1px solid var(--agent-card-border);
      box-shadow: 0 2px 8px -2px rgba(15, 23, 42, 0.03), 0 8px 20px -4px rgba(15, 23, 42, 0.04);
      transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .agent-card-hover:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px -4px rgba(15, 23, 42, 0.08);
    }

    /* Aura Gradient Buttons */
    .btn-aura {
      background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
      color: #FFFFFF !important;
      font-weight: 600;
      border: none;
      border-radius: 11px;
      padding: 0.55rem 1.25rem;
      box-shadow: 0 4px 14px rgba(245, 158, 11, 0.28);
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .btn-aura:hover {
      background: linear-gradient(135deg, #FBBF24 0%, #EA580C 100%);
      color: #FFFFFF !important;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }
    .btn-aura:active {
      transform: translateY(0);
    }

    .btn-aura-outline {
      background: #FFFFFF;
      color: #475569;
      font-weight: 600;
      border: 1px solid #CBD5E1;
      border-radius: 11px;
      padding: 0.55rem 1.2rem;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .btn-aura-outline:hover {
      background: #F8FAFC;
      color: #0F172A;
      border-color: #94A3B8;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
      transform: translateY(-1px);
    }

    /* Policy Notice Banner */
    .compliance-banner {
      background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
      border: 1px solid #FDE68A;
      border-radius: 16px;
      padding: 1.1rem 1.4rem;
      box-shadow: 0 4px 14px -2px rgba(245, 158, 11, 0.08);
      margin-bottom: 1.5rem;
    }

    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(9, 14, 26, 0.65);
      backdrop-filter: blur(4px);
      z-index: 1030;
    }

    @media (max-width: 991.98px) {
      .agent-sidebar {
        transform: translateX(-100%);
      }
      .agent-sidebar.show {
        transform: translateX(0);
      }
      .sidebar-overlay.show {
        display: block;
      }
      .agent-wrapper {
        margin-left: 0;
        padding: 1.15rem 1rem 2.5rem 1rem;
      }
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- Mobile Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- Agent Portal Sidebar -->
  <aside class="agent-sidebar" id="agentSidebar">
    <!-- Sidebar Brand -->
    <div class="agent-sidebar-header d-flex align-items-center justify-content-between">
      <a href="{{ route('agent.dashboard') }}" class="agent-sidebar-brand">
        <div class="agent-brand-icon">
          <i class="fas fa-gem"></i>
        </div>
        <div>
          <div class="lh-1 text-white fw-bold" style="font-size: 1.05rem;">Aura Soaps</div>
          <div class="text-warning text-uppercase fw-bold letter-spacing-1 mt-1" style="font-size: 0.62rem;">Principal Portal</div>
        </div>
      </a>
      <button class="btn btn-sm text-white-50 d-lg-none" id="closeSidebarBtn" aria-label="Close sidebar">
        <i class="fas fa-times fs-6"></i>
      </button>
    </div>

    <!-- Agent Identity Card Widget in Sidebar -->
    <div class="agent-sidebar-profile">
      <div class="d-flex align-items-center gap-2.5">
        <div class="agent-avatar-circle flex-shrink-0">
          {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
          <span class="agent-status-dot" title="Active"></span>
        </div>
        <div class="overflow-hidden flex-grow-1">
          <div class="text-white fw-bold fs-8 text-truncate mb-1">{{ auth()->user()->name }}</div>
          <div>
            <span class="agent-code-badge">
              <i class="fas fa-shield-alt text-warning"></i> {{ auth()->user()->agentProfile->agent_code ?? 'AS-AGT-1001' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="agent-sidebar-nav">
      <div class="agent-nav-section-title">Core Workspace</div>
      <a href="{{ route('agent.dashboard') }}" class="agent-nav-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-pie"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('agent.profile') }}" class="agent-nav-link {{ request()->routeIs('agent.profile') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i>
        <span>My Profile</span>
      </a>
      <a href="{{ route('agent.business') }}" class="agent-nav-link {{ request()->routeIs('agent.business') ? 'active' : '' }}">
        <i class="fas fa-building"></i>
        <span>My Business</span>
      </a>

      <div class="agent-nav-section-title">Catalogue & Wholesale</div>
      <a href="{{ route('agent.products.index') }}" class="agent-nav-link {{ request()->routeIs('agent.products.*') ? 'active' : '' }}">
        <i class="fas fa-boxes-stacked"></i>
        <span>Product Catalogue</span>
      </a>
      <a href="{{ route('agent.wholesale-prices') }}" class="agent-nav-link {{ request()->routeIs('agent.wholesale-prices') ? 'active' : '' }}">
        <i class="fas fa-tags"></i>
        <span>Wholesale Prices</span>
      </a>
      <a href="{{ route('agent.marketing.index') }}" class="agent-nav-link {{ request()->routeIs('agent.marketing.*') ? 'active' : '' }}">
        <i class="fas fa-bullhorn"></i>
        <span>Marketing Materials</span>
      </a>

      <div class="agent-nav-section-title">Buyers & Pipeline</div>
      <a href="{{ route('agent.clients.index') }}" class="agent-nav-link {{ request()->routeIs('agent.clients.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i>
        <span>My Clients / Buyers</span>
      </a>
      <a href="{{ route('agent.enquiries.index') }}" class="agent-nav-link {{ request()->routeIs('agent.enquiries.*') ? 'active' : '' }}">
        <i class="fas fa-comments"></i>
        <span>My Enquiries</span>
      </a>

      <div class="agent-nav-section-title">Orders Management</div>
      <a href="{{ route('agent.orders.create') }}" class="agent-nav-link {{ request()->routeIs('agent.orders.create') ? 'active' : '' }}">
        <i class="fas fa-cart-plus"></i>
        <span>Place Order</span>
      </a>
      <a href="{{ route('agent.orders.index') }}" class="agent-nav-link {{ request()->routeIs('agent.orders.index') || request()->routeIs('agent.orders.show') ? 'active' : '' }}">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>My Orders</span>
      </a>

      <div class="agent-nav-section-title">Compliance & Support</div>
      <a href="{{ route('agent.documents.index') }}" class="agent-nav-link {{ request()->routeIs('agent.documents.*') ? 'active' : '' }}">
        <i class="fas fa-folder-open"></i>
        <span>Documents</span>
      </a>
      <a href="{{ route('agent.support.index') }}" class="agent-nav-link {{ request()->routeIs('agent.support.*') ? 'active' : '' }}">
        <i class="fas fa-headset"></i>
        <span>Support Helpdesk</span>
      </a>
    </nav>
  </aside>

  <!-- Main Agent Workspace -->
  <div class="agent-wrapper">
    <!-- Topbar Header -->
    <header class="agent-header d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light d-lg-none border rounded-3 px-2 py-1" id="toggleSidebarBtn" aria-label="Toggle menu">
          <i class="fas fa-bars"></i>
        </button>
        <div>
          <h4 class="mb-0 fw-bold text-dark fs-5">@yield('page_title', 'Dashboard')</h4>
          <span class="fs-8 text-muted d-none d-sm-inline">
            <i class="fas fa-building text-warning me-1"></i> {{ auth()->user()->agentProfile->company_name ?? 'Principal Agent' }}
            <span class="mx-1">&bull;</span>
            <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ auth()->user()->agentProfile->city ?? 'Rwanda' }}
          </span>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2 gap-sm-3">
        <!-- Quick Action: Place Order -->
        <a href="{{ route('agent.orders.create') }}" class="btn btn-aura btn-sm d-none d-md-inline-flex">
          <i class="fas fa-plus-circle"></i>
          <span>New Order</span>
        </a>

        <!-- User Dropdown -->
        <div class="dropdown">
          <button class="btn btn-light dropdown-toggle border rounded-pill px-3 py-1.5 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold fs-8 text-white" style="width: 28px; height: 28px; background: linear-gradient(135deg, #F59E0B, #D97706);">
              {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <span class="fw-semibold text-dark fs-7 d-none d-sm-inline">{{ auth()->user()->name }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2" style="min-width: 220px;">
            <li>
              <div class="px-3 py-2">
                <div class="fw-bold text-dark fs-7">{{ auth()->user()->name }}</div>
                <div class="fs-9 text-muted font-monospace">{{ auth()->user()->agentProfile->agent_code ?? 'AGENT' }}</div>
              </div>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item rounded-3 fs-7 py-2" href="{{ route('agent.profile') }}"><i class="fas fa-id-card me-2 text-warning"></i> My Profile</a></li>
            <li><a class="dropdown-item rounded-3 fs-7 py-2" href="{{ route('agent.business') }}"><i class="fas fa-building me-2 text-primary"></i> Business Details</a></li>
            <li><a class="dropdown-item rounded-3 fs-7 py-2" href="{{ route('agent.support.index') }}"><i class="fas fa-headset me-2 text-info"></i> Contact Support</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li>
              <form action="{{ route('agent.logout') }}" method="POST">
                @csrf
                <button class="dropdown-item rounded-3 fs-7 py-2 text-danger" type="submit"><i class="fas fa-sign-out-alt me-2"></i> Log Out</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <!-- Government Tender Policy Compliance Alert Banner -->
    @php
      $profile = auth()->user()->agentProfile;
    @endphp
    @if($profile && $profile->gov_tender_permission !== 'approved')
      <div class="compliance-banner d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-warning shadow-sm flex-shrink-0" style="width: 42px; height: 42px; background: rgba(245, 158, 11, 0.18);">
            <i class="fas fa-gavel fs-6"></i>
          </div>
          <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <strong class="fs-7 text-dark fw-bold">Official Policy Notice: Government Tender Restriction</strong>
              <span class="badge badge-soft-warning rounded-pill fs-9 fw-bold px-2 py-0.5">
                Compliance Requirement
              </span>
            </div>
            <div class="fs-8 text-secondary mt-0.5">
              @if($profile->gov_tender_permission === 'requested')
                <span class="badge badge-soft-info me-1">Permission Requested</span> Your government tender authorization request is currently pending review by Aura Soaps Management.
              @else
                Agents are strictly not permitted to participate in Government Tenders without written approval from Aura Soaps Management.
              @endif
            </div>
          </div>
        </div>
        @if($profile->gov_tender_permission === 'not_permitted')
          <a href="{{ route('agent.business') }}" class="btn btn-sm btn-dark rounded-pill px-3.5 py-1.5 fs-8 fw-semibold shadow-sm">
            <i class="fas fa-paper-plane me-1 text-warning"></i> Request Authorization
          </a>
        @endif
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle fs-5 me-2.5 text-success"></i>
        <div class="fs-7">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle fs-5 me-2.5 text-danger"></i>
        <div class="fs-7">{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('info'))
      <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
        <i class="fas fa-info-circle fs-5 me-2.5 text-info"></i>
        <div class="fs-7">{{ session('info') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('agentSidebar');
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
    });
  </script>
  @stack('scripts')
</body>
</html>
