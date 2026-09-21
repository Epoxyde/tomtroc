<?php

class BookController
{
    public function index(): void
    {
        require __DIR__ . '/../views/books.php';
    }
}