<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php?action=login");
    exit;
}

// Default language is English
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Function to translate based on current language
function translate($key) {
    global $lang;
    $translations = array();

    // Include the appropriate translation file based on the language
    switch ($lang) {
        case 'ps':
            include 'language/pashto_book.php';
            break;
        case 'fa':
            include 'language/dari_book.php';
            break;
        default:
            include 'language/english_book.php';
            break;
    }

    // Return the translated text if available, or fallback to English
    return isset($translations[$key]) ? $translations[$key] : $key;
}

// Database connection parameters
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

// Handle form submission to add a book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $number = $conn->real_escape_string($_POST['number']);
    $part = $conn->real_escape_string($_POST['part']);
    $total = $conn->real_escape_string($_POST['total']);
    
    $sql = "INSERT INTO book (name, number, part, total) VALUES ('$name', '$number', '$part', '$total')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Book added successfully');</script>";
    } else {
        echo "<script>alert('Error adding book: " . $conn->error . "');</script>";
    }
}

// Fetch data to display
$sql = "SELECT name, number, part, total FROM book";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo translate('page_title'); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            direction: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
            direction: ltr; /* Ensure navbar text direction is always LTR */
        }
        .navbar a {
            float: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
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
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
        .form-container, .search-box {
            margin: 20px 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
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
        .form-container select {
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
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
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
    </style>
</head>
<body>

<div class="navbar">
    <a href="#home"><?php echo translate('nav_home'); ?></a>
    <a href="schedul.php"><?php echo translate('nav_schedule'); ?></a>
    <a href="logout.php"><?php echo translate('nav_logout'); ?></a>
    <a href="?lang=ps">پښتو</a>
    <a href="?lang=fa">دری</a>
    <a href="?lang=en">English</a>
</div>

<div class="container">
    <div class="form-container">
        <form method="POST" action="">
            <input type="text" name="name" placeholder="<?php echo translate('placeholder_name'); ?>" required>
            <input type="number" name="number" placeholder="<?php echo translate('placeholder_number'); ?>" required>
            <select name="part" required>
                <option value=""><?php echo translate('placeholder_select_part'); ?></option>
                <?php
                // Fetch parts from part table
                $part_sql = "SELECT part_name FROM part";
                $part_result = $conn->query($part_sql);
                if ($part_result->num_rows > 0) {
                    while($part_row = $part_result->fetch_assoc()) {
                        echo "<option value='".htmlspecialchars($part_row['part_name'])."'>".htmlspecialchars($part_row['part_name'])."</option>";
                    }
                }
                ?>
            </select>
            <input type="number" name="total" placeholder="<?php echo translate('placeholder_total'); ?>" required>
            <input type="submit" value="<?php echo translate('button_add_book'); ?>">
        </form>
    </div>

    <div class="search-box">
        <input type="text" id="search" placeholder="<?php echo translate('placeholder_search'); ?>">
    </div>

    <table>
        <thead>
            <tr>
                <th><?php echo translate('th_name'); ?></th>
                <th><?php echo translate('th_number'); ?></th>
                <th><?php echo translate('th_part'); ?></th>
                <th><?php echo translate('th_total'); ?></th>
            </tr>
        </thead>
        <tbody id="book-table">
            <?php
            // Display fetched data
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["name"]) . "</td>
                            <td>" . htmlspecialchars($row["number"]) . "</td>
                            <td>" . htmlspecialchars($row["part"]) . "</td>
                            <td>" . htmlspecialchars($row["total"]) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-records'>" . translate('no_records_found') . "</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('search').addEventListener('input', function() {
    const searchTerm = this.value.trim();

    fetch(`search3.php?term=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('book-table');
            tableBody.innerHTML = '';

            if (data.length > 0) {
                data.forEach(item => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.number}</td>
                            <td>${item.part}</td>
                            <td>${item.total}</td>
                        </tr>
                    `;
                });
            } else {
                tableBody.innerHTML = `<tr><td colspan='4' class='no-records'><?php echo translate('no_records_found'); ?></td></tr>`;
            }
        });
});
</script>
</body>
</html>
