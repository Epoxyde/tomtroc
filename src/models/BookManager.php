<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Book.php';
require_once __DIR__ . '/UploadedImage.php';

class BookManager
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * @return Book[]
     */
    public function getLatestBooks(int $limit = 4): array
    {
        $sql = '
            SELECT books.*, users.username
            FROM books
            JOIN users ON users.id = books.user_id
            ORDER BY books.created_at DESC, books.id DESC
            LIMIT :limit
        ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return array_map(
            fn (array $row): Book => Book::fromArray($row),
            $statement->fetchAll()
        );
    }

    /**
     * @return Book[]
     */
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

        return array_map(
            fn (array $row): Book => Book::fromArray($row),
            $statement->fetchAll()
        );
    }

    public function getBookById(int $id): Book|false
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

        $row = $statement->fetch();

        return $row === false ? false : Book::fromArray($row);
    }

    /**
     * @return Book[]
     */
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

        return array_map(
            fn (array $row): Book => Book::fromArray($row),
            $statement->fetchAll()
        );
    }

    /**
     * @return Book[]
     */
    public function getAvailableBooksByUserId(int $userId): array
    {
        $sql = '
        SELECT *
        FROM books
        WHERE user_id = :user_id
          AND available = 1
        ORDER BY id ASC
    ';

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        return array_map(
            fn (array $row): Book => Book::fromArray($row),
            $statement->fetchAll()
        );
    }

    public function createBook(
        int $userId,
        string $title,
        string $author,
        string $description,
        bool $available,
        ?string $image = null
    ): int {
        $sql = '
        INSERT INTO books (
            user_id,
            title,
            author,
            description,
            available,
            image
        )
        VALUES (
            :user_id,
            :title,
            :author,
            :description,
            :available,
            :image
        )
    ';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':author', $author);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':available', $available, PDO::PARAM_BOOL);
        $statement->bindValue(':image', $image, $image === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $statement->execute();

        return (int) $this->db->lastInsertId();
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
        $book = $this->getBookById($bookId);

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

        if ($statement->rowCount() > 0 && $book !== false) {
            UploadedImage::removeIfUnused($this->db, 'books', $book->getImage());
        }
    }

    public function deleteBook(int $bookId, int $userId): bool
    {
        $book = $this->getBookById($bookId);

        $sql = '
        DELETE FROM books
        WHERE id = :id
          AND user_id = :user_id
    ';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':id', $bookId, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();

        $deleted = $statement->rowCount() > 0;

        if ($deleted && $book !== false) {
            UploadedImage::removeIfUnused($this->db, 'books', $book->getImage());
        }

        return $deleted;
    }
}
