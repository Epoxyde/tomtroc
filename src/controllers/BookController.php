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
}