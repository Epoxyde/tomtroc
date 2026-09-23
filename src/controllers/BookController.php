<?php

require_once __DIR__ . '/../models/BookManager.php';

class BookController
{
    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');

        $bookManager = new BookManager();
        $books = $bookManager->getAvailableBooks($search);

        require __DIR__ . '/../views/books.php';
    }

    public function show(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        require __DIR__ . '/../views/book.php';
    }

    public function edit(): void
    {
        // Vérifier que l'utilisateur est connecté.
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];
        $bookId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Vérifier que l'identifiant du livre est valide.
        if (!$bookId) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);

        // Vérifier que le livre existe.
        if (!$book) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        // Vérifier que le livre appartient à l'utilisateur.
        if ((int) $book['user_id'] !== $userId) {
            http_response_code(403);
            echo 'Vous ne pouvez pas modifier ce livre.';
            return;
        }

        // Traiter le formulaire.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $author = trim($_POST['author'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $available = $_POST['available'] ?? null;

            if (
                $title === '' ||
                $author === '' ||
                $description === '' ||
                !in_array($available, ['0', '1'], true)
            ) {
                $error = 'Veuillez remplir correctement tous les champs.';
            } else {
                $newImage = null;

                // Une nouvelle photo a-t-elle été envoyée ?
                if (
                    isset($_FILES['image']) &&
                    $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
                ) {
                    try {
                        $newImage = $this->uploadBookImage($_FILES['image']);
                    } catch (RuntimeException $exception) {
                        $error = $exception->getMessage();
                    }
                }

                // Enregistrer uniquement si aucune erreur n'a été rencontrée.
                if (empty($error)) {
                    $bookManager->updateBook(
                        $bookId,
                        $userId,
                        $title,
                        $author,
                        $description,
                        $available === '1'
                    );

                    if ($newImage !== null) {
                        $bookManager->updateBookImage(
                            $bookId,
                            $userId,
                            $newImage
                        );
                    }

                    header('Location: /account');
                    exit;
                }
            }

            // Conserver les valeurs saisies en cas d'erreur.
            $book['title'] = $title;
            $book['author'] = $author;
            $book['description'] = $description;

            if (in_array($available, ['0', '1'], true)) {
                $book['available'] = (int) $available;
            }
        }

        require __DIR__ . '/../views/editBook.php';
    }

    private function uploadBookImage(array $file): string
    {
        // Limiter les fichiers à 5 Mo.
        $maxSize = 20 * 1024 * 1024;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException(
                'Une erreur est survenue lors du téléchargement.'
            );
        }

        if ($file['size'] > $maxSize) {
            throw new RuntimeException(
                'La photo ne doit pas dépasser 20 Mo.'
            );
        }

        // Vérifier le type réel du fichier.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($allowedTypes[$mimeType])) {
            throw new RuntimeException(
                'La photo doit être au format JPEG, PNG ou WebP.'
            );
        }

        // Générer un nom unique.
        $extension = $allowedTypes[$mimeType];
        $fileName = bin2hex(random_bytes(16)) . '.' . $extension;

        $uploadDirectory = __DIR__ . '/../../public/uploads/books/';
        $destination = $uploadDirectory . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException(
                'Impossible d’enregistrer la photo.'
            );
        }

        return $fileName;
    }
}
