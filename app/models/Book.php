<?php
/**
 * Book Model
 */

class Book {

    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    /**
     * Get all books with category filter
     */
    public function getAll($category = null) {
        if ($category) {
            $stmt = $this->db->prepare("
                SELECT * FROM books
                WHERE category = ?
                ORDER BY created_at DESC
            ");
            $stmt->execute([$category]);
        } else {
            $stmt = $this->db->query("
                SELECT * FROM books
                ORDER BY created_at DESC
            ");
        }
        return $stmt->fetchAll();
    }

    /**
     * Get recent books
     */
    public function getRecent($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT * FROM books
            ORDER BY created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Search books
     */
    public function search($query) {
        $searchTerm = "%$query%";
        $stmt = $this->db->prepare("
            SELECT * FROM books
            WHERE title LIKE ?
            OR author LIKE ?
            OR category LIKE ?
            OR isbn LIKE ?
            ORDER BY title ASC
        ");
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    /**
     * Find book by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get all categories
     */
    public function getCategories() {
        $stmt = $this->db->query("
            SELECT DISTINCT category
            FROM books
            WHERE category IS NOT NULL AND category != ''
            ORDER BY category ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Create new book
     */
    public function create($title, $author, $isbn, $category, $publisher, $published_year, $description, $cover_image, $pdf_file) {
        $stmt = $this->db->prepare("
            INSERT INTO books (title, author, isbn, category, publisher, published_year, description, cover_image, pdf_file)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $title,
            $author,
            $isbn,
            $category,
            $publisher,
            $published_year,
            $description,
            $cover_image,
            $pdf_file
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update book
     */
    public function update($id, $title, $author, $isbn, $category, $publisher, $published_year, $description, $cover_image, $pdf_file) {
        $stmt = $this->db->prepare("
            UPDATE books
            SET title = ?, author = ?, isbn = ?, category = ?,
                publisher = ?, published_year = ?, description = ?,
                cover_image = ?, pdf_file = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $title,
            $author,
            $isbn,
            $category,
            $publisher,
            $published_year,
            $description,
            $cover_image,
            $pdf_file,
            $id
        ]);
    }

    /**
     * Delete book
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Get total books count
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM books");
        return $stmt->fetchColumn();
    }

    /**
     * Add to reading history
     */
    public function addToReadingHistory($userId, $bookId) {
        $stmt = $this->db->prepare("
            INSERT INTO reading_history (user_id, book_id)
            VALUES (?, ?)
            ON DUPLICATE KEY UPDATE read_at = CURRENT_TIMESTAMP
        ");
        return $stmt->execute([$userId, $bookId]);
    }

    /**
     * Get user's reading history
     */
    public function getReadingHistory($userId, $limit = 10) {
        $stmt = $this->db->prepare("
            SELECT b.*, rh.read_at
            FROM reading_history rh
            JOIN books b ON rh.book_id = b.id
            WHERE rh.user_id = ?
            ORDER BY rh.read_at DESC
            LIMIT ?
        ");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }

    /**
     * Add to favorites
     */
    public function addToFavorites($userId, $bookId) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO favorites (user_id, book_id)
                VALUES (?, ?)
            ");
            return $stmt->execute([$userId, $bookId]);
        } catch (PDOException $e) {
            // Already favorited
            return true;
        }
    }

    /**
     * Remove from favorites
     */
    public function removeFromFavorites($userId, $bookId) {
        $stmt = $this->db->prepare("
            DELETE FROM favorites
            WHERE user_id = ? AND book_id = ?
        ");
        return $stmt->execute([$userId, $bookId]);
    }

    /**
     * Check if book is favorited by user
     */
    public function isFavorited($userId, $bookId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM favorites
            WHERE user_id = ? AND book_id = ?
        ");
        $stmt->execute([$userId, $bookId]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Get user's favorite books
     */
    public function getFavorites($userId) {
        $stmt = $this->db->prepare("
            SELECT b.*, f.created_at as favorited_at
            FROM favorites f
            JOIN books b ON f.book_id = b.id
            WHERE f.user_id = ?
            ORDER BY f.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
?>