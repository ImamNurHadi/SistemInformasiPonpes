@extends('layouts.app')

@section('title', 'Histori Transfer QR Code')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-left-right me-2"></i> Histori Transfer QR Code
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('histori-transfer.index') }}" method="GET">
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <h5>Filter Data</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nis_pengirim" class="form-label">NIS Pengirim</label>
                                    <input type="text" class="form-control" id="nis_pengirim" name="nis_pengirim" value="{{ request('nis_pengirim') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
                                    <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="{{ request('nama_pengirim') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tingkatan_pengirim_id" class="form-label">Kelas Pengirim</label>
                                    <select class="form-select" id="tingkatan_pengirim_id" name="tingkatan_pengirim_id">
                                        <option value="">-- Semua Kelas --</option>
                                        @foreach($tingkatan as $kelas)
                                            <option value="{{ $kelas->id }}" {{ request('tingkatan_pengirim_id') == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipe_sumber" class="form-label">Sumber Dana</label>
                                    <select class="form-select" id="tipe_sumber" name="tipe_sumber">
                                        <option value="">-- Semua Jenis --</option>
                                        <option value="utama" {{ request('tipe_sumber') == 'utama' ? 'selected' : '' }}>Saldo Utama</option>
                                        <option value="belanja" {{ request('tipe_sumber') == 'belanja' ? 'selected' : '' }}>Saldo Belanja</option>
                                        <option value="tabungan" {{ request('tipe_sumber') == 'tabungan' ? 'selected' : '' }}>Saldo Tabungan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nis_penerima" class="form-label">NIS Penerima</label>
                                    <input type="text" class="form-control" id="nis_penerima" name="nis_penerima" value="{{ request('nis_penerima') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_penerima" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" value="{{ request('nama_penerima') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tingkatan_penerima_id" class="form-label">Kelas Penerima</label>
                                    <select class="form-select" id="tingkatan_penerima_id" name="tingkatan_penerima_id">
                                        <option value="">-- Semua Kelas --</option>
                                        @foreach($tingkatan as $kelas)
                                            <option value="{{ $kelas->id }}" {{ request('tingkatan_penerima_id') == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipe_tujuan" class="form-label">Tujuan Dana</label>
                                    <select class="form-select" id="tipe_tujuan" name="tipe_tujuan">
                                        <option value="">-- Semua Jenis --</option>
                                        <option value="utama" {{ request('tipe_tujuan') == 'utama' ? 'selected' : '' }}>Saldo Utama</option>
                                        <option value="belanja" {{ request('tipe_tujuan') == 'belanja' ? 'selected' : '' }}>Saldo Belanja</option>
                                        <option value="tabungan" {{ request('tipe_tujuan') == 'tabungan' ? 'selected' : '' }}>Saldo Tabungan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" name="search" value="1" class="btn btn-primary">
                                        <i class="bi bi-search me-1"></i> Cari
                                    </button>
                                    <a href="{{ route('histori-transfer.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                                    </a>
                                    @if($historiTransfer->count() > 0)
                                    <a href="{{ route('histori-transfer.print') }}?{{ http_build_query(request()->all()) }}" target="_blank" class="btn btn-success ms-auto">
                                        <i class="bi bi-printer me-1"></i> Cetak PDF
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    @if($historiTransfer->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="historiTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pengirim</th>
                                        <th>Penerima</th>
                                        <th>Dari Saldo</th>
                                        <th>Ke Saldo</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historiTransfer as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->tanggal->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <strong>{{ $item->pengirim->nama }}</strong>
                                            <br>
                                            <small>NIS: {{ $item->pengirim->nis }}</small>
                                            <br>
                                            <small>Kelas: {{ $item->pengirim->tingkatan->nama ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $item->penerima->nama }}</strong>
                                            <br>
                                            <small>NIS: {{ $item->penerima->nis }}</small>
                                            <br>
                                            <small>Kelas: {{ $item->penerima->tingkatan->nama ?? '-' }}</small>
                                        </td>
                                        <td>{{ ucfirst($item->tipe_sumber) }}</td>
                                        <td>{{ ucfirst($item->tipe_tujuan) }}</td>
                                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            {{ $isSearching ? 'Tidak ada data histori transfer yang sesuai dengan filter yang dipilih.' : 'Silakan gunakan filter di atas untuk mencari histori transfer.' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#historiTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            }
        });
    });
</script>
@endsection 