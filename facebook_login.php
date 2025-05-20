<?php
// filepath: c:\xampp\htdocs\host-library\facebook_login.php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once 'connection.php'; // Your DB connection

// Replace with your real Facebook App credentials
$appId = 'YOUR_FACEBOOK_APP_ID';
$appSecret = 'YOUR_FACEBOOK_APP_SECRET';
$redirectUri = 'http://localhost/host-library/facebook_login.php';

$fb = new \Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v19.0',
]);

$helper = $fb->getRedirectLoginHelper();

if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}

try {
    if (isset($_GET['code'])) {
        $accessToken = $helper->getAccessToken($redirectUri);
        if (!isset($accessToken)) {
            throw new Exception('No access token');
        }
        $response = $fb->get('/me?fields=id,name,email,picture', $accessToken);
        $user = $response->getGraphUser();

        $email = $user->getEmail();
        $username = $user->getName();
        $facebook_id = $user->getId();

        // 1. Check if user exists in your library DB
        $stmt = $conn->prepare("SELECT user_id, user_type FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($user_id, $user_type);
        if ($stmt->fetch()) {
            // 2. User exists, log them in
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['username'] = $username;
        } else {
            // 3. User does not exist, create new user and log them in
            $stmt->close();
            $user_type = 'user'; // default type
            $stmt = $conn->prepare("INSERT INTO users (username, email, user_type, facebook_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $user_type, $facebook_id);
            $stmt->execute();
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['username'] = $username;
        }
        $stmt->close();
        $conn->close();

        // 4. Store Facebook info in session
        $_SESSION['email'] = $email;
        $_SESSION['picture'] = isset($user['picture']['url']) ? $user['picture']['url'] : '';
        $_SESSION['login_type'] = 'facebook';

        // 5. Redirect to your library dashboard or home
        header('Location: index.php');
        exit;
    } else {
        // Show Facebook login button
        $permissions = ['email'];
        $loginUrl = $helper->getLoginUrl($redirectUri, $permissions);
        echo "<div style='text-align:center;margin-top:60px;'>";
        echo "<a href='$loginUrl' style='
            display:inline-block;
            background:#1877f3;
            color:#fff;
            padding:12px 24px;
            border-radius:4px;
            font-size:18px;
            text-decoration:none;
            font-family:sans-serif;
        '>
            Login with Facebook
        </a>";
        echo "<p style='margin-top:30px;'><a href='login.php'>Back to Login</a></p>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<h2 style='text-align:center;margin-top:40px;'>Facebook authentication failed: " . htmlspecialchars($e->getMessage()) . "</h2>";
    echo "<p style='text-align:center;'><a href='login.php'>Back to Login</a></p>";
}