@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Tambah Barang Baru</h1>
    <a href="{{ route('items.index') }}" class="btn btn-secondary"> &larr; Kembali</a>
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
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Nama Barang:</strong></label>
                <input type="text" name="name" class="form-control form-control-lg" placeholder="Masukkan Nama Barang">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label"><strong>Kategori:</strong></label>
                <select name="category_id" class="form-select form-select-lg">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label"><strong>Gambar:</strong></label>
                <input type="file" name="image" class="form-control form-control-lg">
            </div>
            
            <div class="mb-3">
                <label for="minimum_stock" class="form-label"><strong>Stok Minimum:</strong></label>
                <input type="number" name="minimum_stock" class="form-control form-control-lg" placeholder="Masukkan stok minimum" value="10" min="0">
                <div class="form-text">Sistem akan memberi peringatan jika stok di bawah angka ini</div>
            </div>
            <div class="mt-4">
                @can('create item')
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Submit</button>
                @endcan
                <a class="btn btn-outline-secondary" href="{{ route('items.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection