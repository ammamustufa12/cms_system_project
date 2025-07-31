<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;




Route::get('/login', function () {
    return redirect()->route('twill.login');
})->name('login');
Route::middleware(['web'])->prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Index - List all users
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Create - Show form to create user
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Store - Save new user
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Show - View user details (optional)
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Edit - Show form to edit user
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

// Update - Save updated user
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

// Delete - Remove user
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

