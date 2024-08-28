<?php
session_start();
error_reporting();
include ('connection.php');
$userprofile=$_SESSION['user_id'];
if ($userprofile==true){
    
}
else{
    header('location: login.php ');
}



session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'en';
$rtl_languages = ['ps', 'fa'];
$is_rtl = in_array($lang, $rtl_languages);

// Localization arrays
$translations = [
    'en' => [
        'title' => 'Library Usage Report',
        'start_date' => 'Start Date:',
        'end_date' => 'End Date:',
        'generate_report' => 'Generate Report',
        'report_from' => 'Report from',
        'to' => 'to',
        'total_users' => 'Total Users',
        'users_with_books' => 'Users with Books',
        'users_with_computer' => 'Users with Computer',
        'users_with_internet' => 'Users with Internet',
        'additional_option' => 'Additional Option'
    ],
    'ps' => [
        'title' => 'د کتابتون کارولو راپور',
        'start_date' => 'د پیل نېټه:',
        'end_date' => 'د پای نېټه:',
        'generate_report' => 'راپور تولید کړئ',
        'report_from' => 'راپور له',
        'to' => 'تر',
        'total_users' => 'ټول کارونکي',
        'users_with_books' => 'کارونکي چې کتاب یی استعمال کړی ',
        'users_with_computer' => 'کارونکي چې کمپیوټر یي استعمال کړی',
        'users_with_internet' => 'کارونکي چې انټرنټ یي استعمال کړی',
        'additional_option' => 'اضافي اختیار'
    ],
    'fa' => [
        'title' => 'گزارش استفاده از کتابخانه',
        'start_date' => 'تاریخ شروع:',
        'end_date' => 'تاریخ پایان:',
        'generate_report' => 'تولید گزارش',
        'report_from' => 'گزارش از',
        'to' => 'تا',
        'total_users' => 'کل کاربران',
        'users_with_books' => '  کاربران که  کتاب استفاده نموده  ' ,
        'users_with_computer' => '  کاربران که کمپیوتر استفاده نموده' ,
        'users_with_internet' => '  کاربران که انترنت استفاده نموده ',
        'additional_option' => 'گزینه اضافی'
    ]
];

$trans = $translations[$lang];

// Database connection
$servername = "localhost"; // Change this to your server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "library"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$start_date = '';
$end_date = '';
$total_users = 0;
$users_with_books = 0;
$users_with_computer = 0;
$users_with_internet = 0;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepare and execute the SQL query
    $sql = "
    



    SELECT 
    COUNT(*) AS total_users,
    SUM(CASE WHEN book_name IS NOT NULL AND book_name != '' THEN 1 ELSE 0 END) AS users_with_books,
    SUM(CASE WHEN computer_use = 1 THEN 1 ELSE 0 END) AS users_with_computer,
    SUM(CASE WHEN internet = 1 THEN 1 ELSE 0 END) AS users_with_internet
FROM 
    schedule
WHERE 
    date BETWEEN ? AND ?;
";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $stmt->bind_result($total_users, $users_with_books, $users_with_computer, $users_with_internet);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" <?= $is_rtl ? 'dir="rtl"' : '' ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $trans['title'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            background-color: #f8f9fa;
            padding: 1rem;
        }
        .navbar a {
            margin: 0 1rem;
        }
        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .report {
            background: #fafafa;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .report h2 {
            margin-top: 0;
        }
        .report p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="index.php"><?= $trans['title'] ?></a>
            <a href="dashboar.php"><?= $trans['additional_option'] ?></a>
        </div>
        <form method="GET" action="" style="margin: 0;">
            <select name="lang" onchange="this.form.submit()">
                <option value="en" <?= $lang == 'en' ? 'selected' : '' ?>>English</option>
                <option value="ps" <?= $lang == 'ps' ? 'selected' : '' ?>>Pashto</option>
                <option value="fa" <?= $lang == 'fa' ? 'selected' : '' ?>>Dari</option>
            </select>
        </form>
    </div>

    <div class="container">
        <h1><?= $trans['title'] ?></h1>
        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <label for="start_date"><?= $trans['start_date'] ?></label>
            <input type="date" id="start_date" name="start_date" value="<?= $start_date ?>" required>
            <label for="end_date"><?= $trans['end_date'] ?></label>
            <input type="date" id="end_date" name="end_date" value="<?= $end_date ?>" required>
            <input type="submit" value="<?= $trans['generate_report'] ?>">
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="report">
                <h2><?= $trans['report_from'] ?> <?= $start_date ?> <?= $trans['to'] ?> <?= $end_date ?></h2>
                <p><?= $trans['total_users'] ?>: <?= $total_users ?></p>
                <p><?= $trans['users_with_books'] ?>: <?= $users_with_books ?></p>
                <p><?= $trans['users_with_computer'] ?>: <?= $users_with_computer ?></p>
                <p><?= $trans['users_with_internet'] ?>: <?= $users_with_internet ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
