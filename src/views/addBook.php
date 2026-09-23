<?php
$title = 'Ajouter un livre';
require __DIR__ . '/templates/header.php';
?>

<section class="edit-book">
    <div class="edit-book__container">

        <a class="edit-book__back" href="/account">
            &larr; Retour
        </a>

        <h1 class="edit-book__title">
            Ajouter un livre
        </h1>

        <div class="edit-book__content">

            <div class="edit-book__image-section">
                <p class="edit-book__label">Photo</p>

                <img
                    id="book-image-preview"
                    class="edit-book__image"
                    src="/images/book-placeholder.png"
                    alt="Aperçu de la photo du livre">

                <label class="edit-book__image-link" for="image">
                    Ajouter une photo
                </label>

                <input
                    class="edit-book__image-input"
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    form="add-book-form">
            </div>

            <?php if (!empty($error)): ?>
                <p class="edit-book__error" role="alert">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form
                id="add-book-form"
                class="edit-book__form"
                action="/book/add"
                method="post"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="edit-book__group">
                    <label for="title">Titre</label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="<?= htmlspecialchars($book['title']) ?>"
                        required>
                </div>

                <div class="edit-book__group">
                    <label for="author">Auteur</label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        value="<?= htmlspecialchars($book['author']) ?>"
                        required>
                </div>

                <div class="edit-book__group">
                    <label for="description">Commentaire</label>

                    <textarea
                        id="description"
                        name="description"
                        rows="8"
                        required><?= htmlspecialchars($book['description']) ?></textarea>
                </div>

                <div class="edit-book__group">
                    <label for="available">Disponibilité</label>

                    <select id="available" name="available">
                        <option
                            value="1"
                            <?= $book['available'] ? 'selected' : '' ?>>
                            Disponible
                        </option>

                        <option
                            value="0"
                            <?= !$book['available'] ? 'selected' : '' ?>>
                            Non disponible
                        </option>
                    </select>
                </div>

                <button class="button edit-book__submit" type="submit">
                    Ajouter le livre
                </button>
            </form>

        </div>
    </div>
</section>

<script src="/js/edit-book.js" defer></script>

<?php require __DIR__ . '/templates/footer.php'; ?>