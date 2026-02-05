<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;


Route::get('/', function () {
    return view('welcome');
});

// Routes publiques (Consultation)
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('restaurants', RestaurantController::class)->except(['index', 'show']);
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

    });

Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show')->whereNumber('restaurant');;



