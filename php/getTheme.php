<?php
//! written by claude/chatgpt lol
// Define an array of available themes with corresponding image URLs
$themes = [
    "umbrellas" => "https://utfs.io/f/9LyUqXIb9OlsszXJQOoNny1ZFStd4jUmrq7cxBIphXkCRKAY"
];

header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Allow requests from roblox for iframes
header_remove("X-Frame-Options");
header("Content-Security-Policy: frame-ancestors https://*.roblox.com");

// Get the 'theme' parameter from the URL
$theme = isset($_GET['theme']) ? $_GET['theme'] : null;

if ($theme === "get") {
    // Handle CORS
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
    if (strpos($origin, 'chrome-extension://') === 0) {
        header("Access-Control-Allow-Origin: $origin");
        header('Content-Type: application/json');
        echo json_encode($themes);
        exit;
    }
}

// Validate the theme and get the corresponding image URL
$imageUrl = isset($themes[$theme]) ? $themes[$theme] : null;

// If no valid theme is specified, display an error message
if (!$imageUrl) {
    echo "<p>Invalid theme specified.</p>";
    exit;
}

// Serve the iframe with the image
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Viewer</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div style="width: 100%; height: 100%; background-size: 100%; background-image: url(<?php echo $imageUrl; ?>);" id="theme"></div>
</body>
</html>
