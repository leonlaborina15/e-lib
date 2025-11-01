<?php

if (!class_exists('User')) {
    require_once BASE_PATH . '/app/models/User.php';
}

class AuthController extends BaseController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    /**
     * Show login form and handle login
     */
    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->isAuthenticated()) {
            $this->redirect('dashboard');
        }

        // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            // Validation
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Please enter both email and password';
            } else {
                // Find user by email
                $user = $this->userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    // Log activity
                    $this->userModel->logActivity($user['id'], 'Logged in');

                    // Set remember me cookie
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
                    }

                    $_SESSION['success'] = 'Welcome back, ' . $user['name'] . '!';
                    $this->redirect('dashboard');
                } else {
                    $_SESSION['error'] = 'Invalid email or password';
                    $this->userModel->logActivity(0, "Failed login attempt: $email");
                }
            }

            $this->redirect('login');
        }

        // Show login form
        $data = [
            'title' => 'Login',
            'page_title' => 'Login to E-Library'
        ];

        $this->view('auth/login', $data);
    }

    /**
     * Show register form and handle registration
     */
    public function register() {
        // If already logged in, redirect to dashboard
        if ($this->isAuthenticated()) {
            $this->redirect('dashboard');
        }

        // Handle registration form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'All fields are required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format';
            } elseif ($this->userModel->emailExists($email)) {
                $_SESSION['error'] = 'Email already registered';
            } elseif (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters';
            } elseif ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
            } else {
                // Create user (default role: student)
                $userId = $this->userModel->create($name, $email, $password, 'student');

                if ($userId) {
                    // Auto login after registration
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = 'student';

                    $this->userModel->logActivity($userId, 'Registered and logged in');

                    $_SESSION['success'] = 'Registration successful! Welcome to E-Library, ' . $name . '!';
                    $this->redirect('dashboard');
                } else {
                    $_SESSION['error'] = 'Registration failed. Please try again.';
                }
            }

            $this->redirect('register');
        }

        // Show registration form
        $data = [
            'title' => 'Register',
            'page_title' => 'Create Your Account'
        ];

        $this->view('auth/register', $data);
    }

    /**
     * Handle logout
     */
    public function logout() {
        // Log activity before destroying session
        if (isset($_SESSION['user_id'])) {
            $this->userModel->logActivity($_SESSION['user_id'], 'Logged out');
        }

        // Clear remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

        // Destroy session
        session_unset();
        session_destroy();

        // Start new session for flash message
        session_start();
        $_SESSION['success'] = 'You have been logged out successfully';

        // Redirect to login
        $this->redirect('login');
    }
}
?>