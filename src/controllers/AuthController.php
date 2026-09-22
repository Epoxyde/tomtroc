<?php

require_once __DIR__ . '/../models/UserManager.php';

class AuthController
{
    public function register(): void
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($username === '' || $email === '' || $password === '') {
                $error = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'L’adresse email n’est pas valide.';
            } else {
                $userManager = new UserManager();

                if ($userManager->getUserByEmail($email)) {
                    $error = 'Cette adresse email est déjà utilisée.';
                } else {
                    $hashedPassword = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    $userId = $userManager->createUser(
                        $username,
                        $email,
                        $hashedPassword
                    );

                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION['user_id'] = $userId;

                    header('Location: /');
                    exit;
                }
            }
        }

        require __DIR__ . '/../views/register.php';
    }
}