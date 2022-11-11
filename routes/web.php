<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::resource('users', \App\Http\Controllers\UserController::class)
    ->middleware('auth');

Route::resource('kategoris', \App\Http\Controllers\KategoriController::class)
    ->middleware('auth');

// Route::resource('penjualans', \App\Http\Controllers\PenjualanController::class)->middleware('auth');

Route::resource('peramalans', \App\Http\Controllers\PeramalanController::class)
    ->middleware('auth');

Route::resource('peramalanheaders', \App\Http\Controllers\PeramalanHeaderController::class)
    ->middleware('auth');

Route::get('penjualans', [App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualans.index')->middleware('auth');

Route::get('penjualans/create', [App\Http\Controllers\PenjualanController::class, 'create'])->name('penjualans.create')->middleware('auth');

Route::post('penjualans/store', [App\Http\Controllers\PenjualanController::class, 'store'])->name('penjualans.store')->middleware('auth');

Route::get('penjualans/{tahun}/{bulan}/show', [App\Http\Controllers\PenjualanController::class, 'show'])->name('penjualans.show')->middleware('auth');

Route::get('penjualans/{id}/edit', [App\Http\Controllers\PenjualanController::class, 'edit'])->name('penjualans.edit')->middleware('auth');

Route::put('penjualans/{id}/update', [App\Http\Controllers\PenjualanController::class, 'update'])->name('penjualans.update')->middleware('auth');

Route::delete('penjualans/{id}/destroy', [App\Http\Controllers\PenjualanController::class, 'destroy'])->name('penjualans.destroy')->middleware('auth');
;

