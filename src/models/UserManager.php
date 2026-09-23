<?php

require_once __DIR__ . '/Database.php';

class UserManager
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getUserByEmail(string $email): array|false
    {
        $sql = '
            SELECT *
            FROM users
            WHERE email = :email
        ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();

        return $statement->fetch();
    }

    public function createUser(
        string $username,
        string $email,
        string $password
    ): int {
        $sql = '
            INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)
        ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();

        return (int) $this->db->lastInsertId();
    }

    public function getUserById(int $id): array|false
    {
        $sql = '
        SELECT id, username, email, avatar, created_at
        FROM users
        WHERE id = :id
    ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function updateUser(
        int $id,
        string $username,
        string $email,
        ?string $password = null
    ): void {
        if ($password !== null) {
            $sql = '
            UPDATE users
            SET username = :username,
                email = :email,
                password = :password
            WHERE id = :id
        ';
        } else {
            $sql = '
            UPDATE users
            SET username = :username,
                email = :email
            WHERE id = :id
        ';
        }

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        if ($password !== null) {
            $statement->bindValue(':password', $password);
        }

        $statement->execute();
    }
}
