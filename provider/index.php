<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $username = htmlspecialchars($_SESSION['username']); // Sanitize username for display
    $message = "Welcome, $username!";
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: /login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="statics/styles.css">
</head>

<body>
    <div class="container">
        <center>
            <h2><?php echo $message; ?></h2>
        </center>
        <a href="/logout">Logout</a>
    </div>
</body>

</html>