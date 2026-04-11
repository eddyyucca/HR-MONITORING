@extends('layouts.app')
@section('title','Detail Kandidat')
@section('page-title','<i class="fas fa-user mr-2 text-info"></i>Detail Kandidat')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('rekrutmen.index') }}">Rekrutmen</a></li>
  <li class="breadcrumb-item active">{{ $rek->nama_lengkap }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm">
        <h3 class="card-title">{{ $rek->nama_lengkap }}</h3>
        <div class="card-tools">
          {!! $rek->progress_badge !!}
          {!! $rek->priority_badge !!}
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="130" class="text-muted">Posisi</th><td>{{ $rek->plan_job_title }}</td></tr>
              <tr><th class="text-muted">Divisi</th><td>{{ $rek->divisi?->nama ?? '—' }}</td></tr>
              <tr><th class="text-muted">Departemen</th><td>{{ $rek->departemen?->nama ?? '—' }}</td></tr>
              <tr><th class="text-muted">Level</th><td>{{ $rek->category_level ?: '—' }}</td></tr>
              <tr><th class="text-muted">Gender</th><td>{{ $rek->gender ?: '—' }}</td></tr>
              <tr><th class="text-muted">No. Telepon</th><td>{{ $rek->no_telp ?: '—' }}</td></tr>
              <tr><th class="text-muted">Email</th><td>{{ $rek->email ?: '—' }}</td></tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="130" class="text-muted">Status</th><td>{{ $rek->status }}</td></tr>
              <tr><th class="text-muted">Progress</th><td>{!! $rek->progress_badge !!}</td></tr>
              <tr><th class="text-muted">Priority</th><td>{!! $rek->priority_badge !!}</td></tr>
              <tr><th class="text-muted">Status ATA</th><td>{{ $rek->status_ata ?: '—' }}</td></tr>
              <tr><th class="text-muted">Sumber</th><td>{{ $rek->sourch ?: '—' }}</td></tr>
              <tr><th class="text-muted">Site</th><td>{{ $rek->site }}</td></tr>
              <tr><th class="text-muted">User PIC</th><td>{{ $rek->user_pic ?: '—' }}</td></tr>
            </table>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="130" class="text-muted">Bulan/Tahun</th><td>{{ $rek->month_name }} {{ $rek->year }}</td></tr>
              <tr><th class="text-muted">Date Approved</th><td>{{ $rek->date_approved?->format('d/m/Y') ?? '—' }}</td></tr>
              <tr><th class="text-muted">Date Progress</th><td>{{ $rek->date_progress?->format('d/m/Y') ?? '—' }}</td></tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-sm table-borderless" style="font-size:.82rem">
              <tr><th width="130" class="text-muted">SLA</th>
                <td><span class="sla-{{ $rek->sla_color }}">{{ $rek->sla ? $rek->sla.' hari' : '—' }}</span></td>
              </tr>
              <tr><th class="text-muted">Dibuat</th><td>{{ $rek->created_at->format('d/m/Y H:i') }}</td></tr>
              <tr><th class="text-muted">Diperbarui</th><td>{{ $rek->updated_at->format('d/m/Y H:i') }}</td></tr>
            </table>
          </div>
        </div>
        @if($rek->remarks)
          <div class="alert alert-light border mt-2" style="font-size:.82rem">
            <strong>Remarks:</strong> {{ $rek->remarks }}
          </div>
        @endif
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-outline card-success">
      <div class="card-header card-header-sm"><h3 class="card-title">Aksi</h3></div>
      <div class="card-body">
        <a href="{{ route('rekrutmen.edit',$rek->id) }}" class="btn btn-warning btn-block btn-sm mb-2">
          <i class="fas fa-edit mr-1"></i>Edit Data
        </a>
        @if(!$rek->karyawan)
        <a href="{{ route('karyawan.create',['rekrutmen_id'=>$rek->id]) }}" class="btn btn-success btn-block btn-sm mb-2">
          <i class="fas fa-user-plus mr-1"></i>Buat Data Karyawan
        </a>
        @else
        <a href="{{ route('karyawan.show',$rek->karyawan->id) }}" class="btn btn-info btn-block btn-sm mb-2">
          <i class="fas fa-user mr-1"></i>Lihat Data Karyawan
        </a>
        @endif
        <button onclick="confirmDelete({{ $rek->id }},'{{ route('rekrutmen.destroy',$rek->id) }}')"
          class="btn btn-danger btn-block btn-sm">
          <i class="fas fa-trash mr-1"></i>Hapus
        </button>
      </div>
    </div>
    @if($rek->karyawan)
    <div class="card card-outline card-info">
      <div class="card-header card-header-sm"><h3 class="card-title">Status On Board</h3></div>
      <div class="card-body" style="font-size:.82rem">
        <p><strong>{{ $rek->karyawan->nama }}</strong></p>
        <p>Status: {!! $rek->karyawan->status_badge !!}</p>
        <p>Bergabung: {{ $rek->karyawan->tgl_ol?->format('d/m/Y') ?? '—' }}</p>
      </div>
    </div>
    @endif
  </div>
</div>
<div class="mt-2">
  <a href="{{ route('rekrutmen.index') }}" class="btn btn-default btn-sm">
    <i class="fas fa-arrow-left mr-1"></i>Kembali
  </a>
</div>
@endsection
