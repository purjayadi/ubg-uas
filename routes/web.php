<?php

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Redirect root ke restaurants
Route::redirect('/', '/restaurants');

// Admin only - CRUD restaurant (HARUS SEBELUM wildcard routes!)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
    Route::get('/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
    // Carousel management for admin
    Route::get('/admin/carousel', [App\Http\Controllers\CarouselController::class, 'index'])->name('carousel.index');
    Route::get('/admin/carousel/create', [App\Http\Controllers\CarouselController::class, 'create'])->name('carousel.create');
    Route::post('/admin/carousel', [App\Http\Controllers\CarouselController::class, 'store'])->name('carousel.store');
    Route::get('/admin/carousel/{image}/edit', [App\Http\Controllers\CarouselController::class, 'edit'])->name('carousel.edit');
    Route::put('/admin/carousel/{image}', [App\Http\Controllers\CarouselController::class, 'update'])->name('carousel.update');
    Route::delete('/admin/carousel/{image}', [App\Http\Controllers\CarouselController::class, 'destroy'])->name('carousel.destroy');
});

// Restaurant routes (public - bisa dilihat tanpa login)
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/search', [RestaurantController::class, 'search'])->name('restaurants.search');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

// User only - Review restaurant
Route::middleware('auth')->group(function () {
    Route::post('/restaurants/{restaurant}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Auth routes
require __DIR__.'/auth.php';