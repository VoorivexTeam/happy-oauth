<?php
// Get the current full URL to display in the iframe
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$encodedUrl = urlencode($currentUrl);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Not Found</title>
    <link rel="stylesheet" href="/statics/styles.css">
</head>
<body>
    <div class="container">
        <img src="/statics/sad.jpg" alt="Sad Image" class="sad-image">
        <h1>Error has occurred</h1>
        <p>The page you are looking for cannot be found.</p>
    </div>
    <iframe id="urlFrame" src="<?=getenv('SANDBOX') . '/?debug=' . $encodedUrl;?>"></iframe>
</body>
</html>