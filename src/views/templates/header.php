<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'TomTroc') ?> - TomTroc</title>

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
                <a class="header__link" href="/">Accueil</a>
                <a class="header__link" href="/books">Nos livres à l'échange</a>
            </div>

            <div class="header__nav-account">
                <a class="header__link header__link--icon" href="/messages">
                    <img src="/images/icon-messagerie.svg" alt="" aria-hidden="true">
                    <span>Messagerie</span>
                </a>
                <a class="header__link" href="/account">Mon compte</a>
                <a class="header__link" href="/login">Connexion</a>
            </div>
        </nav>
    </div>
</header>

<main>

<main>