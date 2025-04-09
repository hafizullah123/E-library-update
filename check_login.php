<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "library");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Language configuration
$lang = [
    'invalid_credentials' => 'Invalid username or password.',
    'welcome' => 'Welcome',
    'admin_dashboard' => 'Admin Dashboard',
    'labor_dashboard' => 'Labor Dashboard',
    'user_dashboard' => 'User Dashboard',
    'logout' => 'Logout',
];

// Handle the login functionality
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to check if the username or email exists
    $stmt = $conn->prepare("SELECT user_id, user_type FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username); // Check both username and email
    $stmt->execute();
    $stmt->bind_result($user_id, $user_type);
    $stmt->fetch();

    // Check if the user exists and the password matches
    if ($user_id) {
        // Password verification (you should hash passwords in real applications)
        if ($password) {
            // User found, set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['username'] = $username;

            // Redirect based on user type
            switch ($user_type) {
                case 'admin':
                    header("Location: dashboar.php");
                    break;
                case 'public_manager':
                    header("Location: add_book.php");
                    break;
                case 'labor':
                    header("Location: book.php");
                    break;
                case 'manager':
                    header("Location: add_book.php");
                    break;
                case 'user':
                    header("Location: downbook.php");
                    break;
                default:
                    header("Location: ?action=login");
                    break;
            }
            exit;
        } else {
            // Password is incorrect
            $login_error = $lang['invalid_credentials'];
        }
    } else {
        // No matching user found
        $login_error = $lang['invalid_credentials'];
    }

    $stmt->close();
}

// Handle the dashboard redirects based on user type
if (isset($_GET['dashboard'])) {
    switch ($_GET['dashboard']) {
        case 'admin':
            if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
                header("Location: ?action=login");
                exit;
            }
            echo "<h1>{$lang['welcome']}, " . $_SESSION['username'] . "!</h1>";
            echo "<p>{$lang['admin_dashboard']}</p>";
            echo '<a href="?action=logout">' . $lang['logout'] . '</a>';
            break;
        case 'labor':
            if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'labor') {
                header("Location: ?action=login");
                exit;
            }
            echo "<h1>{$lang['welcome']}, " . $_SESSION['username'] . "!</h1>";
            echo "<p>{$lang['labor_dashboard']}</p>";
            echo '<a href="?action=logout">' . $lang['logout'] . '</a>';
            break;
        case 'user':
            if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
                header("Location: ?action=login");
                exit;
            }
            echo "<h1>{$lang['welcome']}, " . $_SESSION['username'] . "!</h1>";
            echo "<p>{$lang['user_dashboard']}</p>";
            echo '<a href="?action=logout">' . $lang['logout'] . '</a>';
            break;
        default:
            header("Location: ?action=login");
            exit;
    }
    exit;
}

// Handle logout functionality
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?action=login");
    exit;
}
?>
