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
}