<?php


class UserController extends BaseController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User($this->db);

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?route=login');
            exit;
        }
    }


    public function index() {
        // Only admin and librarian can view users
        $this->requireRole(['admin', 'librarian']);

        $users = $this->userModel->getAll();

        $data = [
            'title' => 'Manage Users',
            'page_title' => 'Manage Users',
            'users' => $users
        ];

        $this->view('users/index', $data);
    }


    public function create() {
        // Only admin and librarian can create users
        $this->requireRole(['admin', 'librarian']);

        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $role = $_POST['role'] ?? 'student';

            // Validation
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'All fields are required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format';
            } elseif ($this->userModel->emailExists($email)) {
                $_SESSION['error'] = 'Email already exists';
            } elseif (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters';
            } elseif ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
            } elseif (!in_array($role, ['student', 'librarian', 'admin'])) {
                $_SESSION['error'] = 'Invalid role';
            } elseif ($_SESSION['role'] === 'librarian' && $role === 'admin') {
                $_SESSION['error'] = 'Librarians cannot create admin users';
            } else {
                // Create user
                $userId = $this->userModel->create($name, $email, $password, $role);

                if ($userId) {
                    $this->userModel->logActivity($_SESSION['user_id'], "Created new user: $name ($role)");
                    $_SESSION['success'] = "User '$name' created successfully!";
                    $this->redirect('users');
                } else {
                    $_SESSION['error'] = 'Failed to create user';
                }
            }

            $this->redirect('users/create');
        }

        $data = [
            'title' => 'Add New User',
            'page_title' => 'Add New User'
        ];

        $this->view('users/create', $data);
    }

   
    public function edit() {
        $this->requireRole(['admin', 'librarian']);

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('users');
        }

        $user = $this->userModel->findById($id);

        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('users');
        }

        // Librarians can't edit admins
        if ($_SESSION['role'] === 'librarian' && $user['role'] === 'admin') {
            $_SESSION['error'] = 'You cannot edit admin users';
            $this->redirect('users');
        }

        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $role = $_POST['role'] ?? 'student';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $photo = $user['photo'];

            // Handle photo upload for user edit (optional)
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                finfo_close($finfo);

                if (in_array($mimeType, $allowedTypes)) {
                    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . '_' . time() . '.' . $extension;
                    $destination = BASE_PATH . '/public/uploads/photos/' . $filename;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                        // Optionally delete old photo
                        if (!empty($photo)) {
                            $oldPath = BASE_PATH . '/public/uploads/photos/' . $photo;
                            if (file_exists($oldPath)) unlink($oldPath);
                        }
                        $photo = $filename;
                    }
                }
            }

            // Validation
            if (empty($name) || empty($email)) {
                $_SESSION['error'] = 'Name and email are required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format';
            } elseif ($this->userModel->emailExists($email, $id)) {
                $_SESSION['error'] = 'Email already exists';
            } elseif (!in_array($role, ['student', 'librarian', 'admin'])) {
                $_SESSION['error'] = 'Invalid role';
            } elseif ($_SESSION['role'] === 'librarian' && $role === 'admin') {
                $_SESSION['error'] = 'You cannot set admin role';
            } elseif (!empty($newPassword) && strlen($newPassword) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters';
            } elseif (!empty($newPassword) && $newPassword !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
            } else {
                // Update password if provided
                if (!empty($newPassword)) {
                    $this->userModel->updatePassword($id, $newPassword);
                }

                // Update user including photo
                if ($this->userModel->update($id, $name, $email, $role, $photo)) {
                    $this->userModel->logActivity($_SESSION['user_id'], "Updated user: $name");
                    $_SESSION['success'] = "User '$name' updated successfully!";
                    $this->redirect('users');
                } else {
                    $_SESSION['error'] = 'Failed to update user';
                }
            }

            $this->redirect('users/edit&id=' . $id);
        }

        $data = [
            'title' => 'Edit User',
            'page_title' => 'Edit User',
            'user' => $user
        ];

        $this->view('users/edit', $data);
    }

    /**
     * Delete user
     */
    public function delete() {
        $this->requireRole('admin');

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('users');
        }

        // Prevent deleting yourself
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete yourself';
            $this->redirect('users');
        }

        $user = $this->userModel->findById($id);

        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('users');
        }

        // Delete photo file
        if (!empty($user['photo'])) {
            $photoPath = BASE_PATH . '/public/uploads/photos/' . $user['photo'];
            if (file_exists($photoPath)) unlink($photoPath);
        }

        // Delete user
        if ($this->userModel->delete($id)) {
            $this->userModel->logActivity($_SESSION['user_id'], "Deleted user: {$user['name']} ({$user['email']})");
            $_SESSION['success'] = "User '{$user['name']}' deleted successfully!";
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }

        $this->redirect('users');
    }

    /**
     * View and edit profile
     */
    public function profile() {
        $user = $this->userModel->findById($_SESSION['user_id']);

        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('logout');
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Handle photo upload
            $photo = $user['photo'];
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mimeType, $allowedTypes)) {
                    $_SESSION['error'] = 'Invalid image type. Only JPG, PNG, GIF allowed.';
                    $this->redirect('profile');
                }

                $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '_' . time() . '.' . $extension;
                $destination = BASE_PATH . '/public/uploads/photos/' . $filename;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    // Optionally delete old photo
                    if (!empty($photo)) {
                        $oldPath = BASE_PATH . '/public/uploads/photos/' . $photo;
                        if (file_exists($oldPath)) unlink($oldPath);
                    }
                    $photo = $filename;
                } else {
                    $_SESSION['error'] = 'Failed to upload photo.';
                    $this->redirect('profile');
                }
            }

            // Validation
            if (empty($name) || empty($email)) {
                $_SESSION['error'] = 'Name and email are required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format';
            } elseif ($this->userModel->emailExists($email, $_SESSION['user_id'])) {
                $_SESSION['error'] = 'Email already taken by another user';
            } elseif (!empty($newPassword) && empty($currentPassword)) {
                $_SESSION['error'] = 'Current password is required to change password';
            } elseif (!empty($currentPassword) && !password_verify($currentPassword, $user['password'])) {
                $_SESSION['error'] = 'Current password is incorrect';
            } elseif (!empty($newPassword) && strlen($newPassword) < 6) {
                $_SESSION['error'] = 'New password must be at least 6 characters';
            } elseif (!empty($newPassword) && $newPassword !== $confirmPassword) {
                $_SESSION['error'] = 'New passwords do not match';
            } else {
                // Update password if provided
                if (!empty($newPassword)) {
                    $this->userModel->updatePassword($_SESSION['user_id'], $newPassword);
                    $this->userModel->logActivity($_SESSION['user_id'], "Changed password");
                }

                // Update basic info including photo
                if ($this->userModel->update($_SESSION['user_id'], $name, $email, $user['role'], $photo)) {
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['photo'] = $photo;
                    $this->userModel->logActivity($_SESSION['user_id'], "Updated profile information");
                    if (!empty($newPassword)) {
                        $_SESSION['success'] = 'Profile and password updated successfully';
                    } else {
                        $_SESSION['success'] = 'Profile updated successfully';
                    }
                } else {
                    $_SESSION['error'] = 'Failed to update profile';
                }
            }

            $this->redirect('profile');
        }

        // Load Book model for statistics (if exists)
        $favoritesCount = 0;
        $historyCount = 0;

        if (file_exists(BASE_PATH . '/app/models/Book.php')) {
            require_once BASE_PATH . '/app/models/Book.php';
            $bookModel = new Book($this->db);

            $favoritesCount = count($bookModel->getFavorites($_SESSION['user_id']));
            $historyCount = count($bookModel->getReadingHistory($_SESSION['user_id'], 1000));
        }

        $data = [
            'title' => 'My Profile',
            'page_title' => 'My Profile',
            'user' => $user,
            'favorites_count' => $favoritesCount,
            'history_count' => $historyCount
        ];

        $this->view('users/profile', $data);
    }

    /**
     * View activity logs (Admin only)
     */
    public function logs() {
        $this->requireRole('admin');

        // Get filter parameters
        $limit = $_GET['limit'] ?? 100;
        $userId = $_GET['user_id'] ?? null;

        // Get logs
        if ($userId) {
            $logs = $this->userModel->getUserActivityLogs($userId, $limit);
        } else {
            $logs = $this->userModel->getActivityLogs($limit);
        }

        // Get all users for filter dropdown
        $users = $this->userModel->getAll();

        $data = [
            'title' => 'Activity Logs',
            'page_title' => 'Activity Logs',
            'logs' => $logs,
            'users' => $users,
            'current_user_id' => $userId,
            'current_limit' => $limit
        ];

        $this->view('logs/index', $data);
    }

    // Utility: redirect helper
    protected function redirect($route) {
        header('Location: ' . BASE_URL . '?route=' . $route);
        exit;
    }

    // Utility: role check helper
    protected function requireRole($roles) {
        if (is_array($roles)) {
            if (!in_array($_SESSION['role'], $roles)) {
                $_SESSION['error'] = 'Access denied';
                $this->redirect('dashboard');
            }
        } else {
            if ($_SESSION['role'] !== $roles) {
                $_SESSION['error'] = 'Access denied';
                $this->redirect('dashboard');
            }
        }
    }
}
?>