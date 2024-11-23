document.addEventListener('DOMContentLoaded', function () {
    const descriptionInput = document.querySelector('.title-input');
    const nextButton = document.querySelector('.btn.next');
    const charCount = document.getElementById('charCount');

    // Initialize character count
    charCount.textContent = descriptionInput.value.length;

    // Monitor input changes for validation
    descriptionInput.addEventListener('input', () => {
        const length = descriptionInput.value.length;
        charCount.textContent = length;

        // Enable/Disable the "Next" button based on input length
        if (length > 0 && length <= 255) {
            nextButton.classList.add('active');
            nextButton.removeAttribute('disabled');
        } else {
            nextButton.classList.remove('active');
            nextButton.setAttribute('disabled', 'true');
        }
    });

    // Handle the "Back" button click
    document.querySelector('.btn.back').addEventListener('click', updateTitleAndGoBack);

    function updateTitleAndGoBack() {
        const description = descriptionInput.value;
        const spotId = document.querySelector('input[name="spot_id"]').value;

        fetch(`/description/update-title/${spotId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ title: description })
        })
            .then(response => {
                if (response.ok) {
                    // Redirect on success
                    window.location.href = `/title?spot_id=${spotId}`;
                } else {
                    console.error('Failed to update title');
                    alert('Failed to update the title. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the title.');
            });
    }
});