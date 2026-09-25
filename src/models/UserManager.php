<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/UploadedImage.php';

class UserManager
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getUserByEmail(string $email): User|false
    {
        $sql = '
            SELECT *
            FROM users
            WHERE email = :email
        ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();

        $row = $statement->fetch();

        return $row === false ? false : User::fromArray($row);
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

    public function getUserById(int $id): User|false
    {
        $sql = '
        SELECT id, username, email, avatar, created_at
        FROM users
        WHERE id = :id
    ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch();

        return $row === false ? false : User::fromArray($row);
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

    /**
     * Met à jour la photo de profil d'un utilisateur.
     */
    public function updateAvatar(int $userId, string $filename): bool
    {
        $user = $this->getUserById($userId);

        $sql = '
        UPDATE users
        SET avatar = :avatar
        WHERE id = :user_id
    ';

        $statement = $this->db->prepare($sql);

        $statement->execute([
            'avatar' => $filename,
            'user_id' => $userId
        ]);

        $updated = $statement->rowCount() > 0;

        if ($updated && $user !== false) {
            UploadedImage::removeIfUnused($this->db, 'avatars', $user->getAvatar());
        }

        return $updated || ($user !== false && $user->getAvatar() === $filename);
    }
}
