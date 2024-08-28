<?php
session_start();

// Define constants
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'library');

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set language
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// Load language file
$lang_files = [
    'en' => [
        'title' => 'Login and Registration',
        'login' => 'Login',
        'register' => 'Register',
        'username' => 'Username',
        'password' => 'Password',
        'email' => 'Email',
        'register_button' => 'Register',
        'login_button' => 'Login',
        'already_have_account' => 'Already have an account?',
        'dont_have_account' => "Don't have an account?",
        'login_here' => 'Login here',
        'register_here' => 'Register here',
        'registration_successful' => 'Registration successful. Please log in.',
        'registration_failed' => 'Registration failed. Please try again.',
        'username_or_email_exists' => 'Username or email already exists.',
        'invalid_credentials' => 'Invalid username or password.',
        'logout' => 'Logout',
        'welcome' => 'Welcome',
        'admin_dashboard' => 'This is the admin dashboard.',
        'labor_dashboard' => 'This is the labor dashboard.',
        'user_dashboard' => 'This is the user dashboard.',
    ],
    'ps' => [
        'title' => 'ننوتل او ثبتول',
        'login' => 'ننوتل',
        'register' => 'ثبتول',
        'username' => 'کارن نوم',
        'password' => 'پاسورډ',
        'email' => 'بریښنالیک',
        'register_button' => 'ثبتول',
        'login_button' => 'ننوتل',
        'already_have_account' => 'آیا حساب لرئ؟',
        'dont_have_account' => 'حساب نلرئ؟',
        'login_here' => 'دلته ننوتل',
        'register_here' => 'دلته ثبتول',
        'registration_successful' => 'ثبتول بریالي. مهرباني وکړئ ننوتل.',
        'registration_failed' => 'ثبتول ناکام. مهرباني وکړئ بیا هڅه وکړئ.',
        'username_or_email_exists' => 'کارن نوم یا بریښنالیک دمخه شتون لري.',
        'invalid_credentials' => 'کارن نوم یا پاسورډ غلط دي.',
        'logout' => 'وتل',
        'welcome' => 'ښه راغلاست',
        'admin_dashboard' => 'دا د مدیر ډشبورډ دی.',
        'labor_dashboard' => 'دا د کارګر ډشبورډ دی.',
        'user_dashboard' => 'دا د کارونکي ډشبورډ دی.',
    ],
    'fa' => [
        'title' => 'ورود و ثبت نام',
        'login' => 'ورود',
        'register' => 'ثبت نام',
        'username' => 'نام کاربری',
        'password' => 'رمز عبور',
        'email' => 'ایمیل',
        'register_button' => 'ثبت نام',
        'login_button' => 'ورود',
        'already_have_account' => 'حساب کاربری دارید؟',
        'dont_have_account' => 'حساب کاربری ندارید؟',
        'login_here' => 'ورود کنید',
        'register_here' => 'ثبت نام کنید',
        'registration_successful' => 'ثبت نام موفقیت آمیز بود. لطفا وارد شوید.',
        'registration_failed' => 'ثبت نام ناموفق بود. لطفا دوباره امتحان کنید.',
        'username_or_email_exists' => 'نام کاربری یا ایمیل وجود دارد.',
        'invalid_credentials' => 'نام کاربری یا رمز عبور نامعتبر است.',
        'logout' => 'خروج',
        'welcome' => 'خوش آمدید',
        'admin_dashboard' => 'این داشبورد مدیریت است.',
        'labor_dashboard' => 'این داشبورد کارگر است.',
        'user_dashboard' => 'این داشبورد کاربر است.',
    ],
];

$lang = $lang_files[$lang_code];

// Determine text direction
$dir = ($lang_code == 'ps' || $lang_code == 'fa') ? 'rtl' : 'ltr';

// Registration logic
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $user_type = 'user'; // Default user type

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $register_error = $lang['username_or_email_exists'];
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $user_type);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $register_success = $lang['registration_successful'];
        } else {
            $register_error = $lang['registration_failed'];
        }
    }

    $stmt->close();
}

// Login logic
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, user_type FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($user_id, $user_type);
    $stmt->fetch();

    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_type'] = $user_type;
        $_SESSION['username'] = $username;

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
        $login_error = $lang['invalid_credentials'];
    }

    $stmt->close();
}

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

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?action=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="<?php echo $dir; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['title']; ?></title>
    <link rel="stylesheet" href="login.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: <?php echo $dir; ?>;
        }
        .navbar {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            padding: 10px;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
        }
        .navbar li {
            margin-left: 20px;
        }
        .navbar a {
            text-decoration: none;
            color: #007bff;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: #fff;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .form-group button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .form-footer {
            margin-top: 10px;
            text-align: center;
        }
        .form-footer p {
            margin: 5px 0;
        }
        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <ul>
                <li><a href="?lang=en">English</a></li>
                <li><a href="?lang=ps">Pashto</a></li>
                <li><a href="?lang=fa">Dari</a></li>
            </ul>
        </nav>

        <h2><?php echo isset($_GET['action']) && $_GET['action'] == 'register' ? $lang['register'] : $lang['login']; ?></h2>

        <?php if (isset($login_error)): ?>
            <p class="error"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <?php if (isset($register_error)): ?>
            <p class="error"><?php echo $register_error; ?></p>
        <?php endif; ?>
        <?php if (isset($register_success)): ?>
            <p class="success"><?php echo $register_success; ?></p>
        <?php endif; ?>

        <form action="?" method="post">
            <?php if (isset($_GET['action']) && $_GET['action'] == 'register'): ?>
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="username"><?php echo $lang['username']; ?>:</label>
                    <input type="text" name="username" id="username" placeholder="<?php echo $lang['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password"><?php echo $lang['password']; ?>:</label>
                    <input type="password" name="password" id="password" placeholder="<?php echo $lang['password']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email"><?php echo $lang['email']; ?>:</label>
                    <input type="email" name="email" id="email" placeholder="<?php echo $lang['email']; ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit"><?php echo $lang['register_button']; ?></button>
                </div>
                <div class="form-footer">
                    <p><?php echo $lang['already_have_account']; ?> <a href="?action=login"><?php echo $lang['login_here']; ?></a></p>
                </div>
            <?php else: ?>
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="username"><?php echo $lang['username']; ?>:</label>
                    <input type="text" name="username" id="username" placeholder="<?php echo $lang['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password"><?php echo $lang['password']; ?>:</label>
                    <input type="password" name="password" id="password" placeholder="<?php echo $lang['password']; ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit"><?php echo $lang['login_button']; ?></button>
                </div>
                <div class="form-footer">
                    <p><?php echo $lang['dont_have_account']; ?> <a href="?action=register"><?php echo $lang['register_here']; ?></a></p>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
