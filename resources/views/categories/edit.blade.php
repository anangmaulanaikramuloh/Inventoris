@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Edit Kategori</h1>
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
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Nama Kategori:</strong></label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control form-control-lg" placeholder="Nama Kategori">
            </div>
            <div class="mt-4">
                @can('edit category')
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update</button>
                @endcan
                <a class="btn btn-outline-secondary" href="{{ route('categories.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection