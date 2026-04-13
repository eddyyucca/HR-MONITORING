@extends('layouts.app')
@section('title','Tambah Posisi MPP')
@section('page-title')
  <i class="fas fa-plus text-primary"></i> Tambah Posisi MPP
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('mpp.index') }}">MPP</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<form method="POST" action="{{ route('mpp.store') }}">
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="card card-outline card-primary">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle text-primary"></i> Informasi Posisi</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6"><div class="form-group">
              <label>Tahun <span class="text-danger">*</span></label>
              <select name="tahun" class="form-control" data-placeholder="-- Pilih Tahun --">
                @foreach($years as $y)<option value="{{ $y }}" {{ old('tahun', date('Y'))==$y?'selected':'' }}>{{ $y }}</option>@endforeach
              </select>
            </div></div>
            <div class="col-6"><div class="form-group">
              <label>Site</label>
              <input type="text" name="site" class="form-control" value="{{ old('site','Konawe') }}">
            </div></div>
          </div>
          <div class="form-group">
            <label>Job Title <span class="text-danger">*</span></label>
            <input type="text" name="job_title" class="form-control @error('job_title') is-invalid @enderror"
              value="{{ old('job_title') }}" required placeholder="Nama posisi">
            @error('job_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>App Name</label>
            <input type="text" name="app_name" class="form-control" value="{{ old('app_name') }}" placeholder="Nama aplikasi posisi">
          </div>
          <div class="form-group">
            <label>Divisi</label>
            <select name="divisi_id" id="divisiSel" class="form-control" data-placeholder="-- Pilih Divisi --">
              <option value="">-- Pilih Divisi --</option>
              @foreach($divisis as $d)<option value="{{ $d->id }}" {{ old('divisi_id')==$d->id?'selected':'' }}>{{ $d->nama }}</option>@endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Departemen</label>
            <select name="departemen_id" id="deptSel" class="form-control" data-placeholder="-- Pilih Departemen --">
              <option value="">-- Pilih Departemen --</option>
              @foreach($departemens as $d)<option value="{{ $d->id }}" {{ old('departemen_id')==$d->id?'selected':'' }}>{{ $d->nama }}</option>@endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-6"><div class="form-group">
              <label>Category Grade</label>
              <select name="category_grade" class="form-control" data-placeholder="-- Pilih Grade --">
                <option value="">-- Pilih --</option>
                @foreach($gradeOptions as $g)<option value="{{ $g }}" {{ old('category_grade')==$g?'selected':'' }}>{{ $g }}</option>@endforeach
              </select>
            </div></div>
            <div class="col-6"><div class="form-group">
              <label>Cost Centre</label>
              <input type="text" name="cost_centre" class="form-control" value="{{ old('cost_centre') }}">
            </div></div>
          </div>
          <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-outline card-success">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-table text-success"></i> Headcount per Bulan (MPP Plan)</h3></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead class="thead-dark"><tr><th>Bulan</th><th>MPP Plan</th><th>Existing</th></tr></thead>
              <tbody>
                @foreach($months as $key => $label)
                <tr>
                  <td style="font-size:.8rem">{{ $label }}</td>
                  <td><input type="number" name="mpp_{{ $key }}" class="form-control form-control-sm" value="{{ old('mpp_'.$key, 0) }}" min="0" style="width:70px"></td>
                  <td><input type="number" name="existing_{{ $key }}" class="form-control form-control-sm" value="{{ old('existing_'.$key, 0) }}" min="0" style="width:70px"></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-end mt-2">
    <a href="{{ route('mpp.index') }}" class="btn btn-secondary btn-sm mr-2"><i class="fas fa-times mr-1"></i>Batal</a>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save mr-1"></i>Simpan</button>
  </div>
</form>
@endsection

@push('scripts')
<script>
$('#divisiSel').on('change', function () {
  const id = $(this).val();
  if (!id) return;
  $.get('/ajax/departemen-by-divisi/' + id, function (data) {
    let opts = '<option value="">-- Pilih Departemen --</option>';
    data.forEach(d => opts += `<option value="${d.id}">${d.nama}</option>`);
    s2init($('#deptSel').html(opts)[0]);
  });
});
</script>
@endpush
