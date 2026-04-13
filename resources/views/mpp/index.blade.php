@extends('layouts.app')
@section('title','MPP Planning')
@section('page-title')
  <i class="fas fa-clipboard-list text-info"></i> Man Power Planning (MPP)
@endsection
@section('breadcrumb')<li class="breadcrumb-item active">MPP Planning</li>@endsection

@section('content')
<div class="row mb-3">
  <div class="col-md-3 col-6"><div class="info-box mb-0">
    <span class="info-box-icon bg-info"><i class="fas fa-list"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Total Posisi MPP {{ $year }}</span>
      <span class="info-box-number">{{ number_format($totalMpp) }}</span>
    </div>
  </div></div>
  <div class="col-md-3 col-6"><div class="info-box mb-0">
    <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Karyawan Aktif</span>
      <span class="info-box-number">{{ number_format($totalKaryawan) }}</span>
    </div>
  </div></div>
  <div class="col-md-3 col-6"><div class="info-box mb-0">
    <span class="info-box-icon {{ $totalKaryawan > $totalMpp ? 'bg-success' : 'bg-danger' }}"><i class="fas fa-balance-scale"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Gap (Aktif - MPP)</span>
      <span class="info-box-number {{ $totalKaryawan > $totalMpp ? 'text-success' : 'text-danger' }}">
        {{ $totalKaryawan > $totalMpp ? '+' : '' }}{{ number_format($totalKaryawan - $totalMpp) }}
      </span>
    </div>
  </div></div>
  <div class="col-md-3 col-6"><div class="info-box mb-0">
    <span class="info-box-icon bg-warning"><i class="fas fa-chart-bar"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Fulfillment Rate</span>
      <span class="info-box-number">{{ $totalMpp > 0 ? round($totalKaryawan/$totalMpp*100,1) : 0 }}%</span>
    </div>
  </div></div>
</div>

{{-- Filter --}}
<div class="filter-card">
  <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;color:#6c757d;margin-bottom:10px"><i class="fas fa-filter mr-1"></i>Filter</div>
  <div class="row">
    <div class="col-md-2"><div class="form-group">
      <label>Tahun</label>
      <select id="fYear" class="form-control" data-placeholder="-- Pilih Tahun --">
        @foreach($years as $y)<option value="{{ $y }}" {{ $y == $year ? 'selected':'' }}>{{ $y }}</option>@endforeach
      </select>
    </div></div>
    <div class="col-md-3"><div class="form-group">
      <label>Divisi</label>
      <select id="fDivisi" class="form-control" data-placeholder="-- Semua Divisi --">
        <option value="">-- Semua --</option>
        @foreach($divisis as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach
      </select>
    </div></div>
    <div class="col-md-3"><div class="form-group">
      <label>Grade/Level</label>
      <select id="fGrade" class="form-control" data-placeholder="-- Semua Grade --">
        <option value="">-- Semua --</option>
        @foreach(\App\Models\MppPosition::gradeOptions() as $g)<option value="{{ $g }}">{{ $g }}</option>@endforeach
      </select>
    </div></div>
    <div class="col-md-2"><div class="form-group">
      <label>Cari Posisi</label>
      <input type="text" id="fSearch" class="form-control" placeholder="Cari...">
    </div></div>
    <div class="col-md-2 d-flex align-items-end"><div class="form-group w-100">
      <button onclick="dtMpp.ajax.reload()" class="btn btn-primary btn-sm btn-block"><i class="fas fa-search mr-1"></i>Cari</button>
    </div></div>
  </div>
</div>

<div class="d-flex justify-content-between mb-2">
  <a href="{{ route('mpp.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>Tambah Posisi</a>
  <div>
    <a href="{{ route('mpp.gap',['year'=>$year]) }}" class="btn btn-info btn-sm mr-1"><i class="fas fa-balance-scale mr-1"></i>Gap Analysis</a>
    <a href="{{ route('mpp.export.excel') }}" class="btn btn-success btn-sm"><i class="fas fa-file-excel mr-1"></i>Export</a>
  </div>
</div>

{{-- Summary per divisi --}}
<div class="card card-outline card-info mb-3">
  <div class="card-header card-header-sm">
    <h3 class="card-title">Summary MPP per Divisi — {{ $year }}</h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
  </div>
  <div class="card-body p-0">
    <table class="table table-sm table-bordered table-striped mb-0" style="font-size:.78rem">
      <thead class="thead-dark">
        <tr><th>Divisi</th><th class="text-center">Total Posisi</th><th class="text-center">Kolom Aktif</th><th>Progress</th></tr>
      </thead>
      <tbody>
        @php $maxPosisi = $summary->max('total_posisi') ?: 1; @endphp
        @foreach($summary as $s)
          <tr>
            <td>{{ $s->divisi?->nama ?? '—' }}</td>
            <td class="text-center font-weight-bold">{{ $s->total_posisi }}</td>
            <td class="text-center">{{ number_format($s->total_mpp ?? 0) }}</td>
            <td style="min-width:120px">
              <div class="progress progress-sm">
                <div class="progress-bar bg-info" style="width:{{ round($s->total_posisi/$maxPosisi*100) }}%"></div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- DataTable --}}
<div class="card card-outline card-primary">
  <div class="card-header card-header-sm">
    <h3 class="card-title"><i class="fas fa-table mr-1"></i>Detail Posisi MPP</h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table id="mppTable" class="table table-bordered table-striped table-hover table-sm mb-0">
        <thead class="thead-dark">
          <tr>
            <th>#</th><th>Job Title</th><th>Divisi</th><th>Dept</th><th>Grade</th>
            <th>Tahun</th><th>Max MPP</th><th>Site</th><th width="90">Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
let dtMpp = $('#mppTable').DataTable({
  processing:true, serverSide:true,
  ajax:{
    url:'{{ route("mpp.datatables") }}',
    data:function(d){return $.extend(d,{year:$('#fYear').val(),divisi_id:$('#fDivisi').val(),category_grade:$('#fGrade').val(),search:$('#fSearch').val()});}
  },
  columns:[
    {data:'DT_RowIndex',orderable:false,searchable:false},
    {data:'job_title'},{data:'divisi_nama',orderable:false},{data:'dept_nama',orderable:false},
    {data:'category_grade'},{data:'tahun'},{data:'mpp_total_col',orderable:false},{data:'site'},
    {data:'action',orderable:false},
  ],
  pageLength:15,lengthMenu:[10,15,25,50,100],
  language:{processing:'<i class="fas fa-spinner fa-spin"></i>',search:'Cari:',lengthMenu:'_MENU_',info:'_START_–_END_/_TOTAL_',paginate:{first:'«',last:'»',next:'›',previous:'‹'},emptyTable:'Tidak ada data'},
  createdRow:function(row){$(row).find('td').css('font-size','.78rem');}
});
$('#fYear,#fDivisi,#fGrade').on('change',function(){dtMpp.ajax.reload();});
let st;$('#fSearch').on('keyup',function(){clearTimeout(st);st=setTimeout(()=>dtMpp.ajax.reload(),400);});
</script>
@endpush
