@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Berita</h5>
                    <div>
                        <a href="{{ route('berita.edit', $berita->slug) }}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('berita.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset($berita->image) }}" alt="{{ $berita->judul }}" class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="mb-2">{{ $berita->judul }}</h3>
                        <p class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i> 
                            {{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }}
                        </p>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ringkasan</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ $berita->ringkasan }}</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Konten Lengkap</h5>
                        </div>
                        <div class="card-body">
                            {!! nl2br(e($berita->konten)) !!}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <form action="{{ route('berita.destroy', $berita->slug) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus Berita
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 