<?php
// Set language from the query parameter or default to 'en' (English)
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Make sure to validate the language
if (!in_array($lang, ['en', 'ps', 'fa'])) {
    $lang = 'en'; // Default to English if the language is not valid
}

// Function to get localized text based on the current language
function getLocalizedText($key, $lang) {
    $translations = [
        'en' => [
            'books' => 'Books',
            'papers' => 'Papers',
            'logout' => 'Logout',
            'language' => 'Language',
            'english' => 'English',
            'pashto' => 'Pashto',
            'dari' => 'Dari',
            'search_placeholder' => 'Search for books...',
            'search_button' => 'Search',
            'download_pdf' => 'Download PDF',
            'view_details' => 'View Details',
            'author_name' => 'Author',
            'isbn_number' => 'ISBN',
            'genre' => 'Genre',
            'publication_date' => 'Publication Date',
            'publisher' => 'Publisher',
            'description' => 'Description',
            'close' => 'Close',
            'no_books_found' => 'No books found',
        ],
        'ps' => [
            'books' => 'کتابونه',
            'papers' => 'مقالې',
            'logout' => 'وتل',
            'language' => 'ژبه',
            'english' => 'انګلیسي',
            'pashto' => 'پښتو',
            'dari' => 'دری',
            'search_placeholder' => 'د کتابونو لټون...',
            'search_button' => 'لټون',
            'download_pdf' => 'PDF ډاونلوډ کړئ',
            'view_details' => 'تفصیلات وګورئ',
            'author_name' => 'لیکوال',
            'isbn_number' => 'ISBN',
            'genre' => 'ژانر',
            'publication_date' => 'د خپرېدو نېټه',
            'publisher' => 'چاپونکی',
            'description' => 'تفصیل',
            'close' => 'بندول',
            'no_books_found' => 'هیڅ کتاب ونه موندل شو',
        ],
        'fa' => [
            'books' => 'کتاب‌ها',
            'papers' => 'مقالات',
            'logout' => 'خروج',
            'language' => 'زبان',
            'english' => 'انگلیسی',
            'pashto' => 'پشتو',
            'dari' => 'دری',
            'search_placeholder' => 'جستجو برای کتاب‌ها...',
            'search_button' => 'جستجو',
            'download_pdf' => 'دانلود PDF',
            'view_details' => 'مشاهده جزئیات',
            'author_name' => 'نویسنده',
            'isbn_number' => 'ISBN',
            'genre' => 'ژانر',
            'publication_date' => 'تاریخ انتشار',
            'publisher' => 'ناشر',
            'description' => 'توضیحات',
            'close' => 'بستن',
            'no_books_found' => 'کتابی پیدا نشد',
        ]
    ];

    // Return the translation based on the current language
    return isset($translations[$lang][$key]) ? $translations[$lang][$key] : $translations['en'][$key];
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" <?php echo ($lang == 'ps' || $lang == 'fa') ? 'dir="rtl"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom styling for RTL */
        <?php if ($lang == 'ps' || $lang == 'fa') : ?>
        body {
            direction: rtl;
            text-align: right;
        }
        <?php endif; ?>
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo getLocalizedText('books', $lang); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#"><?php echo getLocalizedText('books', $lang); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo getLocalizedText('papers', $lang); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo getLocalizedText('logout', $lang); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo getLocalizedText('language', $lang); ?></a>
                <ul>
                    <li><a href="?lang=en"><?php echo getLocalizedText('english', $lang); ?></a></li>
                    <li><a href="?lang=ps"><?php echo getLocalizedText('pashto', $lang); ?></a></li>
                    <li><a href="?lang=fa"><?php echo getLocalizedText('dari', $lang); ?></a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- Search Form -->
<div class="container my-4">
    <input type="text" class="form-control" placeholder="<?php echo getLocalizedText('search_placeholder', $lang); ?>" aria-label="Search">
    <button class="btn btn-primary mt-2"><?php echo getLocalizedText('search_button', $lang); ?></button>
</div>

<!-- Book Details Section -->
<div class="container">
    <h2><?php echo getLocalizedText('books', $lang); ?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo getLocalizedText('author_name', $lang); ?></th>
                <th><?php echo getLocalizedText('isbn_number', $lang); ?></th>
                <th><?php echo getLocalizedText('genre', $lang); ?></th>
                <th><?php echo getLocalizedText('publication_date', $lang); ?></th>
                <th><?php echo getLocalizedText('publisher', $lang); ?></th>
                <th><?php echo getLocalizedText('description', $lang); ?></th>
                <th><?php echo getLocalizedText('download_pdf', $lang); ?></th>
                <th><?php echo getLocalizedText('view_details', $lang); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Author Name</td>
                <td>12345</td>
                <td>Fiction</td>
                <td>2023-01-01</td>
                <td>Publisher Name</td>
                <td>Description of the book</td>
                <td><a href="#">Download</a></td>
                <td><button class="btn btn-info"><?php echo getLocalizedText('view_details', $lang); ?></button></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Footer -->
<footer class="bg-light py-4">
    <div class="container text-center">
        <p><?php echo getLocalizedText('no_books_found', $lang); ?></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
