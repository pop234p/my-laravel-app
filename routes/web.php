<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;


Route::get('/', [CarController::class, 'index']);


Route::get('/car/{id}', [CarController::class, 'show']);
Route::post('/book', [CarController::class, 'book']);


Route::get('/my-bookings', [CarController::class, 'myBookings']);


Route::get('/success', [CarController::class, 'success']);


Route::view('/conditions', 'conditions');
Route::view('/promotions', 'promotions');
Route::view('/reviews', 'reviews');
Route::view('/news', 'news');
Route::view('/contacts', 'contacts');