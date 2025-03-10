<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanPembayaranController extends Controller
{
    public function index()
    {
        return view('laporan.pembayaran.index');
    }
}
