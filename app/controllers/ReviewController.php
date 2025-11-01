<?php
require_once __DIR__ . '/../models/WebsiteReview.php';
require_once __DIR__ . '/../../config/database.php';

class ReviewController extends BaseController
{
    public function index()
    {
        global $db;
        $reviews = WebsiteReview::getRecentReviews($db, 10);
        require_once __DIR__ . '/../views/reviews/index.php';
    }

    public function store()
    {
        global $db;
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? 0;
            $name = trim($_POST['name']);
            $rating = intval($_POST['rating']);
            $review_text = trim($_POST['review_text']);

            WebsiteReview::addReview($db, $user_id, $name, $rating, $review_text);
            header("Location: /?route=reviews&success=1");
            exit;
        }
    }
}