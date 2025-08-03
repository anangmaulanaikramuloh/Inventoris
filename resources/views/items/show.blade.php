@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark">Detail Barang</h1>
    <a href="{{ route('items.index') }}" class="btn btn-secondary"> &larr; Kembali</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" class="img-fluid rounded" alt="{{ $item->name }}" 
                         onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                @else
                    <div class="text-center p-4 bg-light rounded">
                        <i class="bi bi-image display-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada gambar</p>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label"><strong>Nama Barang:</strong></label>
                    <p class="form-control-plaintext fs-5">{{ $item->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Kategori:</strong></label>
                    <p class="form-control-plaintext">{{ $item->category->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Stok Saat Ini:</strong></label>
                    <p class="form-control-plaintext fs-4 fw-bold">{{ $item->stock }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Stok Minimum:</strong></label>
                    <p class="form-control-plaintext">{{ $item->minimum_stock ?? 10 }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Status Stok:</strong></label>
                    <p class="form-control-plaintext">
                        @if($item->is_low_stock)
                            <span class="badge bg-warning fs-6">
                                <i class="bi bi-exclamation-triangle me-1"></i>Stok Menipis
                            </span>
                            <small class="text-muted d-block mt-1">
                                Stok ({{ $item->stock }}) ≤ Minimum ({{ $item->minimum_stock ?? 10 }})
                            </small>
                        @else
                            <span class="badge bg-success fs-6">Stok Normal</span>
                            <small class="text-muted d-block mt-1">
                                Stok ({{ $item->stock }}) > Minimum ({{ $item->minimum_stock ?? 10 }})
                            </small>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Dibuat pada:</strong></label>
                    <p class="form-control-plaintext">{{ $item->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Diperbarui pada:</strong></label>
                    <p class="form-control-plaintext">{{ $item->updated_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="mt-4">
                    @can('record stock transaction')
                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#stockInModal">
                        <i class="bi bi-plus-circle"></i> Tambah Stok
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#stockOutModal">
                        <i class="bi bi-dash-circle"></i> Kurangi Stok
                    </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock In Modal -->
<div class="modal fade" id="stockInModal" tabindex="-1" aria-labelledby="stockInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockInModalLabel">Tambah Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('items.stock.in', $item->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantityIn" class="form-label">Kuantitas:</label>
                        <input type="number" class="form-control" id="quantityIn" name="quantity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="notesIn" class="form-label">Catatan (Opsional):</label>
                        <textarea class="form-control" id="notesIn" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Stock Out Modal -->
<div class="modal fade" id="stockOutModal" tabindex="-1" aria-labelledby="stockOutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockOutModalLabel">Kurangi Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('items.stock.out', $item->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantityOut" class="form-label">Kuantitas:</label>
                        <input type="number" class="form-control" id="quantityOut" name="quantity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="notesOut" class="form-label">Catatan (Opsional):</label>
                        <textarea class="form-control" id="notesOut" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary">Riwayat Transaksi Stok</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="stockTransactionsTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>Tipe</th>
                        <th>Kuantitas</th>
                        <th>Catatan</th>
                        <th>Oleh</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($item->stockTransactions->sortByDesc('created_at') as $transaction)
                    <tr>
                        <td>
                            @if($transaction->type == 'in')
                                <span class="badge bg-success">Masuk</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>{{ $transaction->notes ?? '-' }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada riwayat transaksi stok untuk barang ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
