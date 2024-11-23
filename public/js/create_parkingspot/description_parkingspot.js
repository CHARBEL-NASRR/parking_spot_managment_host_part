document.addEventListener('DOMContentLoaded', function () {
    const descriptionInput = document.querySelector('.title-input');
    const nextButton = document.querySelector('.btn.next');
    const charCount = document.getElementById('charCount');

    charCount.textContent = descriptionInput.value.length;

    descriptionInput.addEventListener('input', () => {
        const length = descriptionInput.value.length;
        charCount.textContent = length;

        if (length > 0 && length <= 255) {
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