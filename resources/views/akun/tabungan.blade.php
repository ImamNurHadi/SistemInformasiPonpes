@extends('layouts.app')

@section('title', 'Akun Tabungan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Akun Tabungan</h3>
                </div>
                <div class="card-body">
                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Saldo Tabungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($santriList as $index => $santri)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $santri->nis }}</td>
                                        <td>{{ $santri->nama }}</td>
                                        <td>Rp {{ number_format($santri->saldo_tabungan, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(auth()->user()->isSantri())
                        @if($saldo !== null)
                            <div class="alert alert-info">
                                <h4 class="alert-heading">Saldo Tabungan Anda:</h4>
                                <h2 class="mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
                            </div>
                            <p class="text-muted">
                                Saldo tabungan adalah saldo yang Anda simpan untuk keperluan masa depan.
                            </p>
                        @else
                            <div class="alert alert-warning">
                                Data saldo tidak ditemukan.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            Anda tidak memiliki akses ke fitur ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
@endsection 