@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Detail Kategori</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary"> &larr; Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label"><strong>Nama Kategori:</strong></label>
            <p class="form-control-plaintext fs-5">{{ $category->name }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Dibuat pada:</strong></label>
            <p class="form-control-plaintext">{{ $category->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Diperbarui pada:</strong></label>
            <p class="form-control-plaintext">{{ $category->updated_at->format('d M Y, H:i') }}</p>
        </div>
    </div>
</div>
@endsection
