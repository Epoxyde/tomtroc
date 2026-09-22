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
}