document.addEventListener('DOMContentLoaded', function () {
    const uploadBoxes = Array.from(document.querySelectorAll('.upload-box'));
    const nextButton = document.getElementById('nextButton');
    const backButton = document.getElementById('backButton');
    let uploadedImagesCount = 0;

    // Enable or disable the Next button based on image count
    function checkNextButtonStatus() {
        console.log(`Uploaded Images Count: ${uploadedImagesCount}`);
        if (uploadedImagesCount >= 3) {
            nextButton.classList.add('active');
            nextButton.removeAttribute('disabled');
        } else {
            nextButton.classList.remove('active');
            nextButton.setAttribute('disabled', 'true');
        }
    }

    // Attach click events to individual upload boxes
    uploadBoxes.forEach((box, index) => {
        const fileInput = box.querySelector('input[type="file"]');
        const imageElement = box.querySelector('.selected-image');
        const cameraIcon = box.querySelector('.camera-icon');
        const imageActions = box.querySelector('.image-actions');
        const moreOptionsButton = box.querySelector('.more-options-button');
        const moreOptionsMenu = box.querySelector('.more-options-menu');

        // When the box or button is clicked, open the file picker
        box.addEventListener('click', () => {
            fileInput.click();
        });

        // Handle file input change and display the selected image
        fileInput.addEventListener('change', async () => {
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = async function (e) {
                    imageElement.src = e.target.result;
                    imageElement.style.display = 'block'; // Show the image
                    cameraIcon.style.display = 'none'; // Hide the camera icon
                    imageActions.style.display = 'flex'; // Show image actions

                    // Increment uploaded images count if the box was empty
                    if (!imageElement.dataset.uploaded) {
                        uploadedImagesCount++;
                        imageElement.dataset.uploaded = true; // Mark the image as uploaded
                        console.log(`Image uploaded in box ${index + 1}`);
                    }

                    // Upload image to the server (Google Drive)
                    try {
                        const formData = new FormData();
                        formData.append('file', file);

                        const response = await fetch('{{ route("google.upload") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF protection
                            },
                        });

                        const data = await response.json();
                        if (response.ok) {
                            console.log('File uploaded successfully:', data);
                        } else {
                            console.error('File upload failed:', data.error);
                        }
                    } catch (error) {
                        console.error('Error uploading file:', error);
                    }

                    checkNextButtonStatus();
                };

                reader.readAsDataURL(file);
            }
        });

        // More options button functionality
        moreOptionsButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from propagating to the box
            moreOptionsMenu.style.display = moreOptionsMenu.style.display === 'none' ? 'block' : 'none';
        });

        // Hide the more options menu when clicking outside of it
        document.addEventListener('click', function (event) {
            if (!moreOptionsButton.contains(event.target) && !moreOptionsMenu.contains(event.target)) {
                moreOptionsMenu.style.display = 'none';
            }
        });
    });

    // Back button event
    backButton.addEventListener('click', function () {
        window.history.back();
    });

    checkNextButtonStatus();
});
