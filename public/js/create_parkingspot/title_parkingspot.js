document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.querySelector('.title-input');
    const nextButton = document.querySelector('.btn.next');
    const charCount = document.getElementById('charCount');

    // Update character count on page load
    charCount.textContent = titleInput.value.length;

    titleInput.addEventListener('input', () => {
        const length = titleInput.value.length;
        charCount.textContent = length;

        if (length > 0 && length <= 32) {
            nextButton.classList.add('active');
            nextButton.removeAttribute('disabled');
        } else {
            nextButton.classList.remove('active');
            nextButton.setAttribute('disabled', 'true');
        }
    });

    document.querySelector('.btn.back').addEventListener('click', () => {
        window.history.back();
    });

   
    
});