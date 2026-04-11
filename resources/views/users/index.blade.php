@extends('layouts.app')
@section('title','Manajemen User')
@section('page-title','<i class="fas fa-users-cog mr-2 text-primary"></i>Manajemen User')
@section('breadcrumb')<li class="breadcrumb-item active">Users</li>@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
  <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-user-plus mr-1"></i>Tambah User
  </a>
</div>

<div class="card card-outline card-primary">
  <div class="card-header card-header-sm">
    <h3 class="card-title">Daftar User <span class="badge badge-primary">{{ $users->count() }}</span></h3>
  </div>
  <div class="card-body p-0">
    <table id="userTable" class="table table-sm table-bordered table-striped table-hover mb-0" style="font-size:.8rem">
      <thead class="thead-dark">
        <tr><th>#</th><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        @foreach($users as $i => $u)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $u->name }}</td>
          <td><code>{{ $u->username }}</code></td>
          <td>{{ $u->email }}</td>
          <td>{!! $u->role_badge !!}</td>
          <td>
            @if($u->trashed())
              <span class="badge badge-danger">Dihapus</span>
            @elseif($u->is_active)
              <span class="badge badge-success">Aktif</span>
            @else
              <span class="badge badge-secondary">Nonaktif</span>
            @endif
          </td>
          <td>{{ $u->created_at->format('d/m/Y') }}</td>
          <td>
            @if(!$u->trashed())
            <div class="btn-group btn-group-sm">
              <a href="{{ route('users.edit',$u->id) }}" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
              @if($u->id !== auth()->id())
              <button onclick="confirmDelete({{ $u->id }},'{{ route('users.destroy',$u->id) }}')"
                class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
              @endif
            </div>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
$('#userTable').DataTable({pageLength:20,language:{search:'Cari:',lengthMenu:'_MENU_',info:'_START_-_END_ / _TOTAL_',paginate:{first:'«',last:'»',next:'›',previous:'‹'}}});
</script>
@endpush
