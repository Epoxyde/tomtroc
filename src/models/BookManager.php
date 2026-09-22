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
    }