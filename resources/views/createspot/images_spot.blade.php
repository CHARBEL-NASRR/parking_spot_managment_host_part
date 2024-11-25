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
      <form id="uploadForm" action="{{ route('google.upload') }}" method="POST" enctype="multipart/form-data">
         @csrf
                  <input type="hidden" name="spot_id" value="{{ $spot_id }}">

      <div class="photo-upload" id="photoUploadContainer">
        <!-- Initial Upload Boxes -->
        <div class="upload-box" id="uploadBox1">
          <i class="fas fa-camera camera-icon" id="cameraIcon1"></i>
          <input type="file" id="fileInput1" name="images[]" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage1" style="display: none;">
          <button type="button" class="upload-button" id="uploadButton1">Add photos</button>
          <div class="image-actions" id="imageActions1" style="display: none;">
            <button type="button" class="more-options-button" id="moreOptionsButton1"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu1" style="display: none;">
              <button type="button" class="edit-button" id="editButton1">Edit</button>
            </div>
          </div>
        </div>

        <div class="upload-box" id="uploadBox2">
          <i class="fas fa-camera camera-icon" id="cameraIcon2"></i>
          <input type="file" id="fileInput2" name="images[]" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage2" style="display: none;">
          <button type="button" class="upload-button" id="uploadButton2">Add photos</button>
          <div class="image-actions" id="imageActions2" style="display: none;">
            <button type="button" class="more-options-button" id="moreOptionsButton2"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu2" style="display: none;">
              <button type="button" class="edit-button" id="editButton2">Edit</button>
            </div>
          </div>
        </div>

        <div class="upload-box" id="uploadBox3">
          <i class="fas fa-camera camera-icon" id="cameraIcon3"></i>
          <input type="file" id="fileInput3" name="images[]" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage3" style="display: none;">
          <button type="button" class="upload-button" id="uploadButton3">Add photos</button>
          <div class="image-actions" id="imageActions3" style="display: none;">
            <button type="button" class="more-options-button" id="moreOptionsButton3"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu3" style="display: none;">
              <button type="button" class="edit-button" id="editButton3">Edit</button>
            </div>
          </div>
        </div>

        <div class="upload-box" id="uploadBox4">
          <i class="fas fa-camera camera-icon" id="cameraIcon4"></i>
          <input type="file" id="fileInput4" name="images[]" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage4" style="display: none;">
          <button type="button" class="upload-button" id="uploadButton4">Add photos</button>
          <div class="image-actions" id="imageActions4" style="display: none;">
            <button type="button" class="more-options-button" id="moreOptionsButton4"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu4" style="display: none;">
              <button type="button" class="edit-button" id="editButton4">Edit</button>
            </div>
          </div>
        </div>

        <div class="upload-box" id="uploadBox5">
          <i class="fas fa-camera camera-icon" id="cameraIcon5"></i>
          <input type="file" id="fileInput5" name="images[]" style="display: none;">
          <img src="" alt="Selected Image" class="selected-image" id="selectedImage5" style="display: none;">
          <button type="button" class="upload-button" id="uploadButton5">Add photos</button>
          <div class="image-actions" id="imageActions5" style="display: none;">
            <button type="button" class="more-options-button" id="moreOptionsButton5"><i class="fas fa-ellipsis-v"></i></button>
            <div class="more-options-menu" id="moreOptionsMenu5" style="display: none;">
              <button type="button" class="edit-button" id="editButton5">Edit</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer>
        <button type="button" class="btn back" id="backButton">Back</button>
        <button type="submit" class="btn next" id="nextButton">Next</button>
    </footer>
  </div>
  <script>
document.addEventListener('DOMContentLoaded', function () {
    const uploadBoxes = Array.from(document.querySelectorAll('.upload-box'));
    const nextButton = document.getElementById('nextButton');
    const backButton = document.getElementById('backButton');
    let uploadedImages = []; // Store the selected images

    // Attach click events to individual upload boxes
    uploadBoxes.forEach((box, index) => {
        const fileInput = box.querySelector('input[type="file"]');
        const imageElement = box.querySelector('.selected-image');
        const cameraIcon = box.querySelector('.camera-icon');
        const imageActions = box.querySelector('.image-actions');
        const uploadButton = box.querySelector('.upload-button');

        // When the box or button is clicked, open the file picker
        uploadButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent the form from submitting
            fileInput.click();  // Trigger file input click
        });

        // Handle file input change and display the selected image
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imageElement.src = e.target.result;
                    imageElement.style.display = 'block'; // Show the image
                    cameraIcon.style.display = 'none'; // Hide the camera icon
                    imageActions.style.display = 'flex'; // Show image actions

                    // Store the image file in the uploadedImages array
                    uploadedImages[index] = file;
                    
                    checkNextButtonStatus();
                };

                reader.readAsDataURL(file);
            }
        });
    });

    // Enable or disable the Next button based on image count
    function checkNextButtonStatus() {
        const filledBoxes = uploadedImages.filter(image => image !== undefined);
        if (filledBoxes.length >= 1) {
            nextButton.classList.add('active');
            nextButton.removeAttribute('disabled');
        } else {
            nextButton.classList.remove('active');
            nextButton.setAttribute('disabled', 'true');
        }
    }

    // Back button event
    backButton.addEventListener('click', function () {
        window.history.back();
    });

    checkNextButtonStatus();
});
</script>
</body>
</html>