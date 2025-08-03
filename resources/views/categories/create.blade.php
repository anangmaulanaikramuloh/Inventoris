@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Tambah Kategori Baru</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary"> &larr; Kembali</a>
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
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Nama Kategori:</strong></label>
                <input type="text" name="name" class="form-control form-control-lg" placeholder="Masukkan Nama Kategori">
            </div>
            <div class="mt-4">
                @can('create category')
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Submit</button>
                @endcan
                <a class="btn btn-outline-secondary" href="{{ route('categories.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection