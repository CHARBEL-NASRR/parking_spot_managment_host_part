<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\createtitleController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\upload_id_Controller;


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
        Route::get('/upload_id', [upload_id_Controller::class, 'showuploadpage'])->name('upload_id.form');
        Route::post('/upload_id/upload', [upload_id_Controller::class, 'uploadImageToGoogleDrive2'])->name('upload_id.save');
        Route::get('/description/{spot_id}', [DescriptionController::class, 'showDescriptionForm'])->name('description.form');
        Route::post('/description/{spot_id}', [DescriptionController::class, 'saveDescription'])->name('description.save');
        Route::post('/description/update-title/{spot_id}', [DescriptionController::class, 'updateTitle'])->name('description.update-title');
        Route::get('/images', [GoogleDriveController::class, 'showImagesForm'])->name('images.form');
        Route::post('/images/upload', [GoogleDriveController::class, 'uploadImageToGoogleDrive'])->name('google.upload');
    });
});