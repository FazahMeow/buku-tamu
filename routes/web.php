<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;

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

Route::get('/guestbook', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::get('/guestbook/create', [GuestBookController::class, 'create'])->name('guestbook.create');
