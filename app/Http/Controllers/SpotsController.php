<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSpot;
use App\Models\Image;
use App\Models\spotLocation;

class SpotsController extends Controller
{
    public function showSpots()
    {
        $spots = ParkingSpot::all();

        $spots = $spots->filter(function ($spot) {
            if (empty($spot->status)) {
                $spot->status = 'pending';
            }
            return $spot->status !== 'rejected';
        }); 
        
        foreach ($spots as $spot) {
            $spot->image = Image::where('spot_id', $spot->spot_id)->first();
        }

        foreach($spots as $spot) {
            $spot->address = spotLocation::where('spot_id', $spot->spot_id)->first();
        }

        return view('dashboard.spots', compact('spots'));
    }
}