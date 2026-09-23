<?php
require_once __DIR__ . '/../helpers/format.php';

$title = 'Profil de ' . $user['username'];
require __DIR__ . '/templates/header.php';
?>

<section class="profile-page">
    <div class="profile-page__container">

        <aside class="profile-page__identity">
            <?php if (!empty($user['avatar'])): ?>
                <img
                    class="profile-page__avatar"
                    src="/uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>"
                    alt="Photo de profil de <?= htmlspecialchars($user['username']) ?>">
            <?php endif; ?>

            <div class="profile-page__separator"></div>

            <h1 class="profile-page__username">
                <?= htmlspecialchars($user['username']) ?>
            </h1>

            <p class="profile-page__member">
                <?= htmlspecialchars(formatMemberSince($user['created_at'])) ?>
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
                (int) $_SESSION['user_id'] !== (int) $user['id']
            ): ?>
                <a
                    class="button button--outline profile-page__message"
                    href="/messages?user=<?= (int) $user['id'] ?>">
                    Écrire un message
                </a>
            <?php endif; ?>
        </aside>

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
                                <?php if (!empty($book['image'])): ?>
                                    <a href="/book?id=<?= (int) $book['id'] ?>">
                                        <img
                                            class="profile-page__book-image"
                                            src="/uploads/books/<?= htmlspecialchars($book['image']) ?>"
                                            alt="<?= htmlspecialchars($book['title']) ?>">
                                    </a>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a
                                    class="profile-page__book-link"
                                    href="/book?id=<?= (int) $book['id'] ?>">
                                    <?= htmlspecialchars($book['title']) ?>
                                </a>
                            </td>

                            <td><?= htmlspecialchars($book['author']) ?></td>

                            <td>
                                <p class="profile-page__description">
                                    <?= htmlspecialchars($book['description']) ?>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

<?php require __DIR__ . '/templates/footer.php'; ?>