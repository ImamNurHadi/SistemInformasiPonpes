@extends('layouts.app')

@section('title', 'Detail Data Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Detail Data Koperasi</h5>
                    <div>
                        <a href="{{ route('data-koperasi.edit', $dataKoperasi->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <a href="{{ route('data-koperasi.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
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
                            <td>{{ $dataKoperasi->pengurus->nama ?? 'Tidak ada' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $dataKoperasi->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>{{ $dataKoperasi->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 