@extends('layouts.app')
@section('title','Master Departemen')
@section('page-title','<i class="fas fa-building mr-2 text-primary"></i>Master Data — Departemen')
@section('breadcrumb')
  <li class="breadcrumb-item">Master Data</li>
  <li class="breadcrumb-item active">Departemen</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-5">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm"><h3 class="card-title">Tambah / Edit Departemen</h3></div>
      <div class="card-body">
        <div class="form-group">
          <label>Divisi</label>
          <select id="deptDivisi" class="form-control form-control-sm select2bs4" style="width:100%">
            <option value="">-- Pilih Divisi --</option>
            @foreach($divisis as $d)
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Nama Departemen <span class="text-danger">*</span></label>
          <input type="text" id="deptNama" class="form-control form-control-sm" placeholder="Nama departemen">
        </div>
        <div class="form-group">
          <label>Kode</label>
          <input type="text" id="deptKode" class="form-control form-control-sm" placeholder="Kode singkat">
        </div>
        <input type="hidden" id="deptId">
        <div class="d-flex gap-2">
          <button onclick="saveDept()" class="btn btn-primary btn-sm mr-2">
            <i class="fas fa-save mr-1"></i><span id="deptBtnLabel">Simpan</span>
          </button>
          <button onclick="resetDeptForm()" class="btn btn-default btn-sm">
            <i class="fas fa-undo mr-1"></i>Reset
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="card card-outline card-success">
      <div class="card-header card-header-sm">
        <h3 class="card-title">Daftar Departemen <span class="badge badge-primary ml-1">{{ $departemens->count() }}</span></h3>
      </div>
      <div class="card-body p-0">
        <table id="deptTable" class="table table-sm table-bordered table-striped table-hover mb-0" style="font-size:.78rem">
          <thead class="thead-dark">
            <tr><th>#</th><th>Nama Departemen</th><th>Divisi</th><th class="text-center">Karyawan</th><th>Status</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            @foreach($departemens as $i => $d)
            <tr id="row-dept-{{ $d->id }}">
              <td>{{ $i+1 }}</td>
              <td>{{ $d->nama }}</td>
              <td><small>{{ $d->divisi?->nama ?? '—' }}</small></td>
              <td class="text-center">{{ $d->karyawans_count }}</td>
              <td><span class="badge {{ $d->is_active ? 'badge-success':'badge-secondary' }}">{{ $d->is_active ? 'Aktif':'Off' }}</span></td>
              <td>
                <div class="btn-group btn-group-sm">
                  <button onclick="editDept({{ $d->id }},'{{ addslashes($d->nama) }}','{{ $d->kode }}',{{ $d->divisi_id ?? 'null' }})"
                    class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
                  <button onclick="deleteDept({{ $d->id }})" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
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
$('#deptTable').DataTable({pageLength:20,language:{search:'Cari:',lengthMenu:'_MENU_',info:'_START_-_END_ / _TOTAL_',paginate:{first:'«',last:'»',next:'›',previous:'‹'}}});

function saveDept() {
  const id     = $('#deptId').val();
  const nama   = $('#deptNama').val().trim();
  const kode   = $('#deptKode').val().trim();
  const divisi = $('#deptDivisi').val();
  if (!nama) { alert('Nama departemen wajib diisi!'); return; }
  const url    = id ? '/master/departemen/'+id : '/master/departemen';
  const method = id ? 'PUT' : 'POST';
  $.ajax({ url, type:method,
    data:{ nama, kode, divisi_id:divisi, _token:$('meta[name="csrf-token"]').attr('content') },
    success:function(res){ if(res.success){alert(res.message);location.reload();} },
    error:function(xhr){alert(xhr.responseJSON?.message||'Terjadi kesalahan.');}
  });
}
function editDept(id, nama, kode, divisiId) {
  $('#deptId').val(id); $('#deptNama').val(nama); $('#deptKode').val(kode);
  if (divisiId) $('#deptDivisi').val(divisiId).trigger('change');
  $('#deptBtnLabel').text('Update');
  $('html,body').animate({scrollTop:0},300);
}
function deleteDept(id) {
  if (!confirm('Hapus departemen ini?')) return;
  $.ajax({ url:'/master/departemen/'+id, type:'DELETE',
    data:{ _token:$('meta[name="csrf-token"]').attr('content') },
    success:function(res){ if(res.success){$('#row-dept-'+id).remove();}else{alert(res.message);} },
    error:function(xhr){alert(xhr.responseJSON?.message||'Tidak dapat dihapus.');}
  });
}
function resetDeptForm() {
  $('#deptId').val(''); $('#deptNama').val(''); $('#deptKode').val('');
  $('#deptDivisi').val(null).trigger('change');
  $('#deptBtnLabel').text('Simpan');
}
</script>
@endpush
