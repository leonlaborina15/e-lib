<?php

class BookController extends BaseController {

    private $bookModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->bookModel = new Book($this->db);
        $this->userModel = new User($this->db);

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?route=login');
            exit;
        }
    }

    public function index() {
        $category = $_GET['category'] ?? null;
        $books = $this->bookModel->getAll($category);
        $categories = $this->bookModel->getCategories();

        foreach ($books as &$book) {
            $book['is_favorited'] = $this->bookModel->isFavorited($_SESSION['user_id'], $book['id']);
        }

        $data = [
            'title' => 'Books',
            'page_title' => $category ? "Books - $category" : 'All Books',
            'books' => $books,
            'categories' => $categories,
            'current_category' => $category
        ];

        $this->view('books/index', $data);
    }

    public function show() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $book = $this->bookModel->findById($id);

        if (!$book) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $isFavorited = $this->bookModel->isFavorited($_SESSION['user_id'], $id);

        $data = [
            'title' => $book['title'],
            'page_title' => $book['title'],
            'book' => $book,
            'is_favorited' => $isFavorited
        ];

        $this->view('books/view', $data);
    }

    public function create() {
        if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'librarian') {
            $_SESSION['error'] = 'Access denied';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }

        $data = [
            'title' => 'Add New Book',
            'page_title' => 'Add New Book'
        ];

        $this->view('books/create', $data);
    }

    /**
     * Store new books (multi-book support)
     */
    private function store() {
        $titles = $_POST['title'] ?? [];
        $authors = $_POST['author'] ?? [];
        $isbns = $_POST['isbn'] ?? [];
        $categories = $_POST['category'] ?? [];
        $publishers = $_POST['publisher'] ?? [];
        $years = $_POST['published_year'] ?? [];
        $descriptions = $_POST['description'] ?? [];

        $added = 0;
        $failed = 0;

        for ($i = 0; $i < count($titles); $i++) {
            $title = trim($titles[$i] ?? '');
            $author = trim($authors[$i] ?? '');
            $isbn = isset($isbns[$i]) ? trim($isbns[$i]) : '';
            $category = trim($categories[$i] ?? '');
            $publisher = trim($publishers[$i] ?? '');
            $published_year = $years[$i] ?? null;
            $description = trim($descriptions[$i] ?? '');

            // Validation
            if (empty($title) || empty($author)) {
                $failed++;
                continue;
            }

            // Handle cover image upload (array)
            $cover_image = null;
            if (isset($_FILES['cover_image']['name'][$i]) && $_FILES['cover_image']['name'][$i]) {
                $cover_file = [
                    'name' => $_FILES['cover_image']['name'][$i],
                    'type' => $_FILES['cover_image']['type'][$i],
                    'tmp_name' => $_FILES['cover_image']['tmp_name'][$i],
                    'error' => $_FILES['cover_image']['error'][$i],
                    'size' => $_FILES['cover_image']['size'][$i]
                ];
                if ($cover_file['error'] === 0) {
                    $cover_image = $this->uploadFile($cover_file, 'covers');
                }
            }

            // Handle PDF upload (array)
            $pdf_file = null;
            if (isset($_FILES['pdf_file']['name'][$i]) && $_FILES['pdf_file']['name'][$i]) {
                $pdf_file_arr = [
                    'name' => $_FILES['pdf_file']['name'][$i],
                    'type' => $_FILES['pdf_file']['type'][$i],
                    'tmp_name' => $_FILES['pdf_file']['tmp_name'][$i],
                    'error' => $_FILES['pdf_file']['error'][$i],
                    'size' => $_FILES['pdf_file']['size'][$i]
                ];
                if ($pdf_file_arr['error'] === 0) {
                    $pdf_file = $this->uploadFile($pdf_file_arr, 'pdfs');
                }
            }

            // Create book
            $bookId = $this->bookModel->create(
                $title,
                $author,
                $isbn,
                $category,
                $publisher,
                $published_year,
                $description,
                $cover_image,
                $pdf_file
            );

            if ($bookId) {
                $added++;
                $this->userModel->logActivity($_SESSION['user_id'], "Added new book: $title");
            } else {
                $failed++;
            }
        }

        // Feedback and redirect
        if ($added > 0) {
            $_SESSION['success'] = "$added book(s) added successfully" . ($failed > 0 ? ", $failed failed" : "");
            header('Location: ' . BASE_URL . '?route=books');
        } else {
            $_SESSION['error'] = "No books added. Please fill at least Title and Author for each book.";
            header('Location: ' . BASE_URL . '?route=books/create');
        }
        exit;
    }

    public function read() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $book = $this->bookModel->findById($id);

        if (!$book || !$book['pdf_file']) {
            $_SESSION['error'] = 'PDF file not available';
            header('Location: ' . BASE_URL . '?route=books/show&id=' . $id);
            exit;
        }

        $possiblePaths = [
            BASE_PATH . '/public/uploads/pdfs/' . $book['pdf_file'],
            BASE_PATH . '/uploads/pdfs/' . $book['pdf_file'],
            dirname(BASE_PATH) . '/public/uploads/pdfs/' . $book['pdf_file'],
            $_SERVER['DOCUMENT_ROOT'] . '/e-lib/public/uploads/pdfs/' . $book['pdf_file']
        ];

        $pdfPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $pdfPath = $path;
                break;
            }
        }

        if (!$pdfPath || !file_exists($pdfPath)) {
            $_SESSION['error'] = 'PDF file not found. Filename: ' . $book['pdf_file'];
            header('Location: ' . BASE_URL . '?route=books/show&id=' . $id);
            exit;
        }

        $this->bookModel->addToReadingHistory($_SESSION['user_id'], $id);
        $this->userModel->logActivity($_SESSION['user_id'], "Read book: {$book['title']}");

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($book['pdf_file']) . '"');
        header('Content-Length: ' . filesize($pdfPath));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        header('Accept-Ranges: bytes');

        if (ob_get_level()) {
            ob_end_clean();
        }

        readfile($pdfPath);
        exit;
    }

    public function download() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $book = $this->bookModel->findById($id);

        if (!$book || !$book['pdf_file']) {
            $_SESSION['error'] = 'PDF file not available';
            header('Location: ' . BASE_URL . '?route=books/show&id=' . $id);
            exit;
        }

        $possiblePaths = [
            BASE_PATH . '/public/uploads/pdfs/' . $book['pdf_file'],
            BASE_PATH . '/uploads/pdfs/' . $book['pdf_file'],
            dirname(BASE_PATH) . '/public/uploads/pdfs/' . $book['pdf_file'],
            $_SERVER['DOCUMENT_ROOT'] . '/e-lib/public/uploads/pdfs/' . $book['pdf_file']
        ];

        $pdfPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $pdfPath = $path;
                break;
            }
        }

        if (!$pdfPath || !file_exists($pdfPath)) {
            $_SESSION['error'] = 'PDF file not found. Filename: ' . $book['pdf_file'];
            header('Location: ' . BASE_URL . '?route=books/show&id=' . $id);
            exit;
        }

        $this->bookModel->addToReadingHistory($_SESSION['user_id'], $id);
        $this->userModel->logActivity($_SESSION['user_id'], "Downloaded book: {$book['title']}");

        $cleanTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $book['title']);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $cleanTitle . '.pdf"');
        header('Content-Length: ' . filesize($pdfPath));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        header('Accept-Ranges: bytes');

        if (ob_get_level()) {
            ob_end_clean();
        }

        readfile($pdfPath);
        exit;
    }

    public function toggleFavorite() {
        $bookId = $_GET['book_id'] ?? null;

        if (!$bookId) {
            $_SESSION['error'] = 'Book ID is missing';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $book = $this->bookModel->findById($bookId);
        if (!$book) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $isFavorited = $this->bookModel->isFavorited($_SESSION['user_id'], $bookId);

        if ($isFavorited) {
            $this->bookModel->removeFromFavorites($_SESSION['user_id'], $bookId);
            $this->userModel->logActivity($_SESSION['user_id'], "Removed from favorites: {$book['title']}");
            $_SESSION['success'] = '❤️ Removed from favorites';
        } else {
            $this->bookModel->addToFavorites($_SESSION['user_id'], $bookId);
            $this->userModel->logActivity($_SESSION['user_id'], "Added to favorites: {$book['title']}");
            $_SESSION['success'] = '❤️ Added to favorites';
        }

        $returnUrl = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '?route=books';
        header('Location: ' . $returnUrl);
        exit;
    }

    public function favorites() {
        $favorites = $this->bookModel->getFavorites($_SESSION['user_id']);

        $data = [
            'title' => 'My Favorites',
            'page_title' => 'My Favorite Books',
            'books' => $favorites
        ];

        $this->view('books/favorites', $data);
    }

    public function history() {
        $history = $this->bookModel->getReadingHistory($_SESSION['user_id'], 50);

        $data = [
            'title' => 'Reading History',
            'page_title' => 'My Reading History',
            'history' => $history
        ];

        $this->view('books/history', $data);
    }

    public function search() {
        $query = $_GET['q'] ?? '';

        if (strlen($query) < 2) {
            echo json_encode([]);
            exit;
        }

        $results = $this->bookModel->search($query);
        echo json_encode($results);
        exit;
    }

    private function uploadFile($file, $folder) {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }

        $uploadDir = BASE_PATH . '/public/uploads/' . $folder . '/';

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                return false;
            }
        }

        $allowedTypes = [
            'covers' => ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'],
            'pdfs' => ['application/pdf']
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes[$folder])) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . strtolower($extension);
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            chmod($destination, 0644);
            return $filename;
        }

        return false;
    }

    public function edit() {
        if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'librarian') {
            $_SESSION['error'] = 'Access denied';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $book = $this->bookModel->findById($id);

        if (!$book) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($id);
            return;
        }

        $data = [
            'title' => 'Edit Book',
            'page_title' => 'Edit: ' . $book['title'],
            'book' => $book
        ];

        $this->view('books/edit', $data);
    }

    private function update($id) {
        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $publisher = trim($_POST['publisher'] ?? '');
        $published_year = $_POST['published_year'] ?? null;
        $description = trim($_POST['description'] ?? '');

        if (empty($title) || empty($author)) {
            $_SESSION['error'] = 'Title and Author are required';
            header('Location: ' . BASE_URL . '?route=books/edit&id=' . $id);
            exit;
        }

        $book = $this->bookModel->findById($id);
        $cover_image = $book['cover_image'];
        $pdf_file = $book['pdf_file'];

        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
            $newCover = $this->uploadFile($_FILES['cover_image'], 'covers');
            if ($newCover) {
                if ($cover_image) {
                    $oldCoverPath = BASE_PATH . '/public/uploads/covers/' . $cover_image;
                    if (file_exists($oldCoverPath)) {
                        unlink($oldCoverPath);
                    }
                }
                $cover_image = $newCover;
            }
        }

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
            $newPdf = $this->uploadFile($_FILES['pdf_file'], 'pdfs');
            if ($newPdf) {
                if ($pdf_file) {
                    $oldPdfPath = BASE_PATH . '/public/uploads/pdfs/' . $pdf_file;
                    if (file_exists($oldPdfPath)) {
                        unlink($oldPdfPath);
                    }
                }
                $pdf_file = $newPdf;
            }
        }

        if ($this->bookModel->update($id, $title, $author, $isbn, $category, $publisher, $published_year, $description, $cover_image, $pdf_file)) {
            $this->userModel->logActivity($_SESSION['user_id'], "Updated book: $title");
            $_SESSION['success'] = 'Book updated successfully';
            header('Location: ' . BASE_URL . '?route=books/show&id=' . $id);
        } else {
            $_SESSION['error'] = 'Failed to update book';
            header('Location: ' . BASE_URL . '?route=books/edit&id=' . $id);
        }
        exit;
    }

    public function delete() {
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Access denied';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        $book = $this->bookModel->findById($id);

        if (!$book) {
            $_SESSION['error'] = 'Book not found';
            header('Location: ' . BASE_URL . '?route=books');
            exit;
        }

        if ($book['cover_image']) {
            $coverPath = BASE_PATH . '/public/uploads/covers/' . $book['cover_image'];
            if (file_exists($coverPath)) {
                unlink($coverPath);
            }
        }

        if ($book['pdf_file']) {
            $pdfPath = BASE_PATH . '/public/uploads/pdfs/' . $book['pdf_file'];
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }

        if ($this->bookModel->delete($id)) {
            $this->userModel->logActivity($_SESSION['user_id'], "Deleted book: {$book['title']}");
            $_SESSION['success'] = 'Book deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete book';
        }

        header('Location: ' . BASE_URL . '?route=books');
        exit;
    }
}
?>