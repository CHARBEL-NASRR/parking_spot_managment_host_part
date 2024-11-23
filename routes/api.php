<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Models\ParkingSpot;
use App\Http\Controllers\LoginController;

Route::post('/host/register', [RegisterController::class, 'signup']);
Route::post('/host/login', [LoginController::class, 'login']);

//Used for testing, returns the authenticated user
Route::get('/who', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:api');
