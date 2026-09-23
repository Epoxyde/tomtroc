<?php

class User
{
    public function __construct(
        private int $id,
        private string $username,
        private string $email,
        private ?string $avatar,
        private string $createdAt,
        private ?string $passwordHash = null
    ) {
    }

    /**
     * Transforme une ligne de la base de données en objet User.
     * Le mot de passe n'est chargé que pour la recherche par email.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            $data['username'],
            $data['email'],
            $data['avatar'],
            $data['created_at'],
            $data['password'] ?? null
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function verifyPassword(string $password): bool
    {
        return $this->passwordHash !== null
            && password_verify($password, $this->passwordHash);
    }
}
