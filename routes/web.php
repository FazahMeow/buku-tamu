<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;
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

Route::get('/dashboard', function () {
    return view('login-page.dashboard');
})->name('dashboard');

Route::post('/visitor', [VisitorController::class, 'store'])
     ->name('visitor.store');

Route::get('/dashboard/report', function(){
    return view('login-page.report');
})->name('report');

Route::get('/report', function(){
    return view('login-page.report');
})->name('report');

// Route::get('/', function () {
//     return view('welcome'); 
// });

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');//->middleware('dashboard');

// Route::post('/login', [AuthController::class, 'login']);
//     //->middleware('dashboard');

// Route::get('/dashboard', function () {
//     return view('login-page.dashboard');
// })->name('dashboard');

// Route::post('/visitor', [VisitorController::class, 'store'])
//      ->name('visitor.store');

// Route::get('/dashboard/report', function(){
//     return view('login-page.report');
// })->name('report');
