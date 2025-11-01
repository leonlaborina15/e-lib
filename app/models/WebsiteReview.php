<?php
class WebsiteReview {
    public static function addReview($db, $user_id, $name, $rating, $review_text) {
        $stmt = $db->prepare("INSERT INTO website_reviews (user_id, name, rating, review_text) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $user_id, $name, $rating, $review_text);
        $stmt->execute();
        $stmt->close();
    }

    public static function getRecentReviews($db, $limit = 10) {
        $stmt = $db->prepare("SELECT name, rating, review_text, created_at FROM website_reviews ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $reviews;
    }
}