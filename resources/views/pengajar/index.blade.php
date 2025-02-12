@extends('layouts.app')

@section('title', 'Daftar Pengajar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Pengajar</h3>
                        <a href="{{ route('pengajar.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Pengajar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th>Pendidikan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajars as $pengajar)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengajar->nama }}</td>
                                        <td>{{ $pengajar->nik }}</td>
                                        <td>{{ $pengajar->telepon }}</td>
                                        <td>
                                            {{ $pengajar->kelurahan_domisili }}, 
                                            {{ $pengajar->kecamatan_domisili }}, 
                                            {{ $pengajar->kota_domisili }}
                                        </td>
                                        <td>
                                            {{ $pengajar->pendidikan_terakhir }}
                                            @if($pengajar->asal_kampus)
                                                <br>
                                                <small class="text-muted">{{ $pengajar->asal_kampus }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('pengajar.edit', $pengajar->id) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('pengajar.destroy', $pengajar->id) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pengajar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 