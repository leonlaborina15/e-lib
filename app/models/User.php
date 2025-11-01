<?php


class User {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    /**
     * Find user by ID
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error finding user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Find user by email
     */
    public function findByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error finding user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all users
     */
    public function getAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting users: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Create new user
     */
    public function create($name, $email, $password, $role = 'student') {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("
                INSERT INTO users (name, email, password, role, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");

            $stmt->execute([$name, $email, $hashedPassword, $role]);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user 
     */
    public function update($id, $name, $email, $role, $photo = null) {
        try {
            if ($photo !== null) {
                $stmt = $this->db->prepare("
                    UPDATE users
                    SET name = ?, email = ?, role = ?, photo = ?
                    WHERE id = ?
                ");
                return $stmt->execute([$name, $email, $role, $photo, $id]);
            } else {
                $stmt = $this->db->prepare("
                    UPDATE users
                    SET name = ?, email = ?, role = ?
                    WHERE id = ?
                ");
                return $stmt->execute([$name, $email, $role, $id]);
            }
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update password
     */
    public function updatePassword($id, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");

            return $stmt->execute([$hashedPassword, $id]);
        } catch (PDOException $e) {
            error_log("Error updating password: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete user
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if email exists (optionally exclude a user ID)
     */
    public function emailExists($email, $excludeId = null) {
        try {
            if ($excludeId) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
                $stmt->execute([$email, $excludeId]);
            } else {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                $stmt->execute([$email]);
            }

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking email: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Log user activity
     */
    public function logActivity($userId, $action) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO activity_logs (user_id, action, timestamp)
                VALUES (?, ?, NOW())
            ");

            return $stmt->execute([$userId, $action]);
        } catch (PDOException $e) {
            error_log("Error logging activity: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get activity logs
     */
    public function getActivityLogs($limit = 100) {
        try {
            $stmt = $this->db->prepare("
                SELECT al.*, u.name as user_name, u.email
                FROM activity_logs al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.timestamp DESC
                LIMIT ?
            ");

            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting activity logs: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get user activity logs
     */
    public function getUserActivityLogs($userId, $limit = 50) {
        try {
            $stmt = $this->db->prepare("
                SELECT al.*, u.name as user_name, u.email
                FROM activity_logs al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.user_id = ?
                ORDER BY al.timestamp DESC
                LIMIT ?
            ");

            $stmt->execute([$userId, $limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting user activity logs: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get user count
     */
    public function count() {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) FROM users");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error counting users: " . $e->getMessage());
            return 0;
        }
    }
}
?>