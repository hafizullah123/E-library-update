<?php
session_start();

// Translation content
$translations = [
    'en' => [
        'title' => 'Register',
        'username' => 'Username',
        'password' => 'Password',
        'email' => 'Email',
        'register_button' => 'Register',
        'select_lang' => 'Select Language'
    ],
    'ps' => [
        'title' => 'راجسټر',
        'username' => 'کارن نوم',
        'password' => 'پاسورډ',
        'email' => 'بریښنالیک',
        'register_button' => 'راجسټر',
        'select_lang' => 'ژبه وټاکئ'
    ],
    'fa' => [
        'title' => 'ثبت نام',
        'username' => 'نام کاربری',
        'password' => 'رمز عبور',
        'email' => 'ایمیل',
        'register_button' => 'ثبت نام',
        'select_lang' => 'زبان را انتخاب کنید'
    ]
];

// Language selection logic
$lang_code = 'en';
if (isset($_GET['lang'])) {
    $lang_code = $_GET['lang'];
    $_SESSION['lang'] = $lang_code;
} elseif (isset($_SESSION['lang'])) {
    $lang_code = $_SESSION['lang'];
}

$lang = $translations[$lang_code] ?? $translations['en'];
$is_rtl = in_array($lang_code, ['ps', 'fa']);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>" dir="<?php echo $is_rtl ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['title']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            padding: 40px;
            max-width: 400px;
            margin: auto;
            border-radius: 10px;
            background-color: #ffffff;
            direction: <?php echo $is_rtl ? 'rtl' : 'ltr'; ?>;
            text-align: <?php echo $is_rtl ? 'right' : 'left'; ?>;
        }
        h2 {
            text-align: center;
        }
        input, button, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        select {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <!-- Language Dropdown -->
    <form method="get">
        <select name="lang" onchange="this.form.submit()">
            <option value="en" <?php if ($lang_code == 'en') echo 'selected'; ?>>English</option>
            <option value="ps" <?php if ($lang_code == 'ps') echo 'selected'; ?>>پښتو</option>
            <option value="fa" <?php if ($lang_code == 'fa') echo 'selected'; ?>>دری</option>
        </select>
    </form>

    <!-- Register Form -->
    <h2><?php echo $lang['title']; ?></h2>
    <form action="save_register.php" method="post">
        <input type="text" name="username" placeholder="<?php echo $lang['username']; ?>" required>
        <input type="email" name="email" placeholder="<?php echo $lang['email']; ?>" required>
        <input type="password" name="password" placeholder="<?php echo $lang['password']; ?>" required>
        <button type="submit"><?php echo $lang['register_button']; ?></button>
    </form>
</body>
</html>
