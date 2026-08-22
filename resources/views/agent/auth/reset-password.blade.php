<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Set New Password | Agent Portal | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      <h4 class="fw-bold text-dark">Setup New Password</h4>
      <p class="text-muted fs-7">Create a secure password for your Principal Agent Portal account.</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger fs-8">
        @foreach($errors->all() as $err)
          <div>{{ $err }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('agent.password.update') }}" method="POST">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label class="form-label fw-bold fs-7">Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold fs-7">New Password</label>
        <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold fs-7">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
      </div>

      <button type="submit" class="btn btn-aura w-100 mb-3">Update Password & Proceed</button>
    </form>
  </div>
</body>
</html>
