<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    // User
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/users', [UserController::class, 'allUsers'])->name('users');
    Route::get('/user/{id}', [UserController::class, 'userById'])->name('user');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user');

    // Sign Roles
    Route::post('/add-roles', [RolesController::class, 'create'])->name('signRoles');
    Route::post('/sign-roles', [RolesController::class, 'signRoles'])->name('signRoles');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
