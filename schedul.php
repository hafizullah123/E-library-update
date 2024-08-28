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
            include 'language/pashto_schedule.php';
            break;
        case 'fa':
            include 'language/dari_schedule.php';
            break;
        default:
            include 'language/english_schedule.php';
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

// Insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $book_name = $_POST['book_name'];
    $class = $_POST['class'];
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';
    $date = $_POST['date'];
    $computer_use = $_POST['computer_use'];
    $internet = $_POST['internet'];

    // Check if start_time and end_time are set
    if (!empty($name) && 
    !empty($class) && 
    !empty($start_time) && 
    !empty($end_time) && 
    !empty($date) && 
    isset($computer_use) && 
    isset($internet) && 
    ($book_name === null || $book_name === '' || !empty($book_name))) {
    // if (!empty($name) && !isset($book_name) && !empty($class) && !empty($start_time) && !empty($end_time) && !empty($date) && isset($computer_use) && isset($internet)) {
        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO schedule (name, book_name, class, start_time, end_time, date, computer_use, internet) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssii", $name, $book_name, $class, $start_time, $end_time, $date, $computer_use, $internet);

        if ($stmt->execute()) {
            echo translate('record_created_successfully');
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }
    } else {
        echo "All fields are required.";
    }
}

// Fetch data to display in descending order by ID
$sql = "SELECT * FROM schedule ORDER BY id DESC";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM schedule WHERE name LIKE '%$search%' OR book_name LIKE '%$search%' OR class LIKE '%$search%' ORDER BY id DESC";
}
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
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            direction: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
            padding: 14px 0;
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
            margin: 20px auto;
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
        .form-container input[type="text"], 
        .form-container input[type="time"], 
        .form-container input[type="date"], 
        .form-container select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container label {
            display: block;
            margin: 10px 0;
        }
        .form-container .form-footer {
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
        .form-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #888;
        }
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1;
        }
        .popup-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }
        .close {
            color: #aaa;
            float: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'left' : 'right'; ?>;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .search-container {
            margin-top: 20px;
            text-align: center;
        }
        .search-container input[type="text"] {
            width: calc(100% - 42px);
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .search-container input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="#home"><?php echo translate('nav_home'); ?></a>
    <a href="book.php"><?php echo translate('nav_book'); ?></a>
    <a href="logout.php"><?php echo translate('nav_logout'); ?></a>
    <a href="?lang=ps">پښتو</a>
    <a href="?lang=fa">دری</a>
    <a href="?lang=en">English</a>
</div>

<div class="container">
    <div class="form-container">
        <form method="POST" action="">
            <input type="text" name="name" placeholder="<?php echo translate('placeholder_name'); ?>" required>
            <input type="text" name="book_name" placeholder="<?php echo translate('placeholder_book_name'); ?>">

          
          <input type="text" name="class" placeholder="<?php echo translate('placeholder_class'); ?>" required>
        
            <input type="time" name="start_time" required>
            <input type="time" name="end_time" required>
            <input type="date" name="date" required>
            <label for="computer_use"><?php echo translate('label_computer_use'); ?></label>
            <select name="computer_use" id="computer_use">
                <option value="1"><?php echo translate('option_yes'); ?></option>
                <option value="0"><?php echo translate('option_no'); ?></option>
            </select>
            <label for="internet"><?php echo translate('label_internet'); ?></label>
            <select name="internet" id="internet">
                <option value="1"><?php echo translate('option_yes'); ?></option>
                <option value="0"><?php echo translate('option_no'); ?></option>
            </select>
            <div class="form-footer">
                <input type="submit" value="<?php echo translate('button_add_schedule'); ?>">
            </div>
        </form>

        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" id="search" placeholder="<?php echo translate('placeholder_search'); ?>">
                <input type="submit" style="display: none;">
            </form>
        </div>
    </div>

    <table id="scheduleTable">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all-rows"></th>
                <th>ID</th>
                <th><?php echo translate('th_name'); ?></th>
                <th><?php echo translate('th_book_name'); ?></th>
                <th><?php echo translate('th_class'); ?></th>
                <th><?php echo translate('th_start_time'); ?></th>
                <th><?php echo translate('th_end_time'); ?></th>
                <th><?php echo translate('th_date'); ?></th>
                <th><?php echo translate('th_computer_use'); ?></th>
                <th><?php echo translate('th_internet'); ?></th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic content will be added here -->
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><input type='checkbox' class='row-checkbox'></td>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["book_name"] . "</td>
                            <td>" . $row["class"] . "</td>
                            <td>" . $row["start_time"] . "</td>
                            <td>" . $row["end_time"] . "</td>
                            <td>" . $row["date"] . "</td>
                            <td>" . ($row["computer_use"] ? translate('option_yes') : translate('option_no')) . "</td>
                            <td>" . ($row["internet"] ? translate('option_yes') : translate('option_no')) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='no-records'>" . translate('no_records_found') . "</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Popup HTML -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <div id="popup-content-text"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all-rows');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const popup = document.getElementById('popup');
        const popupContent = document.getElementById('popup-content-text');
        const popupCloseBtn = document.querySelector('.close');
        const searchInput = document.getElementById('search');
        const scheduleTable = document.getElementById('scheduleTable').getElementsByTagName('tbody')[0];

        // Function to handle checkbox select all functionality
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Function to handle row checkbox change
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // If any row is unchecked, uncheck the select all checkbox
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                }
            });
        });

        // Function to show popup when a row is selected
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    const row = this.parentElement.parentElement;
                    const rowData = Array.from(row.children).map(cell => cell.textContent);
                    popupContent.innerHTML = `<strong><?php echo translate('popup_name'); ?>:</strong> ${rowData[2]}<br>
                                              <strong><?php echo translate('popup_book_name'); ?>:</strong> ${rowData[3]}<br>
                                              <strong><?php echo translate('popup_start_time'); ?>:</strong> ${rowData[5]}<br>
                                              <strong><?php echo translate('popup_end_time'); ?>:</strong> ${rowData[6]}`;
                    popup.style.display = 'block';
                }
            });
        });

        // Close popup when close button is clicked
        popupCloseBtn.addEventListener('click', function() {
            popup.style.display = 'none';
        });

        // Close popup when clicking outside the popup
        window.addEventListener('click', function(event) {
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });

        // Live search functionality
        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            Array.from(scheduleTable.rows).slice(1).forEach(row => {
                const textContent = row.textContent.toLowerCase();
                row.style.display = textContent.includes(searchText) ? '' : 'none';
            });
        });
    });
</script>

</body>
</html>
