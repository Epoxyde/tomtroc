<?php
$title = 'Nos livres à l\'échange';
require __DIR__ . '/templates/header.php';
?>

<section class="books-page">
    <div class="books-page__container">

        <div class="books-page__header">
            <h1 class="books-page__title">
                Nos livres à l'échange
            </h1>

            <form class="books-page__search" method="get" action="/books">
                <img
                    class="books-page__search-icon"
                    src="/images/loupe.svg"
                    alt=""
                    aria-hidden="true"
                >

                <input
                    type="search"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Rechercher un livre"
                    aria-label="Rechercher un livre"
                >
        </form>
        </div>

        <div class="books-page__grid">

            <?php foreach ($books as $book): ?>

                <article class="book-card">
                    <a
                        class="book-card__link"
                        href="/book?id=<?= (int) $book['id'] ?>"
                    >
                        <img
                            class="book-card__image"
                            src="/images/book/<?= htmlspecialchars($book['image']) ?>"
                            alt="<?= htmlspecialchars($book['title']) ?>"
                        >

                        <div class="book-card__content">
                            <h2 class="book-card__title">
                                <?= htmlspecialchars($book['title']) ?>
                            </h2>

                            <p class="book-card__author">
                                <?= htmlspecialchars($book['author']) ?>
                            </p>

                            <p class="book-card__seller">
                                Vendu par : <?= htmlspecialchars($book['username']) ?>
                            </p>
                        </div>
                    </a>
                </article>

            <?php endforeach; ?>

        </div>

    </div>
</section>

<?php require __DIR__ . '/templates/footer.php'; ?>