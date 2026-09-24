<?php
require_once __DIR__ . '/../helpers/format.php';

$title = 'Profil de ' . $user->getUsername();
require __DIR__ . '/templates/header.php';
?>

<div class="profile-page">
    <div class="profile-page__container">

        <div class="profile-page__identity">
            <?php if (!empty($user->getAvatar())): ?>
                <img
                    class="profile-page__avatar"
                    src="/uploads/avatars/<?= htmlspecialchars(rawurlencode($user->getAvatar())) ?>"
                    alt="Photo de profil de <?= htmlspecialchars($user->getUsername()) ?>">
            <?php endif; ?>

            <div class="profile-page__separator"></div>

            <h1 class="profile-page__username">
                <?= htmlspecialchars($user->getUsername()) ?>
            </h1>

            <p class="profile-page__member">
                <?= htmlspecialchars(formatMemberSince($user->getCreatedAt())) ?>
            </p>

            <p class="profile-page__library-label">
                BIBLIOTHÈQUE
            </p>

            <p class="profile-page__library-count">
                <img
                    src="/images/4livres.svg"
                    alt=""
                    aria-hidden="true">

                <span>
                    <?= count($books) ?>
                    <?= count($books) > 1 ? 'livres' : 'livre' ?>
                </span>
            </p>

            <?php if (
                !isset($_SESSION['user_id']) ||
                (int) $_SESSION['user_id'] !== (int) $user->getId()
            ): ?>
                <a
                    class="button button--outline profile-page__message"
                    href="/messages?user=<?= (int) $user->getId() ?>">
                    Écrire un message
                </a>
            <?php endif; ?>
        </div>

        <div class="profile-page__library">
            <table class="profile-page__table">
                <thead>
                    <tr>
                        <th>PHOTO</th>
                        <th>TITRE</th>
                        <th>AUTEUR</th>
                        <th>DESCRIPTION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td>
                                <?php if (!empty($book->getImage())): ?>
                                    <a href="/book?id=<?= (int) $book->getId() ?>">
                                        <img
                                            class="profile-page__book-image"
                                            src="/uploads/books/<?= htmlspecialchars(rawurlencode($book->getImage())) ?>"
                                            alt="<?= htmlspecialchars($book->getTitle()) ?>">
                                    </a>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a
                                    class="profile-page__book-link"
                                    href="/book?id=<?= (int) $book->getId() ?>">
                                    <?= htmlspecialchars($book->getTitle()) ?>
                                </a>
                            </td>

                            <td><?= htmlspecialchars($book->getAuthor()) ?></td>

                            <td>
                                <p class="profile-page__description">
                                    <?= htmlspecialchars($book->getDescription()) ?>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php require __DIR__ . '/templates/footer.php'; ?>