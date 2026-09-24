<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserManager.php';

class AuthController extends Controller
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

                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $userId;

                    header('Location: /');
                    exit;
                }
            }
        }

        $this->render('register', ['error' => $error]);
    }

    public function login(): void
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'L’adresse email n’est pas valide.';
            } else {
                $userManager = new UserManager();
                $user = $userManager->getUserByEmail($email);

                if (!$user || !$user->verifyPassword($password)) {
                    $error = 'Adresse email ou mot de passe incorrect.';
                } else {

                    session_regenerate_id(true);
                    $_SESSION['user_id'] = (int) $user->getId();

                    header('Location: /');
                    exit;
                }
            }
        }

        $this->render('login', ['error' => $error]);
    }

    public function logout(): void
    {
        $_SESSION = [];

        session_regenerate_id(true);

        header('Location: /');
        exit;
    }
}
