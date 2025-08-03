@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Dashboard</h1>
</div>

<div class="row">
    <!-- Total Categories Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-primary border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Total Kategori</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalCategories }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-tags fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Items Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-success border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Total Barang</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalItems }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-list-ul fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Stock Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-info border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Total Stok</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalStock }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-boxes fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-warning border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Stok Menipis</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $lowStockItems->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($lowStockItems->count() > 0)
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">
                <i class="bi bi-exclamation-triangle me-2"></i>Peringatan Stok Menipis!
            </h5>
            <p>Ada {{ $lowStockItems->count() }} barang yang stoknya di bawah batas minimum:</p>
            <ul class="mb-0">
                @foreach($lowStockItems->take(5) as $item)
                    <li>
                        <strong>{{ $item->name }}</strong> - Stok: {{ $item->stock }}, Min: {{ $item->minimum_stock }}
                        <a href="{{ route('items.show', $item->id) }}" class="ms-2 text-decoration-none">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </li>
                @endforeach
                @if($lowStockItems->count() > 5)
                    <li class="text-muted">... dan {{ $lowStockItems->count() - 5 }} barang lainnya</li>
                @endif
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard Inventaris
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Selamat Datang, {{ Auth::user()->name }}!</h6>
                        <p class="mb-2">Role: 
                            @if(Auth::user()->hasRole('admin'))
                                <span class="badge bg-danger">Admin</span>
                            @elseif(Auth::user()->hasRole('manager'))
                                <span class="badge bg-success">Manager</span>
                            @elseif(Auth::user()->hasRole('staff'))
                                <span class="badge bg-primary">Staff</span>
                            @elseif(Auth::user()->hasRole('user'))
                                <span class="badge bg-info">User</span>
                            @else
                                <span class="badge bg-secondary">Pengguna</span>
                            @endif
                        </p>
                        <p class="text-muted">Gunakan menu di sebelah kiri untuk mengelola inventaris Anda.</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistik Hari Ini:</h6>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-tags text-primary me-2"></i>{{ $totalCategories }} Kategori</li>
                            <li><i class="bi bi-list-ul text-success me-2"></i>{{ $totalItems }} Jenis Barang</li>
                            <li><i class="bi bi-boxes text-info me-2"></i>{{ $totalStock }} Total Stok</li>
                            @if($lowStockItems->count() > 0)
                                <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>{{ $lowStockItems->count() }} Stok Menipis</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection