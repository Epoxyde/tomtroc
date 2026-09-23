<?php
require_once __DIR__ . '/../helpers/format.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$title = 'Mon compte';
require __DIR__ . '/templates/header.php';

?>

<section class="account-page">
    <div class="account-page__container">
        <h1 class="account-page__title">Mon compte</h1>

        <div class="account-profile">
            <div class="account-profile__identity">
                <form
                    class="account-profile__avatar-form"
                    action="/account/avatar"
                    method="post"
                    enctype="multipart/form-data">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                    <?php if (!empty($user['avatar'])): ?>
                        <img
                            class="account-profile__avatar"
                            src="/uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>"
                            alt="Photo de profil de <?= htmlspecialchars($user['username']) ?>">
                    <?php endif; ?>

                    <label
                        class="account-profile__avatar-link"
                        for="avatar-input">
                        modifier
                    </label>

                    <input
                        id="avatar-input"
                        class="account-profile__avatar-input"
                        type="file"
                        name="avatar"
                        accept="image/jpeg,image/png,image/webp"
                        required>
                </form>

                <div class="account-profile__separator"></div>

                <h2 class="account-profile__username">
                    <?= htmlspecialchars($user['username']) ?>
                </h2>

                <p class="account-profile__member">
                    <?= htmlspecialchars(formatMemberSince($user['created_at'])) ?>
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

                <?php if (!empty($error)): ?>
                    <p class="account-form__error">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endif; ?>
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

        <div class="library-table account-library">
            <table class="library-table__table">
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
                                        class="library-table__image"
                                        src="/uploads/books/<?= htmlspecialchars($book['image']) ?>"
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
                                <p class="library-table__description">
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

                                    <form
                                        action="/book/delete"
                                        method="post"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $book['id'] ?>">

                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                        <button
                                            class="account-library__delete"
                                            type="submit">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="/js/account-avatar.js" defer></script>

<?php require __DIR__ . '/templates/footer.php'; ?>