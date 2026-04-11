@extends('layouts.app')
@section('title','Master Divisi')
@section('page-title','<i class="fas fa-sitemap mr-2 text-primary"></i>Master Data — Divisi')
@section('breadcrumb')
  <li class="breadcrumb-item">Master Data</li>
  <li class="breadcrumb-item active">Divisi</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-5">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm"><h3 class="card-title">Tambah / Edit Divisi</h3></div>
      <div class="card-body">
        <div class="form-group">
          <label>Nama Divisi <span class="text-danger">*</span></label>
          <input type="text" id="divisiNama" class="form-control form-control-sm" placeholder="Nama divisi">
        </div>
        <div class="form-group">
          <label>Kode</label>
          <input type="text" id="divisiKode" class="form-control form-control-sm" placeholder="Kode singkat (optional)">
        </div>
        <input type="hidden" id="divisiId">
        <div class="d-flex gap-2">
          <button onclick="saveDivisi()" class="btn btn-primary btn-sm mr-2">
            <i class="fas fa-save mr-1"></i><span id="btnLabel">Simpan</span>
          </button>
          <button onclick="resetForm()" class="btn btn-default btn-sm">
            <i class="fas fa-undo mr-1"></i>Reset
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="card card-outline card-success">
      <div class="card-header card-header-sm">
        <h3 class="card-title">Daftar Divisi <span class="badge badge-primary ml-1">{{ $divisis->count() }}</span></h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-sm table-bordered table-striped table-hover mb-0" style="font-size:.8rem">
          <thead class="thead-dark">
            <tr><th>#</th><th>Nama Divisi</th><th>Kode</th><th class="text-center">Dept</th><th class="text-center">Karyawan</th><th class="text-center">Status</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            @foreach($divisis as $i => $d)
            <tr id="row-div-{{ $d->id }}">
              <td>{{ $i+1 }}</td>
              <td>{{ $d->nama }}</td>
              <td>{{ $d->kode ?: '—' }}</td>
              <td class="text-center">{{ $d->departemens_count }}</td>
              <td class="text-center">{{ $d->karyawans_count }}</td>
              <td class="text-center">
                <span class="badge {{ $d->is_active ? 'badge-success':'badge-secondary' }}">
                  {{ $d->is_active ? 'Aktif':'Nonaktif' }}
                </span>
              </td>
              <td>
                <div class="btn-group btn-group-sm">
                  <button onclick="editDivisi({{ $d->id }},'{{ addslashes($d->nama) }}','{{ $d->kode }}')"
                    class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
                  <button onclick="deleteDivisi({{ $d->id }})" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
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
function saveDivisi() {
  const id   = $('#divisiId').val();
  const nama = $('#divisiNama').val().trim();
  const kode = $('#divisiKode').val().trim();
  if (!nama) { alert('Nama divisi wajib diisi!'); return; }
  const url    = id ? '/master/divisi/' + id : '/master/divisi';
  const method = id ? 'PUT' : 'POST';
  $.ajax({ url, type: method, data: { nama, kode, _token: $('meta[name="csrf-token"]').attr('content') },
    success: function(res) {
      if (res.success) { alert(res.message); location.reload(); }
    },
    error: function(xhr) { alert(xhr.responseJSON?.message || 'Terjadi kesalahan.'); }
  });
}
function editDivisi(id, nama, kode) {
  $('#divisiId').val(id);
  $('#divisiNama').val(nama);
  $('#divisiKode').val(kode);
  $('#btnLabel').text('Update');
  $('html,body').animate({scrollTop:0},300);
}
function deleteDivisi(id) {
  if (!confirm('Hapus divisi ini?')) return;
  $.ajax({ url:'/master/divisi/'+id, type:'DELETE',
    data:{ _token:$('meta[name="csrf-token"]').attr('content') },
    success:function(res){ if(res.success){$('#row-div-'+id).remove();}else{alert(res.message);} },
    error:function(xhr){ alert(xhr.responseJSON?.message||'Tidak dapat dihapus.'); }
  });
}
function resetForm() {
  $('#divisiId').val(''); $('#divisiNama').val(''); $('#divisiKode').val('');
  $('#btnLabel').text('Simpan');
}
</script>
@endpush
