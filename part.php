<?php
// Start session
session_start();

// Default to English if no language is selected
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Change language if a language is selected from the navbar
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Include the selected language file
if ($_SESSION['lang'] == 'ps') {
    $lang = array(
        "title" => "برخه دننه کړئ",
        "part_name" => "د برخې نوم",
        "insert_part" => "برخه دننه کړئ",
        "new_part_success" => "نوی برخه په بریالیتوب سره دننه شوه",
        "error" => "تېروتنه",
    );
    $direction = "rtl"; // Right-to-Left
} elseif ($_SESSION['lang'] == 'dr') {
    $lang = array(
        "title" => "درج قسمت",
        "part_name" => "نام قسمت",
        "insert_part" => "درج قسمت",
        "new_part_success" => "قسمت جدید با موفقیت درج شد",
        "error" => "خطا",
    );
    $direction = "rtl"; // Right-to-Left
} else {
    $lang = array(
        "title" => "Insert Part",
        "part_name" => "Part Name",
        "insert_part" => "Insert Part",
        "new_part_success" => "New part inserted successfully",
        "error" => "Error",
    );
    $direction = "ltr"; // Left-to-Right
}

// Connect to MySQL database
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the part name from the form
    $part_name = $_POST["part_name"];

    // Insert query to add new part
    $sql = "INSERT INTO part (part_name) VALUES ('$part_name')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center'>{$lang['new_part_success']}</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>{$lang['error']}: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="<?php echo $direction; ?>"> <!-- Set the direction dynamically -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['title']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: <?php echo $direction; ?>;
            text-align: <?php echo $direction === 'rtl' ? 'right' : 'left'; ?>;
        }
    </style>
</head>
<body>

<!-- Navbar for Language Selection -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo $lang['title']; ?></a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="?lang=en">English</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?lang=ps">Pashto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?lang=dr">Dari</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?lang=dr">home</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Form to Insert Part -->
<div class="container mt-5">
    <h2 class="text-center"><?php echo $lang['title']; ?></h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="part_name"><?php echo $lang['part_name']; ?>:</label>
            <input type="text" class="form-control" id="part_name" name="part_name" required>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $lang['insert_part']; ?></button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
