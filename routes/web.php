<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Models\Member;


Route::middleware('guest')->group(function () {
    Route::post('/loginAuth', [UserController::class, 'loginAuth'])->name('loginAuth');
    Route::get('/', function() {
        return view('login');
    })->name('login');
    Route::get('/login', function() {
        return view('login');
    })->name('home');
});

Route::middleware(['isLogin'])->group(function () {
    // Route::get('/dashboard', function() {
    //         return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::prefix('product')->group(function(): void {
        Route::get('/data', [ProductController::class, 'index'])->name('product.index');
    });
    Route::prefix('order')->name('order.')->group(function(): void {
        Route::get('/data', [OrderController::class, 'index'])->name('index');
        Route::get('/invoice/{order}', [OrderController::class, 'invoice'])->name('invoice');
        Route::get('/exportPDF/{order}', [OrderController::class, 'exportPDF'])->name('pdf');
    });
});

Route::middleware('isStaff')->group(function () {
    Route::prefix('product')->group(function(): void {
        Route::get('/addProduct', [ProductController::class, 'addProduct'])->name('product.addProduct');
    });
    Route::prefix('order')->name('order.')->group(function(): void {
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/review', [OrderController::class, 'review'])->name('review');
        // Route::match(['get', 'post'], '/review', [OrderController::class, 'review']);
        Route::get('/checkMember', [MemberController::class, 'checkMember'])->name('checkMember');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
    });
});

Route::middleware(['isAdmin'])->group(function () {
    Route::prefix('/user')->group(function(): void {
        Route::get('/data', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });
    Route::prefix('product')->group(function(): void {
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::put('/{product}/edit-stock', [ProductController::class, 'editStock'])->name('product.edit-stock');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    }); 
    Route::prefix('order')->name('order.')->group(function(): void {
        Route::get('/{id}/export-excel', [OrderController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-orders', [OrderController::class, 'export'])->name('export.excel');
    });
});


