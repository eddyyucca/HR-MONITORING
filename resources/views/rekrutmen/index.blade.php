@extends('layouts.app')
@section('title','Monitoring Rekrutmen')
@section('page-title','<i class="fas fa-search mr-2 text-primary"></i>Monitoring Rekrutmen')
@section('breadcrumb')
  <li class="breadcrumb-item active">Rekrutmen</li>
@endsection

@section('content')
{{-- FILTER --}}
<div class="filter-card">
  <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6c757d;margin-bottom:10px">
    <i class="fas fa-filter mr-1"></i>Filter Data
  </div>
  <form id="filterForm">
    <div class="row">
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Tahun</label>
          <select id="fYear" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            @foreach($years as $y)<option value="{{ $y }}" {{ ($filters['year'] ?? '') == $y ? 'selected':'' }}>{{ $y }}</option>@endforeach
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Bulan</label>
          <select id="fMonth" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $n=>$m)
              <option value="{{ $n }}" {{ ($filters['month'] ?? '') == $n ? 'selected':'' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Progress</label>
          <select id="fProgress" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            <option value="Compro" {{ ($filters['progress'] ?? '') == 'Compro' ? 'selected':'' }}>Compro</option>
            <option value="On Board" {{ ($filters['progress'] ?? '') == 'On Board' ? 'selected':'' }}>On Board</option>
            <option value="Failed - Interview" {{ ($filters['progress'] ?? '') == 'Failed - Interview' ? 'selected':'' }}>Failed - Interview</option>
            <option value="MCU">MCU</option>
            <option value="Offering Letter">Offering Letter</option>
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Level</label>
          <select id="fLevel" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            <option value="Non-Staff">Non-Staff</option>
            <option value="Officer">Officer</option>
            <option value="Supervisor">Supervisor</option>
            <option value="Assistant Manager">Assistant Manager</option>
            <option value="Manager">Manager</option>
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Divisi</label>
          <select id="fDivisi" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            @foreach($divisis as $d)<option value="{{ $d->id }}" {{ ($filters['divisi_id'] ?? '') == $d->id ? 'selected':'' }}>{{ $d->nama }}</option>@endforeach
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Priority</label>
          <select id="fPriority" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            <option value="P1">P1 - Utama</option>
            <option value="P2">P2 - Sedang</option>
            <option value="P3">P3 - Rendah</option>
            <option value="NP">NP - Non Priority</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Sumber</label>
          <select id="fSourch" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            <option value="Referral">Referral</option>
            <option value="BSI">BSI</option>
            <option value="LinkedIn">LinkedIn</option>
            <option value="PUS">PUS</option>
          </select>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="form-group">
          <label>Gender</label>
          <select id="fGender" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Semua --</option>
            <option value="Male">Laki-laki</option>
            <option value="Female">Perempuan</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Cari Nama / Posisi</label>
          <input type="text" id="fSearch" class="form-control form-control-sm" placeholder="Ketik nama atau posisi...">
        </div>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <div class="form-group w-100">
          <button type="button" onclick="reloadTable()" class="btn btn-primary btn-sm btn-block">
            <i class="fas fa-search mr-1"></i>Terapkan
          </button>
        </div>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <div class="form-group w-100">
          <button type="button" onclick="resetFilter()" class="btn btn-default btn-sm btn-block">
            <i class="fas fa-undo mr-1"></i>Reset
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

{{-- Action Bar --}}
<div class="d-flex justify-content-between align-items-center mb-2">
  <div>
    <a href="{{ route('rekrutmen.create') }}" class="btn btn-primary btn-sm">
      <i class="fas fa-plus mr-1"></i>Tambah Kandidat
    </a>
    <button class="btn btn-secondary btn-sm ml-1" onclick="toggleView()">
      <i class="fas fa-columns mr-1"></i>Pipeline View
    </button>
  </div>
  <div>
    <a href="{{ route('rekrutmen.export.excel') }}" class="btn btn-success btn-sm">
      <i class="fas fa-file-excel mr-1"></i>Export Excel
    </a>
  </div>
</div>

{{-- TABLE VIEW --}}
<div id="tableView">
  <div class="card card-outline card-primary">
    <div class="card-header card-header-sm">
      <h3 class="card-title"><i class="fas fa-table mr-1"></i>Tabel Kandidat</h3>
      <div class="card-tools">
        <span class="badge badge-primary" id="recordCount">Loading...</span>
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="rekrutmenTable" class="table table-bordered table-striped table-hover table-sm mb-0">
          <thead class="thead-dark">
            <tr>
              <th width="35">#</th>
              <th>Nama Kandidat</th>
              <th>Posisi</th>
              <th>Divisi</th>
              <th>Dept</th>
              <th>Level</th>
              <th>Gender</th>
              <th>Progress</th>
              <th>Priority</th>
              <th>Sumber</th>
              <th>SLA</th>
              <th>Bulan/Tahun</th>
              <th width="100">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- KANBAN VIEW --}}
<div id="kanbanView" style="display:none">
  <div class="row">
    <div class="col-md-4">
      <div class="card card-outline" style="border-top:4px solid #6f42c1">
        <div class="card-header card-header-sm" style="background:rgba(111,66,193,.1)">
          <h3 class="card-title" style="color:#6f42c1"><i class="fas fa-spinner mr-1"></i>Compro / Pipeline</h3>
          <div class="card-tools"><span class="badge" style="background:#6f42c1" id="cnt-compro">0</span></div>
        </div>
        <div class="card-body p-2" id="kanban-compro" style="max-height:600px;overflow-y:auto"></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-outline card-success" style="border-top:4px solid #28a745">
        <div class="card-header card-header-sm bg-light-green">
          <h3 class="card-title text-success"><i class="fas fa-user-check mr-1"></i>On Board</h3>
          <div class="card-tools"><span class="badge badge-success" id="cnt-onboard">0</span></div>
        </div>
        <div class="card-body p-2" id="kanban-onboard"></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-outline card-danger" style="border-top:4px solid #dc3545">
        <div class="card-header card-header-sm">
          <h3 class="card-title text-danger"><i class="fas fa-times-circle mr-1"></i>Failed — Interview</h3>
          <div class="card-tools"><span class="badge badge-danger" id="cnt-failed">0</span></div>
        </div>
        <div class="card-body p-2" id="kanban-failed" style="max-height:600px;overflow-y:auto"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
let dtTable = null;
let isKanban = false;

function getFilters() {
  return {
    year:     $('#fYear').val(),
    month:    $('#fMonth').val(),
    progress: $('#fProgress').val(),
    category_level: $('#fLevel').val(),
    divisi_id: $('#fDivisi').val(),
    priority: $('#fPriority').val(),
    sourch:   $('#fSourch').val(),
    gender:   $('#fGender').val(),
    search:   $('#fSearch').val(),
  };
}

function initTable() {
  if (dtTable) { dtTable.destroy(); dtTable = null; }
  dtTable = $('#rekrutmenTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '{{ route("rekrutmen.datatables") }}',
      data: function(d) { return $.extend(d, getFilters()); }
    },
    columns: [
      {data:'DT_RowIndex', orderable:false, searchable:false},
      {data:'nama_lengkap'},
      {data:'plan_job_title'},
      {data:'divisi_nama', orderable:false},
      {data:'dept_nama', orderable:false},
      {data:'category_level'},
      {data:'gender'},
      {data:'progress_badge', orderable:false},
      {data:'priority_badge', orderable:false},
      {data:'sourch'},
      {data:'sla_html', orderable:false},
      {data:function(r){return (r.month_name||'')+(r.year?' '+r.year:'')}, orderable:false},
      {data:'action', orderable:false},
    ],
    order:[[7,'asc']],
    pageLength:15,
    lengthMenu:[10,15,25,50,100],
    language:{
      processing:'<i class="fas fa-spinner fa-spin"></i> Loading...',
      search:'Cari:',lengthMenu:'Tampilkan _MENU_',
      info:'_START_–_END_ dari _TOTAL_',
      paginate:{first:'«',last:'»',next:'›',previous:'‹'},
      emptyTable:'Tidak ada data'
    },
    drawCallback: function() {
      $('#recordCount').text(this.api().page.info().recordsTotal + ' records');
      $('[data-toggle="tooltip"]').tooltip();
    },
    createdRow: function(row, data) {
      $(row).find('td').css('font-size','.78rem');
    }
  });
}

function reloadTable() {
  if (dtTable) dtTable.ajax.reload();
  if (isKanban) loadKanban();
}

function resetFilter() {
  $('#fYear,#fMonth,#fProgress,#fLevel,#fDivisi,#fPriority,#fSourch,#fGender').val(null).trigger('change');
  $('#fSearch').val('');
  reloadTable();
}

function toggleView() {
  isKanban = !isKanban;
  if (isKanban) {
    $('#tableView').hide(); $('#kanbanView').show();
    loadKanban();
  } else {
    $('#kanbanView').hide(); $('#tableView').show();
  }
}

function loadKanban() {
  const filters = getFilters();
  ['Compro','On Board','Failed - Interview'].forEach(prog => {
    $.get('{{ route("rekrutmen.datatables") }}', $.extend({}, filters, {progress: prog, length: 100, start: 0}), function(res) {
      const data = res.data || [];
      const ids = {'Compro':'kanban-compro','On Board':'kanban-onboard','Failed - Interview':'kanban-failed'};
      const cnts = {'Compro':'cnt-compro','On Board':'cnt-onboard','Failed - Interview':'cnt-failed'};
      const prioColors = {P1:'danger',P2:'warning',P3:'info',NP:'secondary'};
      const html = data.map(d => `
        <div class="card card-body p-2 mb-2 shadow-sm" style="border-left:3px solid ${prog==='Compro'?'#6f42c1':prog==='On Board'?'#28a745':'#dc3545'}">
          <div class="font-weight-bold" style="font-size:.78rem">${d.nama_lengkap}</div>
          <div class="text-muted" style="font-size:.7rem">${d.plan_job_title}</div>
          <div class="mt-1">
            ${d.divisi_nama !== '—' ? `<span class="badge badge-light border" style="font-size:.6rem">${d.divisi_nama.split(' ')[0]}</span> ` : ''}
            ${d.category_level ? `<span class="badge badge-info" style="font-size:.6rem">${d.category_level}</span> ` : ''}
            ${d.priority_badge}
          </div>
          <div class="d-flex justify-content-between mt-1">
            <small class="text-muted">${d.sourch||'—'}</small>
            <a href="/rekrutmen/${d.id}" class="text-primary" style="font-size:.7rem"><i class="fas fa-eye"></i></a>
          </div>
        </div>`).join('');
      $('#'+ids[prog]).html(html || '<p class="text-muted text-center small py-3">Tidak ada data</p>');
      $('#'+cnts[prog]).text(res.recordsFiltered || data.length);
    });
  });
}

$(document).ready(function() {
  $('.select2bs4').select2({theme:'bootstrap4',allowClear:true,placeholder:'-- Semua --'});
  initTable();
  $('#fYear,#fMonth,#fProgress,#fLevel,#fDivisi,#fPriority,#fSourch,#fGender').on('change', reloadTable);
  let searchTimer;
  $('#fSearch').on('keyup', function() { clearTimeout(searchTimer); searchTimer = setTimeout(reloadTable, 500); });
});
</script>
@endpush
