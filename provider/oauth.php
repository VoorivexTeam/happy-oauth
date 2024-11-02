<?php
session_start();

// Start output buffering to control output location
ob_start();

// Define the path for the tokens database
$tokensFilePath = './db/tokens.json';
if (!file_exists($tokensFilePath)) {
    file_put_contents($tokensFilePath, json_encode([])); // Initialize the file if it doesn't exist
}

// Load existing tokens
$tokens = json_decode(file_get_contents($tokensFilePath), true);

// Define valid application ID and application secret for verification
$validApplicationID = '574a33452ec5e4fc2bfa60d049a70c57';
$validApplicationSecret = 'dc0b52fcf4a6eb8dc329b562236dcea6'; // Replace with your actual application secret

$errorMessage = ''; // Initialize an empty error message

// Check if this is an API call to validate token only
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'validate_token') {
    // Ensure application_secret is provided and correct
    if (!isset($_POST['application_secret']) || $_POST['application_secret'] !== $validApplicationSecret) {
        echo json_encode(['status' => false, 'message' => 'Invalid application secret']);
        exit;
    }

    // Check if token is provided
    if (!isset($_POST['token'])) {
        echo json_encode(['status' => false, 'message' => 'Token required']);
        exit;
    }

    $token = $_POST['token'];

    // Search for the token in the tokens database
    $username = array_search($token, $tokens);

    if ($username !== false) {
        unset($tokens[$username]);
        file_put_contents($tokensFilePath, json_encode($tokens)); // Save updated
        // Token is valid, return true and the associated username
        echo json_encode(['status' => true, 'username' => $username]);
    } else {
        // Token is invalid
        echo json_encode(['status' => false, 'message' => 'Invalid token']);
    }
    exit;
}

// Normal OAuth flow
// Get query parameters
$redirectUri = $_GET['redirect_uri'] ?? '';
$responseType = $_GET['response_type'] ?? '';
$applicationId = $_GET['application_id'] ?? '';

// Define valid redirect URIs (update as per your setup)
$validRedirectURI = getenv('SITE') . '/callback';

try {
    // Validate the redirect URI and application ID
    if (rtrim($redirectUri, '/') !== $validRedirectURI) {
        throw new Exception("Redirect URI mismatch");
    }

    if ($applicationId !== $validApplicationID) {
        throw new Exception("Application ID mismatch");
    }

    // Check if the user is logged in
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        $_SESSION['next'] = $_SERVER['REQUEST_URI'];
        header("Location: /login?next=" . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }

    // Generate a mock access token (in a real app, this would be more secure)
    $username = $_SESSION['username']; // Assuming username is stored in session
    $token = bin2hex(random_bytes(16));

    // Store the token in tokens.json, ensuring one token per user
    $tokens[$username] = $token;
    file_put_contents($tokensFilePath, json_encode($tokens));

    // Redirect to the redirect URI with the token if logged in
    if ($responseType === 'token') {
        header("Location: $redirectUri?token=$token");
        exit;
    } else {
        throw new Exception("Unsupported response type");
    }
} catch (TypeError $e) {
    $errorMessage = 'A type error has occurred: ' . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    $errorMessage = 'An error has occurred: ' . htmlspecialchars($e->getMessage());
}

// Get the contents of the output buffer and clean it
$output = ob_get_clean();
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
        <?php if ($errorMessage): ?>
            <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
    </div>
</body>

</html>