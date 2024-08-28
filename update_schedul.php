<?php
// Default language is English
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Function to translate based on current language
function translate($key) {
    global $lang;
    $translations = array();

    // Include the appropriate translation file based on the language
    switch ($lang) {
        case 'ps':
            $translations = array(
                'page_title' => 'د کتابتون مهالویش مدیریت',
                'name' => 'نوم',
                'book_name' => 'د کتاب نوم',
                'class' => 'صنف',
                'start_time' => 'د پیل وخت',
                'end_time' => 'د پای وخت',
                'date' => 'نیټه',
                'computer_use' => 'د کمپیوټر استعمال',
                'internet' => 'انټرنیټ',
                'yes' => 'هو',
                'no' => 'نه',
                'submit' => 'جمع کول',
                'update' => 'تازه کول',
                'actions' => 'اقدامات',
                'edit' => 'سمول',
                'delete' => 'ړنګول',
                'search' => 'لټون',
                'search_button' => 'لټون',
                'no_records' => 'هیڅ ریکارډ ونه موندل شو.',
                'record_created_successfully' => 'ریکارډ په بریالیتوب سره جوړ شو.',
                'record_updated_successfully' => 'ریکارډ په بریالیتوب سره تازه شو.',
                'record_deleted_successfully' => 'ریکارډ په بریالیتوب سره ړنګ شو.',
                'confirm_delete' => 'ایا تاسو ډاډه یاست چې دا ریکارډ ړنګ کړئ؟'
            );
            break;
        case 'fa':
            $translations = array(
                'page_title' => 'مدیریت زمانبندی کتابخانه',
                'name' => 'نام',
                'book_name' => 'نام کتاب',
                'class' => 'صنف',
                'start_time' => 'زمان شروع',
                'end_time' => 'زمان پایان',
                'date' => 'تاریخ',
                'computer_use' => 'استفاده از کامپیوتر',
                'internet' => 'انترنت',
                'yes' => 'بلی',
                'no' => 'خیر',
                'submit' => 'ارسال',
                'update' => 'تازه کردن',
                'actions' => 'اقدامات',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
                'search' => 'جستجو',
                'search_button' => 'جستجو',
                'no_records' => 'هیچ ریکاردی یافت نشد.',
                'record_created_successfully' => 'ریکارد با موفقیت ایجاد شد.',
                'record_updated_successfully' => 'ریکارد با موفقیت تازه شد.',
                'record_deleted_successfully' => 'ریکارد با موفقیت حذف شد.',
                'confirm_delete' => 'آیا مطمئن هستید که می‌خواهید این ریکارد را حذف کنید؟'
            );
            break;
        default:
            $translations = array(
                'page_title' => 'Library Schedule Management',
                'name' => 'Name',
                'book_name' => 'Book Name',
                'class' => 'Class',
                'start_time' => 'Start Time',
                'end_time' => 'End Time',
                'date' => 'Date',
                'computer_use' => 'Computer Use',
                'internet' => 'Internet',
                'yes' => 'Yes',
                'no' => 'No',
                'submit' => 'Submit',
                'update' => 'Update',
                'actions' => 'Actions',
                'edit' => 'Edit',
                'delete' => 'Delete',
                'search' => 'Search',
                'search_button' => 'Search',
                'no_records' => 'No records found.',
                'record_created_successfully' => 'Record created successfully.',
                'record_updated_successfully' => 'Record updated successfully.',
                'record_deleted_successfully' => 'Record deleted successfully.',
                'confirm_delete' => 'Are you sure you want to delete this record?'
            );
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

// Insert or update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $book_name = $_POST['book_name'];
    $class = $_POST['class'];
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';
    $date = $_POST['date'];
    $computer_use = $_POST['computer_use'];
    $internet = $_POST['internet'];

    // Check if start_time and end_time are set
    if (!empty($name) && !empty($book_name) && !empty($class) && !empty($start_time) && !empty($end_time) && !empty($date) && isset($computer_use) && isset($internet)) {
        if ($id) {
            // Update record
            $sql = "UPDATE schedule SET name=?, book_name=?, class=?, start_time=?, end_time=?, date=?, computer_use=?, internet=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssiii", $name, $book_name, $class, $start_time, $end_time, $date, $computer_use, $internet, $id);

            if ($stmt->execute()) {
                echo translate('record_updated_successfully');
            } else {
                echo "Error: " . $sql . "<br>" . $stmt->error;
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO schedule (name, book_name, class, start_time, end_time, date, computer_use, internet) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssii", $name, $book_name, $class, $start_time, $end_time, $date, $computer_use, $internet);

            if ($stmt->execute()) {
                echo translate('record_created_successfully');
            } else {
                echo "Error: " . $sql . "<br>" . $stmt->error;
            }
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

// Fetch data for editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM schedule WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}

// Delete record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM schedule WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo translate('record_deleted_successfully');
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }
}
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
            padding: 20px;
            background: white;
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        form > * {
            flex: 1 1 200px;
            padding: 10px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
        th {
            background-color: #f4f4f4;
        }
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="?lang=en">English</a>
        <a href="?lang=ps">Pashto</a>
        <a href="?lang=fa">Dari</a>
        <a href='dashboar.php'>Home</a>
    </div>
    <div class="container">
        <h1><?php echo translate('page_title'); ?></h1>
        <form action="" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo isset($edit_data['id']) ? $edit_data['id'] : ''; ?>">
            <input type="text" name="name" id="name" placeholder="<?php echo translate('name'); ?>" value="<?php echo isset($edit_data['name']) ? $edit_data['name'] : ''; ?>" required>
            <input type="text" name="book_name" id="book_name" placeholder="<?php echo translate('book_name'); ?>" value="<?php echo isset($edit_data['book_name']) ? $edit_data['book_name'] : ''; ?>" required>
            <input type="text" name="class" id="class" placeholder="<?php echo translate('class'); ?>" value="<?php echo isset($edit_data['class']) ? $edit_data['class'] : ''; ?>" required>
            <input type="time" name="start_time" id="start_time" placeholder="<?php echo translate('start_time'); ?>" value="<?php echo isset($edit_data['start_time']) ? $edit_data['start_time'] : ''; ?>" required>
            <input type="time" name="end_time" id="end_time" placeholder="<?php echo translate('end_time'); ?>" value="<?php echo isset($edit_data['end_time']) ? $edit_data['end_time'] : ''; ?>" required>
            <input type="date" name="date" id="date" placeholder="<?php echo translate('date'); ?>" value="<?php echo isset($edit_data['date']) ? $edit_data['date'] : ''; ?>" required>
            <label>
                <?php echo translate('computer_use'); ?>
                <select name="computer_use" id="computer_use">
                    <option value="1" <?php echo isset($edit_data['computer_use']) && $edit_data['computer_use'] == 1 ? 'selected' : ''; ?>><?php echo translate('yes'); ?></option>
                    <option value="0" <?php echo isset($edit_data['computer_use']) && $edit_data['computer_use'] == 0 ? 'selected' : ''; ?>><?php echo translate('no'); ?></option>
                </select>
            </label>
            <label>
                <?php echo translate('internet'); ?>
                <select name="internet" id="internet">
                    <option value="1" <?php echo isset($edit_data['internet']) && $edit_data['internet'] == 1 ? 'selected' : ''; ?>><?php echo translate('yes'); ?></option>
                    <option value="0" <?php echo isset($edit_data['internet']) && $edit_data['internet'] == 0 ? 'selected' : ''; ?>><?php echo translate('no'); ?></option>
                </select>
            </label>
            <button type="submit" id="submit_button"><?php echo isset($edit_data) ? translate('update') : translate('submit'); ?></button>
        </form>

        <form action="" method="get" style="margin-top: 20px; text-align: center;">
            <input type="text" name="search" placeholder="<?php echo translate('search'); ?>">
            <button type="submit"><?php echo translate('search_button'); ?></button>
        </form>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th><?php echo translate('name'); ?></th>
                        <th><?php echo translate('book_name'); ?></th>
                        <th><?php echo translate('class'); ?></th>
                        <th><?php echo translate('start_time'); ?></th>
                        <th><?php echo translate('end_time'); ?></th>
                        <th><?php echo translate('date'); ?></th>
                        <th><?php echo translate('computer_use'); ?></th>
                        <th><?php echo translate('internet'); ?></th>
                        <th><?php echo translate('actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['book_name']; ?></td>
                            <td><?php echo $row['class']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['end_time']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['computer_use'] ? translate('yes') : translate('no'); ?></td>
                            <td><?php echo $row['internet'] ? translate('yes') : translate('no'); ?></td>
                            <td class="actions">
                                <a href="?edit=<?php echo $row['id']; ?>"><?php echo translate('edit'); ?></a>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('<?php echo translate('confirm_delete'); ?>');"><?php echo translate('delete'); ?></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><?php echo translate('no_records'); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
‍‍‍