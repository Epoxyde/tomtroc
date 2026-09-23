<?php

session_start();

require_once __DIR__ . '/../src/controllers/HomeController.php';
require_once __DIR__ . '/../src/controllers/BookController.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

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

    case 'book':
        $controller = new BookController();
        $controller->show();
        break;

    case 'book/edit':
        $controller = new BookController();
        $controller->edit();
        break;

    case 'book/delete':
        $controller = new BookController();
        $controller->delete();
        break;

    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;

    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'account':
        $controller = new UserController();
        $controller->account();
        break;


    default:
        http_response_code(404);
        require __DIR__ . '/../src/views/404.php';
        break;
}
