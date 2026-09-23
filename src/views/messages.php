<?php
require_once __DIR__ . '/../helpers/format.php';

$title = 'Messagerie';
require __DIR__ . '/templates/header.php';
?>

<section class="messages-page">
    <div class="messages-page__layout">

        <!-- Liste des conversations -->
        <aside class="messages-page__sidebar">
            <h1 class="messages-page__title">
                Messagerie
            </h1>

            <div class="messages-page__conversations">
                <?php foreach ($conversations as $conversation): ?>
                    <?php
                    $isActive = $correspondent
                        && (int) $correspondent['id'] === (int) $conversation['id'];

                    $lastMessageDate = new DateTime($conversation['last_message_date']);
                    ?>

                    <a
                        class="messages-page__conversation <?= $isActive ? 'messages-page__conversation--active' : '' ?>"
                        href="/messages?user=<?= (int) $conversation['id'] ?>">

                        <?php if (!empty($conversation['avatar'])): ?>
                            <img
                                class="messages-page__conversation-avatar"
                                src="/uploads/avatars/<?= htmlspecialchars($conversation['avatar']) ?>"
                                alt="">
                        <?php endif; ?>

                        <div class="messages-page__conversation-content">
                            <div class="messages-page__conversation-header">
                                <div class="messages-page__conversation-identity">
                                    <span class="messages-page__conversation-name">
                                        <?= htmlspecialchars($conversation['username']) ?>
                                    </span>

                                    <?php if ((int) $conversation['unread_count'] > 0): ?>
                                        <span class="messages-page__unread-count">
                                            <?= (int) $conversation['unread_count'] ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <time
                                    class="messages-page__conversation-date"
                                    datetime="<?= htmlspecialchars($lastMessageDate->format('c')) ?>">
                                    <?= formatMessageDate($conversation['last_message_date']) ?>
                                </time>
                            </div>

                            <p class="messages-page__conversation-preview">
                                <?= htmlspecialchars($conversation['last_message']) ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </aside>

        <!-- Conversation sélectionnée -->
        <div class="messages-page__main">
            <?php if ($correspondent): ?>

                <div class="messages-page__recipient">
                    <?php if (!empty($correspondent['avatar'])): ?>
                        <img
                            class="messages-page__recipient-avatar"
                            src="/uploads/avatars/<?= htmlspecialchars($correspondent['avatar']) ?>"
                            alt="">
                    <?php endif; ?>

                    <a href="/profile?id=<?= (int) $correspondent['id'] ?>">
                        <?= htmlspecialchars($correspondent['username']) ?>
                    </a>
                </div>

                <div class="messages-page__thread">
                    <?php foreach ($messages as $message): ?>
                        <?php
                        $isMine = (int) $message['sender_id'] === $userId;
                        $messageDate = new DateTime($message['created_at']);
                        ?>

                        <div class="messages-page__message <?= $isMine ? 'messages-page__message--mine' : 'messages-page__message--received' ?>">

                            <div class="messages-page__message-meta">
                                <?php if (!$isMine && !empty($correspondent['avatar'])): ?>
                                    <img
                                        class="messages-page__message-avatar"
                                        src="/uploads/avatars/<?= htmlspecialchars($correspondent['avatar']) ?>"
                                        alt="">
                                <?php endif; ?>

                                <time datetime="<?= htmlspecialchars($messageDate->format('c')) ?>">
                                    <?= formatMessageDate($message['created_at']) ?>
                                </time>
                            </div>

                            <p class="messages-page__message-bubble">
                                <?= nl2br(htmlspecialchars($message['content'])) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Formulaire d'envoi -->
                <form
                    class="messages-page__form"
                    action="/messages?user=<?= (int) $correspondent['id'] ?>"
                    method="post">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                    <?php if ($error): ?>
                        <p class="messages-page__error" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </p>
                    <?php endif; ?>

                    <div class="messages-page__form-fields">
                        <input
                            class="messages-page__input"
                            type="text"
                            name="content"
                            placeholder="Tapez votre message ici"
                            aria-label="Votre message"
                            maxlength="5000"
                            value="<?= htmlspecialchars($_POST['content'] ?? '') ?>"
                            required>

                        <button
                            class="button messages-page__submit"
                            type="submit">
                            Envoyer
                        </button>
                    </div>
                </form>

            <?php else: ?>
                <div class="messages-page__empty">
                    <p>Sélectionnez une conversation.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require __DIR__ . '/templates/footer.php'; ?>