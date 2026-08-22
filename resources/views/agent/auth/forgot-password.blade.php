<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | Agent Portal | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #070D1E 0%, #0F172A 100%);
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .card-box {
      background: #FFFFFF;
      border-radius: 20px;
      width: 100%;
      max-width: 440px;
      padding: 2.5rem;
    }
    .btn-aura {
      background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
      color: #FFF;
      font-weight: 700;
      border: none;
      border-radius: 10px;
      padding: 0.75rem;
    }
  </style>
</head>
<body>
  <div class="card-box shadow">
    <div class="text-center mb-4">
      <h4 class="fw-bold text-dark">Password Recovery</h4>
      <p class="text-muted fs-7">Enter your registered Agent email address to receive password reset instructions.</p>
    </div>

    @if(session('status'))
      <div class="alert alert-success fs-7">{{ session('status') }}</div>
    @endif

    <form action="{{ route('agent.password.email') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label fw-bold fs-7">Agent Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="agent@aurasoaps.com" required autofocus>
      </div>

      <button type="submit" class="btn btn-aura w-100 mb-3">Send Reset Link</button>

      <div class="text-center">
        <a href="{{ route('agent.login') }}" class="fs-8 text-decoration-none text-muted"><i class="fas fa-arrow-left me-1"></i> Back to Agent Login</a>
      </div>
    </form>
  </div>
</body>
</html>
