@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Edit Barang</h1>
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
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Nama Barang:</strong></label>
                <input type="text" name="name" value="{{ $item->name }}" class="form-control form-control-lg" placeholder="Nama Barang">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label"><strong>Kategori:</strong></label>
                <select name="category_id" class="form-select form-select-lg">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label"><strong>Gambar:</strong></label>
                <input type="file" name="image" class="form-control form-control-lg">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" class="rounded mt-2" style="width: 100px; height: 100px; object-fit: cover;">
                @endif
            </div>
            
            <div class="mb-3">
                <label for="minimum_stock" class="form-label"><strong>Stok Minimum:</strong></label>
                <input type="number" name="minimum_stock" value="{{ $item->minimum_stock ?? 10 }}" class="form-control form-control-lg" placeholder="Masukkan stok minimum" min="0">
                <div class="form-text">Sistem akan memberi peringatan jika stok di bawah angka ini</div>
            </div>
            <div class="mt-4">
                @can('edit item')
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update</button>
                @endcan
                <a class="btn btn-outline-secondary" href="{{ route('items.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection