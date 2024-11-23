<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\createtitleController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\GoogleDriveController;


Route::get('/', function () {
    return view('welcome');
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('host')->group(function () {
    Route::get('/register', function () {
        return view('signup');
    })->name('signup');

    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/validate/{token}', [RegisterController::class, 'validateToken'])->name('validate.token');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('login/google-callback', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('login/google-redirect', [GoogleLoginController::class, 'handleGoogleCallback'])->name('login.google-callback');

    Route::get('forgetpassword', [ForgetPasswordController::class, 'showForgetPassword'])->name('forgetpassword.form');
    Route::post('forgetpassword', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('resetpassword/{token}', [ForgetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('resetpassword', [ForgetPasswordController::class, 'resetPassword'])->name('password.update');
       
       Route::group(['middleware' => 'auth'], function () {
        Route::get('/title', [createtitleController::class, 'showTitleForm'])->name('title.form');
        Route::post('/title', [createtitleController::class, 'saveTitle'])->name('title.save');
        Route::get('/description', [DescriptionController::class, 'showDescriptionForm'])->name('description.form');
        Route::post('/description', [DescriptionController::class, 'saveDescription'])->name('description.save');
        Route::get('/images', [GoogleDriveController::class, 'showImagesForm'])->name('images.form');
        Route::post('/upload-images', [GoogleDriveController::class, 'upload'])->name('upload.images');

    });
});