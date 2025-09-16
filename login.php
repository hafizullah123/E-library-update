<?php
session_start();
include('connection.php');

// Language selection
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// Language texts
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
$dir = ($lang_code == 'ps' || $lang_code == 'fa') ? 'rtl' : 'ltr';

// ---------- Registration ----------
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $email = trim($_POST['email']);
    $default_role_id = 1; // user role

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $register_error = $lang['username_or_email_exists'];
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $password, $email, $default_role_id);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['role_id'] = $default_role_id;
            $register_success = $lang['registration_successful'];
        } else {
            $register_error = $lang['registration_failed'];
        }
    }
    $stmt->close();
}

// ---------- Login ----------
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("
        SELECT u.user_id, u.password, u.username, r.role_name, r.role_id
        FROM users u
        JOIN roles r ON u.role_id = r.role_id
        WHERE u.username = ?
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $db_username, $role_name, $role_id);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['role_id'] = $role_id;
            $_SESSION['role_name'] = $role_name;

            // Redirect by role
            switch (strtolower($role_name)) {
                case 'admin': header("Location: dashboar.php"); break;
                case 'manager':
                case 'public_manager': header("Location: add_book.php"); break;
                case 'labor': header("Location: book.php"); break;
                case 'user': header("Location: downbook.php"); break;
                default: header("Location: ?action=login");
            }
            exit;
        } else {
            $login_error = $lang['invalid_credentials'];
        }
    } else {
        $login_error = $lang['invalid_credentials'];
    }
    $stmt->close();
}

$show_register = isset($_GET['action']) && $_GET['action'] === 'register';
?>
<!DOCTYPE html>
<html lang="en" dir="<?= $dir ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $lang['title'] ?></title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col justify-center items-center">

<nav class="w-full max-w-2xl mx-auto bg-white shadow p-4 mb-8 rounded-lg flex flex-col sm:flex-row justify-between items-center gap-2">
    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
        <a href="?lang=en" class="text-blue-600 hover:underline text-center">English</a>
        <a href="?lang=ps" class="text-blue-600 hover:underline text-center">Pashto</a>
        <a href="?lang=fa" class="text-blue-600 hover:underline text-center">Dari</a>
    </div>
    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
        <a href="?action=login" class="text-blue-600 hover:underline text-center"><?= $lang['login'] ?></a>
        <a href="?action=register" class="text-blue-600 hover:underline text-center"><?= $lang['register'] ?></a>
    </div>
</nav>

<main class="w-full max-w-md mx-auto">
<div class="bg-white rounded-xl shadow-md overflow-hidden p-8 sm:p-10">
    <h2 class="text-2xl font-semibold mb-6 text-center"><?= $lang['title'] ?></h2>

    <?php if(isset($login_error)) echo "<p class='text-red-500 mb-4 text-center'>{$login_error}</p>"; ?>
    <?php if(isset($register_error)) echo "<p class='text-red-500 mb-4 text-center'>{$register_error}</p>"; ?>
    <?php if(isset($register_success)) echo "<p class='text-green-500 mb-4 text-center'>{$register_success}</p>"; ?>

    <?php if(!$show_register): ?>
        <!-- Login Form -->
        <form method="post" class="space-y-5">
            <input type="hidden" name="action" value="login">
            <div>
                <label class="block font-bold mb-1"><?= $lang['username'] ?></label>
                <input type="text" name="username" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-bold mb-1"><?= $lang['password'] ?></label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded"><?= $lang['login_button'] ?></button>
        </form>
        <div class="text-center mt-6">
            <span><?= $lang['dont_have_account'] ?></span>
            <a href="?action=register" class="text-blue-600 hover:underline ml-2"><?= $lang['register_here'] ?></a>
        </div>
    <?php else: ?>
        <!-- Register Form -->
        <form method="post" class="space-y-5">
            <input type="hidden" name="action" value="register">
            <div>
                <label><?= $lang['username'] ?></label>
                <input type="text" name="username" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label><?= $lang['email'] ?></label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label><?= $lang['password'] ?></label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded"><?= $lang['register_button'] ?></button>
        </form>
        <div class="text-center mt-6">
            <span><?= $lang['already_have_account'] ?></span>
            <a href="?action=login" class="text-blue-600 hover:underline ml-2"><?= $lang['login_here'] ?></a>
        </div>
    <?php endif; ?>
</div>
</main>
</body>
</html>
