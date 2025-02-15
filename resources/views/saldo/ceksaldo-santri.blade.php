@extends('layouts.app')

@section('title', 'Cek Saldo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Saldo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>NIS</th>
                                    <td>: {{ $santri->nis }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>: {{ $santri->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Saldo Saat Ini</th>
                                    <td>: Rp {{ number_format($santri->saldo, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 