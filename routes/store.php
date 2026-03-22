<?php

use App\Store\Http\Controllers\Discount\DiscountSearchSelectController;
use App\Store\Http\Controllers\Product\ProductSearchSelectController;
use App\Store\Http\Controllers\Topping\ToppingSearchSelectController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'stores.index');

Route::middleware('guest:store')->group(function () {
    Route::controller(App\Store\Http\Controllers\Auth\LoginController::class)
        ->prefix('/login')
        ->as('login.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'login')->name('post');
        });
    Route::controller(App\Store\Http\Controllers\Auth\RegisterController::class)
        ->prefix('/register')
        ->as('register.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'register')->name('post');
        });
});


Route::group(['middleware' => 'store.auth.store:store'], function () {


    //discount
    Route::controller(App\Store\Http\Controllers\Discount\DiscountController::class)
        ->prefix('/discounts')
        ->as('discount.')
        ->group(function () {
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/edit', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

    Route::controller(App\Store\Http\Controllers\Order\OrderController::class)
        ->prefix('/orders')
        ->as('order.')
        ->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/edit', 'update')->name('update');
            Route::get('/refuse/{id}', 'refuse')->name('refuse');
            Route::get('/accept/{id}', 'accept')->name('accept');
        });

    //product
    Route::controller(App\Store\Http\Controllers\Product\ProductController::class)
        ->prefix('/products')
        ->as('product.')
        ->group(function () {
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/edit', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/draft/{id}', 'draft')->name('draft');
            Route::post('/allupload', 'allupload')->name('allupload');
        });
    Route::controller(App\Store\Http\Controllers\Product\ToppingController::class)
        ->prefix('/toppings')
        ->as('topping.')
        ->group(function () {
            Route::group(['middleware' => ['permission:createTopping', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/add', 'create')->name('create');
                Route::post('/add', 'store')->name('store');
            });

            //            Route::get('/store/{id}', 'index')->name('index');
            Route::group(['middleware' => ['permission:updateTopping', 'auth:admin']], function () {
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/edit', 'update')->name('update');
            });
            Route::group(['middleware' => ['permission:deleteTopping', 'auth:admin']], function () {
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });


        });
    //auth
    Route::controller(App\Store\Http\Controllers\Auth\ProfileController::class)
        ->prefix('/profile')
        ->as('profile.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });

    Route::controller(App\Store\Http\Controllers\Auth\ChangePasswordController::class)
        ->prefix('/password')
        ->as('password.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });
    Route::controller(App\Store\Http\Controllers\Prioritizes\PrioritizeController::class)
        ->prefix('/prioritizes')
        ->as('prioritize.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'getprice')->name('get');
            Route::put('/', 'store')->name('store');

        });

    //search
    Route::prefix('/search')->as('search.')->group(function () {
        Route::prefix('/select')->as('select.')->group(function () {
            Route::get('/products', [ProductSearchSelectController::class, 'selectSearch'])->name('product');
            Route::get('/discounts', [DiscountSearchSelectController::class, 'selectSearch'])->name('discount');
            Route::get('/toppings', [ToppingSearchSelectController::class, 'selectSearch'])->name('topping');
        });
    });

    // Route::get('/prioritizes', [App\Store\Http\Controllers\Priorizes\PrioritizeController::class, 'index'])->name('index');
    Route::get('/dashboard', [App\Store\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [App\Store\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
});

