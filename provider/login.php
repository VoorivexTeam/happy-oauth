<?php
session_start();

// Load credentials
$credentials = include 'credentials.php';

if (array_key_exists('logged_in', $_SESSION)) {
    if ($_SESSION['logged_in']) {
        // Redirect to the originally requested OAuth URL
        $redirectTo = '/';
        if (array_key_exists('next', $_GET)) {
            $redirectTo = $_GET['next'];
        }
        header("Location: $redirectTo");
        exit();
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Authenticate user
    if (isset($credentials[$username]) && $credentials[$username] === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        // Redirect to the originally requested OAuth URL
        $redirectTo = '/';
        if (array_key_exists('next', $_GET)) {
            $redirectTo = $_GET['next'];
        }
        header("Location: " . urldecode($redirectTo));
        exit();
    } else {
        $error = "Invalid credentials. Please try again.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OAuth Provider</title>
    <link rel="stylesheet" href="statics/styles.css">
</head>

<body>
    <div class="container">
        <center>
            <h2>OAuth Provider</h2>
        </center>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)): ?>
            <br>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>

</html>