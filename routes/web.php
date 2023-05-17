<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiAlternatifController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\WpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('spk', function () {
    return view('spk');
});
Route::resource('alternatif', AlternatifController::class);
Route::resource('kriteria', KriteriaController::class)->parameters([
    'kriteria' => 'kategori'
]);
Route::resource('nilai-alternatif', NilaiAlternatifController::class)->parameters([
    'nilai-alternatif' => 'alternatif'
])->except(['show', 'destroy', 'create', 'store']);
Route::get('hasil-seleksi/SAW', [SawController::class, 'index']);
Route::get('hasil-seleksi/WP', [WpController::class, 'index']);
Route::get('hasil-seleksi/TOPSIS', [TopsisController::class, 'index']);
