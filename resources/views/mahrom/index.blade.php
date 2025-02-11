@extends('layouts.app')

@section('title', 'Data Mahrom')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Mahrom</h1>
        <a href="{{ route('mahrom.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Mahrom
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Santri</th>
                            <th>Nama Mahrom</th>
                            <th>Hubungan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">Data akan ditampilkan di sini</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 