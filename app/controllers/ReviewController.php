<?php

class ReviewController extends BaseController
{
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

    public function index()
    {
        // Admins see all reviews, others see limited
        if ($_SESSION['role'] === 'admin') {
            $reviews = WebsiteReview::getAllReviews($this->db);
        } else {
            $reviews = WebsiteReview::getRecentReviews($this->db, 20);
        }

        $stats = WebsiteReview::getAverageRating($this->db);

        $data = [
            'title' => 'Reviews',
            'page_title' => 'Website Reviews',
            'reviews' => $reviews,
            'stats' => $stats
        ];

        $this->view('reviews/index', $data);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? 0;
            $name = trim($_POST['name']);
            $rating = intval($_POST['rating']);
            $review_text = trim($_POST['review_text']);

            // Validation
            if (empty($name) || $rating < 1 || $rating > 5 || empty($review_text)) {
                $_SESSION['error'] = 'Please fill in all fields correctly';
                header("Location: " . BASE_URL . "?route=reviews");
                exit;
            }

            WebsiteReview::addReview($this->db, $user_id, $name, $rating, $review_text);
            $this->userModel->logActivity($user_id, "Submitted a review with {$rating} stars");

            $_SESSION['success'] = 'Thank you for your review!';
            header("Location: " . BASE_URL . "?route=reviews&success=1");
            exit;
        }
    }

    public function delete()
    {
        // Only admins can delete reviews
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Access denied';
            header('Location: ' . BASE_URL . '?route=reviews');
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Review not found';
            header('Location: ' . BASE_URL . '?route=reviews');
            exit;
        }

        $review = WebsiteReview::getReviewById($this->db, $id);

        if (!$review) {
            $_SESSION['error'] = 'Review not found';
            header('Location: ' . BASE_URL . '?route=reviews');
            exit;
        }

        if (WebsiteReview::deleteReview($this->db, $id)) {
            $this->userModel->logActivity($_SESSION['user_id'], "Deleted review by {$review['name']}");
            $_SESSION['success'] = 'Review deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete review';
        }

        header('Location: ' . BASE_URL . '?route=reviews');
        exit;
    }
}