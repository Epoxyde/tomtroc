<?php

require_once __DIR__ . '/../models/MessageManager.php';

class Controller
{
    public function render(string $view, array $data = []): void
    {
        $unreadMessages = 0;

        if (isset($_SESSION['user_id'])) {
            $messageManager = new MessageManager();
            $unreadMessages = $messageManager->countUnreadMessages(
                (int) $_SESSION['user_id']
            );
        }

        // Rend les données du contrôleur accessibles dans la vue.
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../views/' . $view . '.php';
    }
}
