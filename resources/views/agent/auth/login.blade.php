<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agent Login | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <style>
    body {
      background: linear-gradient(135deg, #070D1E 0%, #0F172A 50%, #1E293B 100%);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }

    .login-card {
      background: #FFFFFF;
      border-radius: 24px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 460px;
      padding: 2.5rem;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-aura {
      background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
      color: #FFF;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      padding: 0.85rem 1.5rem;
      box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);
      transition: all 0.2s ease;
    }
    .btn-aura:hover {
      color: #FFF;
      opacity: 0.95;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.45);
    }

    .form-control {
      border-radius: 10px;
      padding: 0.75rem 1rem;
      border: 1px solid #CBD5E1;
      font-size: 0.95rem;
    }
    .form-control:focus {
      border-color: #F59E0B;
      box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
    }

    .badge-pill {
      background: rgba(245, 158, 11, 0.12);
      color: #D97706;
      border: 1px solid rgba(245, 158, 11, 0.25);
      padding: 0.35rem 0.85rem;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.04em;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="text-center mb-4">
      <div class="mb-3">
        <span class="badge-pill text-uppercase">
          <i class="fas fa-shield-alt me-1"></i> Principal Agent Portal
        </span>
      </div>
      <h3 class="fw-bold text-dark mb-1">Agent Login</h3>
      <p class="text-muted fs-7">Access your wholesale dashboard, client CRM, orders and marketing materials.</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success border-0 rounded-3 py-2 px-3 fs-7 mb-3">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger border-0 rounded-3 py-2 px-3 fs-7 mb-3">
        <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger border-0 rounded-3 py-2 px-3 fs-7 mb-3">
        @foreach($errors->all() as $err)
          <div><i class="fas fa-exclamation-circle me-1"></i> {{ $err }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('agent.login.submit') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label fw-bold fs-7 text-dark">Agent Email Address</label>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-envelope"></i></span>
          <input type="email" name="email" class="form-control border-start-0" placeholder="e.g. agent@aurasoaps.com" value="{{ old('email') }}" required autofocus>
        </div>
      </div>

      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <label class="form-label fw-bold fs-7 text-dark mb-0">Password</label>
          <a href="{{ route('agent.password.request') }}" class="fs-8 text-decoration-none fw-semibold text-warning">Forgot password?</a>
        </div>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-lock"></i></span>
          <input type="password" name="password" class="form-control border-start-0" placeholder="Enter your password" required>
        </div>
      </div>

      <div class="mb-4 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label fs-7 text-secondary" for="remember">Keep me logged in on this device</label>
      </div>

      <button type="submit" class="btn btn-aura w-100 mb-3">
        <span>Sign In to Agent Portal</span>
        <i class="fas fa-arrow-right ms-1.5"></i>
      </button>

      <div class="text-center pt-3 border-top">
        <span class="text-muted fs-7">Not a registered Principal Agent yet?</span>
        <div class="mt-2">
          <a href="{{ route('agent.register') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold fs-8">
            <i class="fas fa-user-plus me-1 text-warning"></i> Apply for Principal Agent Account
          </a>
        </div>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
