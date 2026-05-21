<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect('/login');
});
/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| DASHBOARD & LANDING USER
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    if (auth()->user()->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    // 2. Jika dia user biasa/customer, arahkan ke HomeController (Landing Page)
    return redirect('/user/dashboard');

})->middleware('auth');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin']);


// 3. Ubah route ini agar memanggil HomeController, bukan cuma return kosongan
Route::get('/user/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('user.dashboard');


Route::prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
});