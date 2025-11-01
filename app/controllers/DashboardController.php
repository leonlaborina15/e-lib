<?php
/**
 * Dashboard Controller
 */

class DashboardController extends BaseController {

    private $bookModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->bookModel = new Book($this->db);
        $this->userModel = new User($this->db);

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?route=login');
            exit;
        }
    }

    public function index() {
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        $totalBooks = $this->bookModel->count();
        $totalUsers = $this->userModel->count();
        $recentBooks = $this->bookModel->getRecent(6);
        $myFavorites = $this->bookModel->getFavorites($userId);
        $myHistory = $this->bookModel->getReadingHistory($userId, 5);

        $activityLogs = [];
        if ($role === 'admin') {
            $activityLogs = $this->userModel->getActivityLogs(10);
        }

        $data = [
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'total_books' => $totalBooks,
            'total_users' => $totalUsers,
            'recent_books' => $recentBooks,
            'my_favorites' => $myFavorites,
            'my_history' => $myHistory,
            'activity_logs' => $activityLogs
        ];

        $this->view('dashboard/index', $data);
    }
}
?>