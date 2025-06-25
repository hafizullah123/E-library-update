<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

include 'connection.php';

// Translations
$translations = [
    'en' => [
        'book_name' => 'Book Name',
        'author_name' => 'Author Name',
        'isbn_number' => 'ISBN Number',
        'genre' => 'Genre',
        'publication_date' => 'Publication Date',
        'publisher' => 'Publisher',
        'description' => 'Description',
        'view_details' => 'View Details',
        'download_pdf' => 'Download PDF',
        'search_placeholder' => 'Search by Name or ISBN',
        'search_button' => 'Search',
        'no_books_found' => 'No books found.',
        'cover_image' => 'Cover Image',
        'actions' => 'Actions',
        'books' => 'Books',
        'papers' => 'Papers',
        'logout' => 'Logout',
        'language' => 'Language',
        'english' => 'English',
        'pashto' => 'Pashto',
        'dari' => 'Dari',
        'close' => 'Close'
    ],
    'ps' => [
        'book_name' => 'د کتاب نوم',
        'author_name' => 'د لیکوال نوم',
        'isbn_number' => 'آی ایس بی این نمبر',
        'genre' => 'ژانر',
        'publication_date' => 'د خپرېدو نېټه',
        'publisher' => 'خپرونکی',
        'description' => 'تشریح',
        'view_details' => 'تفصیلات وګورئ',
        'download_pdf' => 'PDF ډاونلوډ کړئ',
        'search_placeholder' => 'د نوم یا ISBN په واسطه لټون وکړئ',
        'search_button' => 'لټون',
        'no_books_found' => 'هیڅ کتابونه ونه موندل شول.',
        'cover_image' => 'پوښ عکس',
        'actions' => 'عملونه',
        'books' => 'کتابونه',
        'papers' => 'لیکونه',
        'logout' => 'وتل',
        'language' => 'ژبه',
        'english' => 'انګلیسي',
        'pashto' => 'پښتو',
        'dari' => 'دری',
        'close' => 'بند'
    ],
    'fa' => [
        'book_name' => 'نام کتاب',
        'author_name' => 'نام نویسنده',
        'isbn_number' => 'شماره شابک',
        'genre' => 'ژانر',
        'publication_date' => 'تاریخ انتشار',
        'publisher' => 'ناشر',
        'description' => 'توضیحات',
        'view_details' => 'مشاهده جزئیات',
        'download_pdf' => 'دانلود PDF',
        'search_placeholder' => 'جستجو بر اساس نام یا ISBN',
        'search_button' => 'جستجو',
        'no_books_found' => 'هیچ کتابی یافت نشد.',
        'cover_image' => 'تصویر جلد',
        'actions' => 'اقدامات',
        'books' => 'کتاب‌ها',
        'papers' => 'مقالات',
        'logout' => 'خروج',
        'language' => 'زبان',
        'english' => 'انگلیسی',
        'pashto' => 'پشتو',
        'dari' => 'دری',
        'close' => 'بستن'
    ]
];

$lang = $_SESSION['lang'] ?? 'en';
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function getLocalizedText($key, $lang, $translations) {
    return $translations[$lang][$key] ?? $key;
}

// Handle file download
if (isset($_GET['download'])) {
    $file = "uploads/" . basename($_GET['download']);
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        readfile($file);
        exit;
    } else {
        echo "File not found.";
    }
}

// Insert new book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_name'])) {
    $book_name = $_POST['book_name'];
    $author_name = $_POST['author_name'];
    $isbn_number = $_POST['isbn_number'];
    $genre = $_POST['genre'];
    $publication_date = $_POST['publication_date'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];

    $cover_image = $_FILES['cover_image']['name'];
    $pdf = $_FILES['pdf']['name'];

    if ($cover_image) {
        move_uploaded_file($_FILES['cover_image']['tmp_name'], "uploads/" . $cover_image);
    }
    if ($pdf) {
        move_uploaded_file($_FILES['pdf']['tmp_name'], "uploads/" . $pdf);
    }

    $stmt = $conn->prepare("INSERT INTO books (book_name, author_name, isbn_number, genre, cover_image, pdf, publication_date, publisher, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $book_name, $author_name, $isbn_number, $genre, $cover_image, $pdf, $publication_date, $publisher, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Book added successfully.');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

$search_query = $_GET['search'] ?? '';
$sql = "SELECT * FROM books";
if ($search_query) {
    $sql .= " WHERE book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" <?php echo ($lang == 'ps' || $lang == 'fa') ? 'dir="rtl"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getLocalizedText('books', $lang, $translations); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .book-card { box-shadow: 0 0 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; background: white; }
        .book-card img { width: 100%; height: 250px; object-fit: contain; background: #fff; }
        .book-details { padding: 15px; }
        .book-actions a { margin-right: 5px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo getLocalizedText('books', $lang, $translations); ?></a>
    <div class="ml-auto">
        <a href="?lang=en" class="btn btn-outline-primary btn-sm">English</a>
        <a href="?lang=ps" class="btn btn-outline-primary btn-sm">پښتو</a>
        <a href="?lang=fa" class="btn btn-outline-primary btn-sm">دری</a>
        <a href="downpaper.php" class="btn btn-info btn-sm"><?php echo getLocalizedText('papers', $lang, $translations); ?></a>
        <a href="logout.php" class="btn btn-danger btn-sm"><?php echo getLocalizedText('logout', $lang, $translations); ?></a>
    </div>
</nav>

<div class="container mt-4">
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" class="form-control" placeholder="<?php echo getLocalizedText('search_placeholder', $lang, $translations); ?>">
            <div class="input-group-append">
                <button class="btn btn-primary"><?php echo getLocalizedText('search_button', $lang, $translations); ?></button>
            </div>
        </div>
    </form>

    <div class="row">
    <?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="book-card">
                <img src="uploads/<?php echo $row['cover_image']; ?>" alt="Cover" onerror="this.src='uploads/default.jpg'">
                <div class="book-details">
                    <h5 class="text-primary"><?php echo $row['book_name']; ?></h5>
                    <p><?php echo getLocalizedText('author_name', $lang, $translations); ?>: <?php echo $row['author_name']; ?></p>
                    <p><?php echo getLocalizedText('genre', $lang, $translations); ?>: <?php echo $row['genre']; ?></p>
                    <div class="book-actions">
                        <a href="?download=<?php echo $row['pdf']; ?>" class="btn btn-success btn-sm"><?php echo getLocalizedText('download_pdf', $lang, $translations); ?></a>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal<?php echo $row['book_id']; ?>"><?php echo getLocalizedText('view_details', $lang, $translations); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal<?php echo $row['book_id']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5><?php echo $row['book_name']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img src="uploads/<?php echo $row['cover_image']; ?>" class="w-100 mb-3" alt="Cover" onerror="this.src='uploads/default.jpg'">
                        <p><strong><?php echo getLocalizedText('author_name', $lang, $translations); ?>:</strong> <?php echo $row['author_name']; ?></p>
                        <p><strong><?php echo getLocalizedText('isbn_number', $lang, $translations); ?>:</strong> <?php echo $row['isbn_number']; ?></p>
                        <p><strong><?php echo getLocalizedText('publication_date', $lang, $translations); ?>:</strong> <?php echo $row['publication_date']; ?></p>
                        <p><strong><?php echo getLocalizedText('publisher', $lang, $translations); ?>:</strong> <?php echo $row['publisher']; ?></p>
                        <p><strong><?php echo getLocalizedText('description', $lang, $translations); ?>:</strong> <?php echo $row['description']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; else: ?>
        <p class="text-center w-100"><?php echo getLocalizedText('no_books_found', $lang, $translations); ?></p>
    <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
