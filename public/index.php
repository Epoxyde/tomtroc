<?php

require_once __DIR__ . '/../src/controllers/HomeController.php';
require_once __DIR__ . '/../src/controllers/BookController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim($uri, '/');

switch ($route) {
    case '':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'books':
        $controller = new BookController();
        $controller->index();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/../src/views/404.php';
        break;
}