const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('book-image-preview');

if (imageInput && imagePreview) {
    let previewUrl = null;

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];

        if (!file) {
            return;
        }

        // Vérifier le format et la taille avant la prévisualisation.
        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        const maxSize = 20 * 1024 * 1024;

        if (!allowedTypes.includes(file.type) || file.size > maxSize) {
            alert('Choisissez une image JPEG, PNG ou WebP de 20 Mo maximum.');
            imageInput.value = '';
            return;
        }

        // Libérer l'ancienne prévisualisation.
        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
        }

        // Afficher la nouvelle photo sans l'envoyer au serveur.
        previewUrl = URL.createObjectURL(file);
        imagePreview.src = previewUrl;
    });
}