    Route::get('/dashboard', function () {
            return view('dashboard.dashboard');
        })->name('dashboard');
        Route::get('/calendar/{spot_id?}', [AvailabilityController::class, 'showCalendar'])->name('calendar');
        Route::get('/calendar/events/{spot_id}', [AvailabilityController::class, 'getSpotEvents'])->name('calendar.events');
        Route::post('/calendar/save', [AvailabilityController::class, 'saveAvailability'])->name('calendar.save');
        Route::post('/calendar/delete', [AvailabilityController::class, 'deleteAvailability'])->name('calendar.delete');
        Route::post('/calendar/update', [AvailabilityController::class, 'updateAvailability'])->name('calendar.update');
        Route::get('/spots', [SpotsController::class, 'showSpots'])->name('spots.show');
        Route::get('/profile',[ProfileController::class,'showProfileForm'])->name('profile.show');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

