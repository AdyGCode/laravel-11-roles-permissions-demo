<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified',])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit',])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update',])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy',])->name('profile.destroy');
});


Route::middleware([
    'auth',
    'permission:role-index', 'permission:role-create', 'permission:role-edit', 'permission:role-delete',
    'permission:product-index', 'permission:product-create', 'permission:product-edit', 'permission:product-delete',
    'permission:users-index', 'permission:users-create', 'permission:users-edit', 'permission:users-delete',
])->group(function () {
    Route::resource('roles', RoleController::class)->only(['index', 'store',]);
    Route::resource('users', UserController::class)->only(['index', 'store',]);
    Route::resource('products', ProductController::class)->only(['index', 'store',]);
});

Route::middleware([
    'auth', 'permission:role-create', 'permission:product-create', 'permission:users-create',
])->group(function () {
    Route::resource('roles', RoleController::class)->only(['create', 'store',]);
    Route::resource('users', UserController::class)->only(['create', 'store',]);
    Route::resource('products', ProductController::class)->only(['create', 'store',]);
});

Route::middleware([
    'auth', 'permission:role-edit', 'permission:product-edit', 'permission:users-edit',
])->group(function () {
    Route::resource('roles', RoleController::class)->only(['edit', 'update',]);
    Route::resource('users', UserController::class)->only(['edit', 'update',]);
    Route::resource('products', ProductController::class)->only(['edit', 'update',]);
});

Route::middleware([
    'auth', 'permission:role-delete', 'permission:product-delete', 'permission:users-delete',
])->group(function () {
    Route::resource('roles', RoleController::class)->only(['destroy',]);
    Route::resource('users', UserController::class)->only(['destroy',]);
    Route::resource('products', ProductController::class)->only(['destroy',]);
});

require __DIR__ . '/auth.php';
