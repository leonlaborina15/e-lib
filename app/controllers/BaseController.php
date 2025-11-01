<?php


class BaseController {

    protected $db;

    public function __construct() {
        $db_instance = new Database();
        $this->db = $db_instance->getConnection();
    }

    /**
     * Load a view file
     */
    protected function view($view, $data = []) {
        extract($data);
        $view_file = BASE_PATH . '/app/views/' . $view . '.php';

        if (file_exists($view_file)) {
            require_once $view_file;
        } else {
            die("View not found: $view");
        }
    }

    /**
     * Redirect to a route
     */
    protected function redirect($route) {
        header('Location: ' . BASE_URL . '?route=' . $route);
        exit;
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Require authentication
     */
    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $_SESSION['error'] = 'Please login to continue';
            header('Location: ' . BASE_URL . '?route=login');
            exit;
        }
    }

    /**
     * Require specific role
     */
    protected function requireRole($roles) {
        if (!$this->isAuthenticated()) {
            $_SESSION['error'] = 'Please login to continue';
            header('Location: ' . BASE_URL . '?route=login');
            exit;
        }

        if (!in_array($_SESSION['role'], (array)$roles)) {
            $_SESSION['error'] = 'You do not have permission to access this page';
            header('Location: ' . BASE_URL . '?route=dashboard');
            exit;
        }
    }

    /**
     * Get current user
     */
    protected function getCurrentUser() {
        if ($this->isAuthenticated()) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role']
            ];
        }
        return null;
    }
}
?>