document.querySelectorAll('.notify-button input[type="radio"]').forEach((radio) => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.notify-button').forEach(button => button.classList.remove('active'));
        if (this.checked) {
            this.closest('.notify-button').classList.add('active');
        }
    });
});