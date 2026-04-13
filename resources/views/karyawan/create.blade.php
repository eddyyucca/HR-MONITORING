@extends('layouts.app')
@section('title','Tambah Karyawan')
@section('page-title')
  <i class="fas fa-user-plus text-primary"></i> Tambah Data Karyawan OL
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('karyawan.index') }}">Karyawan</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<form method="POST" action="{{ route('karyawan.store') }}">
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="card card-outline card-primary">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-id-card text-primary"></i> Identitas Karyawan</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <label>Sapaan</label>
                <select name="salutation" class="form-control" data-placeholder="--">
                  <option value="">--</option>
                  <option value="Mr." {{ old('salutation')=='Mr.'?'selected':'' }}>Mr.</option>
                  <option value="Mrs." {{ old('salutation')=='Mrs.'?'selected':'' }}>Mrs.</option>
                  <option value="Ms." {{ old('salutation')=='Ms.'?'selected':'' }}>Ms.</option>
                </select>
              </div>
            </div>
            <div class="col-9">
              <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                  value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>No. Karyawan</label>
                <input type="text" name="no_karyawan" class="form-control" value="{{ old('no_karyawan') }}" placeholder="Optional">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
          </div>
          <div class="form-group">
            <label>Perusahaan</label>
            <input type="text" name="company" class="form-control" value="{{ old('company','PT Sulawesi Cahaya Mineral') }}">
          </div>
        </div>
      </div>

      <div class="card card-outline card-warning">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-dollar-sign text-warning"></i> Gaji & Tunjangan</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Gaji Pokok (Rp)</label>
            <input type="number" name="basic_salary" class="form-control" value="{{ old('basic_salary') }}" min="0" step="1000">
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Weeks On</label>
                <input type="number" name="weeks_on" class="form-control" value="{{ old('weeks_on') }}" min="0">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Weeks Off</label>
                <input type="number" name="weeks_off" class="form-control" value="{{ old('weeks_off') }}" min="0">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Inpatient Local</label>
                <input type="number" name="inpatient_local" class="form-control" value="{{ old('inpatient_local') }}" min="0">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Inpatient Interlokal</label>
                <input type="number" name="inpatient_interlokal" class="form-control" value="{{ old('inpatient_interlokal') }}" min="0">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4"><div class="form-group">
              <label>Outpatient</label>
              <input type="number" name="outpatient" class="form-control" value="{{ old('outpatient') }}" min="0">
            </div></div>
            <div class="col-4"><div class="form-group">
              <label>Frames</label>
              <input type="number" name="frames" class="form-control" value="{{ old('frames') }}" min="0">
            </div></div>
            <div class="col-4"><div class="form-group">
              <label>Lens</label>
              <input type="number" name="lens" class="form-control" value="{{ old('lens') }}" min="0">
            </div></div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Nama Penandatangan</label>
                <input type="text" name="signature_name" class="form-control" value="{{ old('signature_name','Endah Carolina') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Jabatan Penandatangan</label>
                <input type="text" name="signature_title" class="form-control" value="{{ old('signature_title','HRGA Manager') }}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card card-outline card-info">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-briefcase text-info"></i> Posisi & Penempatan</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Posisi / Job Title <span class="text-danger">*</span></label>
            <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
              value="{{ old('position') }}" required>
            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Divisi</label>
            <select name="divisi_id" id="divisiSelect" class="form-control" data-placeholder="-- Pilih Divisi --">
              <option value="">-- Pilih Divisi --</option>
              @foreach($divisis as $d)
                <option value="{{ $d->id }}" {{ old('divisi_id')==$d->id?'selected':'' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Departemen</label>
            <select name="departemen_id" id="deptSelect" class="form-control" data-placeholder="-- Pilih Departemen --">
              <option value="">-- Pilih Departemen --</option>
              @foreach($departemens as $d)
                <option value="{{ $d->id }}" {{ old('departemen_id')==$d->id?'selected':'' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Tipe <span class="text-danger">*</span></label>
                <select name="tipe" class="form-control" data-placeholder="-- Pilih --">
                  <option value="Staff" {{ old('tipe','Staff')=='Staff'?'selected':'' }}>Staff</option>
                  <option value="Non-Staff" {{ old('tipe')=='Non-Staff'?'selected':'' }}>Non-Staff</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Level</label>
                <select name="level" class="form-control" data-placeholder="-- Pilih Level --">
                  <option value="">-- Pilih --</option>
                  @foreach($levelOptions as $l)
                    <option value="{{ $l }}" {{ old('level')==$l?'selected':'' }}>{{ $l }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Grade</label>
                <input type="number" name="grade" class="form-control" value="{{ old('grade') }}" min="1" max="20" placeholder="10-15">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>POH (Place of Hire)</label>
                <input type="text" name="poh" class="form-control" value="{{ old('poh') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Work Location</label>
            <input type="text" name="work_location" class="form-control" value="{{ old('work_location','Konawe Site') }}">
          </div>
          <div class="form-group">
            <label>Level Direct Report</label>
            <input type="text" name="level_direct_report" class="form-control" value="{{ old('level_direct_report') }}">
          </div>
        </div>
      </div>

      <div class="card card-outline card-success">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-file-contract text-success"></i> Kontrak</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Terms <span class="text-danger">*</span></label>
                <select name="terms" class="form-control" data-placeholder="-- Pilih --">
                  <option value="PKWT" {{ old('terms','PKWT')=='PKWT'?'selected':'' }}>PKWT</option>
                  <option value="PKWTT" {{ old('terms')=='PKWTT'?'selected':'' }}>PKWTT</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" data-placeholder="-- Pilih --">
                  <option value="Kontrak" {{ old('status','Kontrak')=='Kontrak'?'selected':'' }}>Kontrak</option>
                  <option value="Percobaan" {{ old('status')=='Percobaan'?'selected':'' }}>Percobaan/Probation</option>
                  <option value="Tetap" {{ old('status')=='Tetap'?'selected':'' }}>Tetap</option>
                  <option value="Selesai" {{ old('status')=='Selesai'?'selected':'' }}>Selesai</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Durasi (ID)</label>
                <input type="text" name="durasi" class="form-control" value="{{ old('durasi') }}" placeholder="12 Bulan">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Durasi (EN)</label>
                <input type="text" name="durasi_en" class="form-control" value="{{ old('durasi_en') }}" placeholder="12 Months">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Tanggal OL / Join</label>
                <input type="date" name="tgl_ol" class="form-control" value="{{ old('tgl_ol') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Tgl Berakhir Kontrak</label>
                <input type="date" name="tgl_berakhir" class="form-control" value="{{ old('tgl_berakhir') }}">
              </div>
            </div>
          </div>
          @if(request('rekrutmen_id'))
            <input type="hidden" name="rekrutmen_id" value="{{ request('rekrutmen_id') }}">
          @else
          <div class="form-group">
            <label>Dari Rekrutmen</label>
            <select name="rekrutmen_id" class="form-control" data-placeholder="-- Pilih (opsional) --">
              <option value="">-- Pilih (opsional) --</option>
              @foreach($rekrutmens as $r)
                <option value="{{ $r->id }}" {{ old('rekrutmen_id')==$r->id?'selected':'' }}>{{ $r->nama_lengkap }} — {{ $r->plan_job_title }}</option>
              @endforeach
            </select>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end mt-2">
    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary btn-sm mr-2">
      <i class="fas fa-times mr-1"></i>Batal
    </a>
    <button type="submit" class="btn btn-primary btn-sm">
      <i class="fas fa-save mr-1"></i>Simpan Karyawan
    </button>
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
