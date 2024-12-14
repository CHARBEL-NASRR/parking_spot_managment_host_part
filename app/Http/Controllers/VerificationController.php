<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Log;
use App\Models\HostDetail;
use App\Models\ParkingSpot; // Ensure the model is correctly imported


class VerificationController extends Controller
{
    public function showuploadverificationpage()
    {
        
        return view('createspot.verificationdocs');
    }

    public function uploadVeriDocsToGoogleDrive2(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-drive/credentials.json'));
        $client->addScope(Google_Service_Drive::DRIVE);

        $driveService = new Google_Service_Drive($client);
        $folderId = '13qAJ1sxPIw0wnUvlzuXsAQj2qliAeb6R';  

        $validation = $request->validate([
            'VeriDocs' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!$request->hasFile('VeriDocs')) {
            Log::error('No files uploaded');
            return response()->json(['error' => 'No files uploaded'], 400);
        }

        $file = $request->file('VeriDocs');

        if (!$file->isValid()) {
            Log::error('Invalid file');
            return response()->json(['error' => 'Invalid file'], 400);
        }
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
            Log::info('File uploaded to Google Drive', ['file' => $uploadedFile]);
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'File upload failed: ' . $e->getMessage()], 500);
        }
        $user = auth()->user();
        $permission = new Google_Service_Drive_Permission();
        $permission->setRole('reader');
        $permission->setType('anyone');
        $driveService->permissions->create($uploadedFile->id, $permission);
        
        $hostId = session('host_id');
        $host = HostDetail::find($hostId);
        if (!$host) {
            Log::error('Host ID not found in HostDetail table', ['host_id' => $hostId]);
            return response()->json(['error' => 'Host details not found.'], 400);
        }

        $parkingSpot = new ParkingSpot();
        $parkingSpot->host_id = $hostId;
        $parkingSpot->verification_documents = 'https://drive.google.com/uc?id=' .$uploadedFile->id;
        $parkingSpot->save();

        // $parkingSpot = ParkingSpot::where('spot_id', $request->spot_id)
        //                    ->first();

        // if (!$parkingSpot) {
        //     return back()->withErrors(['error' => 'Parking spot not found.']);
        // }

        // if ($parkingSpot) {
        //     $parkingSpot->update(['VeriDocs' => $request->VeriDocs]);
        // }
        
        return redirect()->route('amenities.show', ['spot_id' => $parkingSpot->spot_id]); 
    }
}

