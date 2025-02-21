@extends('layouts.app')

@section('title', 'Cek Saldo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Saldo Santri</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Santri</th>
                                    <th>Saldo Utama</th>
                                    <th>Saldo Belanja</th>
                                    <th>Saldo Tabungan</th>
                                    <th>Total Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($santri as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>Rp {{ number_format($s->saldo_utama, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($s->saldo_belanja, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($s->saldo_tabungan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($s->saldo_utama + $s->saldo_belanja, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    });
</script>
@endpush
@endsection 