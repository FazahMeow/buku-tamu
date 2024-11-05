<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisitorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome'); 
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');//->middleware('dashboard');

Route::post('/login', [AuthController::class, 'login']);
    //->middleware('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [VisitorController::class, 'dashboard'])->name('dashboard');
    
    // Tambahkan route untuk halaman pengunjung
    Route::get('/pengunjung', [VisitorController::class, 'index'])->name('pengunjung');
    
    Route::post('/pengunjung', [VisitorController::class, 'store'])->name('pengunjung.store');
});