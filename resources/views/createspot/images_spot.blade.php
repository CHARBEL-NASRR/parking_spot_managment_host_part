<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Photos</title>
  <link rel="stylesheet" href="{{ asset('css/createspot/images_spot.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <div class="container">
    <header class="header">
      <div class="logo">
        <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
      </div>
    </header>

    <div class="content">
      <h1 class="title">Add some photos of your house</h1>
      <p class="subtitle">
        You'll need at least 3 photos to get started. You can add more or make changes later.
      </p>
      <form id="uploadForm" action="{{ route('upload.images') }}" method="POST" enctype="multipart/form-data">
         @csrf
      <div class="photo-upload" id="photoUploadContainer">
        <!-- Initial Upload Boxes -->
        <div class="upload-box" id="uploadBox1">
          <i class="fas fa-camera camera-icon" id="cameraIcon1"></i>
          <input type="file" id="fileInput1" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage1" style="display: none;">
          <button class="upload-button" id="uploadButton1">Add photos</button>
          <div class="image-actions" id="imageActions1" style="display: none;">
            <button class="more-options-button" id="moreOptionsButton1"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu1" style="display: none;">
              <button class="edit-button" id="editButton1">Edit</button>
            </div>
          </div>
        </div>

        <div class="upload-box" id="uploadBox2">
          <i class="fas fa-camera camera-icon" id="cameraIcon2"></i>
          <input type="file" id="fileInput2" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage2" style="display: none;">
          <button class="upload-button" id="uploadButton2">Add photos</button>
          <div class="image-actions" id="imageActions2" style="display: none;">
            <button class="more-options-button" id="moreOptionsButton2"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu2" style="display: none;">
              <button class="edit-button" id="editButton2">Edit</button>
            </div>
          </div>
        </div>

        <div class="upload-box" id="uploadBox3">
          <i class="fas fa-camera camera-icon" id="cameraIcon3"></i>
          <input type="file" id="fileInput3" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage3" style="display: none;">
          <button class="upload-button" id="uploadButton3">Add photos</button>
          <div class="image-actions" id="imageActions3" style="display: none;">
            <button class="more-options-button" id="moreOptionsButton3"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu3" style="display: none;">
              <button class="edit-button" id="editButton3">Edit</button>
            </div>
          </div>
        </div>

      
        <div class="upload-box" id="uploadBox4">
          <i class="fas fa-camera camera-icon" id="cameraIcon3"></i>
          <input type="file" id="fileInput3" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage3" style="display: none;">
          <button class="upload-button" id="uploadButton3">Add photos</button>
          <div class="image-actions" id="imageActions3" style="display: none;">
            <button class="more-options-button" id="moreOptionsButton3"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu3" style="display: none;">
              <button class="edit-button" id="editButton3">Edit</button>
            </div>
          </div>
        </div>


        
        <div class="upload-box" id="uploadBox5">
          <i class="fas fa-camera camera-icon" id="cameraIcon3"></i>
          <input type="file" id="fileInput3" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage3" style="display: none;">
          <button class="upload-button" id="uploadButton3">Add photos</button>
          <div class="image-actions" id="imageActions3" style="display: none;">
            <button class="more-options-button" id="moreOptionsButton3"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu3" style="display: none;">
              <button class="edit-button" id="editButton3">Edit</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer>
        <button class="btn back" id="backButton">Back</button>
        <button class="btn next" disabled id="nextButton">Next</button>
    </footer>
  </div>
  <script src="{{ asset('js/create_parkingspot/images_parkingspot.js') }}"></script>
</body>
</html>