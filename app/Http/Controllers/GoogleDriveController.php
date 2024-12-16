<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Log;
use App\Models\Image;

class GoogleDriveController extends Controller
{
    public function showImagesForm($spot_id)
    {
        return view('createspot.images_spot', compact('spot_id'));
    }

    public function uploadImageToGoogleDrive(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-drive/credentials.json'));
        $client->addScope(Google_Service_Drive::DRIVE);

        $driveService = new Google_Service_Drive($client);
        $folderId = '13qAJ1sxPIw0wnUvlzuXsAQj2qliAeb6R';  // Replace with your folder ID

        $validation = $request->validate([
            'images' => 'required|array|min:3|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'spot_id' => 'required|exists:parking_spots,spot_id',
        ]);

        // Ensure that at least one file is uploaded
        if (!$request->hasFile('images')) {
            Log::error('No files uploaded');
            return response()->json(['error' => 'No files uploaded'], 400);
        }

        // Get the files from the request
        $files = $request->file('images');
        $spotId = $request->input('spot_id');

        // Delete existing images associated with the given spot_id
        try {
            Image::where('spot_id', $spotId)->delete();
            Log::info('Old images deleted for spot_id: ' . $spotId);
        } catch (\Exception $e) {
            Log::error('Failed to delete old images: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete old images'], 500);
        }

        foreach ($files as $file) {
            // Check if the file is valid
            if (!$file->isValid()) {
                Log::error('Invalid file');
                return response()->json(['error' => 'Invalid file'], 400);
            }

            // Upload file to Google Drive
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

                $permission = new Google_Service_Drive_Permission();
                $permission->setRole('reader');
                $permission->setType('anyone');
                $driveService->permissions->create($uploadedFile->id, $permission);

                // Save the new image URL to the database
                $image = new Image();
                $image->spot_id = $spotId;
                $image->image_url = 'https://drive.google.com/uc?id=' .$uploadedFile->id;
                $image->save();
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return response()->json(['error' => 'File upload failed: ' . $e->getMessage()], 500);
            }
        }

        return redirect()->route('location.form', ['spot_id' => $spotId]);
    }
}
