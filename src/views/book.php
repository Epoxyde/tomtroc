<?php

$title = $book->getTitle();
$breadcrumb = [
    'label' => 'Nos livres',
    'url' => '/books',
    'current' => $book->getTitle()
];

require __DIR__ . '/templates/header.php';
?>

<section class="book-detail">
    <div class="book-detail__image-wrapper">
        <img
            class="book-detail__image"
            src="<?= $book->getImage() ? '/uploads/books/' . htmlspecialchars(rawurlencode($book->getImage())) : '/images/book-placeholder.png.png' ?>"
            alt="<?= htmlspecialchars($book->getTitle()) ?>">
    </div>

    <div class="book-detail__content">
        <div class="book-detail__inner">
            <h1 class="book-detail__title">
                <?= htmlspecialchars($book->getTitle()) ?>
            </h1>

            <p class="book-detail__author">
                par <?= htmlspecialchars($book->getAuthor()) ?>
            </p>

            <div class="book-detail__separator"></div>

            <h2 class="book-detail__label">DESCRIPTION</h2>

            <div class="book-detail__description">
                <?= nl2br(htmlspecialchars($book->getDescription())) ?>
            </div>

            <h2 class="book-detail__label">PROPRIÉTAIRE</h2>

            <a
                class="book-detail__owner"
                href="/profile?id=<?= (int) $book->getUserId() ?>">
                <?php if (!empty($book->getOwnerAvatar())): ?>
                    <img
                        class="book-detail__avatar"
                        src="/uploads/avatars/<?= htmlspecialchars(rawurlencode($book->getOwnerAvatar())) ?>"
                        alt="">
                <?php endif; ?>

                <span><?= htmlspecialchars($book->getOwnerUsername()) ?></span>
            </a>

            <a
                class="button book-detail__message"
                href="/messages?user=<?= (int) $book->getUserId() ?>">
                Envoyer un message
            </a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/templates/footer.php'; ?>