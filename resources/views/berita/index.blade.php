@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Berita</h5>
                    <a href="{{ route('berita.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Berita
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Gambar</th>
                                    <th>Judul</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="25%">Ringkasan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($berita as $index => $item)
                                    <tr>
                                        <td>{{ $index + $berita->firstItem() }}</td>
                                        <td>
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->judul }}" class="img-thumbnail" style="max-height: 100px;">
                                        </td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ Str::limit($item->ringkasan, 100) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('berita.edit', $item->slug) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('berita.destroy', $item->slug) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
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
                                        <td colspan="6" class="text-center">Tidak ada data berita.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $berita->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 