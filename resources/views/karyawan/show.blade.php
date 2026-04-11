@extends('layouts.app')
@section('title','Detail Karyawan')
@section('page-title','<i class="fas fa-user mr-2 text-info"></i>Detail Karyawan')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('karyawan.index') }}">Karyawan</a></li>
  <li class="breadcrumb-item active">{{ $kar->nama }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm">
        <h3 class="card-title">{{ $kar->salutation }} {{ $kar->nama }}</h3>
        <div class="card-tools">
          {!! $kar->tipe_badge !!}
          {!! $kar->status_badge !!}
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="140" class="text-muted">Posisi</th><td>{{ $kar->position }}</td></tr>
              <tr><th class="text-muted">Perusahaan</th><td>{{ $kar->company }}</td></tr>
              <tr><th class="text-muted">Divisi</th><td>{{ $kar->divisi?->nama ?? '—' }}</td></tr>
              <tr><th class="text-muted">Departemen</th><td>{{ $kar->departemen?->nama ?? '—' }}</td></tr>
              <tr><th class="text-muted">Level</th><td>{{ $kar->level ?: '—' }}</td></tr>
              <tr><th class="text-muted">Grade</th><td>{{ $kar->grade ?: '—' }}</td></tr>
              <tr><th class="text-muted">Work Location</th><td>{{ $kar->work_location }}</td></tr>
              <tr><th class="text-muted">POH</th><td>{{ $kar->poh ?: '—' }}</td></tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="140" class="text-muted">No. Karyawan</th><td>{{ $kar->no_karyawan ?: '—' }}</td></tr>
              <tr><th class="text-muted">No. Telepon</th><td>{{ $kar->no_telp ?: '—' }}</td></tr>
              <tr><th class="text-muted">Email</th><td>{{ $kar->email ?: '—' }}</td></tr>
              <tr><th class="text-muted">Tipe</th><td>{!! $kar->tipe_badge !!}</td></tr>
              <tr><th class="text-muted">Status</th><td>{!! $kar->status_badge !!}</td></tr>
              <tr><th class="text-muted">Terms</th><td><span class="badge badge-info">{{ $kar->terms }}</span></td></tr>
              <tr><th class="text-muted">Durasi</th><td>{{ $kar->durasi ?: '—' }}</td></tr>
            </table>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="140" class="text-muted">Tgl OL / Join</th><td>{{ $kar->tgl_ol?->format('d/m/Y') ?? '—' }}</td></tr>
              <tr><th class="text-muted">Tgl Berakhir</th><td>{{ $kar->tgl_berakhir?->format('d/m/Y') ?? '—' }}</td></tr>
              <tr><th class="text-muted">Weeks On/Off</th><td>{{ $kar->weeks_on ?: '—' }}/{{ $kar->weeks_off ?: '—' }}</td></tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="140" class="text-muted">Gaji Pokok</th><td class="font-weight-bold text-success">{{ $kar->basic_salary_formatted }}</td></tr>
              <tr><th class="text-muted">Inpatient Local</th><td>Rp {{ number_format($kar->inpatient_local ?? 0,0,',','.') }}</td></tr>
              <tr><th class="text-muted">Outpatient</th><td>Rp {{ number_format($kar->outpatient ?? 0,0,',','.') }}</td></tr>
            </table>
          </div>
        </div>
        @if($kar->alamat)
          <hr>
          <div style="font-size:.82rem">
            <strong class="text-muted">Alamat:</strong> {{ $kar->alamat }}
          </div>
        @endif
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-outline card-success">
      <div class="card-header card-header-sm"><h3 class="card-title">Aksi</h3></div>
      <div class="card-body">
        <a href="{{ route('karyawan.edit',$kar->id) }}" class="btn btn-warning btn-block btn-sm mb-2">
          <i class="fas fa-edit mr-1"></i>Edit Data
        </a>
        @if($kar->rekrutmen)
          <a href="{{ route('rekrutmen.show',$kar->rekrutmen->id) }}" class="btn btn-info btn-block btn-sm mb-2">
            <i class="fas fa-search mr-1"></i>Lihat Data Rekrutmen
          </a>
        @endif
        <button onclick="confirmDelete({{ $kar->id }},'{{ route('karyawan.destroy',$kar->id) }}')"
          class="btn btn-danger btn-block btn-sm">
          <i class="fas fa-trash mr-1"></i>Hapus
        </button>
      </div>
    </div>
    <div class="card card-outline card-info">
      <div class="card-header card-header-sm"><h3 class="card-title">OL Info</h3></div>
      <div class="card-body" style="font-size:.82rem">
        <p><i class="fas fa-signature mr-1 text-muted"></i>{{ $kar->signature_name ?: '—' }}</p>
        <p><i class="fas fa-id-badge mr-1 text-muted"></i>{{ $kar->signature_title ?: '—' }}</p>
        <hr>
        <p class="text-muted" style="font-size:.75rem">Dibuat: {{ $kar->created_at->format('d/m/Y H:i') }}</p>
        <p class="text-muted" style="font-size:.75rem">Diperbarui: {{ $kar->updated_at->format('d/m/Y H:i') }}</p>
      </div>
    </div>
  </div>
</div>
<a href="{{ route('karyawan.index') }}" class="btn btn-default btn-sm">
  <i class="fas fa-arrow-left mr-1"></i>Kembali
</a>
@endsection
