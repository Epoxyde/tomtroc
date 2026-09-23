<?php

class Message
{
    public function __construct(
        private int $id,
        private int $senderId,
        private int $recipientId,
        private string $content,
        private string $createdAt,
        private ?string $readAt
    ) {
    }

    /**
     * Transforme une ligne de la base de données en objet Message.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (int) $data['sender_id'],
            (int) $data['recipient_id'],
            $data['content'],
            $data['created_at'],
            $data['read_at']
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function getRecipientId(): int
    {
        return $this->recipientId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getReadAt(): ?string
    {
        return $this->readAt;
    }

    public function isRead(): bool
    {
        return $this->readAt !== null;
    }
}
