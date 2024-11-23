<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Google_Client;
use Google_Service_Drive;
use App\Models\Image;

class GoogleDriveController extends Controller
{



    public function showImagesForm()
    {
        return view('createspot/images_spot');
    }


    public function upload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-drive/credentials.json'));
        $client->addScope(Google_Service_Drive::DRIVE);
        $service = new Google_Service_Drive($client);

        $images = $request->file('images');
        $imagePaths = [];

        foreach ($images as $image) {
            $fileName = $image->getClientOriginalName();
            $filePath = $image->getPathname();

            $fileMetadata = new \Google_Service_Drive_DriveFile([
                'name' => $fileName,
                'parents' => ['13qAJ1sxPIw0wnUvlzuXsAQj2qliAeb6R?dmr'] // Replace with your Google Drive folder ID
            ]);

            $content = file_get_contents($filePath);
            $file = $service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $image->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink',
            ]);

            $imagePaths[] = $file->webViewLink;

            // Save the file path to the database
            $imageModel = new Image();
            $imageModel->spot_id = $request->spot_id;
            $imageModel->image_url = $file->webViewLink;
            $imageModel->save();
        }

        Session::put('uploaded_images', $imagePaths);

        return response()->json(['success' => true, 'imagePaths' => $imagePaths]);
    }
}