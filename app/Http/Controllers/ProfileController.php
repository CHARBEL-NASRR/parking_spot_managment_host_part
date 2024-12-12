<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HostDetail;
use App\Models\ParkingSpot;
use App\Models\Wallet;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showProfileForm()
    {

        $user = auth()->user();

        $hostDetail = HostDetail::where('user_id', $user->user_id)->first();

        if ($hostDetail) {
            $host_id = $hostDetail->host_id;

            $wallet = Wallet::where('user_id', $user->user_id)->first();
            $walletBalance = $wallet ? $wallet->balance : 0;
            $profilePictureUrl = 'https://drive.google.com/uc?export=view&id=' . $hostDetail->id_card;

            $spots = ParkingSpot::where('host_id', $host_id)->get();

            $totalRating = $spots->sum('overall_rating');
            $numberOfSpots = $spots->count();
            $averageRating = $numberOfSpots > 0 ? $totalRating / $numberOfSpots : 0;

            $spotIds = $spots->pluck('spot_id');
            $acceptedBookings = Booking::whereIn('spot_id', $spotIds)
                ->where('status', 'accepted')
                ->count();
        } else {
            $profilePictureUrl = 'default_image_url';
            $averageRating = 0;
            $walletBalance = 0; 
            $acceptedBookings = 0; 
        }

        return view('dashboard.profile', compact('user', 'profilePictureUrl', 'averageRating', 'walletBalance', 'acceptedBookings'));
    }




    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only('first_name', 'last_name', 'phone_number', 'email'));
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }


    public function changeProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $hostDetail = HostDetail::where('user_id', $user->user_id)->first();
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-drive/credentials.json'));
        $client->addScope(Google_Service_Drive::DRIVE);

        $driveService = new Google_Service_Drive($client);
        $folderId = '13qAJ1sxPIw0wnUvlzuXsAQj2qliAeb6R';  

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            if ($file->isValid()) {
                $fileMetadata = new Google_Service_Drive_DriveFile([
                    'name' => $file->getClientOriginalName(),
                    'parents' => [$folderId],
                ]);

                $fileContent = file_get_contents($file->getRealPath());
                try {
                    $uploadedFile = $driveService->files->create(
                        $fileMetadata,
                        [
                            'data' => $fileContent,
                            'mimeType' => $file->getMimeType(),
                            'uploadType' => 'multipart',
                            'fields' => 'id, name, mimeType, parents',
                        ]
                    );

                    // Set file permissions to public
                    $permission = new Google_Service_Drive_Permission();
                    $permission->setRole('reader');
                    $permission->setType('anyone');
                    $driveService->permissions->create($uploadedFile->id, $permission);
                    $fileUrl= 'https://drive.google.com/uc?export=view&id=' . $uploadedFile->id;
                    $hostDetail->id_card = $fileUrl;
                    $hostDetail->save();

                    return redirect()->back()->with('success', 'Profile picture updated successfully.');
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'File upload failed: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Invalid file.');
            }
        } else {
            return redirect()->back()->with('error', 'No file uploaded.');
        }
    }
}
