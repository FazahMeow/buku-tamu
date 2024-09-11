<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});


<<<<<<< HEAD
=======
Route::get('/guestbook', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::get('/guestbook/create', [GuestBookController::class, 'create'])->name('guestbook.create');
Route::post('/guestbook', [GuestBookController::class, 'store'])->name('guestbook.store');

