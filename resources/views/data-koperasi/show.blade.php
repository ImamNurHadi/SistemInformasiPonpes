@extends('layouts.app')

@section('title', 'Detail Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 text-dark">Detail Koperasi</h5>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('data-koperasi.index') }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nama Koperasi</th>
                                    <td>{{ $dataKoperasi->nama_koperasi }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $dataKoperasi->lokasi }}</td>
                                </tr>
                                <tr>
                                    <th>Pengurus</th>
                                    <td>{{ $dataKoperasi->pengurus->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $dataKoperasi->username }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Saldo Belanja</th>
                                    <td>Rp. {{ number_format($dataKoperasi->saldo_belanja, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Keuntungan</th>
                                    <td>Rp. {{ number_format($dataKoperasi->keuntungan, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <a href="{{ route('data-koperasi.edit', $dataKoperasi->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('data-koperasi.destroy', $dataKoperasi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus koperasi ini?')">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 