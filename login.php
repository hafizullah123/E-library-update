<?php
session_start();
include 'connection.php';

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';

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

// Registration logic
if ($_POST['action'] ?? '' === 'register') {
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
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $user_type);
        $stmt->execute();
        $register_success = ($stmt->affected_rows > 0) ? $lang['registration_successful'] : $lang['registration_failed'];
    }
    $stmt->close();
}

// Login logic
if ($_POST['action'] ?? '' === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, user_type, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $user_type, $hashed_password);
    $stmt->fetch();

    if ($user_id && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_type'] = $user_type;
        $_SESSION['username'] = $username;

        $redirects = [
            'admin' => 'dashboard.php',
            'public_manager' => 'add_book.php',
            'manager' => 'add_book.php',
            'entry' => 'add_paper_entry.php',
            'labor' => 'book.php',
            'user' => 'downbook.php'
        ];
        header("Location: " . ($redirects[$user_type] ?? "?action=login"));
        exit;
    } else {
        $login_error = $lang['invalid_credentials'];
    }
    $stmt->close();
}

// Logout
if ($_GET['action'] ?? '' === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?action=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans" style="direction: <?= $dir ?>;">
    <nav class="bg-white shadow p-4 flex justify-end space-x-4 rtl:space-x-reverse">
    <a href="register.php" class="text-blue-600 hover:underline">Register</a>
        <a href="?lang=en" class="text-blue-600 hover:underline">English</a>
        <a href="?lang=ps" class="text-blue-600 hover:underline">Pashto</a>
        <a href="?lang=fa" class="text-blue-600 hover:underline">Dari</a>
    </nav>

    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-center">
            <?= ($_GET['action'] ?? '') === 'register' ? $lang['register'] : $lang['login'] ?>
        </h2>

        <?php if (!empty($login_error)): ?>
            <p class="text-red-500 mb-2 text-sm"><?= $login_error ?></p>
        <?php endif; ?>
        <?php if (!empty($register_error)): ?>
            <p class="text-red-500 mb-2 text-sm"><?= $register_error ?></p>
        <?php endif; ?>
        <?php if (!empty($register_success)): ?>
            <p class="text-green-500 mb-2 text-sm"><?= $register_success ?></p>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="action" value="<?= $_GET['action'] ?? 'login' ?>">

            <div>
                <label class="block font-semibold mb-1"><?= $lang['username'] ?>:</label>
                <input type="text" name="username" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring">
            </div>

            <?php if (($_GET['action'] ?? '') === 'register'): ?>
                <div>
                    <label class="block font-semibold mb-1"><?= $lang['email'] ?>:</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring">
                </div>
            <?php endif; ?>

            <div>
                <label class="block font-semibold mb-1"><?= $lang['password'] ?>:</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring">
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    <?= ($_GET['action'] ?? '') === 'register' ? $lang['register_button'] : $lang['login_button'] ?>
                </button>
            </div>
        </form>

        <div class="text-center mt-4 text-sm">
            <?php if (($_GET['action'] ?? '') === 'register'): ?>
                <p><?= $lang['already_have_account'] ?> <a href="?action=login" class="text-blue-600 hover:underline"><?= $lang['login_here'] ?></a></p>
            <?php else: ?>
                <p><?= $lang['dont_have_account'] ?> <a href="?action=register" class="text-blue-600 hover:underline"><?= $lang['register_here'] ?></a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
