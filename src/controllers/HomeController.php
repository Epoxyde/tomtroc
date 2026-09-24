<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/BookManager.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $bookManager = new BookManager();
        $latestBooks = $bookManager->getLatestBooks(4);

        $this->render('home', ['latestBooks' => $latestBooks]);
    }
}