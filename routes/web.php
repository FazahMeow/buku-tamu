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
})->name('login');//->middleware('report');

Route::post('/login', [AuthController::class, 'login']);
    //->middleware('report');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [VisitorController::class, 'index'])->name('dashboard');

Route::post('/visitor', [VisitorController::class, 'store'])
     ->name('visitor.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/report/dashboard', [VisitorController::class, 'report'])->name('report');
    Route::get('/report', [VisitorController::class, 'report'])->name('report');
});