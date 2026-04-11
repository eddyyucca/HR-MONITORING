@extends('layouts.app')
@section('title','Tambah Kandidat')
@section('page-title','<i class="fas fa-user-plus mr-2 text-primary"></i>Tambah Kandidat Rekrutmen')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('rekrutmen.index') }}">Rekrutmen</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<form method="POST" action="{{ route('rekrutmen.store') }}">
  @csrf
  <div class="row">
    {{-- Kolom Kiri --}}
    <div class="col-md-6">
      <div class="card card-outline card-primary">
        <div class="card-header card-header-sm"><h3 class="card-title">Identitas Kandidat</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
              value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap kandidat">
            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control form-control-sm" value="{{ old('no_telp') }}" placeholder="08xx">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control form-control-sm">
                  <option value="">-- Pilih --</option>
                  <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Laki-laki</option>
                  <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Perempuan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" placeholder="email@example.com">
          </div>
        </div>
      </div>

      <div class="card card-outline card-info">
        <div class="card-header card-header-sm"><h3 class="card-title">Posisi & Penempatan</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Plan Job Title <span class="text-danger">*</span></label>
            <input type="text" name="plan_job_title" class="form-control @error('plan_job_title') is-invalid @enderror"
              value="{{ old('plan_job_title') }}" required placeholder="Nama posisi yang dilamar">
            @error('plan_job_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Divisi</label>
            <select name="divisi_id" id="divisiSelect" class="form-control form-control-sm select2bs4" style="width:100%">
              <option value="">-- Pilih Divisi --</option>
              @foreach($divisis as $d)
                <option value="{{ $d->id }}" {{ old('divisi_id')==$d->id?'selected':'' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Departemen</label>
            <select name="departemen_id" id="deptSelect" class="form-control form-control-sm select2bs4" style="width:100%">
              <option value="">-- Pilih Departemen --</option>
              @foreach($departemens as $d)
                <option value="{{ $d->id }}" {{ old('departemen_id')==$d->id?'selected':'' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Category Level</label>
            <select name="category_level" class="form-control form-control-sm select2bs4" style="width:100%">
              <option value="">-- Pilih --</option>
              @foreach($levelOptions as $l)
                <option value="{{ $l }}" {{ old('category_level')==$l?'selected':'' }}>{{ $l }}</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Site</label>
                <input type="text" name="site" class="form-control form-control-sm" value="{{ old('site','Konawe') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>User PIC</label>
                <input type="text" name="user_pic" class="form-control form-control-sm" value="{{ old('user_pic') }}" placeholder="Nama PIC">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Kolom Kanan --}}
    <div class="col-md-6">
      <div class="card card-outline card-success">
        <div class="card-header card-header-sm"><h3 class="card-title">Status & Progress</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control form-control-sm">
                  <option value="Open" {{ old('status','Open')=='Open'?'selected':'' }}>Open</option>
                  <option value="In Progress" {{ old('status')=='In Progress'?'selected':'' }}>In Progress</option>
                  <option value="Closed" {{ old('status')=='Closed'?'selected':'' }}>Closed</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Progress <span class="text-danger">*</span></label>
                <select name="progress" class="form-control form-control-sm select2bs4" style="width:100%">
                  @foreach($progressOptions as $p)
                    <option value="{{ $p }}" {{ old('progress','Compro')==$p?'selected':'' }}>{{ $p }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Priority</label>
                <select name="priority" class="form-control form-control-sm">
                  <option value="">-- Pilih --</option>
                  <option value="P1" {{ old('priority')=='P1'?'selected':'' }}>P1 - Prioritas Utama</option>
                  <option value="P2" {{ old('priority')=='P2'?'selected':'' }}>P2 - Sedang</option>
                  <option value="P3" {{ old('priority')=='P3'?'selected':'' }}>P3 - Rendah</option>
                  <option value="NP" {{ old('priority')=='NP'?'selected':'' }}>NP - Non Priority</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Status ATA</label>
                <select name="status_ata" class="form-control form-control-sm">
                  <option value="">-- Pilih --</option>
                  <option value="Full Approval" {{ old('status_ata')=='Full Approval'?'selected':'' }}>Full Approval</option>
                  <option value="Not Yet" {{ old('status_ata')=='Not Yet'?'selected':'' }}>Not Yet</option>
                  <option value="Pending" {{ old('status_ata')=='Pending'?'selected':'' }}>Pending</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Sumber Rekrutmen</label>
            <select name="sourch" class="form-control form-control-sm select2bs4" style="width:100%">
              <option value="">-- Pilih --</option>
              @foreach($sourchOptions as $s)
                <option value="{{ $s }}" {{ old('sourch')==$s?'selected':'' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="card card-outline card-warning">
        <div class="card-header card-header-sm"><h3 class="card-title">Timeline & SLA</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Bulan</label>
                <select name="month_number" class="form-control form-control-sm select2bs4" style="width:100%">
                  <option value="">-- Pilih --</option>
                  @foreach($months as $n=>$m)
                    <option value="{{ $n }}" {{ old('month_number')==$n?'selected':'' }}>{{ $m }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Tahun</label>
                <input type="number" name="year" class="form-control form-control-sm" value="{{ old('year', date('Y')) }}" min="2020" max="2030">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Date Approved</label>
                <input type="date" name="date_approved" class="form-control form-control-sm" value="{{ old('date_approved') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Date Progress</label>
                <input type="date" name="date_progress" class="form-control form-control-sm" value="{{ old('date_progress') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>SLA (hari)</label>
            <input type="number" name="sla" class="form-control form-control-sm" value="{{ old('sla') }}" min="0" step="0.5" placeholder="Jumlah hari SLA">
          </div>
          <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control form-control-sm" rows="3" placeholder="Catatan...">{{ old('remarks') }}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end gap-2">
    <a href="{{ route('rekrutmen.index') }}" class="btn btn-default btn-sm mr-2">
      <i class="fas fa-times mr-1"></i>Batal
    </a>
    <button type="submit" class="btn btn-primary btn-sm">
      <i class="fas fa-save mr-1"></i>Simpan Kandidat
    </button>
  </div>
</form>
@endsection

@push('scripts')
<script>
$('#divisiSelect').on('change', function() {
  var divisiId = $(this).val();
  if (!divisiId) return;
  $.get('/ajax/departemen-by-divisi/' + divisiId, function(data) {
    var opts = '<option value="">-- Pilih Departemen --</option>';
    data.forEach(d => opts += `<option value="${d.id}">${d.nama}</option>`);
    $('#deptSelect').html(opts).trigger('change');
  });
});
</script>
@endpush
