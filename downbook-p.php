<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

include 'connection.php';

// Localization function
function getLocalizedText($key, $lang) {
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
        'close' => 'Close',
        'type' => 'Type',
        'all_types' => 'All Types',
        'filter' => 'Filter'
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
        'close' => 'بند',
        'type' => 'ډول',
        'all_types' => 'ټول ډولونه',
        'filter' => 'فلټر'
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
        'close' => 'بستن',
        'type' => 'نوع',
        'all_types' => 'همه نوع‌ها',
        'filter' => 'فیلتر'
    ]
];
 // same as your provided translations
        

    return $translations[$lang][$key] ?? $key;
}

$lang = $_SESSION['lang'] ?? 'en';

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['download'])) {
    $file = $_GET['download'];
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "File not found.";
    }
}

$search_query = $_GET['search'] ?? '';
$filter_genre = $_GET['genre'] ?? '';
$sql = "SELECT * FROM books WHERE 1";
if (!empty($search_query)) {
    $sql .= " AND (book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%')";
}
if (!empty($filter_genre)) {
    $sql .= " AND genre = '" . $conn->real_escape_string($filter_genre) . "'";
}
$result = $conn->query($sql);

// Get all unique genres for the filter dropdown
$genre_options = [];
$genre_sql = "SELECT DISTINCT genre FROM books WHERE genre IS NOT NULL AND genre != '' ORDER BY genre ASC";
$genre_result = $conn->query($genre_sql);
while ($row_genre = $genre_result->fetch_assoc()) {
    $genre_options[] = $row_genre['genre'];
}
$filter_type = $_GET['genre'] ?? '';
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" <?php echo ($lang == 'ps' || $lang == 'fa') ? 'dir="rtl"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, 'Liberation Sans', sans-serif;
            font-size: 0.87rem;
            background: #f4f6fa;
        }
        .container-box {
            background-color: #fff;
            padding: 20px 18px;
            border-radius: 12px;
            margin-top: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: 0 6px 18px rgba(0,0,0,0.10);
        }
        .card-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 1rem;
            font-weight: 600;
            color: #234078;
        }
        .card-text {
            font-size: 0.85rem;
            color: #4a5568;
        }
        .btn, .modal-title, .modal-body, .modal-footer {
            font-size: 0.91rem;
        }
        .btn-success {
            background: #2563eb;
            border: none;
        }
        .btn-success:hover {
            background: #1d4ed8;
        }
        .card-img-top {
            border-radius: 12px 12px 0 0;
            background: #f8fafc;
        }
        .navbar, .navbar-brand {
            font-size: 1rem;
        }
        @media (max-width: 576px) {
            .card-title {
                white-space: normal;
            }
            .container-box {
                padding: 10px 4px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo getLocalizedText('books', $lang); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php"><?php echo getLocalizedText('books', $lang); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="downpaper.php"><?php echo getLocalizedText('papers', $lang); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php"><?php echo getLocalizedText('logout', $lang); ?></a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" data-toggle="dropdown"><?php echo getLocalizedText('language', $lang); ?></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="?lang=en"><?php echo getLocalizedText('english', $lang); ?></a>
                    <a class="dropdown-item" href="?lang=ps"><?php echo getLocalizedText('pashto', $lang); ?></a>
                    <a class="dropdown-item" href="?lang=fa"><?php echo getLocalizedText('dari', $lang); ?></a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="container container-box">
    <h2 class="text-center mb-4"><?php echo getLocalizedText('books', $lang); ?></h2>

    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="<?php echo getLocalizedText('search_placeholder', $lang); ?>" value="<?php echo htmlspecialchars($search_query); ?>">
            <select name="genre" class="custom-select ml-2" style="max-width: 200px;">
                <option value=""><?php echo getLocalizedText('genre', $lang) ?? 'All Genres'; ?></option>
                <?php foreach ($genre_options as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre); ?>" <?php if ($filter_genre == $genre) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($genre); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><?php echo getLocalizedText('search_button', $lang); ?></button>
            </div>
        </div>
    </form>

    <?php if ($result->num_rows > 0) : ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                    <div class="card w-100 shadow-sm">
                        <img src="<?php echo $row['cover_image']; ?>" class="card-img-top img-fluid" alt="Book Cover" style="height: 250px; object-fit: contain;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['book_name']); ?></h5>
                            <p class="card-text text-muted mb-1">
                                <strong><?php echo getLocalizedText('author_name', $lang); ?>:</strong>
                                <?php echo htmlspecialchars($row['author_name']); ?>
                            </p>
                            <p class="card-text text-muted mb-1">
                                <strong><?php echo getLocalizedText('genre', $lang); ?>:</strong>
                                <?php echo htmlspecialchars($row['genre']); ?>
                            </p>
                            <p class="card-text text-muted mb-1">
                                <strong><?php echo getLocalizedText('isbn_number', $lang); ?>:</strong>
                                <?php echo htmlspecialchars($row['isbn_number']); ?>
                            </p>
                            <p class="card-text text-muted mb-1">
                                <strong><?php echo getLocalizedText('publication_date', $lang); ?>:</strong>
                                <?php echo htmlspecialchars($row['publication_date']); ?>
                            </p>
                            <p class="card-text text-muted mb-2">
                                <strong><?php echo getLocalizedText('publisher', $lang); ?>:</strong>
                                <?php echo htmlspecialchars($row['publisher']); ?>
                            </p>
                            <div class="mt-auto">
                                <a href="?download=<?php echo $row['pdf']; ?>" class="btn btn-success btn-sm w-100"><?php echo getLocalizedText('download_pdf', $lang); ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="bookModal<?php echo $row['book_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel<?php echo $row['book_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo htmlspecialchars($row['book_name']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo $row['cover_image']; ?>" class="img-fluid mb-3" alt="Cover Image" style="max-height: 200px; object-fit: contain;">
                                <p><strong><?php echo getLocalizedText('author_name', $lang); ?>:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>
                                <p><strong><?php echo getLocalizedText('isbn_number', $lang); ?>:</strong> <?php echo htmlspecialchars($row['isbn_number']); ?></p>
                                <p><strong><?php echo getLocalizedText('genre', $lang); ?>:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                                <p><strong><?php echo getLocalizedText('publication_date', $lang); ?>:</strong> <?php echo htmlspecialchars($row['publication_date']); ?></p>
                                <p><strong><?php echo getLocalizedText('publisher', $lang); ?>:</strong> <?php echo htmlspecialchars($row['publisher']); ?></p>
                                <p><strong><?php echo getLocalizedText('description', $lang); ?>:</strong> <?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo getLocalizedText('close', $lang); ?></button>
                                <a href="?download=<?php echo $row['pdf']; ?>" class="btn btn-primary"><?php echo getLocalizedText('download_pdf', $lang); ?></a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center"><?php echo getLocalizedText('no_books_found', $lang); ?></p>
    <?php endif; ?>
</div>
<?php include('back-to-top.html'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
