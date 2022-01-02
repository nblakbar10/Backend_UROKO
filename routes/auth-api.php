<?php

use App\Http\Controllers\API\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\Auth\ConfirmablePasswordController;
use App\Http\Controllers\API\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\API\Auth\EmailVerificationPromptController;
use App\Http\Controllers\API\Auth\NewPasswordController;
use App\Http\Controllers\API\Auth\PasswordResetLinkController;
use App\Http\Controllers\API\Auth\RegisteredUserController;
use App\Http\Controllers\API\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest','web');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest','web');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request-api');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email-api');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset-api');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update-api');


Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth:api')
                ->name('password.confirm-api');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth:api');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth:api')
                ->name('api-logout');
