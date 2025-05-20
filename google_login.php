<?php
// filepath: c:\xampp\htdocs\host-library\google_login.php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

// Replace with your credentials from Google Cloud Console
$clientID = '1234567890-abc123def456.apps.googleusercontent.com';
$clientSecret = 'ABCDefGhIjKlMnOpQrStUvWx';
$redirectUri = 'http://localhost/host-library/google_login.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        // Store user info in session
        $_SESSION['user_id'] = $userInfo->id;
        $_SESSION['username'] = $userInfo->name;
        $_SESSION['email'] = $userInfo->email;
        $_SESSION['picture'] = $userInfo->picture;
        $_SESSION['login_type'] = 'google';

        header('Location: index.php');
        exit;
    } else {
        echo "<h2 style='text-align:center;margin-top:40px;'>Google authentication failed.</h2>";
        echo "<p style='text-align:center;'><a href='login.php'>Back to Login</a></p>";
        exit;
    }
} else {
    $loginUrl = $client->createAuthUrl();
    echo "<div style='text-align:center;margin-top:60px;'>";
    echo "<a href='$loginUrl' style='
        display:inline-block;
        background:#4285F4;
        color:#fff;
        padding:12px 24px;
        border-radius:4px;
        font-size:18px;
        text-decoration:none;
        font-family:sans-serif;
    '>
        Login with Google
    </a>";
    echo "<p style='margin-top:30px;'><a href='login.php'>Back to Login</a></p>";
    echo "</div>";
}