<?php
session_start();

// Function to get translations based on selected language
function getTranslations($lang) {
    $translations = [
        'en' => [
            'add_book' => 'Add Book',
            'name' => 'Name',
            'number' => 'Number',
            'part' => 'Part',
            'search' => 'Search',
            'id' => 'ID',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'confirm_delete' => 'Are you sure you want to delete this record?',
            'no_records' => 'No records found',
            'update_book' => 'Update Book',
            'home' => 'Home',
            'schedule' => 'Schedule',
            'logout' => 'Logout'
        ],
        'ps' => [
            'add_book' => 'کتاب اضافه کړئ',
            'name' => 'نوم',
            'number' => 'شمېره',
            'part' => 'برخه',
            'search' => 'پلټنه',
            'id' => 'ID',
            'edit' => 'سمول',
            'delete' => 'حذف',
            'confirm_delete' => 'ایا تاسو ډاډه یاست چې غواړئ دا ریکارډ حذف کړئ؟',
            'no_records' => 'هیڅ ریکارډ ونه موندل شو',
            'update_book' => 'کتاب تازه کړئ',
            'home' => 'کور',
            'schedule' => 'مهال ویش',
            'logout' => 'وتل'
        ],
        'fa' => [
            'add_book' => 'اضافه کردن کتاب',
            'name' => 'نام',
            'number' => 'شماره',
            'part' => 'بخش',
            'search' => 'جستجو',
            'id' => 'ID',
            'edit' => 'ویرایش',
            'delete' => 'حذف',
            'confirm_delete' => 'آیا مطمئن هستید که می‌خواهید این رکورد را حذف کنید؟',
            'no_records' => 'هیچ رکوردی یافت نشد',
            'update_book' => 'بروزرسانی کتاب',
            'home' => 'خانه',
            'schedule' => 'برنامه',
            'logout' => 'خروج'
        ]
    ];

    return $translations[$lang] ?? $translations['en'];
}

// Handle language selection
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if (in_array($lang, ['en', 'ps', 'fa'])) {
        $_SESSION['lang'] = $lang;
    }
}

$lang = $_SESSION['lang'] ?? 'en';
$translations = getTranslations($lang);

function t($key, $translations) {
    return $translations[$key] ?? $key;
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'insert') {
        $name = $_POST['name'];
        $number = $_POST['number'];
        $part = $_POST['part'];

        $sql = "INSERT INTO book (name, number, part) VALUES ('$name', '$number', '$part')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New record created successfully</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number = $_POST['number'];
        $part = $_POST['part'];

        $sql = "UPDATE book SET name='$name', number='$number', part='$part' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Record updated successfully</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } elseif ($action == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM book WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Record deleted successfully</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
}

// Handle search
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
}

$sql = "SELECT * FROM book WHERE name LIKE '%$searchQuery%'";
$result = $conn->query($sql);

// Handle editing
$editRecord = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM book WHERE id='$id'";
    $editResult = $conn->query($sql);
    $editRecord = $editResult->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('add_book', $translations); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .form-container, .search-box {
            margin: 20px 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            direction: <?php echo in_array($lang, ['ps', 'fa']) ? 'rtl' : 'ltr'; ?>;
        }
        .form-container input[type="text"], 
        .form-container input[type="number"], 
        .search-box input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #888;
        }
        .lang-select {
            margin-bottom: 20px;
        }
        .lang-select select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            direction: <?php echo in_array($lang, ['ps', 'fa']) ? 'rtl' : 'ltr'; ?>;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="?lang=en">EN</a>
    <a href="?lang=ps">PS</a>
    <a href="?lang=fa">FA</a>
    <a href="dashboar.php"><?php echo t('home', $translations); ?></a>
    <a href="schedule.php"><?php echo t('schedule', $translations); ?></a>
    <a href="logout.php"><?php echo t('logout', $translations); ?></a>
</div>

<div class="container">
    <?php if ($editRecord): ?>
        <div class="form-container">
            <h2><?php echo t('update_book', $translations); ?></h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $editRecord['id']; ?>">
                <input type="text" name="name" value="<?php echo $editRecord['name']; ?>" required>
                <input type="number" name="number" value="<?php echo $editRecord['number']; ?>" required>
                <input type="text" name="part" value="<?php echo $editRecord['part']; ?>" required>
                <input type="submit" value="<?php echo t('update_book', $translations); ?>">
            </form>
        </div>
    <?php else: ?>
        <div class="form-container">
            <h2><?php echo t('add_book', $translations); ?></h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="insert">
                <input type="text" name="name" placeholder="<?php echo t('name', $translations); ?>" required>
                <input type="number" name="number" placeholder="<?php echo t('number', $translations); ?>" required>
                <input type="text" name="part" placeholder="<?php echo t('part', $translations); ?>" required>
                <input type="submit" value="<?php echo t('add_book', $translations); ?>">
            </form>
        </div>
    <?php endif; ?>

    <div class="search-box">
        <h2><?php echo t('search', $translations); ?></h2>
        <form method="POST" action="">
            <input type="text" name="search" placeholder="<?php echo t('name', $translations); ?>" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="submit" value="<?php echo t('search', $translations); ?>">
        </form>
    </div>

    <h2><?php echo t('name', $translations); ?></h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table><tr><th>" . t('id', $translations) . "</th><th>" . t('name', $translations) . "</th><th>" . t('number', $translations) . "</th><th>" . t('part', $translations) . "</th><th>" . t('edit', $translations) . "</th><th>" . t('delete', $translations) . "</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["number"]. "</td><td>" . $row["part"]. "</td><td><a href='?edit=" . $row["id"]. "'>" . t('edit', $translations) . "</a></td><td><form method='POST' action='' style='display:inline;'><input type='hidden' name='action' value='delete'><input type='hidden' name='id' value='" . $row["id"] . "'><input type='submit' value='" . t('delete', $translations) . "' onclick='return confirm(\"" . t('confirm_delete', $translations) . "\")'></form></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-records'>" . t('no_records', $translations) . "</p>";
    }
    ?>
</div>

</body>
</html>
