<?php
$title = 'Accueil';
require __DIR__ . '/templates/header.php';
?>

<section class="hero">
    <div class="hero__container">

        <div class="hero__content">
            <h1 class="hero__title">
                Rejoignez nos<br>
                lecteurs passionnés
            </h1>

            <p class="hero__text">
                Donnez une nouvelle vie à vos livres en les échangeant
                avec d'autres amoureux de la lecture. Nous croyons en la
                magie du partage de connaissances et d'histoires à travers
                les livres.
            </p>

            <a class="button" href="/books">Découvrir</a>
        </div>

        <figure class="hero__visual">
            <img
                class="hero__image"
                src="/images/Hamza.jpg"
                alt="Librairie remplie de livres"
            >
            <figcaption class="hero__credit">Hamza</figcaption>
        </figure>

    </div>
</section>

<section class="latest-books">
    <div class="latest-books__container">

        <h2 class="latest-books__title">
            Les derniers livres ajoutés
        </h2>

        <div class="latest-books__grid">
            <?php foreach ($latestBooks as $book): ?>

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
                            <h3 class="book-card__title">
                                <?= htmlspecialchars($book['title']) ?>
                            </h3>

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

        <a class="button latest-books__button" href="/books">
            Voir tous les livres
        </a>

    </div>
</section>

<section class="how-it-works">
    <div class="how-it-works__container">

        <h2 class="how-it-works__title">
            Comment ça marche ?
        </h2>

        <p class="how-it-works__intro">
            Échanger des livres avec TomTroc c’est simple et<br>
            amusant ! Suivez ces étapes pour commencer :
        </p>

        <div class="how-it-works__steps">

            <div class="how-it-works__step">
                <p>Inscrivez-vous gratuitement sur notre plateforme.</p>
            </div>

            <div class="how-it-works__step">
                <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
            </div>

            <div class="how-it-works__step">
                <p>Parcourez les livres disponibles chez d'autres membres.</p>
            </div>

            <div class="how-it-works__step">
                <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
            </div>

        </div>

        <a class="button button--outline" href="/books">
            Voir tous les livres
        </a>

    </div>
</section>

<section class="values">

    <img
        class="values__banner"
        src="/images/Bandeau.jpg"
        alt=""
    >

    <div class="values__container">
        <div class="values__content">

            <h2 class="values__title">Nos valeurs</h2>

            <p>
                Chez Tom Troc, nous mettons l'accent sur le partage,
                la découverte et la communauté. Nos valeurs sont ancrées
                dans notre passion pour les livres et notre désir de créer
                des liens entre les lecteurs. Nous croyons en la puissance
                des histoires pour rassembler les gens et inspirer des
                conversations enrichissantes.
            </p>

            <p>
                Notre association a été fondée avec une conviction profonde :
                chaque livre mérite d'être lu et partagé.
            </p>

            <p>
                Nous sommes passionnés par la création d'une plateforme
                conviviale qui permet aux lecteurs de se connecter, de partager
                leurs découvertes littéraires et d'échanger des livres qui
                attendent patiemment sur les étagères.
            </p>

            <div class="values__signature">
                <span>L'équipe Tom Troc</span>

                <img
                    class="values__heart"
                    src="/images/Coeur.svg"
                    alt=""
                >
            </div>

        </div>
    </div>

</section>

<?php require __DIR__ . '/templates/footer.php'; ?>