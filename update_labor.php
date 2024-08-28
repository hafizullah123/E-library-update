<?php
session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'library');

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the language
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
} elseif (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

$lang = $_SESSION['lang'];

// Language arrays
$lang_en = [
    'UPDATE_LABOR' => 'Update Labor',
    'USERNAME' => 'Username',
    'EMAIL' => 'Email',
    'PASSWORD' => 'Password',
    'UPDATE' => 'Update',
    'CANCEL' => 'Cancel',
    'HOME' => 'Home'
];

$lang_ps = [
    'UPDATE_LABOR' => 'د کار تازه کول',
    'USERNAME' => 'کارنوم',
    'EMAIL' => 'بریښنالیک',
    'PASSWORD' => 'پټ',
    'UPDATE' => 'تازه کول',
    'CANCEL' => 'لغوه کول',
    'HOME' => 'کور'
];

$lang_fa = [
    'UPDATE_LABOR' => 'به‌روزرسانی کارگر',
    'USERNAME' => 'نام کاربری',
    'EMAIL' => 'ایمیل',
    'PASSWORD' => 'رمز عبور',
    'UPDATE' => 'به‌روزرسانی',
    'CANCEL' => 'لغو',
    'HOME' => 'خانه'
];

// Include language files based on selected language
switch ($lang) {
    case 'ps':
        $lang = $lang_ps;
        break;
    case 'fa':
        $lang = $lang_fa;
        break;
    default:
        $lang = $lang_en;
}

// Fetch user details for update
$user_id = $_GET['user_id'] ?? null;
if (!$user_id) {
    header("Location: labor_management.php");
    exit;
}

$stmt = $conn->prepare("SELECT username, email FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $new_username, $new_email, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: labor_managment.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>" dir="<?php echo ($_SESSION['lang'] == 'ps' || $_SESSION['lang'] == 'fa') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['UPDATE_LABOR']; ?></title>
    <link rel="stylesheet" href="designl2.css"> <!-- Check this path -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: <?php echo ($_SESSION['lang'] == 'ps' || $_SESSION['lang'] == 'fa') ? 'right' : 'left'; ?>;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        nav ul li a.active {
            font-weight: bold;
        }
        .container {
            width: 40%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form input[type="text"], form input[type="email"], form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        form button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        form button:hover {
            background-color: #45a049;
        }
        form a {
            color: #f44336;
            text-decoration: none;
            margin-top: 10px;
        }
        form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2><?php echo $lang['UPDATE_LABOR']; ?></h2>
        <form action="" method="post">
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="password" name="password" placeholder="<?php echo $lang['PASSWORD']; ?>" required>
            <button type="submit"><?php echo $lang['UPDATE']; ?></button>
            <a href="labor_managment.php"><?php echo $lang['CANCEL']; ?></a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
