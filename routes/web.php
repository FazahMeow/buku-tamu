<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\AuthController;

// Route untuk login
Route::post('/login', [AuthController::class, 'login'])->name('login');

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

// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman login
Route::get('/login', function () {
    return view('login');
});

// Route untuk halaman dashboard, dilindungi oleh middleware auth
Route::get('/dashboard', function () {
    return 'Selamat datang di Dashboard!';
})->middleware('auth');

// Route untuk halaman GuestBook
Route::get('/guestbook', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::get('/guestbook/create', [GuestBookController::class, 'create'])->name('guestbook.create');
Route::post('/guestbook', [GuestBookController::class, 'store'])->name('guestbook.store');

