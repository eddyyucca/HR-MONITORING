@extends('layouts.app')
@section('title','Detail MPP')
@section('page-title','<i class="fas fa-clipboard-list mr-2 text-info"></i>Detail Posisi MPP')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('mpp.index') }}">MPP</a></li>
  <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-7">
    <div class="card card-outline card-info">
      <div class="card-header card-header-sm">
        <h3 class="card-title">{{ $mpp->job_title }}</h3>
        <div class="card-tools">
          <span class="badge badge-primary">{{ $mpp->tahun }}</span>
          @if($mpp->category_grade)
            <span class="badge badge-info">{{ $mpp->category_grade }}</span>
          @endif
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="120" class="text-muted">Divisi</th><td>{{ $mpp->divisi?->nama ?? '—' }}</td></tr>
              <tr><th class="text-muted">Departemen</th><td>{{ $mpp->departemen?->nama ?? '—' }}</td></tr>
              <tr><th class="text-muted">Grade</th><td>{{ $mpp->category_grade ?: '—' }}</td></tr>
              <tr><th class="text-muted">Site</th><td>{{ $mpp->site }}</td></tr>
            </table>
          </div>
          <div class="col-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="120" class="text-muted">App Name</th><td>{{ $mpp->app_name ?: '—' }}</td></tr>
              <tr><th class="text-muted">Cost Centre</th><td>{{ $mpp->cost_centre ?: '—' }}</td></tr>
              <tr><th class="text-muted">Tahun</th><td>{{ $mpp->tahun }}</td></tr>
              <tr><th class="text-muted">Status</th><td>
                <span class="badge {{ $mpp->is_active ? 'badge-success' : 'badge-secondary' }}">
                  {{ $mpp->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
              </td></tr>
            </table>
          </div>
        </div>
        @if($mpp->remarks)
          <div class="alert alert-light border mt-2" style="font-size:.82rem">
            <strong>Remarks:</strong> {{ $mpp->remarks }}
          </div>
        @endif
      </div>
    </div>

    <div class="card card-outline card-success">
      <div class="card-header card-header-sm"><h3 class="card-title">Headcount per Bulan</h3></div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-bordered mb-0" style="font-size:.78rem">
            <thead class="thead-dark">
              <tr><th>Bulan</th><th class="text-center">MPP Plan</th><th class="text-center">Existing</th><th class="text-center">Deviasi</th><th>Progress</th></tr>
            </thead>
            <tbody>
              @foreach($months as $key => $label)
              @php
                $mppVal = $mpp->{"mpp_$key"} ?? 0;
                $exVal  = $mpp->{"existing_$key"} ?? 0;
                $gap    = $exVal - $mppVal;
                $pct    = $mppVal > 0 ? min(100, round($exVal/$mppVal*100)) : 0;
              @endphp
              <tr>
                <td>{{ $label }}</td>
                <td class="text-center font-weight-bold">{{ $mppVal }}</td>
                <td class="text-center">{{ $exVal }}</td>
                <td class="text-center">
                  @if($gap > 0)<span class="text-success font-weight-bold">+{{ $gap }}</span>
                  @elseif($gap < 0)<span class="text-danger font-weight-bold">{{ $gap }}</span>
                  @else<span class="text-muted">0</span>@endif
                </td>
                <td style="min-width:100px">
                  <div class="progress progress-sm">
                    <div class="progress-bar {{ $pct >= 100 ? 'bg-success' : ($pct >= 50 ? 'bg-info' : 'bg-warning') }}" style="width:{{ $pct }}%"></div>
                  </div>
                  <small class="text-muted">{{ $pct }}%</small>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm"><h3 class="card-title">Aksi</h3></div>
      <div class="card-body">
        <a href="{{ route('mpp.edit',$mpp->id) }}" class="btn btn-warning btn-block btn-sm mb-2">
          <i class="fas fa-edit mr-1"></i>Edit Data
        </a>
        <button onclick="confirmDelete({{ $mpp->id }},'{{ route('mpp.destroy',$mpp->id) }}')"
          class="btn btn-danger btn-block btn-sm">
          <i class="fas fa-trash mr-1"></i>Hapus
        </button>
      </div>
    </div>

    <div class="card card-outline card-warning">
      <div class="card-header card-header-sm"><h3 class="card-title">Visualisasi MPP vs Existing</h3></div>
      <div class="card-body">
        <canvas id="chartMpp" height="220"></canvas>
      </div>
    </div>
  </div>
</div>
<a href="{{ route('mpp.index') }}" class="btn btn-default btn-sm">
  <i class="fas fa-arrow-left mr-1"></i>Kembali
</a>
@endsection

@push('scripts')
<script>
const labels  = @json(array_values($months));
const mppVals = @json(array_map(fn($k) => $mpp->{"mpp_$k"} ?? 0, array_keys($months)));
const exVals  = @json(array_map(fn($k) => $mpp->{"existing_$k"} ?? 0, array_keys($months)));
new Chart(document.getElementById('chartMpp'), {
  type:'bar',
  data:{
    labels:labels,
    datasets:[
      {label:'MPP Plan',data:@json(collect(array_keys($months))->map(fn($k)=>$mpp->{"mpp_$k"}??0)),backgroundColor:'rgba(0,123,255,.6)',borderRadius:3},
      {label:'Existing',data:@json(collect(array_keys($months))->map(fn($k)=>$mpp->{"existing_$k"}??0)),backgroundColor:'rgba(40,167,69,.6)',borderRadius:3},
    ]
  },
  options:{
    responsive:true,maintainAspectRatio:false,
    plugins:{legend:{position:'bottom',labels:{font:{size:10},padding:6}}},
    scales:{x:{grid:{display:false},ticks:{font:{size:9}}},y:{beginAtZero:true}}
  }
});
</script>
@endpush
