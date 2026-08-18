<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 Forbidden | {{ App\Models\Setting::get('site_name', 'Aura Soaps') }} Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #FFF8EF 0%, #FFE9D1 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Manrope', system-ui, sans-serif;
    }
    .forbidden-card {
      max-width: 500px;
      width: 100%;
      background: #FFFFFF;
      border-radius: 20px;
      border: 1px solid #FDE68A;
      box-shadow: 0 15px 35px rgba(217, 119, 6, 0.12);
      padding: 3rem 2.5rem;
    }
    .forbidden-badge {
      width: 80px;
      height: 80px;
      background: rgba(220, 38, 38, 0.1);
      color: #DC2626;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
    }
    .btn-aura {
      background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
      color: #FFF;
      font-weight: 700;
      border: none;
      border-radius: 50px;
      padding: 0.8rem 1.8rem;
    }
    .btn-aura:hover {
      color: #FFF;
      opacity: 0.95;
    }
  </style>
</head>
<body>

<div class="forbidden-card text-center">
  <div class="forbidden-badge">
    <i class="fas fa-shield-cat"></i>
  </div>
  <h2 class="fw-bold text-dark mb-2">403 Forbidden</h2>
  <h5 class="text-secondary fw-semibold mb-3">Access Denied</h5>
  <p class="text-muted fs-7 mb-4">
    You do not have permission to access this module or execute this action. Please contact your Super Administrator if you believe this is an error.
  </p>

  <div class="d-flex align-items-center justify-content-center gap-2">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-aura">
      <i class="fas fa-home me-2"></i> Return to Dashboard
    </a>
  </div>
</div>

</body>
</html>
