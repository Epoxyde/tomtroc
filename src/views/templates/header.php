<?php

$currentRoute = trim(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
    '/'
);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'TomTroc') ?> - TomTroc</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Playfair+Display:wght@400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/main.css">
</head>

<body>

    <header class="header">
        <div class="header__container">

            <a class="header__logo" href="/" aria-label="Tom Troc - Accueil">
                <img src="/images/logo.svg" alt="Tom Troc">
            </a>

            <nav class="header__nav" aria-label="Navigation principale">

                <div class="header__nav-main">
                    <a
                        class="header__link <?= $currentRoute === '' ? 'header__link--active' : '' ?>"
                        href="/">
                        Accueil
                    </a>

                    <a
                        class="header__link <?= in_array($currentRoute, ['books', 'book'], true) ? 'header__link--active' : '' ?>"
                        href="/books">
                        Nos livres à l'échange
                    </a>
                </div>

                <div class="header__nav-account">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a
                            class="header__link <?= $currentRoute === 'messages' ? 'header__link--active' : '' ?>"
                            href="/messages">
                            <img
                                src="/images/icon-messagerie.svg"
                                alt=""
                                aria-hidden="true">
                            <span>Messagerie</span>
                        </a>

                        <a
                            class="header__link <?= $currentRoute === 'account' ? 'header__link--active' : '' ?>"
                            href="/account">
                            <img
                                src="/images/icon-moncompte.svg"
                                alt=""
                                aria-hidden="true">
                            <span>Mon compte</span>
                        </a>

                        <a class="header__link" href="/logout">
                            Déconnexion
                        </a>
                    <?php else: ?>
                        <a
                            class="header__link <?= in_array($currentRoute, ['login', 'register'], true) ? 'header__link--active' : '' ?>"
                            href="/login">
                            Connexion
                        </a>
                    <?php endif; ?>
                </div>

            </nav>

            <?php if (!empty($breadcrumb)): ?>
                <nav class="header__breadcrumb" aria-label="Fil d'Ariane">
                    <a href="<?= htmlspecialchars($breadcrumb['url']) ?>">
                        <?= htmlspecialchars($breadcrumb['label']) ?>
                    </a>

                    <span>&gt;</span>

                    <span><?= htmlspecialchars($breadcrumb['current']) ?></span>
                </nav>
            <?php endif; ?>

        </div>
    </header>

    <main>