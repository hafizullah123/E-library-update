<?php
session_start();
include 'db.php';

// Check user login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Language handling
if (!isset($_SESSION['lang'])) $_SESSION['lang'] = 'en';
if (isset($_GET['lang'])) $_SESSION['lang'] = $_GET['lang'];
$lang = $_SESSION['lang'];

// Localization function
function t($key, $lang) {
    $translations = [
        'en' => [
            'update_book_details' => 'Update Book Details',
            'book_name' => 'Book Name',
            'author_name' => 'Author Name',
            'isbn_number' => 'ISBN Number',
            'genre' => 'Genre',
            'cover_image' => 'Cover Image',
            'pdf' => 'PDF',
            'publication_date' => 'Publication Date',
            'publisher' => 'Publisher',
            'description' => 'Description',
            'update' => 'Update',
            'search_placeholder' => 'Search by Name or ISBN',
            'search' => 'Search',
            'no_books_found' => 'No books found.',
            'actions' => 'Actions',
            'language' => 'Language:',
            'english' => 'English',
            'pashto' => 'Pashto',
            'dari' => 'Dari',
            'home' => 'Home'
        ],
        'ps' => [
            'update_book_details' => 'د کتاب جزئیات تازه کړئ',
            'book_name' => 'د کتاب نوم',
            'author_name' => 'د لیکوال نوم',
            'isbn_number' => 'د ISBN شمېره',
            'genre' => 'ژانر',
            'cover_image' => 'د پوښ انځور',
            'pdf' => 'PDF',
            'publication_date' => 'د خپرېدو نېټه',
            'publisher' => 'خپرندوی',
            'description' => 'تشریح',
            'update' => 'تازه کړئ',
            'search_placeholder' => 'د نوم یا ISBN له مخې پلټنه',
            'search' => 'پلټنه',
            'no_books_found' => 'هیڅ کتاب ونه موندل شو.',
            'actions' => 'عملیات',
            'language' => 'ژبه:',
            'english' => 'انګلیسي',
            'pashto' => 'پښتو',
            'dari' => 'دري',
            'home' => 'کور'
        ],
        'fa' => [
            'update_book_details' => 'جزئیات کتاب را به روز کنید',
            'book_name' => 'نام کتاب',
            'author_name' => 'نام نویسنده',
            'isbn_number' => 'شماره ISBN',
            'genre' => 'ژانر',
            'cover_image' => 'تصویر جلد',
            'pdf' => 'PDF',
            'publication_date' => 'تاریخ انتشار',
            'publisher' => 'ناشر',
            'description' => 'توضیحات',
            'update' => 'به روز رسانی',
            'search_placeholder' => 'جستجو بر اساس نام یا ISBN',
            'search' => 'جستجو',
            'no_books_found' => 'هیچ کتابی یافت نشد.',
            'actions' => 'عملیات',
            'language' => 'زبان:',
            'english' => 'انگلیسی',
            'pashto' => 'پشتو',
            'dari' => 'دری',
            'home' => 'خانه'
        ]
    ];
    return $translations[$lang][$key] ?? $key;
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('update_book_details', $lang); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo t('language', $lang); ?></a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="?lang=en"><?php echo t('english', $lang); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="?lang=ps"><?php echo t('pashto', $lang); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="?lang=fa"><?php echo t('dari', $lang); ?></a></li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="dashboard.php"><?php echo t('home', $lang); ?></a></li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
