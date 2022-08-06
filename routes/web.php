<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('booking.bookingIndex');
});
// For booking
Route::resource('bookings', App\Http\Controllers\BookingsController::class);
Route::delete('bookings/{id}', 'App\Http\Controllers\BookingsController@destroy')->name('bookings.destroy');
Route::post('bookings/{id}', 'App\Http\Controllers\BookingsController@edit')->name('bookings.edit');
Route::post('/bookingsUpdate', [App\Http\Controllers\BookingsController::class, 'update'])->name('bookingsUpdate');