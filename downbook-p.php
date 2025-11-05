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
    $file = basename($_GET['download']); // Prevent directory traversal
    $filepath = 'uploads/' . $file;
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
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

function isImage($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" <?php echo ($lang == 'ps' || $lang == 'fa') ? 'dir="rtl"' : 'dir="ltr"'; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, 'Liberation Sans', sans-serif;
            font-size: 0.87rem;
            background: #f4f6fa;
            <?php if ($lang == 'ps' || $lang == 'fa') : ?>
            direction: rtl;
            text-align: right;
            <?php else: ?>
            direction: ltr;
            text-align: left;
            <?php endif; ?>
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
            .container-box {
                padding: 6px 2px !important;
                margin-top: 10px !important;
            }
            .list-group-item {
                flex-direction: column !important;
                align-items: flex-start !important;
                padding: 14px 8px !important;
            }
            .list-group-item > .d-flex {
                min-width: 100% !important;
                margin-bottom: 10px !important;
                justify-content: flex-start !important;
            }
            .img-thumbnail {
                width: 90px !important;
                height: 120px !important;
                margin-right: 0 !important;
                margin-bottom: 10px !important;
            }
            .flex-grow-1 {
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .ml-auto {
                margin-left: 0 !important;
                margin-top: 10px !important;
                width: 100%;
                justify-content: flex-end !important;
                display: flex !important;
            }
            .btn-lg {
                width: 100% !important;
                font-size: 1rem !important;
                padding: 10px 0 !important;
            }
            h5.mb-2 {
                font-size: 1.1rem !important;
                margin-bottom: 0.5rem !important;
            }
            .mb-2, .mb-1 {
                font-size: 0.97rem !important;
            }
            /* Each feature in one line on mobile */
            .book-feature-row {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                margin-bottom: 6px !important;
                gap: 8px;
                flex-wrap: wrap;
            }
            .book-feature-row span,
            .book-feature-row .badge {
                margin-bottom: 0 !important;
                margin-right: 0 !important;
                margin-left: 0 !important;
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
    <h2 class="text-center mb-4" style="font-size:2rem; font-weight:700; color:#234078; letter-spacing:1px;">
        <i class="fas fa-book-open mr-2 text-primary"></i>
        <?php echo getLocalizedText('books', $lang); ?>
    </h2>

    <?php
    // --- Sorting logic for SQL ---
    $sort = $_GET['sort'] ?? '';
    $order_by = "ORDER BY book_name ASC";
    if ($sort == 'name_desc') $order_by = "ORDER BY book_name DESC";
    elseif ($sort == 'date_new') $order_by = "ORDER BY publication_date DESC";
    elseif ($sort == 'date_old') $order_by = "ORDER BY publication_date ASC";

    // Re-run the query with sorting
    $sql = "SELECT * FROM books WHERE 1";
    if (!empty($search_query)) {
        $sql .= " AND (book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%')";
    }
    if (!empty($filter_genre)) {
        $sql .= " AND genre = '" . $conn->real_escape_string($filter_genre) . "'";
    }
    $sql .= " $order_by";
    $result = $conn->query($sql);
    ?>

    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control search-input" style="font-size:1rem;" placeholder="<?php echo getLocalizedText('search_placeholder', $lang); ?>" value="<?php echo htmlspecialchars($search_query); ?>">
            <select name="genre" class="custom-select ml-2" style="max-width: 200px; font-size:1rem;">
                <option value=""><?php echo getLocalizedText('genre', $lang) ?? 'All Genres'; ?></option>
                <?php foreach ($genre_options as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre); ?>" <?php if ($filter_genre == $genre) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($genre); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary search-btn" style="font-size:1rem;" type="submit">
                    <i class="fas fa-search mr-1"></i><?php echo getLocalizedText('search_button', $lang); ?>
                </button>
            </div>
        </div>
    </form>

    <?php if ($result->num_rows > 0) : ?>
        <div class="list-group">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <?php
                    $cover = $row['cover_image'];
                    if (strpos($cover, 'uploads/') === 0) {
                        $img_src = $cover;
                    } else {
                        $img_src = 'uploads/' . $cover;
                    }
                ?>
                <div class="list-group-item mb-4 py-4 px-3 d-flex align-items-center rounded shadow-sm flex-column flex-sm-row" style="background:#f8fafc; border:1px solid #e3e8f0;">
                    <div class="d-flex align-items-center justify-content-center mb-3 mb-sm-0" style="min-width:180px;">
                        <img src="<?php echo htmlspecialchars($img_src); ?>"
                             alt="Book Cover"
                             class="img-thumbnail mr-0 mr-sm-4"
                             style="width: 180px; height: 250px; object-fit: cover; border-radius:12px; background:#f8fafc; box-shadow:0 2px 8px rgba(44,62,80,0.08);">
                    </div>
                    <div class="flex-grow-1 w-100" style="margin-<?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>:32px;">
                        <h5 class="mb-2" style="font-size:1.35rem; color:#234078; font-weight:700; letter-spacing:0.5px;">
                            <?php echo htmlspecialchars($row['book_name']); ?>
                        </h5>
                        <div class="book-feature-row mb-2" style="font-size:1.08rem;">
                            <span class="badge badge-primary mr-2 mb-1" style="font-size:0.98rem;">
                                <i class="fas fa-user mr-1"></i><?php echo getLocalizedText('author_name', $lang); ?>
                            </span>
                            <span class="text-secondary mr-3"><?php echo htmlspecialchars($row['author_name']); ?></span>
                        </div>
                        <div class="book-feature-row mb-2" style="font-size:1.03rem;">
                            <span class="badge badge-secondary mr-2 mb-1" style="font-size:0.98rem;">
                                <i class="fas fa-barcode mr-1"></i><?php echo getLocalizedText('isbn_number', $lang); ?>
                            </span>
                            <span class="text-secondary mr-3"><?php echo htmlspecialchars($row['isbn_number']); ?></span>
                        </div>
                        <div class="book-feature-row mb-2" style="font-size:1.03rem;">
                            <span class="badge badge-warning mr-2 mb-1" style="font-size:0.98rem;">
                                <i class="fas fa-calendar-alt mr-1"></i><?php echo getLocalizedText('publication_date', $lang); ?>
                            </span>
                            <span class="text-secondary"><?php echo htmlspecialchars($row['publication_date']); ?></span>
                        </div>
                        <div class="book-feature-row mb-2" style="font-size:1.03rem;">
                            <span class="badge badge-success mr-2 mb-1" style="font-size:0.98rem;">
                                <i class="fas fa-building mr-1"></i><?php echo getLocalizedText('publisher', $lang); ?>
                            </span>
                            <span class="text-secondary"><?php echo htmlspecialchars($row['publisher']); ?></span>
                        </div>
                    </div>
                    <div class="ml-auto d-flex flex-column align-items-center mt-3 mt-sm-0">
                        <a href="?download=<?php echo urlencode(basename($row['pdf'])); ?>" class="btn btn-success btn-lg mb-2" style="min-width:140px;">
                            <i class="fas fa-download mr-2"></i><?php echo getLocalizedText('download_pdf', $lang); ?>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-muted" style="font-size:1.1rem;"><?php echo getLocalizedText('no_books_found', $lang); ?></p>
    <?php endif; ?>
</div>
<?php include('back-to-top.html'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
