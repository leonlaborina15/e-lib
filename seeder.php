<?php
/**
 * Database Seeder
 * Run this file to populate database with sample data
 * Usage: php seeder.php
 */

require_once 'config/database.php';

echo "=================================\n";
echo "E-Library Database Seeder\n";
echo "=================================\n\n";

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die("Database connection failed!\n");
}

echo "✓ Database connected successfully\n\n";

try {
    // Clear existing data
    echo "Clearing existing data...\n";
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
    $db->exec("TRUNCATE TABLE activity_logs");
    $db->exec("TRUNCATE TABLE borrow_records");
    $db->exec("TRUNCATE TABLE books");
    $db->exec("TRUNCATE TABLE users");
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "✓ Tables cleared\n\n";

    // Insert Users
    echo "Inserting users...\n";
    $password = password_hash('admin123', PASSWORD_BCRYPT);

    $users = [
        ['Admin User', 'admin@elib.com', $password, 'admin'],
        ['Librarian User', 'librarian@elib.com', password_hash('lib123', PASSWORD_BCRYPT), 'librarian'],
        ['Student User', 'student@elib.com', password_hash('student123', PASSWORD_BCRYPT), 'student'],
        ['John Doe', 'john@example.com', password_hash('password123', PASSWORD_BCRYPT), 'student'],
        ['Jane Smith', 'jane@example.com', password_hash('password123', PASSWORD_BCRYPT), 'student'],
    ];

    $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
        echo "  - Created user: {$user[0]} ({$user[3]})\n";
    }
    echo "✓ " . count($users) . " users created\n\n";

    // Insert Books
    echo "Inserting books...\n";
    $books = [
        ['Introduction to Computer Science', 'John Smith', 'Computer Science', '978-0-123456-78-9', 'A comprehensive guide to computer science fundamentals.'],
        ['Advanced Mathematics for Engineers', 'Maria Garcia', 'Mathematics', '978-0-234567-89-0', 'Advanced mathematical concepts for engineering students.'],
        ['World History: Ancient Civilizations', 'Robert Johnson', 'History', '978-0-345678-90-1', 'Explore ancient civilizations in this detailed historical account.'],
        ['Modern Physics', 'Dr. Sarah Chen', 'Physics', '978-0-456789-01-2', 'Understanding quantum mechanics and relativity.'],
        ['English Literature Classics', 'William Brown', 'Literature', '978-0-567890-12-3', 'Collection of classic English literature works.'],
        ['Organic Chemistry Fundamentals', 'Dr. James Wilson', 'Chemistry', '978-0-678901-23-4', 'Master organic chemistry fundamentals.'],
        ['Introduction to Psychology', 'Dr. Emily Davis', 'Psychology', '978-0-789012-34-5', 'Understanding human behavior and cognitive processes.'],
        ['Business Management Principles', 'Michael Anderson', 'Business', '978-0-890123-45-6', 'Essential business management principles.'],
        ['Environmental Science', 'Dr. Lisa Taylor', 'Science', '978-0-901234-56-7', 'Study of environmental systems and ecology.'],
        ['Digital Marketing Strategies', 'David Martinez', 'Marketing', '978-0-012345-67-8', 'Modern digital marketing techniques.'],
        ['Artificial Intelligence Basics', 'Dr. Alan Turing', 'Computer Science', '978-0-111111-11-1', 'Introduction to AI and machine learning concepts.'],
        ['Creative Writing Workshop', 'Emily Wordsworth', 'Literature', '978-0-222222-22-2', 'Develop your creative writing skills.'],
        ['Biology: The Living World', 'Dr. Charles Darwin Jr.', 'Biology', '978-0-333333-33-3', 'Comprehensive guide to biological sciences.'],
        ['Philosophy: Ancient to Modern', 'Sophia Wisdom', 'Philosophy', '978-0-444444-44-4', 'Journey through philosophical thought.'],
        ['Web Development Complete Guide', 'Tim Berners', 'Computer Science', '978-0-555555-55-5', 'Full-stack web development from scratch.'],
    ];

    $stmt = $db->prepare("INSERT INTO books (title, author, category, isbn, description, available) VALUES (?, ?, ?, ?, ?, 1)");
    foreach ($books as $book) {
        $stmt->execute($book);
        echo "  - Added book: {$book[0]}\n";
    }
    echo "✓ " . count($books) . " books added\n\n";

    // Insert Activity Logs
    echo "Inserting activity logs...\n";
    $stmt = $db->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, ?)");
    $stmt->execute([1, 'User logged in']);
    $stmt->execute([1, 'Added multiple books to the library']);
    $stmt->execute([2, 'User logged in']);
    $stmt->execute([3, 'User logged in']);
    echo "✓ Activity logs created\n\n";

    echo "=================================\n";
    echo "✓ Database seeding completed!\n";
    echo "=================================\n\n";

    echo "You can now login with:\n";
    echo "  Admin: admin@elib.com / admin123\n";
    echo "  Librarian: librarian@elib.com / lib123\n";
    echo "  Student: student@elib.com / student123\n\n";

} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>