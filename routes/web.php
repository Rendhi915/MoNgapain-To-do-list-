<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Home (alias to todos list)
    Route::get('/home', [TodoController::class, 'index'])->name('home');

    // To-Do CRUD
    Route::get('/todos',              [TodoController::class, 'index'])->name('todos.index');
    Route::get('/todos/completed',    [TodoController::class, 'completed'])->name('todos.completed');
    Route::get('/todos/create',       [TodoController::class, 'create'])->name('todos.create');
    Route::post('/todos/store',       [TodoController::class, 'store'])->name('todos.store');
    Route::get('/todos/{todo}/edit',  [TodoController::class, 'edit'])->name('todos.edit');
    Route::put('/todos/{todo}/update',[TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}/delete', [TodoController::class, 'destroy'])->name('todos.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
});
