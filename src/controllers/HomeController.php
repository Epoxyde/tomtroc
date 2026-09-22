<?php

require_once __DIR__ . '/../models/BookManager.php';

class HomeController
{
    public function index(): void
    {
        $bookManager = new BookManager();
        $latestBooks = $bookManager->getLatestBooks(4);

        require __DIR__ . '/../views/home.php';
    }
}