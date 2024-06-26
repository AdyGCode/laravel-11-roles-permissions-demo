<?php

use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('static.welcome');
})->name('home');


// Administration Dashboard
Route::get('/dashboard', [StaticPageController::class, 'admin'])
    ->middleware(['auth', 'verified', 'role:Admin|Super-Admin'])
    ->name('dashboard');


// Members home page
Route::group(['prefix' => 'members', 'middleware' => ['auth', 'verified', 'role:Member|Admin|Super-Admin']],
    function () {
        Route::get('/home', [StaticPageController::class, 'index'])
            ->name('members.home');
    }
);

// Logged in User Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit',])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update',])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy',])->name('profile.destroy');
});


// role-assignment screen
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'verified', 'role:Admin|Super-Admin']
], function () {

    Route::get('/permissions', [RolesAndPermissionsController::class, 'index'])
        ->name('admin.permissions');

    Route::post('/assign_role', [RolesAndPermissionsController::class, 'store'])
        ->name('admin.assign-role');

    Route::delete('/revoke_role', [RolesAndPermissionsController::class, 'destroy'])
        ->name('admin.revoke-role');

    Route::resource('/users', UserController::class);
});


require __DIR__.'/auth.php';
