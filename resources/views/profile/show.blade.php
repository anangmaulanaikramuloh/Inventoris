@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Profil Pengguna
                    </h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit Profil
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama:</label>
                                <p class="form-control-plaintext">{{ $user->name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email:</label>
                                <p class="form-control-plaintext">{{ $user->email }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Role:</label>
                                <p class="form-control-plaintext">
                                    @if($user->hasRole('admin'))
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->hasRole('manager'))
                                        <span class="badge bg-success">Manager</span>
                                    @elseif($user->hasRole('staff'))
                                        <span class="badge bg-primary">Staff</span>
                                    @elseif($user->hasRole('user'))
                                        <span class="badge bg-info">User</span>
                                    @else
                                        <span class="badge bg-secondary">Pengguna</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Bergabung sejak:</label>
                                <p class="form-control-plaintext">{{ $user->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-circle display-1 text-muted"></i>
                                    <h5 class="mt-3">{{ $user->name }}</h5>
                                    <p class="text-muted">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection