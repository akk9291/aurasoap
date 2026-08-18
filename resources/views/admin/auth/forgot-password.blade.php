<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }} Admin</title>
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
    .auth-card {
      max-width: 440px;
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
    .text-amber {
      color: #D97706;
    }
  </style>
</head>
<body>

<div class="auth-card text-center">
  <img src="{{ asset(App\Models\Setting::get('site_logo', 'assets/images/logo.png')) }}" alt="Aura Soaps" class="img-fluid mb-3" style="max-height: 60px;">
  <h4 class="fw-bold mb-1">Reset Your Password</h4>
  <p class="text-muted fs-7 mb-4">Enter your registered admin email address to receive password reset instructions.</p>

  @if (session('status'))
    <div class="alert alert-success text-start fs-7 p-3 mb-3 rounded-3">
      <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger text-start fs-7 p-3 mb-3 rounded-3">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('admin.password.email') }}" method="POST" class="text-start">
    @csrf
    <div class="mb-4">
      <label class="form-label fw-semibold fs-7">Admin Email Address</label>
      <div class="input-group">
        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
        <input type="email" name="email" class="form-control border-start-0" placeholder="admin@aurasoaps.com" value="{{ old('email') }}" required autofocus>
      </div>
    </div>

    <button type="submit" class="btn btn-aura w-100 mb-3">Send Password Reset Link <i class="fas fa-paper-plane ms-2"></i></button>

    <div class="text-center">
      <a href="{{ route('admin.login') }}" class="text-amber fw-semibold text-decoration-none fs-7">
        <i class="fas fa-arrow-left me-1"></i> Back to Login
      </a>
    </div>
  </form>
</div>

</body>
</html>
