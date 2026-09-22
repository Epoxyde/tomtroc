<?php

$title = $book['title'];
require __DIR__ . '/templates/header.php';
?>

<section class="book-detail">
    <div class="book-detail__image-wrapper">
        <img
            class="book-detail__image"
            src="/images/book/<?= htmlspecialchars($book['image']) ?>"
            alt="<?= htmlspecialchars($book['title']) ?>"
        >
    </div>

    <div class="book-detail__content">
        <div class="book-detail__inner">
            <h1 class="book-detail__title">
                <?= htmlspecialchars($book['title']) ?>
            </h1>

            <p class="book-detail__author">
                par <?= htmlspecialchars($book['author']) ?>
            </p>

            <div class="book-detail__separator"></div>

            <h2 class="book-detail__label">DESCRIPTION</h2>

            <div class="book-detail__description">
                <?= nl2br(htmlspecialchars($book['description'])) ?>
            </div>

            <h2 class="book-detail__label">PROPRIÉTAIRE</h2>

            <a
                class="book-detail__owner"
                href="/profile?id=<?= (int) $book['user_id'] ?>"
            >
                <?php if ($book['avatar']): ?>
                    <img
                        class="book-detail__avatar"
                        src="/images/profil/<?= htmlspecialchars($book['avatar']) ?>"
                        alt=""
                    >
                <?php endif; ?>

                <span><?= htmlspecialchars($book['username']) ?></span>
            </a>

            <a
                class="button book-detail__message"
                href="/messages?user=<?= (int) $book['user_id'] ?>"
            >
                Envoyer un message
            </a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/templates/footer.php'; ?>