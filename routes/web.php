<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\FavoriteController;


Route::get('/', function () {
    return view('welcome');
});

// Routes publiques (Consultation)
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('restaurants', RestaurantController::class)->except(['index', 'show']);
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::post('/restaurants/{restaurant}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/my-favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    });

Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show')->whereNumber('restaurant');;



