<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::apiResource('tasks', TaskController::class);
});


Route::get('holamon', function () {
    return 'Hola Mon!';
});

Route::get('holamon/{nom}', function ($nom) {
    return 'Hola Mon! ' . $nom;
});

Route::apiResource('tasks', TaskController::class);
Route::apiResource('categories', CategoryController::class);
