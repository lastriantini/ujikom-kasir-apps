<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Models\Member;

Route::get('/', function() {
    return view('dashboard');
});

Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::get('/dashboard', function() {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::prefix('/user')->group(function(): void {
    Route::get('/data', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::prefix('product')->group(function(): void {
    Route::get('/data', [ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::put('/{product}/edit-stock', [ProductController::class, 'editStock'])->name('product.edit-stock');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/addProduct', [ProductController::class, 'addProduct'])->name('product.addProduct');
});

Route::prefix('order')->name('order.')->group(function(): void {
    Route::get('/data', [OrderController::class, 'index'])->name('index');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/review', [OrderController::class, 'review'])->name('review');
    Route::get('/checkMember', [MemberController::class, 'checkMember'])->name('checkMember');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
});

// Route::get('/checkMember', function() {
//     return view('order.checkMember');
// })->name('checkMember');

Route::get('/review', function() {
    return view('order.review');
})->name('review');

Route::get('/create', function() {
    return view('order.create');
})->name('create');

