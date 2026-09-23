<?php

require_once __DIR__ . '/../models/UserManager.php';
require_once __DIR__ . '/../models/BookManager.php';

class UserController
{
    public function account(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];
        $userManager = new UserManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($username === '' || $email === '') {
                $error = 'Le pseudo et l’adresse email sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'L’adresse email n’est pas valide.';
            } else {
                $existingUser = $userManager->getUserByEmail($email);

                if (
                    $existingUser &&
                    (int) $existingUser['id'] !== $userId
                ) {
                    $error = 'Cette adresse email est déjà utilisée.';
                } else {
                    $hashedPassword = null;

                    if ($password !== '') {
                        $hashedPassword = password_hash(
                            $password,
                            PASSWORD_DEFAULT
                        );
                    }

                    $userManager->updateUser(
                        $userId,
                        $username,
                        $email,
                        $hashedPassword
                    );

                    header('Location: /account');
                    exit;
                }
            }
        }

        $user = $userManager->getUserById($userId);

        if (!$user) {
            $_SESSION = [];

            header('Location: /login');
            exit;
        }

        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUserId($userId);

        require __DIR__ . '/../views/account.php';
    }
}
