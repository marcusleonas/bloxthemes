<?php
//! written by claude/chatgpt lol
//! Please note that updating this WILL NOT update the API automatically. I will need to FTP it to my server.
//! (sorry)
// Define an array of available themes with corresponding image URLs
$themes = [
    "umbrellas" => "https://utfs.io/f/9LyUqXIb9OlsszXJQOoNny1ZFStd4jUmrq7cxBIphXkCRKAY",
    "bridge" => "https://shpnjos4je.ufs.sh/f/9LyUqXIb9OlsBkYxG79ZckmlH6X5JPKBtxiNLrhA1YzjwVd7",
    "palm trees" => "https://shpnjos4je.ufs.sh/f/9LyUqXIb9OlsZB7ClutVIjogAxfbz4dvacJ8FnCy9DYruLWT",
    "mountains" => "https://shpnjos4je.ufs.sh/f/9LyUqXIb9Ols4GjBpliSWkcG0Rhqu2lpwiKgjAOnx9ea6m8D",
    "forest" => "https://shpnjos4je.ufs.sh/f/9LyUqXIb9OlsFPRCIeSMOo4SDEZjIJdtNla3kgwrG2hupYn0",
    "city lights" => "https://shpnjos4je.ufs.sh/f/9LyUqXIb9Ols8bP2jMw1Unc7mAMJpB0Zwoq9dhRCF3HTigfk",
    "sunset beach" => "https://shpnjos4je.ufs.sh/f/9LyUqXIb9OlsbXY7VgHoilUGNFXCZ8AnaDpPjJythswRWe9Q"
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
