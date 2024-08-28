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
    'LABOR_MANAGEMENT' => 'Labor Management',
    'USERNAME' => 'Username',
    'EMAIL' => 'Email',
    'ACTIONS' => 'Actions',
    'UPDATE' => 'Update',
    'DELETE' => 'Delete',
    'DELETE_CONFIRM' => 'Are you sure you want to delete this record?',
    'HOME' => 'Home'
];

$lang_ps = [
    'LABOR_MANAGEMENT' => 'د کار مدیریت',
    'USERNAME' => 'کارنوم',
    'EMAIL' => 'بریښنالیک',
    'ACTIONS' => 'عملیات',
    'UPDATE' => 'تازه کول',
    'DELETE' => 'ړنګول',
    'DELETE_CONFIRM' => 'آیا تاسو مطمئن یاست چې دا ریکارډ ړنګول کړئ؟',
    'HOME' => 'کور'
];

$lang_fa = [
    'LABOR_MANAGEMENT' => 'مدیریت کارگر',
    'USERNAME' => 'نام کاربری',
    'EMAIL' => 'ایمیل',
    'ACTIONS' => 'عملیات',
    'UPDATE' => 'به‌روزرسانی',
    'DELETE' => 'حذف',
    'DELETE_CONFIRM' => 'آیا مطمئن هستید که می‌خواهید این رکورد را حذف کنید؟',
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

// Handle delete operation
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: labor_management.php");
    exit;
}

// Fetch labor records
// 
$result = $conn->query("SELECT user_id, username, email FROM users WHERE user_type IN ('labor', 'manager', 'public_manager')");

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>" dir="<?php echo ($_SESSION['lang'] == 'ps' || $_SESSION['lang'] == 'fa') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['LABOR_MANAGEMENT']; ?></title>
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
            width: 80%;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            display: flex;
            align-items: center;
        }
        form input[type="text"], form input[type="email"] {
            margin-right: 10px;
            padding: 5px;
            flex: 1;
        }
        form button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }
        form button:hover {
            background-color: #45a049;
        }
        form a {
            color: #f44336;
            text-decoration: none;
        }
        form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="?lang=en" <?php echo ($_SESSION['lang'] == 'en') ? 'class="active"' : ''; ?>>English</a></li>
            <li><a href="?lang=ps" <?php echo ($_SESSION['lang'] == 'ps') ? 'class="active"' : ''; ?>>پښتو</a></li>
            <li><a href="?lang=fa" <?php echo ($_SESSION['lang'] == 'fa') ? 'class="active"' : ''; ?>>دری</a></li>
            <li><a href="dashboar.php"><?php echo $lang['HOME']; ?></a></li>
        </ul>
    </nav>
    <div class="container">
        <h2><?php echo $lang['LABOR_MANAGEMENT']; ?></h2>
        <table>
            <thead>
                <tr>
                    <th><?php echo $lang['USERNAME']; ?></th>
                    <th><?php echo $lang['EMAIL']; ?></th>
                    <th><?php echo $lang['ACTIONS']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="update_labor.php?user_id=<?php echo $row['user_id']; ?>"><?php echo $lang['UPDATE']; ?></a>
                        <a href="?action=delete&user_id=<?php echo $row['user_id']; ?>" onclick="return confirm('<?php echo $lang['DELETE_CONFIRM']; ?>')"><?php echo $lang['DELETE']; ?></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
