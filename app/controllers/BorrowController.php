<?php
/**
 * Borrow Controller
 * Handles book borrowing operations
 */

class BorrowController extends BaseController {

    private $borrowModel;
    private $bookModel;

    public function __construct() {
        parent::__construct();
        $this->borrowModel = new BorrowRecord($this->db);
        $this->bookModel = new Book($this->db);
    }

    /**
     * Display borrow records
     */
    public function index() {
        $this->requireAuth();

        if ($this->hasRole('admin') || $this->hasRole('librarian')) {
            $records = $this->borrowModel->getAll();
        } else {
            $records = $this->borrowModel->getByUser($_SESSION['user_id']);
        }

        $this->view('borrow/index', ['records' => $records]);
    }

    /**
     * Borrow a book
     */
    public function create() {
        $this->requireAuth();

        $book_id = $_POST['book_id'] ?? 0;
        $book = $this->bookModel->findById($book_id);

        if (!$book) {
            $this->json(['success' => false, 'message' => 'Book not found'], 404);
        }

        if ($book['available'] == 0) {
            $this->json(['success' => false, 'message' => 'Book is not available'], 400);
        }

        // Check if user already borrowed this book
        if ($this->borrowModel->hasActiveBorrow($_SESSION['user_id'], $book_id)) {
            $this->json(['success' => false, 'message' => 'You have already borrowed this book'], 400);
        }

        if ($this->borrowModel->create($_SESSION['user_id'], $book_id)) {
            $this->bookModel->updateAvailability($book_id, 0);
            $this->borrowModel->logActivity($_SESSION['user_id'], "Borrowed book: " . $book['title']);
            $this->json(['success' => true, 'message' => 'Book borrowed successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to borrow book'], 500);
        }
    }

    /**
     * Return a book
     */
    public function returnBook() {
        $this->requireAuth();

        $record_id = $_POST['record_id'] ?? 0;
        $record = $this->borrowModel->findById($record_id);

        if (!$record) {
            $this->json(['success' => false, 'message' => 'Borrow record not found'], 404);
        }

        // Check authorization
        if (!$this->hasRole('admin') && !$this->hasRole('librarian') && $record['user_id'] != $_SESSION['user_id']) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($this->borrowModel->returnBook($record_id)) {
            $this->bookModel->updateAvailability($record['book_id'], 1);
            $book = $this->bookModel->findById($record['book_id']);
            $this->borrowModel->logActivity($_SESSION['user_id'], "Returned book: " . $book['title']);
            $this->json(['success' => true, 'message' => 'Book returned successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to return book'], 500);
        }
    }
}
?>