<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotLocation;
use App\Models\SpotAmenities;
use App\Models\ParkingSpot;

class pricePageController extends Controller
{
    public function showpriceForm($spot_id){
        $user = auth()->user(); 
        $spot = ParkingSpot::where('spot_id', $spot_id)->first();
        $spotAmenities = SpotAmenities::where('spot_id', $spot_id)->first();
        $spotLocation = SpotLocation::where('spot_id', $spot_id)->first();
        $carSize = ParkingSpot::where('spot_id', $spot_id)->value('car_type');

        $basePrice = 0;
        $priceAdjustment = 0;
    
        if ($spotAmenities->is_covered) $priceAdjustment += 3;
        if ($spotAmenities->is_gated) $priceAdjustment += 5;
        if ($spotAmenities->has_security) $priceAdjustment += 6;
        if ($spotAmenities->has_ev_charging) $priceAdjustment += 8;
        if ($spotAmenities->is_handicap_accessible) $priceAdjustment += 4;
        if ($spotAmenities->has_lighting) $priceAdjustment += 2;
        if ($spotAmenities->has_cctv) $priceAdjustment += 2;

        if ($carSize == '1') $priceAdjustment += 2;
        if ($carSize == '2') $priceAdjustment += 5;
        if ($carSize == '3') $priceAdjustment += 7;
        if ($carSize == '4') $priceAdjustment += 15;
        
        // if (str_contains($spotLocation->city, 'Beirut')) {
        //     $priceAdjustment += 10;
        // } 
        

        $finalPrice = $basePrice + $priceAdjustment;

        return view('createspot.pricePage', compact('spot', 'finalPrice', 'basePrice')); 
    }

    public function savePrice(Request $request){
        $validated = $request->validate([
            'price' => 'required|numeric',
        ]);

        $spot = ParkingSpot::where('spot_id',  $request->spot_id)->first();
        if ($spot) {
            $spot->update([
                'price_per_hour' => $validated['price'],
            ]);
        }

        return redirect()->route('dashboard');
    }

}
