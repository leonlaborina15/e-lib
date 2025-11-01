<?php


class BorrowRecord {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Find record by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM borrow_records WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create borrow record
     */
    public function create($user_id, $book_id) {
        $stmt = $this->db->prepare("
            INSERT INTO borrow_records (user_id, book_id, borrow_date, status)
            VALUES (?, ?, NOW(), 'borrowed')
        ");
        return $stmt->execute([$user_id, $book_id]);
    }

    /**
     * Return book
     */
    public function returnBook($id) {
        $stmt = $this->db->prepare("
            UPDATE borrow_records
            SET return_date = NOW(), status = 'returned'
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    /**
     * Get all borrow records
     */
    public function getAll() {
        $stmt = $this->db->query("
            SELECT br.*, u.name as user_name, u.email, b.title, b.author, b.category
            FROM borrow_records br
            LEFT JOIN users u ON br.user_id = u.id
            LEFT JOIN books b ON br.book_id = b.id
            ORDER BY br.borrow_date DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Get borrow records by user
     */
    public function getByUser($user_id, $limit = null) {
        $sql = "
            SELECT br.*, b.title, b.author, b.category, b.cover_image
            FROM borrow_records br
            LEFT JOIN books b ON br.book_id = b.id
            WHERE br.user_id = ?
            ORDER BY br.borrow_date DESC
        ";

        if ($limit) {
            $sql .= " LIMIT ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $limit]);
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
        }

        return $stmt->fetchAll();
    }

    /**
     * Check if user has active borrow for book
     */
    public function hasActiveBorrow($user_id, $book_id) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM borrow_records
            WHERE user_id = ? AND book_id = ? AND status = 'borrowed'
        ");
        $stmt->execute([$user_id, $book_id]);
        $result = $stmt->fetch();
        return $result['total'] > 0;
    }

    /**
     * Count active borrows
     */
    public function countActive() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM borrow_records WHERE status = 'borrowed'");
        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Log activity
     */
    public function logActivity($user_id, $action) {
        $stmt = $this->db->prepare("INSERT INTO activity_logs (user_id, action, timestamp) VALUES (?, ?, NOW())");
        return $stmt->execute([$user_id, $action]);
    }
}
?>