@extends('layouts.app')

@section('title', 'Menu Kantin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">Menu Kantin</h2>
            <a href="{{ route('menu.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Tambah Menu
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($menus as $menu)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ Storage::url($menu->foto) }}" class="card-img-top" alt="{{ $menu->nama }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->nama }}</h5>
                            <p class="card-text">{{ $menu->deskripsi }}</p>
                            <p class="card-text">
                                <strong>Harga:</strong> Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </p>
                            <p class="card-text">
                                <strong>Stok:</strong> {{ $menu->stok }}
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" 
                                        id="delete-form-{{ $menu->id }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="return confirmDelete('delete-form-{{ $menu->id }}')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateStokModal{{ $menu->id }}">
                                    <i class="bi bi-plus-slash-minus"></i> Update Stok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Update Stok -->
                <div class="modal fade" id="updateStokModal{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Stok {{ $menu->nama }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('menu.update-stok', $menu->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Jumlah Stok</label>
                                        <input type="number" class="form-control" id="stok" name="stok" 
                                            value="{{ $menu->stok }}" min="0" required>
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
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Belum ada menu yang ditambahkan.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 