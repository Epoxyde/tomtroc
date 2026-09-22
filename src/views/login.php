<?php

$title = 'Connexion';
require __DIR__ . '/templates/header.php';

?>

<section class="auth-page">
    <div class="auth-page__content">
        <div class="auth-page__inner">
            <h1 class="auth-page__title">Connexion</h1>

            <?php if ($error): ?>
                <p class="auth-form__error">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form class="auth-form" method="post" action="/login">
                <div class="auth-form__group">
                    <label for="email">Adresse email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                    >
                </div>

                <div class="auth-form__group">
                    <label for="password">Mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <button class="button auth-form__submit" type="submit">
                    Se connecter
                </button>
            </form>

            <p class="auth-page__login">
                Pas de compte ?
                <a href="/register">Inscrivez-vous</a>
            </p>
        </div>
    </div>

    <div class="auth-page__image-wrapper">
        <img
            class="auth-page__image"
            src="/images/inscription.jpg"
            alt=""
        >
    </div>
</section>

<?php require __DIR__ . '/templates/footer.php'; ?>