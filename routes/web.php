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
use App\Http\Controllers\AmennitiesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SpotsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;


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
        
        Route::get('/location',[LocationController::class,'showLocationForm'])->name('location.form');
        Route::post('/googlemap',[LocationController::class,'saveLocation'])->name('save-location');
        Route::get('/amenities', [AmennitiesController::class, 'showAmenitiesForm'])->name('amenities.show');
        Route::post('/amenities/save', [AmennitiesController::class, 'submitAmenities'])->name('amenities.save');
        Route::get('/title', [createtitleController::class, 'showTitleForm'])->name('title.form');
        Route::post('/title', [createtitleController::class, 'saveTitle'])->name('title.save');
        Route::get('/upload_id', [upload_id_Controller::class, 'showuploadpage'])->name('upload_id.form');
        Route::post('/upload_id/upload', [upload_id_Controller::class, 'uploadImageToGoogleDrive2'])->name('upload_id.save');
        Route::get('/description/{spot_id}', [DescriptionController::class, 'showDescriptionForm'])->name('description.form');
        Route::post('/description/{spot_id}', [DescriptionController::class, 'saveDescription'])->name('description.save');
        Route::get('/images/{spot_id}', [GoogleDriveController::class, 'showImagesForm'])->name('images.form');
        Route::post('/images/upload', [GoogleDriveController::class, 'uploadImageToGoogleDrive'])->name('google.upload');




        Route::get('/dashboard', function () {
            return view('dashboard.dashboard');
        })->name('dashboard');
        Route::get('/calendar/{spot_id?}', [CalendarController::class, 'showCalendar'])->name('calendar');
        Route::get('/calendar/events/{spot_id}', [CalendarController::class, 'getSpotEvents'])->name('calendar.events');
        Route::post('/calendar/save', [CalendarController::class, 'saveAvailability'])->name('calendar.save');
        Route::post('/calendar/delete', [CalendarController::class, 'deleteAvailability'])->name('calendar.delete');
        Route::post('/calendar/update', [CalendarController::class, 'updateAvailability'])->name('calendar.update');
        Route::get('/spots', [SpotsController::class, 'showSpots'])->name('spots.show');
        Route::get('/profile',[ProfileController::class,'showProfileForm'])->name('profile.show');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/sendticket',[TicketController::class,'store'])->name('tickets.store');
        Route::get('/notifications/count', [NotificationController::class, 'getNewMessagesCount'])->name('notifications.count');
        Route::get('/notifications/tickets', [NotificationController::class, 'getTickets'])->name('notifications.tickets');
        Route::get('/booking/requested',[BookingController::class,'getRequestedBookings'])->name('bookings.requested');
        Route::post('/booking/update/{id}',[BookingController::class,'updateBookingStatus'])->name('bookings.update');
        Route::get('/bookings/last', [BookingController::class, 'getLastBookings'])->name('dashboard.bookings');   
        Route::get('/booking/{id}', [BookingController::class, 'getBooking'])->name('bookings.show');
    });
});