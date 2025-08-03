@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Edit Pengguna</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary"> &larr; Kembali</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Nama:</strong></label>
                <input type="text" name="name" class="form-control form-control-lg" placeholder="Nama Pengguna" value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><strong>Email:</strong></label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Email Pengguna" value="{{ old('email', $user->email) }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><strong>Password (biarkan kosong jika tidak ingin mengubah):</strong></label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label"><strong>Konfirmasi Password:</strong></label>
                <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi Password">
            </div>
            <div class="mb-3">
                <label for="roles" class="form-label"><strong>Peran:</strong></label>
                <select name="roles" id="roles" class="form-select form-select-lg" required>
                    <option value="">Pilih Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ old('roles', $user->roles->first()->name ?? '') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">
                    <strong>Admin:</strong> Akses penuh ke semua fitur<br>
                    <strong>Manager:</strong> Bisa kelola barang dan transaksi, tidak bisa kelola kategori<br>
                    <strong>Staff:</strong> Hanya bisa melihat data dan mencatat transaksi stok<br>
                    <strong>User:</strong> Hanya bisa melihat data (read-only)
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update</button>
                <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
