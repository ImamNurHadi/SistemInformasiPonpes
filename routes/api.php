<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\TransferQRController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/kamar/{komplek_id}', [KamarController::class, 'getByKomplek']);
Route::get('/santri/{santri}/saldo', [SantriController::class, 'getSaldo']);
Route::get('/santri/{santri}', [SantriController::class, 'getSantriData']);

// Tambahan route untuk TransferQRController
Route::get('/santri/id/{id}', [TransferQRController::class, 'getSantriData']); 