<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/MessageManager.php';
require_once __DIR__ . '/../models/UserManager.php';

class MessageController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];

        $messageManager = new MessageManager();
        $userManager = new UserManager();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $correspondentId = filter_input(
            INPUT_GET,
            'user',
            FILTER_VALIDATE_INT
        );

        $correspondent = null;
        $messages = [];
        $error = null;

        if ($correspondentId && $correspondentId !== $userId) {
            $correspondent = $userManager->getUserById(
                $correspondentId
            );

            if (!$correspondent) {
                http_response_code(404);
                $this->render('404');
                return;
            }

            // Traitement de l'envoi d'un message.
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $content = trim($_POST['content'] ?? '');
                $csrfToken = $_POST['csrf_token'] ?? '';

                if (
                    !is_string($csrfToken) ||
                    !hash_equals($_SESSION['csrf_token'], $csrfToken)
                ) {
                    http_response_code(403);
                    $error = 'Formulaire invalide. Veuillez réessayer.';
                } elseif ($content === '') {
                    $error = 'Veuillez saisir un message.';
                } elseif (mb_strlen($content) > 5000) {
                    $error = 'Votre message est trop long.';
                } else {
                    $messageManager->sendMessage(
                        $userId,
                        $correspondentId,
                        $content
                    );

                    header(
                        'Location: /messages?user=' . $correspondentId
                    );
                    exit;
                }
            }

            $messageManager->markAsRead($userId, $correspondentId);

            $messages = $messageManager->getMessages(
                $userId,
                $correspondentId
            );
        } elseif ($correspondentId === $userId) {
            header('Location: /messages');
            exit;
        }

        $conversations = $messageManager->getConversations($userId);

        $this->render('messages', compact('userId', 'correspondent', 'messages', 'conversations', 'error'));
    }
}