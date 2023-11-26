<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ChangeEmailController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CommentController;

Route::post('/login', LoginController::class);
Route::post('/registration', RegistrationController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ProfileController::class)
        ->prefix('profile')
        ->group(function () {
            Route::get('/', 'index');
        });
    Route::controller(CommentController::class)
        ->prefix('comment')
        ->group(function () {
            Route::post('/', 'add');
        });
    Route::post('/logout', LogoutController::class);
    Route::post('/reset', ResetPasswordController::class);
    Route::controller(ChangeEmailController::class)
        ->prefix('/change-email',)
        ->group(function () {
            Route::post('/', 'send');
            Route::patch('/', 'change');
        });
});

Route::controller(ArticleController::class)
    ->prefix('article')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::delete('/{id}', 'delete');
    });
