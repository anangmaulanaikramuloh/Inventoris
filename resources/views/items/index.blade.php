@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Manajemen Barang</h1>
    @can('create item')
    <a href="{{ route('items.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Tambah Barang Baru
    </a>
    @endcan
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Daftar Barang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;" 
                                     onerror="this.src='https://via.placeholder.com/60x60?text=No+Img'" alt="{{ $item->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>
                            {{ $item->stock }}
                            @if($item->is_low_stock)
                                <i class="bi bi-exclamation-triangle text-warning ms-1" title="Stok menipis"></i>
                            @endif
                        </td>
                        <td>
                            @if($item->is_low_stock)
                                <span class="badge bg-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Stok Menipis
                                </span>
                            @else
                                <span class="badge bg-success">Stok Normal</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('items.destroy',$item->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('items.show',$item->id) }}"><i class="bi bi-eye"></i> Show</a>
                                @can('edit item')
                                <a class="btn btn-primary btn-sm" href="{{ route('items.edit',$item->id) }}"><i class="bi bi-pencil-square"></i> Edit</a>
                                @endcan
                                @can('delete item')
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $items->links() !!}
        </div>
    </div>
</div>

@foreach ($items as $item)
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-{{ $item->id }}">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus barang <strong>{{ $item->name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('items.destroy',$item->id) }}" method="POST" class="d-inline">
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