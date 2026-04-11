@extends('layouts.app')
@section('title','Tambah User')
@section('page-title','<i class="fas fa-user-plus mr-2 text-primary"></i>Tambah User')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-outline card-primary">
      <div class="card-header card-header-sm"><h3 class="card-title">Form Tambah User</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
          @csrf
          <div class="form-group">
            <label>Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Username <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
              value="{{ old('username') }}" required>
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
              value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Role <span class="text-danger">*</span></label>
            <select name="role" class="form-control form-control-sm">
              <option value="admin"      {{ old('role')=='admin'?'selected':'' }}>Administrator</option>
              <option value="hr_manager" {{ old('role','hr_manager')=='hr_manager'?'selected':'' }}>HR Manager</option>
              <option value="hr_staff"   {{ old('role')=='hr_staff'?'selected':'' }}>HR Staff</option>
              <option value="viewer"     {{ old('role')=='viewer'?'selected':'' }}>Viewer</option>
            </select>
          </div>
          <div class="form-group">
            <label>Password <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <div class="d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="btn btn-default btn-sm mr-2">Batal</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save mr-1"></i>Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
