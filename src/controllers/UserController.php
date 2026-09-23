<?php

require_once __DIR__ . '/../models/UserManager.php';
require_once __DIR__ . '/../models/BookManager.php';

class UserController
{
    public function account(): void
    {
        // Vérifier que l'utilisateur est connecté.
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Récupérer les informations de l'utilisateur.
        $userManager = new UserManager();
        $user = $userManager->getUserById(
            (int) $_SESSION['user_id']
        );

        // Gérer le cas où le compte n'existe plus.
        if (!$user) {
            $_SESSION = [];

            header('Location: /login');
            exit;
        }

        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUserId((int) $user['id']);

        // Afficher la page.
        require __DIR__ . '/../views/account.php';
    }
}