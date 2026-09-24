<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/BookManager.php';

class BookController extends Controller
{
    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');

        $bookManager = new BookManager();
        $books = $bookManager->getAvailableBooks($search);

        $this->render('books', ['books' => $books, 'search' => $search]);
    }

    public function show(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(404);
            $this->render('404');
            return;
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            http_response_code(404);
            $this->render('404');
            return;
        }

        $this->render('book', ['book' => $book]);
    }

    public function edit(): void
    {
        // Vérifier que l'utilisateur est connecté.
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $bookId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Vérifier que l'identifiant du livre est valide.
        if (!$bookId) {
            http_response_code(404);
            $this->render('404');
            return;
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);

        // Vérifier que le livre existe.
        if (!$book) {
            http_response_code(404);
            $this->render('404');
            return;
        }

        // Vérifier que le livre appartient à l'utilisateur.
        if ($book->getUserId() !== $userId) {
            http_response_code(403);
            echo 'Vous ne pouvez pas modifier ce livre.';
            return;
        }

        // Traiter le formulaire.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';

            if (
                !is_string($token) ||
                !hash_equals($_SESSION['csrf_token'], $token)
            ) {
                http_response_code(403);
                echo 'Requête non autorisée.';
                return;
            }
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
            $book->setTitle($title);
            $book->setAuthor($author);
            $book->setDescription($description);

            if (in_array($available, ['0', '1'], true)) {
                $book->setAvailable($available === '1');
            }
        }

        $this->render('editBook', ['book' => $book, 'error' => $error ?? null]);
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

    public function delete(): void
    {
        // Vérifier que l'utilisateur est connecté.
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // La suppression doit obligatoirement utiliser POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        // Vérifier le jeton CSRF.
        $token = $_POST['csrf_token'] ?? '';

        if (
            !is_string($token) ||
            !isset($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $token)
        ) {
            http_response_code(403);
            echo 'Requête non autorisée.';
            return;
        }

        // Vérifier l'identifiant du livre.
        $bookId = filter_input(
            INPUT_POST,
            'id',
            FILTER_VALIDATE_INT
        );

        if (!$bookId || $bookId < 1) {
            http_response_code(400);
            echo 'Identifiant de livre invalide.';
            return;
        }

        $bookManager = new BookManager();

        $deleted = $bookManager->deleteBook(
            $bookId,
            (int) $_SESSION['user_id']
        );

        if (!$deleted) {
            http_response_code(404);
            $this->render('404');
            return;
        }

        header('Location: /account');
        exit;
    }

    public function add(): void
    {
        // Vérifier que l'utilisateur est connecté.
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];

        // Créer le jeton CSRF si nécessaire.
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // L'identifiant et la date seront attribués par la base à la création.
        $book = new Book(
            id: null,
            userId: $userId,
            title: '',
            author: '',
            description: '',
            image: null,
            available: true,
            createdAt: null
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier le jeton CSRF.
            $token = $_POST['csrf_token'] ?? '';

            if (
                !is_string($token) ||
                !hash_equals($_SESSION['csrf_token'], $token)
            ) {
                http_response_code(403);
                echo 'Requête non autorisée.';
                return;
            }

            $title = trim($_POST['title'] ?? '');
            $author = trim($_POST['author'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $available = $_POST['available'] ?? null;

            // Conserver les valeurs saisies en cas d'erreur.
            $book->setTitle($title);
            $book->setAuthor($author);
            $book->setDescription($description);

            if (in_array($available, ['0', '1'], true)) {
                $book->setAvailable($available === '1');
            }

            if (
                $title === '' ||
                $author === '' ||
                $description === '' ||
                !in_array($available, ['0', '1'], true)
            ) {
                $error = 'Veuillez remplir correctement tous les champs.';
            } else {
                $image = null;

                // La photo est facultative.
                if (
                    isset($_FILES['image']) &&
                    $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
                ) {
                    try {
                        $image = $this->uploadBookImage($_FILES['image']);
                    } catch (RuntimeException $exception) {
                        $error = $exception->getMessage();
                    }
                }

                if (empty($error)) {
                    $bookManager = new BookManager();

                    try {
                        $bookManager->createBook(
                            $book->getUserId(),
                            $book->getTitle(),
                            $book->getAuthor(),
                            $book->getDescription(),
                            $book->isAvailable(),
                            $image
                        );
                    } catch (Throwable $exception) {
                        // Supprimer le fichier si l'insertion échoue.
                        if ($image !== null) {
                            unlink(
                                __DIR__ . '/../../public/uploads/books/' . $image
                            );
                        }

                        throw $exception;
                    }

                    header('Location: /account');
                    exit;
                }
            }
        }

        $this->render('addBook', ['book' => $book, 'error' => $error ?? null]);
    }
}
