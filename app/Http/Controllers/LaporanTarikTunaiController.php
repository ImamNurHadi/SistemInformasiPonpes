<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanTarikTunaiController extends Controller
{
    public function index()
    {
        return view('laporan.tarik-tunai.index');
    }
}
