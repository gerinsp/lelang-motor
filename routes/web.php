<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DevController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::view('/', 'dashboard')->middleware('auth')->name('home');
Volt::route('/', 'pages.users.lelang.index')->middleware(['auth', 'isNotAdmin'])->name('home');

Volt::route('/profile', 'pages.admin.users.form')->name('profile');

// Users Routes
Route::prefix('users')->name('users.')->middleware(['auth', 'isNotAdmin'])->group(function () {
    Volt::route('/', 'pages.users.dashboard')->name('dashboard');
    Route::prefix('lelang')->name('lelang.')->group(function () {
        Volt::route('/', 'pages.users.lelang.index')->name('index');
        Volt::route('/join/{lelang}', 'pages.users.lelang.join')->name('join');
        Volt::route('/bayar', 'pages.mask')->name('bayar');
        Volt::route('/history', 'pages.users.lelang.history')->name('history');

        Volt::route('/{lelang}', 'pages.mask')->name('detail');
    });

    // Saldo
    Route::prefix('saldo')->name('saldo.')->group(function () {
        Volt::route('/', 'pages.users.saldo.index')->name('index');
        Volt::route('/topup', 'pages.users.saldo.topup')->name('topup');
        Volt::route('/topup/{topup}', 'pages.users.saldo.topup')->name('topup.edit');
    });
    Volt::route('/pemenang', 'pages.admin.pemenang.user')->name('pemenang.index');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
    Volt::route('/', 'pages.admin.dashboard')->name('dashboard');

    Route::prefix('lelang')->name('lelang.')->group(function () {
        Volt::route('/', 'pages.admin.lelang.index')->name('index');
        Volt::route('/create', 'pages.admin.lelang.form')->name('create');
        Volt::route('/bayar', 'pages.admin.lelang.bayar')->name('bayar');
        Volt::route('/nasabah', 'pages.admin.lelang.nasabah')->name('nasabah');
        // route edit sengaja disimpan di bawah soalnya kalau disimpan diatas route bayar dan nasabah
        // maka 2 route itu menjadi notfound
        Volt::route('/{lelang}', 'pages.admin.lelang.form')->name('edit');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Volt::route('/', 'pages.admin.users.index')->name('index');
        Volt::route('/create', 'pages.admin.users.form')->name('create');
        Volt::route('/edit/{user}', 'pages.admin.users.form')->name('edit');
    });
    Route::prefix('saldo')->name('saldo.')->group(function () {
        Volt::route('/', 'pages.admin.saldo.index')->name('index');
        Volt::route('/history', 'pages.admin.saldo.history')->name('history');
    });
    Route::prefix('pemenang')->name('pemenang.')->group(function () {
        Volt::route('/', 'pages.admin.pemenang.index')->name('index');
        Volt::route('/{user}', 'pages.admin.pemenang.user')->name('user');
    });
    // Volt::route('/profile', 'pages.admin.profile')->name('profile');
});










// Dev Routes
Volt::route('renderless', 'pages.renderless')->name('renderless');
Volt::route('devvolt', 'pages.dev')->name('devvolt');


Route::view('/flowbite', 'flowbite');
Route::get('/dev', DevController::class)->name('dev');











// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__ . '/auth.php';
