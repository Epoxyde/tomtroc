<?php

class Book
{
    public function __construct(
        private ?int $id,
        private int $userId,
        private string $title,
        private string $author,
        private string $description,
        private ?string $image,
        private bool $available,
        private ?string $createdAt,
        private string $ownerUsername = '',
        private ?string $ownerAvatar = null
    ) {
    }

    /**
     * Transforme une ligne de la base de données en objet Book.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (int) $data['user_id'],
            $data['title'],
            $data['author'],
            $data['description'],
            $data['image'],
            (bool) $data['available'],
            $data['created_at'],
            $data['username'] ?? '',
            $data['avatar'] ?? null
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getOwnerUsername(): string
    {
        return $this->ownerUsername;
    }

    public function getOwnerAvatar(): ?string
    {
        return $this->ownerAvatar;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }
}
