<?php

$title = 'Mon compte';
require __DIR__ . '/templates/header.php';

?>

<section class="account-page">
    <div class="account-page__container">
        <h1 class="account-page__title">Mon compte</h1>

        <div class="account-profile">
            <div class="account-profile__identity">
                <?php if ($user['avatar']): ?>
                    <img
                        class="account-profile__avatar"
                        src="/images/profil/<?= htmlspecialchars($user['avatar']) ?>"
                        alt="">
                <?php endif; ?>

                <a class="account-profile__avatar-link" href="#">
                    modifier
                </a>

                <div class="account-profile__separator"></div>

                <h2 class="account-profile__username">
                    <?= htmlspecialchars($user['username']) ?>
                </h2>

                <p class="account-profile__member">
                    membre depuis 1 an
                </p>

                <p class="account-profile__library-label">
                    BIBLIOTHÈQUE
                </p>

                <p class="account-profile__library-count">
                    <img
                        src="/images/4livres.svg"
                        alt=""
                        aria-hidden="true">
                    <span>
                        <?= count($books) ?>
                        <?= count($books) > 1 ? 'livres' : 'livre' ?>
                    </span>
                </p>
            </div>

            <div class="account-profile__information">
                <h2 class="account-profile__information-title">
                    Vos informations personnelles
                </h2>

                <form class="account-form" method="post" action="/account">
                    <div class="account-form__group">
                        <label for="email">Adresse email</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($user['email']) ?>">
                    </div>

                    <div class="account-form__group">
                        <label for="password">Mot de passe</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••">
                    </div>

                    <div class="account-form__group">
                        <label for="username">Pseudo</label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?= htmlspecialchars($user['username']) ?>">
                    </div>

                    <button
                        class="button button--outline account-form__submit"
                        type="submit">
                        Enregistrer
                    </button>
                </form>
            </div>
        </div>

        <div class="account-library">
            <table class="account-library__table">
                <thead>
                    <tr>
                        <th>PHOTO</th>
                        <th>TITRE</th>
                        <th>AUTEUR</th>
                        <th>DESCRIPTION</th>
                        <th>DISPONIBILITÉ</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td>
                                <?php if ($book['image']): ?>
                                    <img
                                        class="account-library__image"
                                        src="/images/book/<?= htmlspecialchars($book['image']) ?>"
                                        alt="<?= htmlspecialchars($book['title']) ?>">
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($book['title']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($book['author']) ?>
                            </td>

                            <td>
                                <p class="account-library__description">
                                    <?= htmlspecialchars($book['description']) ?>
                                </p>
                            </td>

                            <td>
                                <span class="account-library__availability <?= $book['available'] ? 'account-library__availability--available' : 'account-library__availability--unavailable' ?>">
                                    <?= $book['available'] ? 'disponible' : 'non dispo.' ?>
                                </span>
                            </td>

                            <td>
                                <div class="account-library__actions">
                                    <a href="/book/edit?id=<?= (int) $book['id'] ?>">
                                        Éditer
                                    </a>

                                    <a
                                        class="account-library__delete"
                                        href="/book/delete?id=<?= (int) $book['id'] ?>">
                                        Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require __DIR__ . '/templates/footer.php'; ?>