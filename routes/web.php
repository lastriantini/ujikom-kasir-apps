<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;

Route::get('/', function() {
    return view('dashboard');
});
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
    // Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/{product}/edit-stock', [ProductController::class, 'editStock'])->name('product.edit-stock');
});

Route::prefix('member')->group(function(): void {
    // Route::get('/data', [MemberController::class, 'index'])->name('member.index');
    // Route::get('/create', [MemberController::class, 'create'])->name('member.create');
    // Route::post('/store', [MemberController::class, 'store'])->name('member.store');
    // Route::get('/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
    // Route::put('/{member}', [MemberController::class, 'update'])->name('member.update');
    // Route::delete('/{member}', [MemberController::class, 'destroy'])->name('member.destroy');
});
