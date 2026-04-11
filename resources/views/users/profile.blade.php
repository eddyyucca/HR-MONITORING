@extends('layouts.app')
@section('title','Profil Saya')
@section('page-title','<i class="fas fa-user-circle mr-2 text-primary"></i>Profil Saya')
@section('breadcrumb')<li class="breadcrumb-item active">Profil</li>@endsection

@section('content')
<div class="row">
  <div class="col-md-5">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm"><h3 class="card-title">Informasi Akun</h3></div>
      <div class="card-body">
        <div class="text-center mb-3">
          <div class="bg-primary d-inline-flex align-items-center justify-content-center rounded-circle"
            style="width:70px;height:70px;font-size:2rem;color:#fff">
            <i class="fas fa-user-tie"></i>
          </div>
          <div class="mt-2"><strong>{{ $user->name }}</strong></div>
          <div>{!! $user->role_badge !!}</div>
        </div>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
              value="{{ old('name',$user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
              value="{{ old('email',$user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control form-control-sm" value="{{ $user->username }}" disabled>
          </div>
          <button type="submit" class="btn btn-primary btn-sm btn-block">
            <i class="fas fa-save mr-1"></i>Update Profil
          </button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-outline card-warning">
      <div class="card-header card-header-sm"><h3 class="card-title">Ubah Password</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('profile.password') }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Password Saat Ini <span class="text-danger">*</span></label>
            <input type="password" name="current_password" class="form-control form-control-sm
              @error('current_password') is-invalid @enderror" required>
            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Password Baru <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control form-control-sm
              @error('password') is-invalid @enderror" required minlength="8">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
          </div>
          <button type="submit" class="btn btn-warning btn-sm btn-block">
            <i class="fas fa-lock mr-1"></i>Ubah Password
          </button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-outline card-info">
      <div class="card-header card-header-sm"><h3 class="card-title">Info Akun</h3></div>
      <div class="card-body" style="font-size:.82rem">
        <table class="table table-sm table-borderless">
          <tr><th class="text-muted">Role</th><td>{!! $user->role_badge !!}</td></tr>
          <tr><th class="text-muted">Status</th><td><span class="badge badge-success">Aktif</span></td></tr>
          <tr><th class="text-muted">Bergabung</th><td>{{ $user->created_at->format('d/m/Y') }}</td></tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
