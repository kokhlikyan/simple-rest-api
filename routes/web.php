<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChangeRestedPassword;

Route::get('/reset-password', function () {
    return view('auth.reset');
})->name('password.reset');
Route::post('/reset-password', ChangeRestedPassword::class)
    ->name('password.change');

Route::fallback(function (){
    return redirect('/api/documentation');
});
