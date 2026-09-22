<?php

require_once __DIR__ . '/../models/BookManager.php';

class BookController
{
    public function index(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getAvailableBooks();

        require __DIR__ . '/../views/books.php';
    }
}