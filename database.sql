
CREATE DATABASE IF NOT EXISTS elibrary_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE elibrary_db;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','librarian','student') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `description` text,
  `cover_image` varchar(255) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`),
  KEY `idx_author` (`author`),
  KEY `idx_category` (`category`),
  KEY `idx_available` (`available`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `borrow_records`;
CREATE TABLE `borrow_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` timestamp NULL DEFAULT NULL,
  `status` enum('borrowed','returned') DEFAULT 'borrowed',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_book_id` (`book_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_borrow_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_borrow_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_timestamp` (`timestamp`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@elib.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-10-01 08:00:00'),
(2, 'Librarian User', 'librarian@elib.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'librarian', '2025-10-02 09:00:00'),
(3, 'Student User', 'student@elib.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '2025-10-03 10:00:00');


INSERT INTO `books` (`id`, `title`, `author`, `category`, `isbn`, `file_path`, `description`, `cover_image`, `available`, `created_at`) VALUES
(1, 'Introduction to Computer Science', 'John Smith', 'Computer Science', '978-0-123456-78-9', '', 'A comprehensive guide to computer science fundamentals covering algorithms, data structures, and programming concepts.', '', 1, '2025-10-05 08:00:00'),
(2, 'Advanced Mathematics for Engineers', 'Maria Garcia', 'Mathematics', '978-0-234567-89-0', '', 'Advanced mathematical concepts including calculus, linear algebra, and differential equations for engineering students.', '', 1, '2025-10-06 09:00:00'),
(3, 'World History: Ancient Civilizations', 'Robert Johnson', 'History', '978-0-345678-90-1', '', 'Explore the ancient civilizations of Egypt, Greece, Rome, and Mesopotamia in this detailed historical account.', '', 1, '2025-10-07 10:00:00'),
(4, 'Modern Physics', 'Dr. Sarah Chen', 'Physics', '978-0-456789-01-2', '', 'Understanding quantum mechanics, relativity, and modern physics theories with practical applications.', '', 1, '2025-10-08 11:00:00'),
(5, 'English Literature Classics', 'William Brown', 'Literature', '978-0-567890-12-3', '', 'A collection of classic English literature works from Shakespeare to modern authors.', '', 1, '2025-10-09 12:00:00'),
(6, 'Organic Chemistry Fundamentals', 'Dr. James Wilson', 'Chemistry', '978-0-678901-23-4', '', 'Master the fundamentals of organic chemistry with detailed explanations and lab examples.', '', 1, '2025-10-10 13:00:00'),
(7, 'Introduction to Psychology', 'Dr. Emily Davis', 'Psychology', '978-0-789012-34-5', '', 'Understanding human behavior, cognitive processes, and psychological theories.', '', 1, '2025-10-11 14:00:00'),
(8, 'Business Management Principles', 'Michael Anderson', 'Business', '978-0-890123-45-6', '', 'Essential principles of business management, leadership, and organizational behavior.', '', 1, '2025-10-12 15:00:00'),
(9, 'Environmental Science', 'Dr. Lisa Taylor', 'Science', '978-0-901234-56-7', '', 'Study of environmental systems, ecology, and sustainability practices.', '', 1, '2025-10-13 16:00:00'),
(10, 'Digital Marketing Strategies', 'David Martinez', 'Marketing', '978-0-012345-67-8', '', 'Modern digital marketing techniques including SEO, social media, and content marketing.', '', 1, '2025-10-14 17:00:00');


INSERT INTO `activity_logs` (`user_id`, `action`, `timestamp`) VALUES
(1, 'User logged in', '2025-10-28 08:00:00'),
(1, 'Added new book: Introduction to Computer Science', '2025-10-28 08:15:00'),
(2, 'User logged in', '2025-10-28 09:00:00'),
(3, 'User logged in', '2025-10-28 10:00:00'),
(3, 'Borrowed book: Introduction to Computer Science', '2025-10-28 10:30:00');


ALTER TABLE `users` ADD INDEX `idx_created_at` (`created_at`);
ALTER TABLE `books` ADD INDEX `idx_created_at` (`created_at`);
ALTER TABLE `borrow_records` ADD INDEX `idx_borrow_date` (`borrow_date`);

