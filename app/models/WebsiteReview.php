<?php
class WebsiteReview {

    public static function addReview($db, $user_id, $name, $rating, $review_text) {
        $stmt = $db->prepare("INSERT INTO website_reviews (user_id, name, rating, review_text) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $rating, $review_text]);
    }

    public static function getRecentReviews($db, $limit = 10) {
        $stmt = $db->prepare("SELECT id, user_id, name, rating, review_text, created_at FROM website_reviews ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reviews;
    }

    public static function getAllReviews($db) {
        $stmt = $db->prepare("SELECT id, user_id, name, rating, review_text, created_at FROM website_reviews ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteReview($db, $id) {
        $stmt = $db->prepare("DELETE FROM website_reviews WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getAverageRating($db) {
        $stmt = $db->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM website_reviews");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getReviewById($db, $id) {
        $stmt = $db->prepare("SELECT * FROM website_reviews WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}