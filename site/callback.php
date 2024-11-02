<?php
session_start();
// Start output buffering to control output location
ob_start();

$errorMessage = ''; // Initialize an empty error message
$successMessage = ''; // Initialize an empty success message

// Check if the token is provided in the URL
if (!isset($_GET['token'])) {
    $errorMessage = "Error: Token is missing from the URL.";
} else {
    // Retrieve the token from the URL
    $token = $_GET['token'];

    // Define the OAuth endpoint
    $oauthUrl = 'http://provider/oauth';

    // Define the required data
    $data = [
        'action' => 'validate_token',
        'token' => $token, // Use the token from the URL
        'application_secret' => 'dc0b52fcf4a6eb8dc329b562236dcea6' // Replace with the actual application secret
    ];

    // Initialize cURL
    $ch = curl_init($oauthUrl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $errorMessage = 'Request Error: ' . curl_error($ch);
    } else {
        // Decode the JSON response
        $result = json_decode($response, true);

        // Check if the token was valid and revoked
        if ($result['status'] === true) {
            $successMessage = "Logged in successfully. Please wait while you are being redirected...";
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $result['username'];
        } else {
            $errorMessage = "Error: " . $result['message'];
        }
    }

    // Close cURL session
    curl_close($ch);
}

// Get the contents of the output buffer and clean it
$output = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Token Validation</title>
    <link rel="stylesheet" href="statics/styles.css">
</head>

<body>
    <div class="container">
        <?php if ($errorMessage): ?>
            <?php echo htmlspecialchars($errorMessage); ?>
        <?php elseif ($successMessage): ?>
            <?= htmlspecialchars($successMessage); ?>
            <script>window.location.href = './'</script>
        <?php endif; ?>
    </div>
</body>

</html>