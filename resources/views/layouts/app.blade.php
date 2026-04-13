<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Dashboard') | SCM HR Monitoring</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap4-theme/1.0.0/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">

  <style>
  /* =======================================================================
     SCM HR Monitoring — Global Theme Override
  ======================================================================= */
  :root {
    --primary   : #4361ee;
    --success   : #10b981;
    --warning   : #f59e0b;
    --danger    : #ef4444;
    --info      : #06b6d4;
    --purple    : #8b5cf6;
    --sidebar-bg: #1e293b;
    --body-bg   : #f0f2f5;
    --card-sh   : 0 2px 16px rgba(0,0,0,.07);
    --radius    : .6rem;
    --trans     : all .2s ease;
  }

  /* ── Base ── */
  body {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    background: var(--body-bg) !important;
    font-size: 13px;
    color: #374151;
  }
  /* Apply Inter to text elements only — NEVER use * selector, it breaks Font Awesome */
  .content-wrapper, .main-header, .main-sidebar, .main-footer,
  h1, h2, h3, h4, h5, h6,
  p, td, th, label, input, select, textarea, button,
  .card-title, .nav-link p, .breadcrumb-item, .dropdown-item,
  .badge, .btn, .alert, .form-control, .info-box-text, .info-box-number {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
  }

  /* ── Sidebar ── */
  .main-sidebar {
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%) !important;
    box-shadow: 3px 0 16px rgba(0,0,0,.2) !important;
  }
  .brand-link {
    background: rgba(0,0,0,.3) !important;
    border-bottom: 1px solid rgba(255,255,255,.07) !important;
    padding: .7rem .9rem !important;
  }
  .brand-text { font-size: .85rem !important; letter-spacing: .3px; }

  .nav-sidebar .nav-link {
    border-radius: .45rem;
    margin: 1px 8px;
    padding: .48rem .8rem !important;
    transition: var(--trans);
  }
  .nav-sidebar .nav-link p       { font-size: .78rem !important; font-weight: 500; }
  .nav-sidebar .nav-icon         { width: 1.4rem; font-size: .82rem; }
  .nav-header                    { font-size: .6rem !important; letter-spacing: 1px; opacity: .4; padding: .8rem 1rem .3rem; }
  .user-panel                    { border-bottom: 1px solid rgba(255,255,255,.08) !important; }

  .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
    background: rgba(255,255,255,.07) !important;
    color: #fff !important;
  }
  .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
    background: linear-gradient(90deg, var(--primary), #3a0ca3) !important;
    box-shadow: 0 4px 14px rgba(67,97,238,.4) !important;
    color: #fff !important;
  }

  /* ── Topbar ── */
  .main-header.navbar {
    background: #fff !important;
    border-bottom: 1px solid #e9ecef !important;
    box-shadow: 0 1px 8px rgba(0,0,0,.07) !important;
    min-height: 52px;
  }

  /* ── Content ── */
  .content-wrapper { background: var(--body-bg) !important; }
  .content-header  { padding: 12px 0 4px; }
  .content-header h1 {
    font-size: 1.1rem !important; font-weight: 700; color: #1e293b;
    display: flex; align-items: center; gap: .4rem;
  }
  .breadcrumb {
    background: transparent !important;
    font-size: .73rem; padding: .3rem 0;
  }
  .breadcrumb-item + .breadcrumb-item::before { color: #cbd5e1; }

  /* ── Cards ── */
  .card {
    border: none !important;
    border-radius: var(--radius) !important;
    box-shadow: var(--card-sh) !important;
    transition: var(--trans);
  }
  .card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.1) !important; }

  .card-header {
    background: transparent !important;
    border-bottom: 1px solid rgba(0,0,0,.05) !important;
    padding: .6rem 1rem !important;
    display: flex; align-items: center;
  }
  .card-header .card-title {
    font-size: .8rem !important; font-weight: 700;
    color: #374151; margin: 0; display: flex; align-items: center; gap: .35rem;
  }
  .card-header .card-tools { margin-left: auto; }
  .card-body { padding: .85rem 1rem !important; }

  .card-outline.card-primary { border-top: 3px solid var(--primary)  !important; }
  .card-outline.card-success { border-top: 3px solid var(--success)  !important; }
  .card-outline.card-warning { border-top: 3px solid var(--warning)  !important; }
  .card-outline.card-info    { border-top: 3px solid var(--info)     !important; }
  .card-outline.card-danger  { border-top: 3px solid var(--danger)   !important; }

  /* ── KPI Gradient Cards ── */
  .kpi-card {
    border-radius: var(--radius);
    padding: 1.1rem 1.2rem 2rem;
    color: #fff;
    position: relative; overflow: hidden;
    box-shadow: var(--card-sh);
    transition: var(--trans);
    margin-bottom: 1rem;
  }
  .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,.16); }
  .kpi-card::after {
    content: ''; position: absolute;
    right: -20px; bottom: -20px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,.1);
  }
  .kpi-card::before {
    content: ''; position: absolute;
    right: 20px; bottom: -40px;
    width: 70px; height: 70px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
  }
  .kpi-top         { display: flex; align-items: flex-start; justify-content: space-between; }
  .kpi-value       { font-size: 1.75rem; font-weight: 700; line-height: 1; margin-bottom: .25rem; }
  .kpi-label       { font-size: .7rem; font-weight: 600; opacity: .85; text-transform: uppercase; letter-spacing: .5px; }
  .kpi-sub         { font-size: .68rem; opacity: .65; margin-top: .3rem; }
  .kpi-icon        { font-size: 2.1rem; opacity: .2; flex-shrink: 0; margin-left: .5rem; margin-top: -.1rem; }
  .kpi-footer {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,.15);
    padding: .28rem 1.2rem;
    font-size: .68rem; color: rgba(255,255,255,.75);
    display: flex; align-items: center; justify-content: space-between;
    text-decoration: none; transition: var(--trans);
  }
  .kpi-footer:hover { background: rgba(0,0,0,.28); color: #fff; text-decoration: none; }

  .kpi-blue   { background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); }
  .kpi-green  { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
  .kpi-amber  { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
  .kpi-cyan   { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
  .kpi-red    { background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); }
  .kpi-purple { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
  .kpi-slate  { background: linear-gradient(135deg, #64748b 0%, #475569 100%); }

  /* ── Stat Strip (rekrutmen row) ── */
  .stat-strip {
    background: #fff; border-radius: var(--radius);
    padding: .75rem 1rem;
    display: flex; align-items: center; gap: .75rem;
    box-shadow: var(--card-sh);
    margin-bottom: 1rem;
    transition: var(--trans);
  }
  .stat-strip:hover { box-shadow: 0 4px 20px rgba(0,0,0,.1); transform: translateY(-1px); }
  .stat-icon {
    width: 44px; height: 44px; border-radius: .5rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
  }
  .stat-value { font-size: 1.35rem; font-weight: 700; color: #1e293b; line-height: 1; }
  .stat-label { font-size: .69rem; color: #64748b; font-weight: 500; margin-top: .1rem; }
  .stat-bar   { height: 3px; border-radius: 2px; background: #f1f5f9; margin-top: .45rem; overflow: hidden; }
  .stat-bar-fill { height: 100%; border-radius: 2px; transition: width .8s cubic-bezier(.4,0,.2,1); }
  .stat-pct   { font-size: .7rem; font-weight: 700; min-width: 32px; text-align: right; }

  /* ── Tables ── */
  .table th {
    font-size: .68rem !important; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: #6b7280; border-top: none !important;
  }
  .table-sm td, .table-sm th { padding: .4rem .65rem !important; }
  thead.thead-dark th {
    background: #1e293b !important;
    color: #94a3b8 !important;
    font-size: .67rem !important;
    border: none !important;
  }
  .table-hover tbody tr:hover { background: #f8fafc; }

  /* ── Form Controls (normalize all sizes) ── */
  .form-control,
  .form-control-sm {
    height: 34px;
    padding: .3rem .7rem;
    font-size: .82rem;
    border-radius: .4rem;
    border: 1px solid #e2e8f0;
    color: #374151;
    background-color: #fff;
    transition: border-color .15s, box-shadow .15s;
    line-height: 1.5;
  }
  textarea.form-control,
  textarea.form-control-sm { height: auto; min-height: 68px; resize: vertical; }
  .form-control:focus,
  .form-control-sm:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(67,97,238,.12);
    outline: none;
  }
  .form-control.is-invalid,
  .form-control-sm.is-invalid { border-color: var(--danger); }
  .invalid-feedback { font-size: .72rem; }

  .form-group { margin-bottom: .85rem; }
  .form-group > label {
    font-size: .72rem; font-weight: 600; color: #475569;
    margin-bottom: .28rem; display: block; line-height: 1.4;
  }

  /* ── Select2 overrides ── */
  .select2-container { width: 100% !important; }
  .select2-container--bootstrap4 .select2-selection--single {
    height: 34px !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: .4rem !important;
    background: #fff !important;
  }
  .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    line-height: 32px !important;
    padding: 0 .7rem !important;
    font-size: .82rem !important;
    color: #374151 !important;
  }
  .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
    color: #adb5bd !important;
  }
  .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
    height: 34px !important; top: 0 !important;
  }
  .select2-container--bootstrap4.select2-container--focus .select2-selection--single,
  .select2-container--bootstrap4.select2-container--open .select2-selection--single {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(67,97,238,.12) !important;
  }
  .select2-container--bootstrap4 .select2-dropdown {
    border: 1px solid #e2e8f0 !important;
    border-radius: .4rem !important;
    box-shadow: 0 6px 24px rgba(0,0,0,.1) !important;
    font-size: .82rem !important;
  }
  .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
    border-radius: .35rem; border-color: #e2e8f0; font-size: .8rem; padding: .3rem .5rem;
  }
  .select2-container--bootstrap4 .select2-results__option {
    padding: .35rem .7rem; font-size: .82rem;
  }
  .select2-container--bootstrap4 .select2-results__option--highlighted {
    background: var(--primary) !important;
  }
  .select2-container--bootstrap4 .select2-results__option[aria-selected="true"] {
    background: rgba(67,97,238,.08) !important; color: var(--primary) !important;
  }
  .select2-search--dropdown { padding: .4rem; }

  /* ── Filter bar & filter card (index pages) ── */
  .filter-bar, .filter-card {
    background: #fff; border-radius: var(--radius);
    padding: .85rem 1rem .2rem;
    box-shadow: var(--card-sh); margin-bottom: 1.1rem;
    border-left: 3px solid var(--primary);
  }
  .filter-card-header {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .8px; color: #94a3b8; margin-bottom: .6rem;
    display: flex; align-items: center; gap: .4rem;
  }
  .filter-bar label, .filter-card label {
    font-size: .72rem; font-weight: 600; color: #475569; margin-bottom: .28rem;
  }

  /* ── Progress ── */
  .progress       { border-radius: 10px !important; overflow: hidden; }
  .progress-xs    { height: 4px; }
  .progress-sm    { height: 6px; }

  /* ── Misc ── */
  .badge          { font-weight: 600; letter-spacing: .3px; border-radius: .35rem; }
  .badge-purple   { background: var(--purple); color: #fff; }
  .btn            { border-radius: .4rem !important; font-weight: 500; }
  .btn-xs         { padding: .18rem .45rem; font-size: .7rem; }
  .text-muted     { color: #94a3b8 !important; }
  .font-weight-600{ font-weight: 600; }
  .font-weight-700{ font-weight: 700; }
  .sla-ok         { color: var(--success); font-weight: 600; }
  .sla-warn       { color: var(--warning); font-weight: 600; }
  .sla-over       { color: var(--danger);  font-weight: 600; }
  .chart-wrap     { position: relative; }

  .divisi-label {
    font-size: .72rem; font-weight: 500; color: #374151;
    max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
  }

  /* ── Alerts ── */
  .alert { border: none; border-radius: .5rem; font-size: .82rem; }

  /* ── Footer ── */
  .main-footer {
    background: #fff !important;
    border-top: 1px solid #e9ecef !important;
    font-size: .75rem;
  }

  /* ── Responsive ── */
  @media (max-width: 576px) {
    .kpi-value { font-size: 1.3rem; }
    .stat-value { font-size: 1.1rem; }
    .content-header h1 { font-size: .95rem !important; }
    .filter-bar { gap: .4rem; }
  }
  </style>
  @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

{{-- ══ TOPBAR ══ --}}
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link px-3" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars" style="color:#64748b"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <span class="nav-link" style="font-size:.8rem;color:#94a3b8;cursor:default;padding-left:0">
        <!-- <i class="fas fa-hard-hat mr-1" style="color:#f59e0b"></i> -->
        <strong style="color:#1e293b">SCM HR Monitoring</strong>
        <span class="text-muted"> — Konawe</span>
      </span>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto align-items-center pr-2">
    <li class="nav-item d-none d-lg-block">
      <span class="nav-link text-muted" style="font-size:.73rem">
        <i class="far fa-calendar-alt mr-1"></i>{{ now()->format('d M Y') }}
      </span>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" role="button">
        <div class="d-flex align-items-center justify-content-center rounded-circle text-white font-weight-700"
             style="width:30px;height:30px;font-size:.72rem;background:linear-gradient(135deg,#4361ee,#3a0ca3);flex-shrink:0">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <span class="d-none d-md-inline ml-2" style="font-size:.8rem;font-weight:600;color:#374151">
          {{ auth()->user()->name }}
        </span>
        <i class="fas fa-chevron-down ml-1" style="font-size:.55rem;color:#94a3b8"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow-sm"
           style="border:none;border-radius:.55rem;min-width:175px;font-size:.8rem;padding:.35rem 0">
        <div class="px-3 py-2" style="border-bottom:1px solid #f1f5f9">
          <div style="font-weight:600;color:#1e293b">{{ auth()->user()->name }}</div>
          <div class="mt-1">{!! auth()->user()->role_badge !!}</div>
        </div>
        <a href="{{ route('profile') }}" class="dropdown-item py-2">
          <i class="fas fa-user mr-2 text-primary"></i>Profil Saya
        </a>
        <div class="dropdown-divider my-1"></div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item py-2 text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i>Logout
          </button>
        </form>
      </div>
    </li>
  </ul>
</nav>

{{-- ══ SIDEBAR ══ --}}
<aside class="main-sidebar sidebar-dark-primary elevation-0">
  <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none d-flex align-items-center">
    <span class="d-inline-flex align-items-center justify-content-center mr-2"
          style="width:30px;height:30px;background:linear-gradient(135deg,#4361ee,#3a0ca3);border-radius:.4rem;flex-shrink:0">
      <!-- <i class="fas fa-hard-hat text-white" style="font-size:.75rem"></i> -->
    </span>
    <span class="brand-text font-weight-700" style="font-size:.83rem;letter-spacing:.2px">SCM HR Monitoring</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-2 d-flex align-items-center">
      <div class="image mr-2">
        <div class="d-flex align-items-center justify-content-center rounded-circle text-white font-weight-700"
             style="width:32px;height:32px;font-size:.75rem;background:linear-gradient(135deg,#4361ee,#3a0ca3)">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
      </div>
      <div class="info">
        <a href="{{ route('profile') }}" class="d-block text-white" style="font-size:.78rem;font-weight:600">
          {{ auth()->user()->name }}
        </a>
        <small style="font-size:.65rem;color:rgba(255,255,255,.4)">{{ auth()->user()->role_label }}</small>
      </div>
    </div>

    <nav class="mt-1">
      <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu">

        <li class="nav-header">DASHBOARD</li>
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-pie"></i><p>Overview</p>
          </a>
        </li>

        <li class="nav-header">REKRUTMEN</li>
        <li class="nav-item">
          <a href="{{ route('rekrutmen.index') }}" class="nav-link {{ request()->routeIs('rekrutmen.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-search-plus"></i><p>Monitoring Rekrutmen</p>
          </a>
        </li>

        <li class="nav-header">KARYAWAN</li>
        <li class="nav-item">
          <a href="{{ route('karyawan.index') }}" class="nav-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i><p>Data Karyawan OL</p>
          </a>
        </li>

        <li class="nav-header">MPP</li>
        <li class="nav-item">
          <a href="{{ route('mpp.index') }}" class="nav-link {{ request()->routeIs('mpp.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i><p>MPP Planning</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('mpp.gap') }}" class="nav-link {{ request()->routeIs('mpp.gap') ? 'active' : '' }}">
            <i class="nav-icon fas fa-balance-scale"></i><p>Gap Analysis</p>
          </a>
        </li>

        @if(auth()->user()->canEdit())
        <li class="nav-header">MASTER DATA</li>
        <li class="nav-item">
          <a href="{{ route('master.divisi.index') }}" class="nav-link {{ request()->routeIs('master.divisi*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-sitemap"></i><p>Divisi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('master.departemen.index') }}" class="nav-link {{ request()->routeIs('master.departemen*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-building"></i><p>Departemen</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('master.jabatan.index') }}" class="nav-link {{ request()->routeIs('master.jabatan*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-id-badge"></i><p>Jabatan</p>
          </a>
        </li>
        @endif

        @if(auth()->user()->isAdmin())
        <li class="nav-header">ADMINISTRASI</li>
        <li class="nav-item">
          <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users-cog"></i><p>Manajemen User</p>
          </a>
        </li>
        @endif

      </ul>
    </nav>
  </div>
</aside>

{{-- ══ CONTENT WRAPPER ══ --}}
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row align-items-center mb-1">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('page-title','Dashboard')</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-primary">Home</a></li>
            @yield('breadcrumb')
          </ol>
        </div>
      </div>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 mb-2">
          <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      @endif
      @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show py-2 mb-2">
          <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show py-2 mb-2">
          <i class="fas fa-exclamation-circle mr-2"></i>
          <ul class="mb-0 pl-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      @endif
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @yield('content')
    </div>
  </section>
</div>

<footer class="main-footer py-2 d-flex align-items-center justify-content-between">
  <span><strong>PT Sulawesi Cahaya Mineral</strong> — SCM Division</span>
  <span class="text-muted d-none d-sm-block" style="font-size:.71rem">
    HR Monitoring v1.0 &nbsp;|&nbsp; MPP-970 &nbsp;|&nbsp; Site Konawe
  </span>
</footer>
</div>{{-- /.wrapper --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function confirmDelete(id, url) {
  if (!confirm('Yakin ingin menghapus data ini?')) return;
  $.ajax({
    url, type: 'DELETE',
    success: res => res.success ? location.reload() : alert(res.message),
  });
}

// Global Select2 init — semua <select> otomatis dapat search, kecuali .no-select2
window.s2init = function (el) {
  const $el = $(el);
  if ($el.hasClass('select2-hidden-accessible')) $el.select2('destroy');
  $el.select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: $el.data('placeholder') || '-- Pilih --',
    width: '100%',
  });
};

window.initAllSelect2 = function (scope) {
  (scope ? $(scope).find('select') : $('select:not(.no-select2)')).each(function () {
    if (!$(this).hasClass('select2-hidden-accessible')) s2init(this);
  });
};

$(function () {
  initAllSelect2();
  setTimeout(() => $('.alert-success, .alert-info').fadeOut('slow'), 4000);
});
</script>
@stack('scripts')
</body>
</html>
