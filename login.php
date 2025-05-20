<?php
session_start();

include('connection.php');
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

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
        'login_google' => 'Login with Google',
        'login_facebook' => 'Login with Facebook',
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
        'login_google' => 'د ګوګل سره ننوتل',
        'login_facebook' => 'د فیسبوک سره ننوتل',
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
        'login_google' => 'ورود با گوگل',
        'login_facebook' => 'ورود با فیسبوک',
    ],
];
$lang = $lang_files[$lang_code];
$dir = ($lang_code == 'ps' || $lang_code == 'fa') ? 'rtl' : 'ltr';

// Registration logic
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $user_type = 'user';

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $register_error = $lang['username_or_email_exists'];
    } else {
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
            case 'manager':
                header("Location: add_book.php");
                break;
            case 'labor':
                header("Location: book.php");
                break;
            case 'user':
                header("Location: downbook.php");
                break;
            default:
                header("Location: ?action=login");
        }
        exit;
    } else {
        $login_error = $lang['invalid_credentials'];
    }

    $stmt->close();
}

if (isset($_GET['dashboard'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ?action=login");
        exit;
    }

    echo "<div class='p-8'>";
    echo "<h1 class='text-2xl font-bold mb-4'>{$lang['welcome']}, " . $_SESSION['username'] . "!</h1>";

    switch ($_GET['dashboard']) {
        case 'admin':
            if ($_SESSION['user_type'] !== 'admin') { header("Location: ?action=login"); exit; }
            echo "<p>{$lang['admin_dashboard']}</p>";
            break;
        case 'labor':
            if ($_SESSION['user_type'] !== 'labor') { header("Location: ?action=login"); exit; }
            echo "<p>{$lang['labor_dashboard']}</p>";
            break;
        case 'user':
            if ($_SESSION['user_type'] !== 'user') { header("Location: ?action=login"); exit; }
            echo "<p>{$lang['user_dashboard']}</p>";
            break;
        default:
            header("Location: ?action=login");
            exit;
    }
    echo "<a href='?action=logout' class='text-blue-500 hover:underline block mt-4'>{$lang['logout']}</a>";
    echo "</div>";
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?action=login");
    exit;
}
$show_register = isset($_GET['action']) && $_GET['action'] === 'register';
?>
<!DOCTYPE html>
<html lang="en" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans" dir="<?= $dir ?>">

<nav class="bg-white shadow p-4 mb-6 flex justify-between">
    <div class="flex gap-4">
        <a href="?lang=en" class="text-blue-600 hover:underline">English</a>
        <a href="?lang=ps" class="text-blue-600 hover:underline">Pashto</a>
        <a href="?lang=fa" class="text-blue-600 hover:underline">Dari</a>
    </div>
    <div class="flex gap-4">
        <a href="?action=login" class="text-blue-600 hover:underline"><?= $lang['login'] ?></a>
        <a href="?action=register" class="text-blue-600 hover:underline"><?= $lang['register'] ?></a>
    </div>
</nav>

<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
    <h2 class="text-2xl font-semibold mb-4"><?= $lang['title'] ?></h2>

    <?php if (isset($login_error)): ?>
        <p class="text-red-500 mb-2"><?= $login_error ?></p>
    <?php endif; ?>

    <?php if (isset($register_error)): ?>
        <p class="text-red-500 mb-2"><?= $register_error ?></p>
    <?php endif; ?>

    <?php if (isset($register_success)): ?>
        <p class="text-green-500 mb-2"><?= $register_success ?></p>
    <?php endif; ?>

    <?php if (!$show_register): ?>
        <!-- Login Form -->
        <form method="post" class="mb-6">
            <input type="hidden" name="action" value="login">
            <div class="mb-4">
                <label class="block font-bold mb-1"><?= $lang['username'] ?></label>
                <input type="text" name="username" class="w-full border border-gray-300 p-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-1"><?= $lang['password'] ?></label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                <?= $lang['login_button'] ?>
            </button>
        </form>
    <?php else: ?>
        <!-- Register Form -->
        <form method="post">
            <input type="hidden" name="action" value="register">
            <div class="mb-4">
                <label class="block font-bold mb-1"><?= $lang['username'] ?></label>
                <input type="text" name="username" class="w-full border border-gray-300 p-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-1"><?= $lang['email'] ?></label>
                <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-1"><?= $lang['password'] ?></label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded">
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                <?= $lang['register_button'] ?>
            </button>
        </form>
    <?php endif; ?>

    <!-- Social Login Buttons -->
    <div class="flex flex-col gap-2 mb-4">
        <a href="google_login.php" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48"><g><path fill="#4285F4" d="M44.5 20H24v8.5h11.7C34.1 32.9 29.7 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.1 8.1 2.9l6.1-6.1C34.5 6.2 29.5 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20c11 0 20-8.9 20-20 0-1.3-.1-2.7-.3-4z"/><path fill="#34A853" d="M6.3 14.7l7 5.1C15.5 16.1 19.4 13 24 13c3.1 0 5.9 1.1 8.1 2.9l6.1-6.1C34.5 6.2 29.5 4 24 4c-7.4 0-13.7 4.1-17.1 10.1l-.6.6z"/><path fill="#FBBC05" d="M24 44c5.5 0 10.5-2.1 14.3-5.7l-6.6-5.4C29.6 34.9 26.9 36 24 36c-5.7 0-10.1-3.1-11.7-7.5l-7 5.4C10.3 41.9 16.6 44 24 44z"/><path fill="#EA4335" d="M44.5 20H24v8.5h11.7c-1.2 3.2-4.1 5.5-7.7 5.5-5.7 0-10.1-3.1-11.7-7.5l-7 5.4C10.3 41.9 16.6 44 24 44c11 0 20-8.9 20-20 0-1.3-.1-2.7-.3-4z"/></g></svg>
            <?= isset($lang['login_google']) ? $lang['login_google'] : 'Login with Google' ?>
        </a>
        <a href="facebook_login.php" class="bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24"><path fill="#fff" d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.408.595 24 1.325 24H12.82v-9.294H9.692v-3.622h3.127V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.408 24 22.674V1.326C24 .592 23.406 0 22.675 0"/></svg>
            <?= isset($lang['login_facebook']) ? $lang['login_facebook'] : 'Login with Facebook' ?>
        </a>
    </div>
</div>

</body>
</html>
