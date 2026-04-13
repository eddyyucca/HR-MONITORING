@extends('layouts.app')
@section('title','Data Karyawan')
@section('page-title')
  <i class="fas fa-users text-primary"></i> Data Karyawan OL
@endsection
@section('breadcrumb')<li class="breadcrumb-item active">Karyawan</li>@endsection

@section('content')
{{-- Summary Cards --}}
<div class="row mb-3">
  <div class="col-md-3 col-6">
    <div class="info-box mb-0">
      <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Aktif</span>
        <span class="info-box-number">{{ number_format($totalStaff + $totalNonStaff) }}</span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="info-box mb-0">
      <span class="info-box-icon bg-success"><i class="fas fa-user-tie"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Staff</span>
        <span class="info-box-number">{{ number_format($totalStaff) }}</span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="info-box mb-0">
      <span class="info-box-icon bg-warning"><i class="fas fa-hard-hat"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Non-Staff</span>
        <span class="info-box-number">{{ number_format($totalNonStaff) }}</span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="info-box mb-0">
      <span class="info-box-icon bg-info"><i class="fas fa-file-contract"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Rasio Staff</span>
        <span class="info-box-number">{{ ($totalStaff+$totalNonStaff) > 0 ? round($totalStaff/($totalStaff+$totalNonStaff)*100,1) : 0 }}%</span>
      </div>
    </div>
  </div>
</div>

{{-- Filter --}}
<div class="filter-card">
  <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6c757d;margin-bottom:10px">
    <i class="fas fa-filter mr-1"></i>Filter Data Karyawan
  </div>
  <div class="row">
    <div class="col-md-2 col-sm-6">
      <div class="form-group">
        <label>Tipe</label>
        <select id="fTipe" class="form-control" data-placeholder="-- Semua --">
          <option value="">-- Semua --</option>
          <option value="Staff" {{ ($filters['tipe'] ?? '') == 'Staff' ? 'selected' : '' }}>Staff</option>
          <option value="Non-Staff" {{ ($filters['tipe'] ?? '') == 'Non-Staff' ? 'selected' : '' }}>Non-Staff</option>
        </select>
      </div>
    </div>
    <div class="col-md-2 col-sm-6">
      <div class="form-group">
        <label>Status</label>
        <select id="fStatus" class="form-control" data-placeholder="-- Semua --">
          <option value="">-- Semua --</option>
          <option value="Kontrak">Kontrak</option>
          <option value="Percobaan">Probation</option>
          <option value="Tetap">Tetap</option>
        </select>
      </div>
    </div>
    <div class="col-md-2 col-sm-6">
      <div class="form-group">
        <label>Divisi</label>
        <select id="fDivisi" class="form-control" data-placeholder="-- Semua Divisi --">
          <option value="">-- Semua --</option>
          @foreach($divisis as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach
        </select>
      </div>
    </div>
    <div class="col-md-2 col-sm-6">
      <div class="form-group">
        <label>Level</label>
        <select id="fLevel" class="form-control" data-placeholder="-- Semua Level --">
          <option value="">-- Semua --</option>
          <option value="Assistant Manager">Assistant Manager</option>
          <option value="Supervisor">Supervisor</option>
          <option value="Officer">Officer</option>
          <option value="Non Staff">Non Staff</option>
        </select>
      </div>
    </div>
    <div class="col-md-2 col-sm-6">
      <div class="form-group">
        <label>Cari Nama/Posisi</label>
        <input type="text" id="fSearch" class="form-control" placeholder="Cari...">
      </div>
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <div class="form-group w-100">
        <button onclick="dtKaryawan.ajax.reload()" class="btn btn-primary btn-sm btn-block">
          <i class="fas fa-search mr-1"></i>Cari
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Actions --}}
<div class="d-flex justify-content-between mb-2">
  <a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus mr-1"></i>Tambah Karyawan
  </a>
  <a href="{{ route('karyawan.export.excel') }}" class="btn btn-success btn-sm">
    <i class="fas fa-file-excel mr-1"></i>Export Excel
  </a>
</div>

<div class="card card-outline card-primary">
  <div class="card-header card-header-sm">
    <h3 class="card-title"><i class="fas fa-table mr-1"></i>Daftar Karyawan</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table id="karyawanTable" class="table table-bordered table-striped table-hover table-sm mb-0">
        <thead class="thead-dark">
          <tr>
            <th width="35">#</th><th>Nama</th><th>Posisi</th><th>Divisi</th>
            <th>Dept</th><th>Tipe</th><th>Level</th><th>Status</th>
            <th>Terms</th><th>Gaji Pokok</th><th>Tgl OL</th><th width="90">Aksi</th>
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
let dtKaryawan = $('#karyawanTable').DataTable({
  processing:true, serverSide:true,
  ajax: {
    url: '{{ route("karyawan.datatables") }}',
    data: function(d) {
      return $.extend(d, {
        tipe:   $('#fTipe').val(),
        status: $('#fStatus').val(),
        divisi_id: $('#fDivisi').val(),
        level:  $('#fLevel').val(),
        search: $('#fSearch').val(),
      });
    }
  },
  columns:[
    {data:'DT_RowIndex',orderable:false,searchable:false},
    {data:'nama'},
    {data:'position'},
    {data:'divisi_nama',orderable:false},
    {data:'dept_nama',orderable:false},
    {data:'tipe_badge',orderable:false},
    {data:'level'},
    {data:'status_badge',orderable:false},
    {data:'terms'},
    {data:'gaji_fmt',orderable:false},
    {data:'tgl_ol'},
    {data:'action',orderable:false},
  ],
  pageLength:15,
  lengthMenu:[10,15,25,50,100],
  language:{
    processing:'<i class="fas fa-spinner fa-spin"></i> Loading...',
    search:'Cari:',lengthMenu:'Tampilkan _MENU_',
    info:'_START_–_END_ dari _TOTAL_',
    paginate:{first:'«',last:'»',next:'›',previous:'‹'},
    emptyTable:'Tidak ada data'
  },
  createdRow:function(row){$(row).find('td').css('font-size','.78rem');}
});
$('#fTipe,#fStatus,#fDivisi,#fLevel').on('change',function(){dtKaryawan.ajax.reload();});
let st;$('#fSearch').on('keyup',function(){clearTimeout(st);st=setTimeout(()=>dtKaryawan.ajax.reload(),400);});
</script>
@endpush
