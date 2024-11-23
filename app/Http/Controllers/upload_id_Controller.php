<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Log;

class upload_id_Controller extends Controller
{
    public function showuploadpage()
    {
        return view('upload_id.upload_id');
    }

    public function uploadImageToGoogleDrive2(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-drive/credentials.json'));
        $client->addScope(Google_Service_Drive::DRIVE);

        $driveService = new Google_Service_Drive($client);
        $folderId = '13qAJ1sxPIw0wnUvlzuXsAQj2qliAeb6R';  

        $validation = $request->validate([
            'idCard' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!$request->hasFile('idCard')) {
            Log::error('No files uploaded');
            return response()->json(['error' => 'No files uploaded'], 400);
        }

        $file = $request->file('idCard');

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

        return response()->json(['message' => 'File uploaded successfully!']);
    }
}