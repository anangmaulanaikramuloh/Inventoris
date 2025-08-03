@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h1 class="mb-0">Selamat Datang di Inventaris App</h1>
                </div>
                <div class="card-body p-5 text-center">
                    <p class="lead">Aplikasi manajemen inventaris yang modern dan responsif.</p>
                    <p>Kelola barang-barang Anda dengan mudah dan efisien.</p>
                    <hr class="my-4">
                    <p>Untuk memulai, silakan masuk atau daftar.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg mx-2">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection