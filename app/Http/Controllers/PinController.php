<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ParkingSpot;

class PinController extends Controller
{

    public function showPinForm(Request $request)
    {
        $user = auth()->user();

        $spot_id = $request->query('spot_id');
        $spot = null;

        if ($spot_id) {
            $spot = ParkingSpot::where('spot_id', $spot_id)
                                ->first();
        }
        return view('createspot.PinCode', compact('spot'));
    }

    public function storePin(Request $request)
    {
        $spot_id = $request->spot_id;
        $pin = $request->pin;  

        $request->validate([
            'pin' => 'required|digits:4', 
            'spot_id' => 'required|exists:parking_spots,spot_id',  
        ]);

        $parkingSpot = ParkingSpot::where('spot_id', $request->spot_id)
                           ->first();

        if (!$parkingSpot) {
            return back()->withErrors(['error' => 'Parking spot not found.']);
        }

        $parkingSpot->update(['key_box' => $pin]);
        $parkingSpot->save();

        return redirect()->route('title.form', ['spot_id' => $parkingSpot->spot_id]);
    }
}
