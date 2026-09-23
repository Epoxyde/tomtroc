const avatarInput = document.querySelector('#avatar-input');

if (avatarInput) {
    avatarInput.addEventListener('change', () => {
        if (avatarInput.files.length > 0) {
            avatarInput.form.requestSubmit();
        }
    });
}