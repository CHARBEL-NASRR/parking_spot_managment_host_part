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
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AmennitiesController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SpotsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\pricePageController;
use App\Http\Controllers\carSizeController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UpcomingBookingsController;    


Route::get('/', function () {
    return view('welcome');
});



Route::prefix('host')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
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

        Route::get('/getstarted', function () {
            return view('createspot.GetStarted');
        })->name('getstarted');

        Route::get('/upload_docs', [VerificationController::class, 'showuploadverificationpage'])->name('upload_docs.form');
        Route::post('/upload_docs', [VerificationController::class, 'uploadVeriDocsToGoogleDrive2'])->name('upload_docs.save');
        Route::get('/upload-docs', [VerificationController::class, 'showUploadForm'])->name('upload_docs.updateform');
        Route::post('/upload-docs', [VerificationController::class, 'updateVeriDocsInGoogleDrive'])->name('upload-docs.update');
        
        
        Route::get('/amenities', [AmennitiesController::class, 'showAmenitiesForm'])->name('amenities.show');
        Route::post('/amenities/save', [AmennitiesController::class, 'submitAmenities'])->name('amenities.save');
        Route::get('/pin', [PinController::class, 'showPinForm'])->name('pin.form');
        Route::post('/pin', [PinController::class, 'storePin'])->name('pin.submit');
        Route::get('/title', [createtitleController::class, 'showTitleForm'])->name('title.form');
        Route::post('/title', [createtitleController::class, 'saveTitle'])->name('title.save');
        Route::get('/description/{spot_id}', [DescriptionController::class, 'showDescriptionForm'])->name('description.form');
        Route::post('/description/{spot_id}', [DescriptionController::class, 'saveDescription'])->name('description.save');
        Route::get('/images/{spot_id}', [GoogleDriveController::class, 'showImagesForm'])->name('images.form');
        //
        Route::post('/images/upload', [GoogleDriveController::class, 'uploadImageToGoogleDrive'])->name('google.upload');
        Route::get('/location/{spot_id}',[LocationController::class,'showLocationForm'])->name('location.form');
        Route::post('/googlemap/{spot_id}',[LocationController::class,'saveLocation'])->name('save-location');
        Route::get('/price/{spot_id}', [pricePageController::class, 'showpriceForm'])->name('price.form');
        Route::post('/price/{spot_id}',[pricePageController::class, 'savePrice'])->name('save-price');
        Route::get('/carSize/{spot_id}', [carSizeController::class, 'showCarSizeForm'])->name('carSize.show');
        Route::post('/carSize/{spot_id}', [carSizeController::class, 'saveCarSize'])->name("carSize.save");
        Route::get('/availability/{spot_id}', [AvailabilityController::class, 'showAvailabilityForm'])->name('availability.form');
        Route::post('/availability', [AvailabilityController::class, 'saveAvailability'])->name('availability.save');

        Route::get('/upload_id', [upload_id_Controller::class, 'showuploadpage'])->name('upload_id.form');
        Route::post('/upload_id/upload', [upload_id_Controller::class, 'uploadImageToGoogleDrive2'])->name('upload_id.save');


        Route::get('/dashboard', function () {
            return view('dashboard.dashboard');
        })->name('dashboard');

        Route::get('/dashboard/revenue-data', [DashboardController::class, 'getRevenueData'])->name('dashboard.revenue-data');
        Route::get('/dashboard/last-bookings', [DashboardController::class, 'getLastBookings'])->name('dashboard.last-bookings');
        Route::get('/dashboard/monthly-income', [DashboardController::class, 'getMonthlyIncome'])->name('dashboard.monthly-income');
        Route::get('/dashboard/daily-income', [DashboardController::class, 'getDailyIncome'])->name('dashboard.daily-income');
        Route::get('/dashboard/deals-completed', [DashboardController::class, 'getDealsCompleted'])->name('dashboard.deals-completed');
        Route::get('/dashboard/overall-rating', [DashboardController::class, 'getOverallRating'])->name('dashboard.overall-rating');
        
          
        Route::get('/weekly-schedule', [CalendarController::class, 'showWeeklySchedule'])->name('weekly-schedule');
        Route::get('/get-spot-availability/{spotId}', [CalendarController::class, 'getSpotAvailability'])->name('get-spot-availability');
        Route::post('/save-availability', [CalendarController::class, 'saveAvailability']);
        Route::post('/update-availability', [CalendarController::class, 'updateAvailability']);
        Route::post('/delete-availability', [CalendarController::class, 'deleteAvailability']);
       
       
        Route::get('/spots', [SpotsController::class, 'showSpots'])->name('spots.show');
       
       
       
        Route::get('/profile',[ProfileController::class,'showProfileForm'])->name('profile.show');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('/profile/change-picture', [ProfileController::class, 'changeProfilePicture'])->name('profile.change-picture');        Route::post('/profile/sendticket',[TicketController::class,'store'])->name('tickets.store');
       
       
        Route::get('/notifications/count', [NotificationController::class, 'getNewMessagesCount'])->name('notifications.count');
        Route::get('/notifications/tickets', [NotificationController::class, 'getTickets'])->name('notifications.tickets');
       
       
        Route::get('/booking/requested',[BookingController::class,'getRequestedBookings'])->name('bookings.requested');
        Route::post('/booking/update/{id}',[BookingController::class,'updateBookingStatus'])->name('bookings.update');
        Route::get('/bookings/last', [BookingController::class, 'getLastBookings'])->name('dashboard.bookings');   
        Route::get('/booking/{id}', [BookingController::class, 'getBooking'])->name('bookings.show');
      
      
        Route::get('/upcoming-bookings', [UpcomingBookingsController::class, 'getUpcomingBookings'])->name('upcoming.bookings');
        Route::get('/upcoming-bookings/view', [UpcomingBookingsController::class, 'viewUpcomingBookings'])->name('upcoming.bookings.view');
    
    
        Route::get('/messages', [ChatController::class, 'index'])->name('messages.index');
        Route::post('/messages', [ChatController::class, 'send'])->name('messages.send');
    });
    
});