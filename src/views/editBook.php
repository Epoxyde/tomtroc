<?php
$title = 'Modifier un livre';
require __DIR__ . '/templates/header.php';
?>

<section class="edit-book">
    <div class="edit-book__container">

        <a class="edit-book__back" href="/account">
            &larr; Retour
        </a>

        <h1 class="edit-book__title">
            Modifier les informations
        </h1>

        <div class="edit-book__content">

            <div class="edit-book__image-section">
                <p class="edit-book__label">Photo</p>

                <img
                    id="book-image-preview"
                    class="edit-book__image"
                    src="/uploads/books/<?= htmlspecialchars($book['image']) ?>"
                    alt="<?= htmlspecialchars($book['title']) ?>">

                <label class="edit-book__image-link" for="image">
                    Modifier la photo
                </label>

                <input
                    class="edit-book__image-input"
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    form="edit-book-form">
            </div>

            <?php if (!empty($error)): ?>
                <p class="edit-book__error" role="alert">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form
                id="edit-book-form"
                class="edit-book__form"
                action="/book/edit?id=<?= (int) $book['id'] ?>"
                method="post"
                enctype="multipart/form-data">

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
                    Valider
                </button>
            </form>

        </div>
    </div>
</section>

<script src="/js/edit-book.js" defer></script>

<?php require __DIR__ . '/templates/footer.php'; ?>