@extends('layouts.app')
@section('title','Edit Karyawan')
@section('page-title')
  <i class="fas fa-edit text-warning"></i> Edit Karyawan — {{ $kar->nama }}
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('karyawan.index') }}">Karyawan</a></li>
  <li class="breadcrumb-item"><a href="{{ route('karyawan.show',$kar->id) }}">{{ $kar->nama }}</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form method="POST" action="{{ route('karyawan.update',$kar->id) }}">
  @csrf @method('PUT')
  <div class="row">
    <div class="col-md-6">
      <div class="card card-outline card-primary">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-id-card text-primary"></i> Identitas</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label>Sapaan</label>
                <select name="salutation" class="form-control" data-placeholder="--">
                  <option value="">--</option>
                  @foreach(['Mr.','Mrs.','Ms.'] as $s)<option value="{{ $s }}" {{ old('salutation',$kar->salutation)==$s?'selected':'' }}>{{ $s }}</option>@endforeach
                </select>
              </div>
            </div>
            <div class="col-9">
              <div class="form-group">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                  value="{{ old('nama',$kar->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group">
              <label>No. Karyawan</label>
              <input type="text" name="no_karyawan" class="form-control" value="{{ old('no_karyawan',$kar->no_karyawan) }}">
            </div></div>
            <div class="col-6"><div class="form-group">
              <label>No. Telepon</label>
              <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp',$kar->no_telp) }}">
            </div></div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email',$kar->email) }}">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat',$kar->alamat) }}</textarea>
          </div>
          <div class="form-group">
            <label>Perusahaan</label>
            <input type="text" name="company" class="form-control" value="{{ old('company',$kar->company) }}">
          </div>
        </div>
      </div>

      <div class="card card-outline card-warning">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-dollar-sign text-warning"></i> Gaji & Tunjangan</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Gaji Pokok</label>
            <input type="number" name="basic_salary" class="form-control" value="{{ old('basic_salary',$kar->basic_salary) }}" min="0">
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Inpatient Local</label><input type="number" name="inpatient_local" class="form-control" value="{{ old('inpatient_local',$kar->inpatient_local) }}" min="0"></div></div>
            <div class="col-6"><div class="form-group"><label>Inpatient Interlokal</label><input type="number" name="inpatient_interlokal" class="form-control" value="{{ old('inpatient_interlokal',$kar->inpatient_interlokal) }}" min="0"></div></div>
          </div>
          <div class="row">
            <div class="col-4"><div class="form-group"><label>Outpatient</label><input type="number" name="outpatient" class="form-control" value="{{ old('outpatient',$kar->outpatient) }}" min="0"></div></div>
            <div class="col-4"><div class="form-group"><label>Frames</label><input type="number" name="frames" class="form-control" value="{{ old('frames',$kar->frames) }}" min="0"></div></div>
            <div class="col-4"><div class="form-group"><label>Lens</label><input type="number" name="lens" class="form-control" value="{{ old('lens',$kar->lens) }}" min="0"></div></div>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Weeks On</label><input type="number" name="weeks_on" class="form-control" value="{{ old('weeks_on',$kar->weeks_on) }}" min="0"></div></div>
            <div class="col-6"><div class="form-group"><label>Weeks Off</label><input type="number" name="weeks_off" class="form-control" value="{{ old('weeks_off',$kar->weeks_off) }}" min="0"></div></div>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Nama Penandatangan</label><input type="text" name="signature_name" class="form-control" value="{{ old('signature_name',$kar->signature_name) }}"></div></div>
            <div class="col-6"><div class="form-group"><label>Jabatan Penandatangan</label><input type="text" name="signature_title" class="form-control" value="{{ old('signature_title',$kar->signature_title) }}"></div></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card card-outline card-info">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-briefcase text-info"></i> Posisi & Penempatan</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Posisi <span class="text-danger">*</span></label>
            <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
              value="{{ old('position',$kar->position) }}" required>
            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Divisi</label>
            <select name="divisi_id" id="divisiSelect" class="form-control" data-placeholder="-- Pilih Divisi --">
              <option value="">-- Pilih --</option>
              @foreach($divisis as $d)
                <option value="{{ $d->id }}" {{ old('divisi_id',$kar->divisi_id)==$d->id?'selected':'' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Departemen</label>
            <select name="departemen_id" id="deptSelect" class="form-control" data-placeholder="-- Pilih Departemen --">
              <option value="">-- Pilih --</option>
              @foreach($departemens as $d)
                <option value="{{ $d->id }}" {{ old('departemen_id',$kar->departemen_id)==$d->id?'selected':'' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Tipe</label>
              <select name="tipe" class="form-control" data-placeholder="-- Pilih --">
                <option value="Staff" {{ old('tipe',$kar->tipe)=='Staff'?'selected':'' }}>Staff</option>
                <option value="Non-Staff" {{ old('tipe',$kar->tipe)=='Non-Staff'?'selected':'' }}>Non-Staff</option>
              </select>
            </div></div>
            <div class="col-6"><div class="form-group"><label>Level</label>
              <select name="level" class="form-control" data-placeholder="-- Pilih Level --">
                <option value="">-- Pilih --</option>
                @foreach($levelOptions as $l)<option value="{{ $l }}" {{ old('level',$kar->level)==$l?'selected':'' }}>{{ $l }}</option>@endforeach
              </select>
            </div></div>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Grade</label><input type="number" name="grade" class="form-control" value="{{ old('grade',$kar->grade) }}" min="1" max="20"></div></div>
            <div class="col-6"><div class="form-group"><label>POH</label><input type="text" name="poh" class="form-control" value="{{ old('poh',$kar->poh) }}"></div></div>
          </div>
          <div class="form-group"><label>Work Location</label><input type="text" name="work_location" class="form-control" value="{{ old('work_location',$kar->work_location) }}"></div>
        </div>
      </div>

      <div class="card card-outline card-success">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-file-contract text-success"></i> Kontrak</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Terms</label>
              <select name="terms" class="form-control" data-placeholder="-- Pilih --">
                <option value="PKWT" {{ old('terms',$kar->terms)=='PKWT'?'selected':'' }}>PKWT</option>
                <option value="PKWTT" {{ old('terms',$kar->terms)=='PKWTT'?'selected':'' }}>PKWTT</option>
              </select>
            </div></div>
            <div class="col-6"><div class="form-group"><label>Status</label>
              <select name="status" class="form-control" data-placeholder="-- Pilih --">
                @foreach(['Kontrak','Percobaan','Tetap','Selesai'] as $s)
                  <option value="{{ $s }}" {{ old('status',$kar->status)==$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
              </select>
            </div></div>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Durasi (ID)</label><input type="text" name="durasi" class="form-control" value="{{ old('durasi',$kar->durasi) }}"></div></div>
            <div class="col-6"><div class="form-group"><label>Durasi (EN)</label><input type="text" name="durasi_en" class="form-control" value="{{ old('durasi_en',$kar->durasi_en) }}"></div></div>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group"><label>Tgl OL</label><input type="date" name="tgl_ol" class="form-control" value="{{ old('tgl_ol',$kar->tgl_ol?->format('Y-m-d')) }}"></div></div>
            <div class="col-6"><div class="form-group"><label>Tgl Berakhir</label><input type="date" name="tgl_berakhir" class="form-control" value="{{ old('tgl_berakhir',$kar->tgl_berakhir?->format('Y-m-d')) }}"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-end mt-2">
    <a href="{{ route('karyawan.show',$kar->id) }}" class="btn btn-secondary btn-sm mr-2"><i class="fas fa-times mr-1"></i>Batal</a>
    <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-save mr-1"></i>Update Data</button>
  </div>
</form>
@endsection

@push('scripts')
<script>
$('#divisiSelect').on('change', function () {
  const id = $(this).val();
  if (!id) return;
  $.get('/ajax/departemen-by-divisi/' + id, function (data) {
    let opts = '<option value="">-- Pilih Departemen --</option>';
    data.forEach(d => opts += `<option value="${d.id}">${d.nama}</option>`);
    s2init($('#deptSelect').html(opts)[0]);
  });
});
</script>
@endpush
