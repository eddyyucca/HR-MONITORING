@extends('layouts.app')
@section('title','Edit User')
@section('page-title','<i class="fas fa-user-edit mr-2 text-warning"></i>Edit User — '.$user->name)
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-outline card-warning">
      <div class="card-header card-header-sm"><h3 class="card-title">Edit User: {{ $user->name }}</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('users.update',$user->id) }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name',$user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Username <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
              value="{{ old('username',$user->username) }}" required>
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
              value="{{ old('email',$user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control form-control-sm">
              <option value="admin"      {{ old('role',$user->role)=='admin'?'selected':'' }}>Administrator</option>
              <option value="hr_manager" {{ old('role',$user->role)=='hr_manager'?'selected':'' }}>HR Manager</option>
              <option value="hr_staff"   {{ old('role',$user->role)=='hr_staff'?'selected':'' }}>HR Staff</option>
              <option value="viewer"     {{ old('role',$user->role)=='viewer'?'selected':'' }}>Viewer</option>
            </select>
          </div>
          <div class="form-group">
            <label>Status</label>
            <div class="icheck-primary">
              <input type="checkbox" id="isActive" name="is_active" value="1" {{ old('is_active',$user->is_active) ? 'checked':'' }}>
              <label for="isActive">Aktif</label>
            </div>
          </div>
          <div class="form-group">
            <label>Password Baru <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
          </div>
          <div class="d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="btn btn-default btn-sm mr-2">Batal</a>
            <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-save mr-1"></i>Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
