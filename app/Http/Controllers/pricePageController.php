<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotLocation;
use App\Models\SpotAmenities;
use App\Models\ParkingSpot;

class pricePageController extends Controller
{
    public function showpriceForm($spot_id) {
        $spot = ParkingSpot::where('spot_id', $spot_id)->first();
        $spotAmenities = SpotAmenities::where('spot_id', $spot_id)->first();
        if (!$spot || !$spotAmenities) {
            return redirect()->back()->withErrors('Spot data is missing.');
        }
    
        $carSize = $spot->car_type;
        $basePrice = 5; 
        $priceAdjustment = $this->calculatePrice($spotAmenities, $carSize);
        $finalPrice = $basePrice + $priceAdjustment;
    
        return view('createspot.pricePage', compact('spot', 'finalPrice', 'basePrice'));
    }

    public function calculatePrice($spotAmenities, $carSize) {
        $priceAdjustment = 0;
        $adjustments = [
            'is_covered' => 1,
            'is_gated' => 3,
            'has_security' => 3,
            'has_ev_charging' => 4,
            'is_handicap_accessible' => 2,
            'has_lighting' => 1,
            'has_cctv' => 2
        ];
    
        foreach ($adjustments as $amenity => $value) {
            if ($spotAmenities->$amenity) $priceAdjustment += $value;
        }
    
        $carSizeAdjustments = [
            '2wheeler' => 1, 
            '4wheeler' => 3,
            '6wheeler' => 5,
            '8wheeler' => 10];
        $priceAdjustment += $carSizeAdjustments[$carSize] ?? 0;
    
        return $priceAdjustment;
    }
    
    

    public function savePrice(Request $request){
        $validated = $request->validate([
            'price' => 'required|numeric',
        ]);

        $spot = ParkingSpot::where('spot_id',  $request->spot_id)->first();
        if ($spot) {
            $spot->update([
                'price_per_hour' => $validated['price'],
                'status' => "pending",
            ]);
        }

        return redirect()->route('dashboard');
    }

}
