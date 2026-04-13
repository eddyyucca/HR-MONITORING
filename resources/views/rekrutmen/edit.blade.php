@extends('layouts.app')
@section('title', 'Edit Kandidat')
@section('page-title')
  <i class="fas fa-edit text-warning"></i> Edit Kandidat — {{ $rek->nama_lengkap }}
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('rekrutmen.index') }}">Rekrutmen</a></li>
  <li class="breadcrumb-item"><a href="{{ route('rekrutmen.show', $rek->id) }}">{{ $rek->nama_lengkap }}</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form method="POST" action="{{ route('rekrutmen.update', $rek->id) }}">
  @csrf @method('PUT')
  <div class="row">

    <div class="col-md-6">

      <div class="card card-outline card-primary">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-id-card text-primary"></i> Identitas Kandidat</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama_lengkap"
              class="form-control @error('nama_lengkap') is-invalid @enderror"
              value="{{ old('nama_lengkap', $rek->nama_lengkap) }}" required>
            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $rek->no_telp) }}">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control" data-placeholder="-- Pilih --">
                  <option value="">-- Pilih --</option>
                  <option value="Male"   {{ old('gender', $rek->gender)=='Male'   ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Female" {{ old('gender', $rek->gender)=='Female' ? 'selected' : '' }}>Perempuan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $rek->email) }}">
          </div>
        </div>
      </div>

      <div class="card card-outline card-info">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-briefcase text-info"></i> Posisi & Penempatan</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Plan Job Title <span class="text-danger">*</span></label>
            <input type="text" name="plan_job_title"
              class="form-control @error('plan_job_title') is-invalid @enderror"
              value="{{ old('plan_job_title', $rek->plan_job_title) }}" required>
            @error('plan_job_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Divisi</label>
            <select name="divisi_id" id="divisiSelect" class="form-control" data-placeholder="-- Pilih Divisi --">
              <option value="">-- Pilih Divisi --</option>
              @foreach($divisis as $d)
                <option value="{{ $d->id }}" {{ old('divisi_id', $rek->divisi_id)==$d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Departemen</label>
            <select name="departemen_id" id="deptSelect" class="form-control" data-placeholder="-- Pilih Departemen --">
              <option value="">-- Pilih Departemen --</option>
              @foreach($departemens as $d)
                <option value="{{ $d->id }}" {{ old('departemen_id', $rek->departemen_id)==$d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Category Level</label>
            <select name="category_level" class="form-control" data-placeholder="-- Pilih Level --">
              <option value="">-- Pilih Level --</option>
              @foreach($levelOptions as $l)
                <option value="{{ $l }}" {{ old('category_level', $rek->category_level)==$l ? 'selected' : '' }}>{{ $l }}</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Site</label>
                <input type="text" name="site" class="form-control" value="{{ old('site', $rek->site) }}">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>User PIC</label>
                <input type="text" name="user_pic" class="form-control" value="{{ old('user_pic', $rek->user_pic) }}">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="col-md-6">

      <div class="card card-outline card-success">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-tasks text-success"></i> Status & Progress</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                  @foreach(['Open', 'In Progress', 'Closed'] as $s)
                    <option value="{{ $s }}" {{ old('status', $rek->status)==$s ? 'selected' : '' }}>{{ $s }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Progress</label>
                <select name="progress" class="form-control" data-placeholder="-- Pilih Progress --">
                  @foreach($progressOptions as $p)
                    <option value="{{ $p }}" {{ old('progress', $rek->progress)==$p ? 'selected' : '' }}>{{ $p }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Priority</label>
                <select name="priority" class="form-control" data-placeholder="-- Pilih --">
                  <option value="">-- Pilih --</option>
                  @foreach(['P1' => 'P1 — Utama', 'P2' => 'P2 — Sedang', 'P3' => 'P3 — Rendah', 'NP' => 'Non Priority'] as $v => $l)
                    <option value="{{ $v }}" {{ old('priority', $rek->priority)==$v ? 'selected' : '' }}>{{ $l }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Status ATA</label>
                <select name="status_ata" class="form-control" data-placeholder="-- Pilih --">
                  <option value="">-- Pilih --</option>
                  @foreach(['Full Approval', 'Not Yet', 'Pending'] as $s)
                    <option value="{{ $s }}" {{ old('status_ata', $rek->status_ata)==$s ? 'selected' : '' }}>{{ $s }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Sumber Rekrutmen</label>
            <select name="sourch" class="form-control" data-placeholder="-- Pilih Sumber --">
              <option value="">-- Pilih Sumber --</option>
              @foreach($sourchOptions as $s)
                <option value="{{ $s }}" {{ old('sourch', $rek->sourch)==$s ? 'selected' : '' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="card card-outline card-warning">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-calendar-alt text-warning"></i> Timeline & SLA</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Bulan</label>
                <select name="month_number" class="form-control" data-placeholder="-- Pilih Bulan --">
                  <option value="">-- Pilih Bulan --</option>
                  @foreach($months as $n => $m)
                    <option value="{{ $n }}" {{ old('month_number', $rek->month_number)==$n ? 'selected' : '' }}>{{ $m }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Tahun</label>
                <input type="number" name="year" class="form-control"
                  value="{{ old('year', $rek->year) }}" min="2020" max="2030">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Date Approved</label>
                <input type="date" name="date_approved" class="form-control"
                  value="{{ old('date_approved', $rek->date_approved?->format('Y-m-d')) }}">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label>Date Progress</label>
                <input type="date" name="date_progress" class="form-control"
                  value="{{ old('date_progress', $rek->date_progress?->format('Y-m-d')) }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>SLA (hari)</label>
            <input type="number" name="sla" class="form-control"
              value="{{ old('sla', $rek->sla) }}" min="0" step="0.5">
          </div>
          <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="3">{{ old('remarks', $rek->remarks) }}</textarea>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="d-flex justify-content-end mt-2">
    <a href="{{ route('rekrutmen.show', $rek->id) }}" class="btn btn-secondary btn-sm mr-2">
      <i class="fas fa-times mr-1"></i>Batal
    </a>
    <button type="submit" class="btn btn-warning btn-sm">
      <i class="fas fa-save mr-1"></i>Update Data
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
