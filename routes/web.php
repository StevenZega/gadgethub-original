<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    if (auth()->user()->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/user/dashboard');

})->middleware('auth');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin']);


Route::get('/user/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('user.dashboard');

// Route Landing Page Utama User
Route::get('/user/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('user.dashboard');

Route::get('/user/products/{id}', [App\Http\Controllers\HomeController::class, 'show'])->middleware('auth')->name('user.products.show');

Route::prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
});