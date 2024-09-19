<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;

// Rute za prijavu i registraciju
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rute za knjige (ne zahtijevaju autentifikaciju)
Route::get('/books', [BookController::class, 'index']);

// Rute koje zahtijevaju autentifikaciju
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/order', [OrderController::class, 'store']); // Dodavanje narudžbi
    Route::delete('/cart/{id}', [CartController::class, 'removeFromCart']); // Uklanjanje stavke iz košarice
    Route::post('/checkout', [CartController::class, 'checkout']); // Završavanje kupovine

    // Ruta za poništavanje narudžbi
    Route::delete('/order/{orderId}', [OrderController::class, 'cancelOrder']);
    Route::get('/cart', [OrderController::class, 'getCartItems']);
});

// Admin routes that require both authentication and admin privileges
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/admin/books', [BookController::class, 'store']); // Add new book
    Route::put('/admin/books/{book}', [BookController::class, 'update']); // Update book
    //Route::put('/admin/books/title/{title}', [BookController::class, 'updateByTitle']);
    Route::delete('/admin/books/{id}', [BookController::class, 'destroy']);


});
