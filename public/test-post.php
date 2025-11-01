<?php
session_start();
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/e-lib/public/');
?>
<!DOCTYPE html>
<html>
<head>
    <title>POST Test</title>
</head>
<body>
    <h2>POST Request Test</h2>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div style="background: #dcfce7; padding: 20px; border: 2px solid #22c55e; margin: 20px 0;">
            <h3>✅ POST Request Received!</h3>
            <pre><?php print_r($_POST); ?></pre>
        </div>
    <?php else: ?>
        <p>Fill this form and submit to test POST:</p>
    <?php endif; ?>

    <form method="POST" action="test-post.php">
        <p>
            <label>Name:</label><br>
            <input type="text" name="name" required>
        </p>
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </p>
        <p>
            <button type="submit">Test POST Submit</button>
        </p>
    </form>
</body>
</html>