<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>403 — Akses Ditolak</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>
<body class="hold-transition">
<div class="wrapper">
  <section class="content" style="padding:80px 0">
    <div class="error-page text-center">
      <h2 class="headline text-warning">403</h2>
      <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning mr-2"></i>Akses Ditolak</h3>
        <p>{{ $message ?? 'Anda tidak memiliki hak akses untuk halaman ini.' }}</p>
        <a href="/" class="btn btn-warning">Kembali ke Dashboard</a>
      </div>
    </div>
  </section>
</div>
</body>
</html>
