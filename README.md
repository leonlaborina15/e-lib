# E-Library System

A complete PHP MVC-based E-Library Management System designed for local hosting using XAMPP. Perfect for schools, colleges, or organizations that need an offline library management solution.

## Features

✨ **Core Features:**
- User Authentication (Login/Register)
- Role-Based Access Control (Admin, Librarian, Student)
- Book Management (Add, Edit, Delete, Search)
- Book Borrowing System
- PDF/ePub Upload & Download
- Advanced Search with AJAX suggestions
- Activity Logging
- Responsive Dashboard with Metrics
- Dark/Light Theme Toggle

👥 **User Roles:**
- **Admin**: Full access to all features including user management
- **Librarian**: Manage books and borrow records
- **Student**: Browse, search, borrow, and download books

## Requirements

- XAMPP (PHP 7.4+ and MySQL 5.7+)
- Web Browser (Chrome, Firefox, Edge, Safari)
- Minimum 100MB free disk space

## Installation Guide

### Step 1: Install XAMPP

1. Download XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)
2. Install XAMPP on your computer
3. Start Apache and MySQL from XAMPP Control Panel

### Step 2: Setup Database

1. Open your browser and go to `http://localhost/phpmyadmin`
2. Click on "Import" tab
3. Choose the `database.sql` file from the project
4. Click "Go" to import the database

**Alternative:** Create database manually:
```sql
CREATE DATABASE elibrary_db;
```
Then import the `database.sql` file.

### Step 3: Install Project Files

1. Copy the entire `e-lib` folder to `C:\xampp\htdocs\`
2. Your project path should be: `C:\xampp\htdocs\e-lib\`

### Step 4: Configure Database Connection

1. Open `config/database.php`
2. Verify the database credentials (default settings):
   ```php
   private $host = 'localhost';
   private $db_name = 'elibrary_db';
   private $username = 'root';
   private $password = '';
   ```

### Step 5: Create Required Directories

Create these folders inside `public/uploads/`:
```
public/uploads/books/
public/uploads/covers/
```

Set proper permissions (XAMPP on Windows usually handles this automatically).

### Step 6: Run the Seeder (Optional)

To populate the database with sample data:

1. Open Command Prompt/Terminal
2. Navigate to project directory:
   ```bash
   cd C:\xampp\htdocs\e-lib
   ```
3. Run the seeder:
   ```bash
   php seeder.php
   ```

### Step 7: Access the System

Open your browser and go to:
```
http://localhost/e-lib/public/
```

## Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@elib.com | admin123 |
| Librarian | librarian@elib.com | lib123 |
| Student | student@elib.com | student123 |

## Project Structure

```
e-lib/
├── app/
│   ├── controllers/       # Application controllers
│   │   ├── AuthController.php
│   │   ├── BookController.php
│   │   ├── BorrowController.php
│   │   ├── DashboardController.php
│   │   ├── HomeController.php
│   │   ├── LogController.php
│   │   └── UserController.php
│   ├── models/           # Data models
│   │   ├── Book.php
│   │   ├── BorrowRecord.php
│   │   └── User.php
│   └── views/            # View templates
│       ├── auth/         # Login/Register views
│       ├── books/        # Book management views
│       ├── borrow/       # Borrow records views
│       ├── dashboard/    # Dashboard view
│       ├── layouts/      # Layout templates
│       ├── logs/         # Activity logs views
│       └── users/        # User management views
├── config/
│   └── database.php      # Database configuration
├── public/
│   ├── assets/           # CSS, JS, Images
│   ├── uploads/          # Uploaded files
│   │   ├── books/       # Book files (PDF/ePub)
│   │   └── covers/      # Book cover images
│   ├── .htaccess        # URL rewriting rules
│   └── index.php        # Application entry point
├── routes/
│   └── web.php          # Route definitions
├── database.sql         # Database schema & sample data
├── seeder.php          # Database seeder script
└── README.md           # This file
```

## Usage Guide

### For Students

1. **Browse Books**: View all available books from the Books page
2. **Search**: Use the search bar to find books by title, author, ISBN, or category
3. **Borrow Books**: Click on a book and click "Borrow This Book"
4. **Download**: Download PDF files directly from book details page
5. **Return Books**: Go to "Borrow Records" and click "Return" when done
6. **View Dashboard**: See your borrowed books and library statistics

### For Librarians

All student features plus:
- View all borrow records from all users
- Monitor book availability
- Manage returns

### For Admins

All features plus:
- **Add Books**: Add new books with PDF uploads and cover images
- **Edit Books**: Update book information and availability
- **Delete Books**: Remove books from the system
- **Manage Users**: Create, edit, or delete user accounts
- **View Logs**: Monitor all system activities
- **User Management**: Assign roles and manage permissions

## Features in Detail

### Book Management
- Add books with title, author, category, ISBN
- Upload book files (PDF/ePub)
- Upload cover images
- Set availability status
- Edit and delete books

### Search & Filter
- Real-time AJAX search suggestions
- Filter by category
- Search by title, author, ISBN, or category

### Borrowing System
- One-click borrowing
- Automatic availability updates
- Borrow history tracking
- Return functionality
- Status monitoring (borrowed/returned)

### Dashboard
- Total books count
- Available books count
- Borrowed books count
- Total users (admin only)
- Recent books list
- My borrowed books
- Recent activities (admin only)

### Activity Logging
- All user actions are logged
- Timestamp tracking
- Admin can view complete activity history

### Theme Toggle
- Switch between light and dark modes
- Preference saved in localStorage
- Applies to all pages

## Captive Portal Setup (Optional)

To use this system as a captive portal on a local network:

1. Setup a Wi-Fi hotspot on your computer
2. Configure DNS to redirect all requests to your local IP
3. The `.htaccess` file will redirect all requests to the homepage
4. Users connecting to Wi-Fi will automatically see the login page

## Troubleshooting

### Problem: Cannot access the site
**Solution**: Make sure Apache is running in XAMPP Control Panel

### Problem: Database connection error
**Solution**: 
- Verify MySQL is running in XAMPP
- Check database credentials in `config/database.php`
- Ensure database `elibrary_db` exists

### Problem: File upload not working
**Solution**: 
- Check `public/uploads/` folders exist
- Verify folder permissions
- Check `php.ini` for upload_max_filesize and post_max_size

### Problem: Clean URLs not working
**Solution**: 
- Ensure `mod_rewrite` is enabled in Apache
- Check `.htaccess` file exists in `public/` folder
- Verify `AllowOverride All` in Apache config

### Problem: Session errors
**Solution**: 
- Clear browser cookies and cache
- Check PHP session configuration
- Restart Apache

## Database Schema

### users
- id, name, email, password (hashed), role, created_at

### books
- id, title, author, category, isbn, file_path, description, cover_image, available, create