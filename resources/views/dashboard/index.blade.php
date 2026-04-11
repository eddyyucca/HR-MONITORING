@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title')
  <i class="fas fa-chart-pie text-primary" style="font-size:1rem"></i> Overview Dashboard
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item active">Overview</li>
@endsection

@section('content')

{{-- ══ Filter Bar ══ --}}
<div class="filter-bar">
  <i class="fas fa-sliders-h text-primary"></i>
  <form method="GET" class="d-flex align-items-center gap-2 mb-0">
    <label class="mb-0">Tahun:</label>
    <select name="year" class="form-control form-control-sm" style="width:88px" onchange="this.form.submit()">
      @foreach($availableYears as $y)
        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
      @endforeach
    </select>
  </form>
  <span class="badge badge-primary px-2">{{ $year }}</span>
  <span class="badge badge-secondary px-2">Site: Konawe</span>
  <span class="badge px-2" style="background:#1e293b;color:#94a3b8">MPP-970</span>
  <span class="ml-auto text-muted d-none d-md-inline" style="font-size:.7rem">
    <i class="far fa-clock mr-1"></i>{{ now()->format('d M Y, H:i') }}
  </span>
</div>

{{-- ══ Row 1 — Employee KPIs ══ --}}
<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="kpi-card kpi-blue">
      <div class="kpi-top">
        <div>
          <div class="kpi-value">{{ number_format($totalKaryawan) }}</div>
          <div class="kpi-label">Total Karyawan Aktif</div>
          <div class="kpi-sub">Staff {{ $totalStaff }} &nbsp;·&nbsp; Non-Staff {{ $totalNonStaff }}</div>
        </div>
        <div class="kpi-icon"><i class="fas fa-users"></i></div>
      </div>
      <a href="{{ route('karyawan.index') }}" class="kpi-footer">
        <span>Lihat Detail</span><i class="fas fa-arrow-right" style="font-size:.65rem"></i>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="kpi-card kpi-green">
      <div class="kpi-top">
        <div>
          <div class="kpi-value">{{ number_format($totalStaff) }}</div>
          <div class="kpi-label">Staff OL Aktif</div>
          <div class="kpi-sub">{{ $staffKontrak }} Kontrak &nbsp;·&nbsp; {{ $staffProb }} Probation</div>
        </div>
        <div class="kpi-icon"><i class="fas fa-user-tie"></i></div>
      </div>
      <a href="{{ route('karyawan.index', ['tipe' => 'Staff']) }}" class="kpi-footer">
        <span>Lihat Detail</span><i class="fas fa-arrow-right" style="font-size:.65rem"></i>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="kpi-card kpi-amber">
      <div class="kpi-top">
        <div>
          <div class="kpi-value">{{ number_format($totalNonStaff) }}</div>
          <div class="kpi-label">Non-Staff OL Aktif</div>
        </div>
        <div class="kpi-icon"><i class="fas fa-hard-hat"></i></div>
      </div>
      <a href="{{ route('karyawan.index', ['tipe' => 'Non-Staff']) }}" class="kpi-footer">
        <span>Lihat Detail</span><i class="fas fa-arrow-right" style="font-size:.65rem"></i>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="kpi-card kpi-cyan">
      <div class="kpi-top">
        <div>
          <div class="kpi-value">{{ number_format($totalMpp) }}</div>
          <div class="kpi-label">Posisi MPP {{ $year }}</div>
        </div>
        <div class="kpi-icon"><i class="fas fa-clipboard-list"></i></div>
      </div>
      <a href="{{ route('mpp.index', ['year' => $year]) }}" class="kpi-footer">
        <span>Lihat Detail</span><i class="fas fa-arrow-right" style="font-size:.65rem"></i>
      </a>
    </div>
  </div>
</div>

{{-- ══ Row 2 — Rekrutmen Stats ══ --}}
@php
  $rekStats = [
    ['label' => 'Total Kandidat '.$year, 'value' => $totalRek,  'pct' => 100,
     'color' => '#64748b', 'icon' => 'fas fa-file-alt'],
    ['label' => 'On Board',              'value' => $onBoard,   'pct' => $totalRek > 0 ? round($onBoard/$totalRek*100)  : 0,
     'color' => '#10b981', 'icon' => 'fas fa-user-check'],
    ['label' => 'Pipeline (Compro)',     'value' => $compro,    'pct' => $totalRek > 0 ? round($compro/$totalRek*100)   : 0,
     'color' => '#8b5cf6', 'icon' => 'fas fa-spinner'],
    ['label' => 'Gagal / Rejected',      'value' => $failed,    'pct' => $totalRek > 0 ? round($failed/$totalRek*100)   : 0,
     'color' => '#ef4444', 'icon' => 'fas fa-times-circle'],
  ];
@endphp
<div class="row">
  @foreach($rekStats as $s)
  <div class="col-xl-3 col-md-6">
    <div class="stat-strip">
      <div class="stat-icon" style="background:{{ $s['color'] }}1a;color:{{ $s['color'] }}">
        <i class="{{ $s['icon'] }}"></i>
      </div>
      <div class="flex-fill" style="min-width:0">
        <div class="stat-value" style="color:{{ $s['color'] }}">{{ number_format($s['value']) }}</div>
        <div class="stat-label">{{ $s['label'] }}</div>
        <div class="stat-bar">
          <div class="stat-bar-fill" style="width:{{ $s['pct'] }}%;background:{{ $s['color'] }}"></div>
        </div>
      </div>
      <div class="stat-pct" style="color:{{ $s['color'] }}">{{ $s['pct'] }}%</div>
    </div>
  </div>
  @endforeach
</div>

{{-- ══ Row 3 — Monthly + Status ══ --}}
<div class="row">
  <div class="col-lg-8">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-chart-bar text-primary"></i>Rekrutmen per Bulan {{ $year }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-wrap" style="height:250px">
          <canvas id="chartMonth"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card card-outline card-info">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-chart-pie text-info"></i>Status Rekrutmen
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-wrap" style="height:250px">
          <canvas id="chartProgress"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ══ Row 4 — Divisi + Level + Priority ══ --}}
<div class="row">
  <div class="col-lg-6">
    <div class="card card-outline card-success">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-sitemap text-success"></i>Rekrutmen per Divisi {{ $year }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body" style="max-height:260px;overflow-y:auto">
        @forelse($rekPerDivisi as $item)
          @php
            $max = $rekPerDivisi->max('total');
            $pct = $max > 0 ? round($item->total / $max * 100) : 0;
          @endphp
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="divisi-label">{{ $item->divisi?->nama ?? 'N/A' }}</span>
            <span class="font-weight-700 text-success ml-2" style="font-size:.75rem">{{ $item->total }}</span>
          </div>
          <div class="progress progress-sm mb-2">
            <div class="progress-bar" style="width:{{ $pct }}%;background:linear-gradient(90deg,#10b981,#059669)"></div>
          </div>
        @empty
          <p class="text-center text-muted py-3 mb-0">
            <i class="fas fa-inbox d-block fa-2x mb-2 text-light"></i>Tidak ada data
          </p>
        @endforelse
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-sm-6">
    <div class="card card-outline card-warning">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-layer-group text-warning"></i>Level Kandidat
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-wrap" style="height:205px">
          <canvas id="chartLevel"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-sm-6">
    <div class="card card-outline card-danger">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-exclamation-circle text-danger"></i>Priority
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-wrap" style="height:205px">
          <canvas id="chartPriority"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ══ Row 5 — Sumber + Pipeline ══ --}}
<div class="row">
  <div class="col-lg-4">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-share-alt text-primary"></i>Sumber Rekrutmen
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-wrap" style="height:205px">
          <canvas id="chartSourch"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card card-outline card-success">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-user-clock text-success"></i>Pipeline Aktif (Compro)
        </h3>
        <div class="card-tools d-flex align-items-center gap-1">
          <a href="{{ route('rekrutmen.index', ['progress' => 'Compro']) }}"
             class="btn btn-xs btn-outline-success mr-1">
            Lihat Semua
          </a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-hover mb-0" style="font-size:.75rem">
            <thead class="thead-dark">
              <tr>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Divisi</th>
                <th>Level</th>
                <th class="text-nowrap">Bln / Thn</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pipeline as $p)
              <tr>
                <td class="font-weight-600">{{ $p->nama_lengkap }}</td>
                <td>{{ Str::limit($p->plan_job_title, 28) }}</td>
                <td><small class="text-muted">{{ Str::limit($p->divisi?->nama ?? '—', 22) }}</small></td>
                <td>
                  @if($p->category_level)
                    <span class="badge badge-light border" style="font-weight:500">{{ $p->category_level }}</span>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                <td class="text-nowrap text-muted">{{ $p->month_name }} {{ $p->year }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-2x d-block mb-2 text-light"></i>
                  Tidak ada pipeline aktif
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
  'use strict';

  // ── Chart.js global defaults ──────────────────────────────────────────
  Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
  Chart.defaults.font.size   = 11;
  Object.assign(Chart.defaults.plugins.tooltip, {
    padding: 10, cornerRadius: 8,
    boxPadding: 4, usePointStyle: true,
  });

  // ── Colour palette ────────────────────────────────────────────────────
  const C = {
    blue  : '#4361ee', green : '#10b981', amber : '#f59e0b',
    red   : '#ef4444', cyan  : '#06b6d4', purple: '#8b5cf6',
    orange: '#f97316', pink  : '#ec4899', teal  : '#14b8a6',
    slate : '#64748b',
  };
  const PALETTE = [C.blue, C.green, C.amber, C.red, C.cyan, C.purple, C.orange, C.pink, C.teal];

  /** Convert hex to rgba */
  function rgba(hex, a) {
    const [r, g, b] = [hex.slice(1,3), hex.slice(3,5), hex.slice(5,7)].map(h => parseInt(h, 16));
    return `rgba(${r},${g},${b},${a})`;
  }

  /** Create vertical gradient on a canvas element */
  function gradient(canvasId, color, a0 = .75, a1 = .08) {
    const g = document.getElementById(canvasId).getContext('2d').createLinearGradient(0, 0, 0, 300);
    g.addColorStop(0, rgba(color, a0));
    g.addColorStop(1, rgba(color, a1));
    return g;
  }

  // ── Data from server ──────────────────────────────────────────────────
  const progressData = @json($rekPerProgress);
  const monthData    = @json($rekPerBulan->pluck('total', 'month_number'));
  const levelData    = @json($rekPerLevel);
  const prioData     = @json($rekPerPriority);
  const sourData     = @json($rekPerSourch);

  const MONTHS   = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  const monthVals = Array.from({ length: 12 }, (_, i) => monthData[i + 1] || 0);

  // ── 1. Monthly Bar ────────────────────────────────────────────────────
  new Chart(document.getElementById('chartMonth'), {
    type: 'bar',
    data: {
      labels: MONTHS,
      datasets: [{
        label: 'Kandidat',
        data: monthVals,
        backgroundColor: gradient('chartMonth', C.blue),
        borderColor: C.blue,
        borderWidth: 1.5,
        borderRadius: 7,
        borderSkipped: false,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false }, ticks: { color: '#94a3b8' } },
        y: {
          beginAtZero: true,
          grid: { color: '#f1f5f9' },
          ticks: { color: '#94a3b8', precision: 0 },
        },
      },
    },
  });

  // ── 2. Status Doughnut ────────────────────────────────────────────────
  const progressLabels = Object.keys(progressData);
  new Chart(document.getElementById('chartProgress'), {
    type: 'doughnut',
    data: {
      labels: progressLabels,
      datasets: [{
        data: Object.values(progressData),
        backgroundColor: progressLabels.map((_, i) => PALETTE[i % PALETTE.length]),
        borderWidth: 2,
        borderColor: '#fff',
        hoverOffset: 8,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '68%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: { padding: 10, usePointStyle: true, pointStyleWidth: 8, font: { size: 10 } },
        },
      },
    },
  });

  // ── 3. Level Polar Area ───────────────────────────────────────────────
  const levelLabels = Object.keys(levelData);
  new Chart(document.getElementById('chartLevel'), {
    type: 'polarArea',
    data: {
      labels: levelLabels,
      datasets: [{
        data: Object.values(levelData),
        backgroundColor: PALETTE.slice(0, levelLabels.length).map(c => rgba(c, .72)),
        borderColor: PALETTE.slice(0, levelLabels.length),
        borderWidth: 1.5,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: { padding: 8, usePointStyle: true, font: { size: 9 } },
        },
      },
      scales: {
        r: { ticks: { display: false }, grid: { color: '#f1f5f9' } },
      },
    },
  });

  // ── 4. Priority Doughnut ──────────────────────────────────────────────
  const PRIO_COLORS = { P1: C.red, P2: C.amber, P3: C.cyan, NP: C.slate };
  const prioLabels  = Object.keys(prioData);
  new Chart(document.getElementById('chartPriority'), {
    type: 'doughnut',
    data: {
      labels: prioLabels,
      datasets: [{
        data: Object.values(prioData),
        backgroundColor: prioLabels.map(k => PRIO_COLORS[k] || C.slate),
        borderWidth: 2,
        borderColor: '#fff',
        hoverOffset: 8,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: { padding: 8, usePointStyle: true, font: { size: 9 } },
        },
      },
    },
  });

  // ── 5. Source Horizontal Bar ──────────────────────────────────────────
  const sourLabels = Object.keys(sourData);
  const sourColors = sourLabels.map((_, i) => PALETTE[i % PALETTE.length]);
  new Chart(document.getElementById('chartSourch'), {
    type: 'bar',
    data: {
      labels: sourLabels,
      datasets: [{
        data: Object.values(sourData),
        backgroundColor: sourColors.map(c => rgba(c, .78)),
        borderColor: sourColors,
        borderWidth: 1.5,
        borderRadius: 6,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      indexAxis: 'y',
      plugins: { legend: { display: false } },
      scales: {
        x: {
          beginAtZero: true,
          grid: { display: false },
          ticks: { color: '#94a3b8', precision: 0 },
        },
        y: {
          grid: { display: false },
          ticks: { color: '#374151', font: { size: 10 } },
        },
      },
    },
  });

})();
</script>
@endpush
