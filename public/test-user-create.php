<?php
/**
 * Database User Creation Test
 * Tests if we can insert users into the database
 * Author: leonlaborina15
 * Date: 2025-10-29 00:51:08 UTC
 */

// Your database class
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/config/database.php';

// Get connection from class
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die("<h1>❌ Database connection failed!</h1><p>Check your database credentials in config/database.php</p>");
}

// Check if we have BASE_URL, if not define it
if (!defined('BASE_URL')) {
    define('BASE_URL', '/e-lib/public/');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Creation Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2563eb;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            margin-top: 30px;
            padding: 10px;
            background: #f3f4f6;
            border-left: 4px solid #2563eb;
        }
        .success {
            background: #f0fdf4;
            border-left: 4px solid #22c55e;
            padding: 15px;
            margin: 10px 0;
            color: #15803d;
        }
        .error {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 10px 0;
            color: #dc2626;
        }
        .info {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 10px 0;
            color: #1e40af;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }
        th {
            background: #f3f4f6;
            font-weight: 600;
        }
        tr:hover {
            background: #f9fafb;
        }
        pre {
            background: #f9fafb;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 13px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px 5px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
        }
        .btn:hover {
            background: #1d4ed8;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-admin { background: #fee2e2; color: #dc2626; }
        .badge-librarian { background: #dbeafe; color: #1e40af; }
        .badge-student { background: #f3f4f6; color: #4b5563; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 User Creation Database Test</h1>
        <p><em>Testing database connectivity and user insertion</em></p>
        <p><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?> | <strong>User:</strong> leonlaborina15</p>

        <?php
        // Test 1: Database Connection
        echo "<h2>Test 1: Database Connection</h2>";
        if ($db instanceof PDO) {
            echo "<div class='success'>";
            echo "<strong>✅ Database connected successfully!</strong><br>";
            echo "Connection type: <code>PDO</code><br>";
            echo "Database name: <strong>elibrary_db</strong>";
            echo "</div>";
        } else {
            echo "<div class='error'>❌ Database connection failed</div>";
            exit;
        }

        // Test 2: Users Table Check
        echo "<h2>Test 2: Users Table Check</h2>";
        try {
            $stmt = $db->query("SELECT COUNT(*) FROM users");
            $count = $stmt->fetchColumn();
            echo "<div class='success'>✅ Users table exists</div>";
            echo "<div class='info'>📊 Total users in database: <strong>$count</strong></div>";
        } catch (Exception $e) {
            echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            exit;
        }

        // Test 3: List Current Users
        echo "<h2>Test 3: Current Users</h2>";
        try {
            $stmt = $db->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 10");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($users)) {
                echo "<div class='info'>⚠️ No users found in database</div>";
            } else {
                echo "<table>";
                echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th></tr></thead>";
                echo "<tbody>";
                foreach ($users as $u) {
                    $badgeClass = 'badge-' . $u['role'];
                    echo "<tr>";
                    echo "<td><strong>{$u['id']}</strong></td>";
                    echo "<td>" . htmlspecialchars($u['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($u['email']) . "</td>";
                    echo "<td><span class='badge $badgeClass'>" . ucfirst($u['role']) . "</span></td>";
                    echo "<td>" . date('M d, Y H:i', strtotime($u['created_at'])) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
        } catch (Exception $e) {
            echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }

        // Test 4: Try Creating Test User
        echo "<h2>Test 4: Create Test User (Main Test)</h2>";
        try {
            $testName = "Test User " . date('His');
            $testEmail = "test_" . time() . "@example.com";
            $testPassword = password_hash("test123", PASSWORD_DEFAULT);
            $testRole = "student";

            echo "<div class='info'>";
            echo "<strong>📝 Preparing test data:</strong><br>";
            echo "Name: <code>$testName</code><br>";
            echo "Email: <code>$testEmail</code><br>";
            echo "Password: <code>test123</code> (will be hashed)<br>";
            echo "Role: <code>$testRole</code>";
            echo "</div>";

            echo "<div class='info'>🔄 Executing INSERT query...</div>";

            $stmt = $db->prepare("
                INSERT INTO users (name, email, password, role, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");

            $result = $stmt->execute([$testName, $testEmail, $testPassword, $testRole]);

            if ($result) {
                $newId = $db->lastInsertId();

                echo "<div class='success'>";
                echo "<h3 style='margin: 0 0 10px 0;'>✅ SUCCESS!</h3>";
                echo "<p style='margin: 5px 0;'><strong>Test user created successfully!</strong></p>";
                echo "<ul>";
                echo "<li><strong>User ID:</strong> $newId</li>";
                echo "<li><strong>Name:</strong> $testName</li>";
                echo "<li><strong>Email:</strong> $testEmail</li>";
                echo "<li><strong>Role:</strong> $testRole</li>";
                echo "</ul>";
                echo "</div>";

                // Verify user exists
                $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$newId]);
                $newUser = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($newUser) {
                    echo "<div class='success'>✅ <strong>Verification passed:</strong> User exists in database</div>";

                    // Cleanup - delete test user
                    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                    if ($stmt->execute([$newId])) {
                        echo "<div class='info'>🗑️ <strong>Cleanup:</strong> Test user deleted successfully</div>";
                    }
                }

                echo "<div class='success' style='margin-top: 20px; padding: 20px;'>";
                echo "<h3 style='margin: 0 0 10px 0; color: #15803d;'>🎉 Database Test PASSED!</h3>";
                echo "<p style='margin: 5px 0;'><strong>Your database is working perfectly!</strong></p>";
                echo "<p style='margin: 15px 0 0 0; padding-top: 15px; border-top: 1px solid #86efac;'>";
                echo "<strong>✅ The database can create users successfully.</strong><br>";
                echo "The issue must be in the UserController or form.";
                echo "</p>";
                echo "</div>";

            } else {
                echo "<div class='error'>❌ FAILED: Database returned FALSE</div>";
            }

        } catch (PDOException $e) {
            echo "<div class='error'>";
            echo "<strong>❌ DATABASE ERROR</strong><br>";
            echo "<strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
            echo "<strong>Code:</strong> " . $e->getCode();
            echo "</div>";
        } catch (Exception $e) {
            echo "<div class='error'>";
            echo "<strong>❌ EXCEPTION</strong><br>";
            echo htmlspecialchars($e->getMessage());
            echo "</div>";
        }
        ?>

        <hr style="margin: 40px 0 30px 0;">

        <h2>🎯 Next Steps</h2>
        <div class="info">
            <p><strong>Now test the actual form:</strong></p>
            <ol>
                <li>Click "Go to Create User Form" below</li>
                <li>Fill in the form with test data</li>
                <li>Submit and see the debug output</li>
            </ol>
        </div>

        <div style="margin-top: 30px;">
            <a href="<?= BASE_URL ?>?route=users/create" class="btn">📝 Go to Create User Form</a>
            <a href="<?= BASE_URL ?>?route=users" class="btn">👥 View All Users</a>
        </div>
    </div>
</body>
</html>