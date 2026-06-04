<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::get('/search-products', [HomeController::class, 'searchProducts'])
    ->name('products.search');

/*
|--------------------------------------------------------------------------
| REDIRECT DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect('/login');
    }

    if (auth()->user()->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/user/dashboard');

})->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin']);

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/user/dashboard', [HomeController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/user/products/{id}', [HomeController::class, 'show'])
        ->name('user.products.show');

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    |
    */

    Route::get('/user/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/user/cart/add/{productId}', [CartController::class, 'addToCart'])
        ->name('cart.add');

    Route::patch('/user/cart/update/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/user/cart/delete/{id}', [CartController::class, 'destroy'])
        ->name('cart.delete');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::resource('products', ProductController::class);

        Route::resource('promos', PromoController::class);

    });