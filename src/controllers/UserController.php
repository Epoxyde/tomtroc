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

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';

            if (
                !is_string($token) ||
                !hash_equals($_SESSION['csrf_token'], $token)
            ) {
                http_response_code(403);
                echo 'Formulaire invalide. Veuillez recharger la page et réessayer.';
                return;
            }
        }

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
                    (int) $existingUser->getId() !== $userId
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

    public function profile(): void
    {
        $userId = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if (!$userId || $userId < 1) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        if (!$user) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        $bookManager = new BookManager();
        $books = $bookManager->getAvailableBooksByUserId($userId);

        require __DIR__ . '/../views/profile.php';
    }

    public function updateAvatar(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /account');
            exit;
        }

        if (
            empty($_SESSION['csrf_token']) ||
            !isset($_POST['csrf_token']) ||
            !is_string($_POST['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            http_response_code(403);
            exit('Formulaire invalide.');
        }

        $file = $_FILES['avatar'] ?? null;

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            header('Location: /account');
            exit;
        }

        // Taille maximale : 5 Mo.
        if ($file['size'] > 5 * 1024 * 1024) {
            http_response_code(400);
            exit('La photo ne doit pas dépasser 5 Mo.');
        }

        // Vérification du véritable type du fichier.
        $mimeType = (new finfo(FILEINFO_MIME_TYPE))
            ->file($file['tmp_name']);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($allowedTypes[$mimeType])) {
            http_response_code(400);
            exit('Format non autorisé. Utilisez JPG, PNG ou WebP.');
        }

        // Génération d'un nom unique.
        $filename = bin2hex(random_bytes(16))
            . '.'
            . $allowedTypes[$mimeType];

        $destination = __DIR__
            . '/../../public/uploads/avatars/'
            . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            http_response_code(500);
            exit("Impossible d'enregistrer la photo.");
        }

        $userManager = new UserManager();

        if (!$userManager->updateAvatar(
            (int) $_SESSION['user_id'],
            $filename
        )) {
            // Évite de conserver un fichier inutilisé.
            unlink($destination);

            http_response_code(500);
            exit("Impossible de mettre à jour le profil.");
        }

        header('Location: /account');
        exit;
    }
}
