<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Message.php';

class MessageManager
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Récupère les correspondants de l'utilisateur,
     * classés par date du dernier message.
     */
    public function getConversations(int $userId): array
    {
        $sql = '
        SELECT
            u.id,
            u.username,
            u.avatar,
            m.content AS last_message,
            m.created_at AS last_message_date,
            (
                SELECT COUNT(*)
                FROM messages unread
                WHERE unread.sender_id = u.id
                  AND unread.recipient_id = :unread_user_id
                  AND unread.read_at IS NULL
            ) AS unread_count
        FROM messages m
        INNER JOIN users u
            ON u.id = CASE
                WHEN m.sender_id = :sender_id
                    THEN m.recipient_id
                ELSE m.sender_id
            END
        WHERE
            (m.sender_id = :sender_filter
             OR m.recipient_id = :recipient_filter)
            AND m.id = (
                SELECT m2.id
                FROM messages m2
                WHERE
                    (m2.sender_id = :current_user_1
                     AND m2.recipient_id = u.id)
                    OR
                    (m2.sender_id = u.id
                     AND m2.recipient_id = :current_user_2)
                ORDER BY m2.created_at DESC, m2.id DESC
                LIMIT 1
            )
        ORDER BY m.created_at DESC, m.id DESC
    ';

        $statement = $this->db->prepare($sql);

        $statement->execute([
            'unread_user_id' => $userId,
            'sender_id' => $userId,
            'sender_filter' => $userId,
            'recipient_filter' => $userId,
            'current_user_1' => $userId,
            'current_user_2' => $userId
        ]);

        return $statement->fetchAll();
    }

    /**
     * Récupère les messages entre deux utilisateurs,
     * dans l'ordre chronologique.
     *
     * @return Message[]
     */
    public function getMessages(
        int $userId,
        int $correspondentId
    ): array {
        $sql = '
            SELECT *
            FROM messages
            WHERE
                (sender_id = :user_sender
                 AND recipient_id = :correspondent_recipient)
                OR
                (sender_id = :correspondent_sender
                 AND recipient_id = :user_recipient)
            ORDER BY created_at ASC, id ASC
        ';

        $statement = $this->db->prepare($sql);

        $statement->execute([
            'user_sender' => $userId,
            'correspondent_recipient' => $correspondentId,
            'correspondent_sender' => $correspondentId,
            'user_recipient' => $userId
        ]);

        return array_map(
            fn (array $row): Message => Message::fromArray($row),
            $statement->fetchAll()
        );
    }

    /**
     * Enregistre un message envoyé par un utilisateur.
     */
    public function sendMessage(
        int $senderId,
        int $recipientId,
        string $content
    ): bool {
        $sql = '
        INSERT INTO messages (sender_id, recipient_id, content)
        VALUES (:sender_id, :recipient_id, :content)
    ';

        $statement = $this->db->prepare($sql);

        return $statement->execute([
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'content' => $content
        ]);
    }

    /**
     * Compte les messages non lus reçus par un utilisateur.
     */
    public function countUnreadMessages(int $userId): int
    {
        $sql = '
        SELECT COUNT(*)
        FROM messages
        WHERE recipient_id = :user_id
          AND read_at IS NULL
    ';

        $statement = $this->db->prepare($sql);
        $statement->execute(['user_id' => $userId]);

        return (int) $statement->fetchColumn();
    }

    /**
     * Marque comme lus les messages reçus d'un correspondant.
     */
    public function markAsRead(int $userId, int $correspondentId): void
    {
        $sql = '
            UPDATE messages
            SET read_at = NOW()
            WHERE recipient_id = :user_id
            AND sender_id = :correspondent_id
            AND read_at IS NULL
        ';

        $statement = $this->db->prepare($sql);
        $statement->execute([
            'user_id' => $userId,
            'correspondent_id' => $correspondentId
        ]);
    }
}
