<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="statics/styles.css">
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            console.log("Document is ready!");

            // Add a click event to the login button
            const loginButton = document.getElementById('login-oauth');
            if (loginButton) {
                loginButton.onclick = () => {
                    const link = loginButton.getAttribute('data-link');
                    if (link) {
                        window.location.href = link;
                    }
                };
            }
        });
    </script>
</head>

<body>
    <div class="container">
        <h1>Voorivex Website</h1>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="/logout">Logout</a>
        <?php else: ?>
            <div class="button" id="login-oauth" data-link="<?php echo getenv('PROVIDER'); ?>/oauth?redirect_uri=<?php echo urlencode(getenv('SITE') . '/callback'); ?>&response_type=token&application_id=574a33452ec5e4fc2bfa60d049a70c57">
                Login with X
            </div>
        <?php endif; ?>
    </div>
</body>

</html>