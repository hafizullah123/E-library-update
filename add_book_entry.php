<?php
session_start();
include 'connection.php';

// Check if the language is set in the session
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; // Default to English
}

// Handle language switching
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

// Get the current language
$lang = $_SESSION['lang'];

// Localization function
function getLocalizedText($key, $lang) {
    $translations = [
        'en' => [
            'register_book' => 'Register a New Book',
            'book_name' => 'Book Name:',
            'author_name' => 'Author Name:',
            'isbn_number' => 'ISBN Number:',
            'genre' => 'Genre:',
            'cover_image' => 'Cover Image:',
            'pdf' => 'PDF:',
            'publication_date' => 'Publication Date:',
            'publisher' => 'Publisher:',
            'description' => 'Description:',
            'register' => 'Register Book',
            'language' => 'Language:',
            'english' => 'English',
            'pashto' => 'Pashto',
            'dari' => 'Dari',
            'home' => 'Home'
        ],
        'ps' => [
            'register_book' => 'نوی کتاب ثبت کړئ',
            'book_name' => 'د کتاب نوم:',
            'author_name' => 'د لیکوال نوم:',
            'isbn_number' => 'د ISBN شمېره:',
            'genre' => 'ډول یا نوع:',
            'cover_image' => 'د پوښ انځور:',
            'pdf' => 'PDF:',
            'publication_date' => 'د خپرېدو نېټه:',
            'publisher' => 'خپرندوی:',
            'description' => 'تشریح:',
            'register' => 'کتاب ثبت کړئ',
            'language' => 'ژبه:',
            'english' => 'انګلیسي',
            'pashto' => 'پښتو',
            'dari' => 'دري',
            'home' => 'کور'
        ],
        'fa' => [
            'register_book' => 'ثبت کتاب جدید',
            'book_name' => 'نام کتاب:',
            'author_name' => 'نام نویسنده:',
            'isbn_number' => 'شماره ISBN:',
            'genre' => 'نوعیت:',
            'cover_image' => 'تصویر جلد:',
            'pdf' => 'PDF:',
            'publication_date' => 'تاریخ انتشار:',
            'publisher' => 'ناشر:',
            'description' => 'توضیحات:',
            'register' => 'ثبت کتاب',
            'language' => 'زبان:',
            'english' => 'انگلیسی',
            'pashto' => 'پشتو',
            'dari' => 'دری',
            'home' => 'خانه'
        ]
    ];
    return $translations[$lang][$key] ?? $key;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $bookName = isset($_POST["bookName"]) ? $_POST["bookName"] : "";
    $authorName = isset($_POST["authorName"]) ? $_POST["authorName"] : "";
    $isbnNumber = isset($_POST["isbnNumber"]) ? $_POST["isbnNumber"] : "";
    $genre = isset($_POST["genre"]) ? $_POST["genre"] : "";
    $coverImage = isset($_FILES["coverImage"]["name"]) ? $_FILES["coverImage"]["name"] : "";
    $pdf = isset($_FILES["pdf"]["name"]) ? $_FILES["pdf"]["name"] : "";
    $publicationDate = isset($_POST["publicationDate"]) ? $_POST["publicationDate"] : "";
    $publisher = isset($_POST["publisher"]) ? $_POST["publisher"] : "";
    $description = isset($_POST["description"]) ? $_POST["description"] : "";

    // File upload handling
    $targetDir = "uploads/";
    $coverImagePath = "";
    $pdfPath = "";
    
    // Handle cover image upload
    if (isset($_FILES["coverImage"]) && $_FILES["coverImage"]["error"] == UPLOAD_ERR_OK) {
        $coverImage = $_FILES["coverImage"]["name"];
        $coverImagePath = $targetDir . basename($coverImage);
        if (!move_uploaded_file($_FILES["coverImage"]["tmp_name"], $coverImagePath)) {
            echo "<div class='bg-red-500 text-white p-4 mb-4'>Cover image upload failed. Please try again.</div>";
            exit;
        }
    } elseif (isset($_FILES["coverImage"]["error"]) && $_FILES["coverImage"]["error"] != UPLOAD_ERR_NO_FILE) {
        echo "<div class='bg-red-500 text-white p-4 mb-4'>Error uploading cover image: " . $_FILES["coverImage"]["error"] . "</div>";
        exit;
    }

    // Handle PDF upload
    if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] == UPLOAD_ERR_OK) {
        $pdf = $_FILES["pdf"]["name"];
        $pdfPath = $targetDir . basename($pdf);
        if (!move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdfPath)) {
            echo "<div class='bg-red-500 text-white p-4 mb-4'>PDF upload failed. Please try again.</div>";
            exit;
        }
    } elseif (isset($_FILES["pdf"]["error"]) && $_FILES["pdf"]["error"] != UPLOAD_ERR_NO_FILE) {
        echo "<div class='bg-red-500 text-white p-4 mb-4'>Error uploading PDF: " . $_FILES["pdf"]["error"] . "</div>";
        exit;
    }

    // Prepare SQL statement to insert data into the books table
    $sql = "INSERT INTO books (book_name, author_name, isbn_number, genre, cover_image, pdf, publication_date, publisher, description) 
            VALUES ('$bookName', '$authorName', '$isbnNumber', '$genre', '$coverImagePath', '$pdfPath', '$publicationDate', '$publisher', '$description')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        echo "<div class='bg-green-500 text-white p-4 mb-4'>Book added successfully</div>";
    } else {
        echo "<div class='bg-red-500 text-white p-4 mb-4'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getLocalizedText('register_book', $lang); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .rtl {
            direction: rtl;
            text-align: right;
        }
        .ltr {
            direction: ltr;
            text-align: left;
        }
    </style>
</head>
<body class="bg-gray-100 <?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">
    <!-- Language Selection Navbar -->
    <nav class="bg-white shadow-md p-4 mb-6">
        <div class="flex justify-between items-center">
            <a class="text-xl font-bold" href="#"><?php echo getLocalizedText('language', $lang); ?></a>
            <div class="flex space-x-4">
                <a class="text-blue-500 hover:text-blue-700" href="?lang=en"><?php echo getLocalizedText('english', $lang); ?></a>
                <a class="text-blue-500 hover:text-blue-700" href="?lang=ps"><?php echo getLocalizedText('pashto', $lang); ?></a>
                <a class="text-blue-500 hover:text-blue-700" href="?lang=fa"><?php echo getLocalizedText('dari', $lang); ?></a>
                <a class="text-blue-500 hover:text-blue-700" href="add_paper_entry.php"><?php echo getLocalizedText('paper', $lang); ?></a>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4"><?php echo getLocalizedText('register_book', $lang); ?></h2>
        <form action="" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="bookName" class="block text-gray-700"><?php echo getLocalizedText('book_name', $lang); ?></label>
                <input type="text" id="bookName" name="bookName" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="authorName" class="block text-gray-700"><?php echo getLocalizedText('author_name', $lang); ?></label>
                <input type="text" id="authorName" name="authorName" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="isbnNumber" class="block text-gray-700"><?php echo getLocalizedText('isbn_number', $lang); ?></label>
                <input type="text" id="isbnNumber" name="isbnNumber" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="genre" class="block text-gray-700"><?php echo getLocalizedText('genre', $lang); ?></label>
                <input type="text" id="genre" name="genre" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="coverImage" class="block text-gray-700"><?php echo getLocalizedText('cover_image', $lang); ?></label>
                <input type="file" id="coverImage" name="coverImage" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="pdf" class="block text-gray-700"><?php echo getLocalizedText('pdf', $lang); ?></label>
                <input type="file" id="pdf" name="pdf" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="publicationDate" class="block text-gray-700"><?php echo getLocalizedText('publication_date', $lang); ?></label>
                <input type="date" id="publicationDate" name="publicationDate" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="publisher" class="block text-gray-700"><?php echo getLocalizedText('publisher', $lang); ?></label>
                <input type="text" id="publisher" name="publisher" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700"><?php echo getLocalizedText('description', $lang); ?></label>
                <textarea id="description" name="description" rows="3" class="w-full p-2 border border-gray-300 rounded" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700"><?php echo getLocalizedText('register', $lang); ?></button>
        </form>
    </div>
</body>
</html>