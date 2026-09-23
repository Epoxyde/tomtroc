<?php

require_once __DIR__ . '/Database.php';

class BookManager
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getLatestBooks(int $limit = 4): array
    {
        $sql = '
            SELECT books.*, users.username
            FROM books
            JOIN users ON users.id = books.user_id
            ORDER BY books.id ASC
            LIMIT :limit
        ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getAvailableBooks(string $search = ''): array
    {
        $sql = '
            SELECT books.*, users.username
            FROM books
            JOIN users ON users.id = books.user_id
            WHERE books.available = 1
        ';

        if ($search !== '') {
            $sql .= ' AND books.title LIKE :search';
        }

        $sql .= ' ORDER BY books.id ASC';

        $statement = $this->db->prepare($sql);

        if ($search !== '') {
            $statement->bindValue(':search', '%' . $search . '%');
        }

        $statement->execute();

        return $statement->fetchAll();
    }

    public function getBookById(int $id): array|false
    {
        $sql = '
            SELECT
                books.*,
                users.username,
                users.avatar
            FROM books
            JOIN users ON users.id = books.user_id
            WHERE books.id = :id
        ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function getBooksByUserId(int $userId): array
    {
        $sql = '
        SELECT *
        FROM books
        WHERE user_id = :user_id
        ORDER BY id ASC
    ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function updateBook(
        int $id,
        int $userId,
        string $title,
        string $author,
        string $description,
        bool $available
    ): void {
        $sql = '
        UPDATE books
        SET title = :title,
            author = :author,
            description = :description,
            available = :available
        WHERE id = :id
          AND user_id = :user_id
    ';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':author', $author);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':available', $available, PDO::PARAM_BOOL);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();
    }

    public function updateBookImage(
        int $bookId,
        int $userId,
        string $image
    ): void {
        $sql = '
        UPDATE books
        SET image = :image
        WHERE id = :id
          AND user_id = :user_id
    ';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':image', $image);
        $statement->bindValue(':id', $bookId, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();
    }
}
