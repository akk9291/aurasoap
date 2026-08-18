<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #FFF8EF 0%, #FFE9D1 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      max-width: 420px;
      width: 100%;
      background: #FFFFFF;
      border-radius: 20px;
      border: 1px solid #FDE68A;
      box-shadow: 0 15px 35px rgba(217, 119, 6, 0.12);
      padding: 2.5rem;
    }
    .btn-aura {
      background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
      color: #FFF;
      font-weight: 700;
      border: none;
      border-radius: 50px;
      padding: 0.8rem 1.5rem;
    }
    .btn-aura:hover {
      color: #FFF;
      opacity: 0.95;
    }
  </style>
</head>
<body>

<div class="login-card text-center">
  <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="Aura Soaps" class="img-fluid mb-3" style="max-height: 60px;">
  <h4 class="fw-bold mb-1">Admin Portal</h4>
  <p class="text-muted fs-7 mb-4">Sign in to manage {{ App\Models\Setting::get('site_name', 'Aura Soaps') }} CMS</p>

  @if($errors->any())
    <div class="alert alert-danger text-start fs-7 p-2 mb-3">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('admin.login.submit') }}" method="POST" class="text-start">
    @csrf
    <div class="mb-3">
      <label class="form-label fw-semibold fs-7">Email Address</label>
      <div class="input-group">
        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
        <input type="email" name="email" class="form-control border-start-0" placeholder="admin@aurasoaps.com" value="{{ old('email') }}" required autofocus>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold fs-7">Password</label>
      <div class="input-group">
        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
        <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
      </div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4 fs-7">
      <div class="form-check">
        <input type="checkbox" name="remember" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Remember me</label>
      </div>
      <a href="{{ route('admin.password.request') }}" class="text-amber fw-semibold text-decoration-none">Forgot Password?</a>
    </div>

    <button type="submit" class="btn btn-aura w-100 mb-2">Sign In to Dashboard <i class="fas fa-arrow-right ms-2"></i></button>
  </form>
</div>

</body>
</html>
