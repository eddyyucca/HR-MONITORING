@extends('layouts.app')
@section('title','Gap Analysis MPP')
@section('page-title','<i class="fas fa-balance-scale mr-2 text-success"></i>Gap Analysis — MPP vs Karyawan Aktif')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('mpp.index') }}">MPP</a></li>
  <li class="breadcrumb-item active">Gap Analysis</li>
@endsection

@section('content')
{{-- Year filter --}}
<div class="d-flex align-items-center mb-3">
  <form method="GET" class="d-flex align-items-center">
    <label class="mr-2 mb-0 text-muted" style="font-size:.82rem">Tahun:</label>
    <select name="year" class="form-control form-control-sm" style="width:100px" onchange="this.form.submit()">
      @foreach($years as $y)
        <option value="{{ $y }}" {{ $y == $year ? 'selected':'' }}>{{ $y }}</option>
      @endforeach
    </select>
  </form>
</div>

{{-- Overall summary --}}
@php
  $totalMppAll = $mppPerDivisi->sum('total_mpp');
  $totalKarAll = $karPerDivisi->sum('total_kar');
  $gapAll      = $totalKarAll - $totalMppAll;
@endphp
<div class="row mb-3">
  <div class="col-md-4">
    <div class="card bg-primary text-white">
      <div class="card-body text-center py-3">
        <div style="font-size:2.5rem;font-weight:700">{{ number_format($totalKarAll) }}</div>
        <div style="font-size:.85rem">Total Karyawan Aktif</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card" style="background:#6f42c1;color:#fff">
      <div class="card-body text-center py-3">
        <div style="font-size:2.5rem;font-weight:700">{{ number_format($totalMppAll) }}</div>
        <div style="font-size:.85rem">Total Posisi MPP {{ $year }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card {{ $gapAll >= 0 ? 'bg-success' : 'bg-danger' }} text-white">
      <div class="card-body text-center py-3">
        <div style="font-size:2.5rem;font-weight:700">{{ $gapAll >= 0 ? '+':'' }}{{ number_format($gapAll) }}</div>
        <div style="font-size:.85rem">Gap (Aktif - MPP)</div>
        <div style="font-size:.72rem;opacity:.8">
          {{ $totalMppAll > 0 ? round($totalKarAll/$totalMppAll*100,1) : 0 }}% Fulfillment Rate
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-7">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm">
        <h3 class="card-title">Gap per Divisi — {{ $year }}</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-sm table-bordered table-striped mb-0" style="font-size:.78rem">
          <thead class="thead-dark">
            <tr>
              <th>Divisi</th>
              <th class="text-center">Posisi MPP</th>
              <th class="text-center">Karyawan Aktif</th>
              <th class="text-center">Gap</th>
              <th>Fulfillment</th>
            </tr>
          </thead>
          <tbody>
            @forelse($mppPerDivisi as $item)
            @php
              $karCount = $karPerDivisi[$item->divisi_id]->total_kar ?? 0;
              $gap = $karCount - $item->total_mpp;
              $pct = $item->total_mpp > 0 ? round($karCount/$item->total_mpp*100) : 0;
            @endphp
            <tr>
              <td>{{ $item->divisi?->nama ?? '—' }}</td>
              <td class="text-center font-weight-bold">{{ $item->total_mpp }}</td>
              <td class="text-center">{{ $karCount }}</td>
              <td class="text-center">
                @if($gap > 0)
                  <span class="badge badge-success">+{{ $gap }}</span>
                @elseif($gap < 0)
                  <span class="badge badge-danger">{{ $gap }}</span>
                @else
                  <span class="badge badge-secondary">0</span>
                @endif
              </td>
              <td>
                <div class="progress progress-sm" style="min-width:80px">
                  <div class="progress-bar {{ $pct >= 100 ? 'bg-success' : ($pct >= 75 ? 'bg-info' : ($pct >= 50 ? 'bg-warning' : 'bg-danger')) }}"
                    style="width:{{ min(100,$pct) }}%"></div>
                </div>
                <small class="text-muted">{{ $pct }}%</small>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data MPP untuk tahun {{ $year }}</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <div class="card card-outline card-info">
      <div class="card-header card-header-sm"><h3 class="card-title">Grafik Perbandingan</h3></div>
      <div class="card-body">
        <canvas id="chartGap" height="300"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const labels  = @json($mppPerDivisi->map(fn($i)=> Str::limit($i->divisi?->nama ?? '—', 20)));
const mppVals = @json($mppPerDivisi->pluck('total_mpp'));
const karVals = @json($mppPerDivisi->map(fn($i) => $karPerDivisi[$i->divisi_id]->total_kar ?? 0));

new Chart(document.getElementById('chartGap'), {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [
      { label: 'MPP Plan',         data: mppVals, backgroundColor: 'rgba(111,66,193,.7)', borderRadius: 3 },
      { label: 'Karyawan Aktif',   data: karVals, backgroundColor: 'rgba(0,123,255,.7)',  borderRadius: 3 },
    ]
  },
  options: {
    responsive: true, maintainAspectRatio: false, indexAxis: 'y',
    plugins: { legend: { position:'bottom', labels: { font:{size:10}, padding:6 } } },
    scales: { x: { beginAtZero: true, grid: { color:'#f4f6f9' } }, y: { ticks: { font:{size:9} } } }
  }
});
</script>
@endpush
