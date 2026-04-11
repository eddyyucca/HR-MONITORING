@extends('layouts.app')
@section('title','Master Jabatan')
@section('page-title','<i class="fas fa-id-badge mr-2 text-primary"></i>Master Data — Jabatan')
@section('breadcrumb')
  <li class="breadcrumb-item">Master Data</li>
  <li class="breadcrumb-item active">Jabatan</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm"><h3 class="card-title">Tambah / Edit Jabatan</h3></div>
      <div class="card-body">
        <div class="form-group">
          <label>Departemen</label>
          <select id="jabDept" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Pilih Departemen --</option>
            @foreach($departemens as $d)
              <option value="{{ $d->id }}">{{ $d->nama }} — {{ $d->divisi?->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Nama Jabatan <span class="text-danger">*</span></label>
          <input type="text" id="jabNama" class="form-control form-control-sm" placeholder="Nama jabatan/posisi">
        </div>
        <div class="row">
          <div class="col-7"><div class="form-group">
            <label>Level</label>
            <select id="jabLevel" class="form-control form-control-sm">
              <option value="">-- Pilih --</option>
              @foreach(['Executive Committee','General Manager','Senior Manager','Manager','Assistant Manager','Supervisor','Officer','Labour Supply','Non-Staff'] as $l)
                <option value="{{ $l }}">{{ $l }}</option>
              @endforeach
            </select>
          </div></div>
          <div class="col-5"><div class="form-group">
            <label>Grade</label>
            <input type="number" id="jabGrade" class="form-control form-control-sm" min="1" max="20" placeholder="10-15">
          </div></div>
        </div>
        <input type="hidden" id="jabId">
        <div class="d-flex gap-2">
          <button onclick="saveJab()" class="btn btn-primary btn-sm mr-2">
            <i class="fas fa-save mr-1"></i><span id="jabBtnLabel">Simpan</span>
          </button>
          <button onclick="resetJabForm()" class="btn btn-default btn-sm">
            <i class="fas fa-undo mr-1"></i>Reset
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card card-outline card-success">
      <div class="card-header card-header-sm">
        <h3 class="card-title">Daftar Jabatan <span class="badge badge-primary ml-1">{{ $jabatans->count() }}</span></h3>
      </div>
      <div class="card-body p-0">
        <table id="jabTable" class="table table-sm table-bordered table-striped table-hover mb-0" style="font-size:.78rem">
          <thead class="thead-dark">
            <tr><th>#</th><th>Nama Jabatan</th><th>Level</th><th>Grade</th><th>Departemen</th><th class="text-center">Karyawan</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            @foreach($jabatans as $i => $j)
            <tr id="row-jab-{{ $j->id }}">
              <td>{{ $i+1 }}</td>
              <td>{{ $j->nama }}</td>
              <td><span class="badge badge-info" style="font-size:.65rem">{{ $j->level ?: '—' }}</span></td>
              <td>{{ $j->grade ?: '—' }}</td>
              <td><small>{{ $j->departemen?->nama ?? '—' }}</small></td>
              <td class="text-center">{{ $j->karyawans_count }}</td>
              <td>
                <div class="btn-group btn-group-sm">
                  <button onclick="editJab({{ $j->id }},'{{ addslashes($j->nama) }}','{{ $j->level }}',{{ $j->grade ?? 'null' }},{{ $j->departemen_id ?? 'null' }})"
                    class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
                  <button onclick="deleteJab({{ $j->id }})" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$('#jabTable').DataTable({pageLength:20,language:{search:'Cari:',lengthMenu:'_MENU_',info:'_START_-_END_ / _TOTAL_',paginate:{first:'«',last:'»',next:'›',previous:'‹'}}});

function saveJab() {
  const id    = $('#jabId').val();
  const nama  = $('#jabNama').val().trim();
  const level = $('#jabLevel').val();
  const grade = $('#jabGrade').val();
  const dept  = $('#jabDept').val();
  if (!nama) { alert('Nama jabatan wajib diisi!'); return; }
  const url    = id ? '/master/jabatan/'+id : '/master/jabatan';
  const method = id ? 'PUT' : 'POST';
  $.ajax({ url, type:method,
    data:{ nama, level, grade, departemen_id:dept, _token:$('meta[name="csrf-token"]').attr('content') },
    success:function(res){ if(res.success){alert(res.message);location.reload();} },
    error:function(xhr){alert(xhr.responseJSON?.message||'Terjadi kesalahan.');}
  });
}
function editJab(id, nama, level, grade, deptId) {
  $('#jabId').val(id); $('#jabNama').val(nama); $('#jabLevel').val(level); $('#jabGrade').val(grade);
  if (deptId) $('#jabDept').val(deptId).trigger('change');
  $('#jabBtnLabel').text('Update');
  $('html,body').animate({scrollTop:0},300);
}
function deleteJab(id) {
  if (!confirm('Hapus jabatan ini?')) return;
  $.ajax({ url:'/master/jabatan/'+id, type:'DELETE',
    data:{ _token:$('meta[name="csrf-token"]').attr('content') },
    success:function(res){ if(res.success){$('#row-jab-'+id).remove();}else{alert(res.message);} },
    error:function(xhr){alert(xhr.responseJSON?.message||'Tidak dapat dihapus.');}
  });
}
function resetJabForm() {
  $('#jabId,#jabNama,#jabGrade').val('');
  $('#jabLevel,#jabDept').val(null).trigger('change');
  $('#jabBtnLabel').text('Simpan');
}
</script>
@endpush
