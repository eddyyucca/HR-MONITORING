<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login | SCM HR Monitoring</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <style>
    body{background:linear-gradient(135deg,#1e3a5f 0%,#2563a8 100%)}
    .login-box{width:380px}
    .login-card-body{border-radius:.5rem}
    .brand-logo{font-size:2.5rem;margin-bottom:.3rem}
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="text-center mb-3">
    <div class="brand-logo">⛏️</div>
    <h4 class="text-white font-weight-bold mb-0">SCM HR Monitoring</h4>
    <small class="text-white-50">PT Sulawesi Cahaya Mineral — Konawe</small>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg text-muted" style="font-size:.85rem">Masuk untuk melanjutkan</p>
      @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:.82rem">
          <i class="fas fa-exclamation-circle mr-1"></i>{{ $errors->first() }}
        </div>
      @endif
      @if(session('success'))
        <div class="alert alert-success py-2 mb-3" style="font-size:.82rem">{{ session('success') }}</div>
      @endif
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="login" class="form-control @error('login') is-invalid @enderror"
            placeholder="Username atau Email" value="{{ old('login') }}" autofocus required>
          <div class="input-group-append"><div class="input-group-text"><i class="fas fa-user"></i></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append"><div class="input-group-text"><i class="fas fa-lock"></i></div></div>
        </div>
        <div class="row mb-2">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember" style="font-size:.82rem">Ingat saya</label>
            </div>
          </div>
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block btn-sm">
              <i class="fas fa-sign-in-alt mr-1"></i>Masuk
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="text-center mt-2">
    <small class="text-white-50">Default: admin / password123</small>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>
