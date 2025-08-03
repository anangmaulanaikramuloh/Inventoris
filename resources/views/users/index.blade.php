@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Manajemen Pengguna</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Tambah Pengguna Baru
    </a>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Daftar Pengguna</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="usersTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @forelse ($user->getRoleNames() as $role)
                                @if($role == 'admin')
                                    <span class="badge bg-danger">{{ ucfirst($role) }}</span>
                                @elseif($role == 'manager')
                                    <span class="badge bg-success">{{ ucfirst($role) }}</span>
                                @elseif($role == 'staff')
                                    <span class="badge bg-primary">{{ ucfirst($role) }}</span>
                                @elseif($role == 'user')
                                    <span class="badge bg-info">{{ ucfirst($role) }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($role) }}</span>
                                @endif
                            @empty
                                <span class="badge bg-warning text-dark">Tidak ada role</span>
                            @endforelse
                        </td>
                        <td class="text-center">
                            <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="bi bi-pencil-square"></i> Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {!! $users->links() !!}
            </div>
        </div>
    </div>
</div>

@foreach ($users as $user)
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-{{ $user->id }}">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengguna <strong>{{ $user->name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('users.destroy',$user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
