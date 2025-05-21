<?php
session_start();
include 'connection.php';

// Check if the language is set in the session
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; // Default to English
}

// Handle language switching from query parameter
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ps', 'fa'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Get the current language from session
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
            'home' => 'Home',
            'logout' => 'Logout',
            'paper' => 'Add Paper',
            'type' => 'Type:',
            'book' => 'Book',
            'magazine' => 'Magazine',
            'journal' => 'Journal',
            'thesis' => 'Thesis'
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
            'home' => 'کور',
            'logout' => 'وتل',
            'paper' => 'مقاله ثبت کړئ',
            'type' => 'ډول:',
            'book' => 'کتاب',
            'magazine' => 'مجله',
            'journal' => 'ژورنال',
            'thesis' => 'تیزس'
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
            'home' => 'خانه',
            'logout' => 'خروج',
            'paper' => 'ثبت مقاله',
            'type' => 'نوعیت:',
            'book' => 'کتاب',
            'magazine' => 'مجله',
            'journal' => 'ژورنال',
            'thesis' => 'پایان‌نامه'
        ]
    ];
    return $translations[$lang][$key] ?? $key;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
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
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 <?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">

<!-- Language Selection Navbar -->
<nav class="sticky top-0 z-10 bg-white shadow-md mb-8">
    <div class="max-w-3xl mx-auto flex flex-wrap items-center justify-between gap-2 px-4 py-3">
        <!-- Logo / Title -->
        <div class="flex items-center gap-2">
            <span class="text-2xl font-extrabold text-blue-700 tracking-tight">eLibrary</span>
            <span class="hidden sm:inline-block text-gray-400 text-lg">|</span>
            <span class="text-base font-semibold text-blue-500"><?php echo getLocalizedText('register_book', $lang); ?></span>
        </div>
        <!-- Hamburger for mobile -->
        <div class="sm:hidden flex items-center">
            <button id="nav-toggle" class="text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <!-- Nav Links -->
        <div id="nav-menu" class="w-full sm:w-auto flex-col sm:flex-row flex gap-2 mt-3 sm:mt-0 sm:flex hidden sm:flex">
            <!-- Language Switcher Styled -->
            <div class="flex gap-1 bg-blue-50 rounded-lg px-2 py-1 shadow-inner">
                <a href="?lang=en" class="px-3 py-1 rounded-lg text-sm font-semibold transition
                    <?php echo $lang == 'en' ? 'bg-blue-600 text-white shadow' : 'text-blue-700 hover:bg-blue-100'; ?>">
                    <?php echo getLocalizedText('english', $lang); ?>
                </a>
                <a href="?lang=ps" class="px-3 py-1 rounded-lg text-sm font-semibold transition
                    <?php echo $lang == 'ps' ? 'bg-blue-600 text-white shadow' : 'text-blue-700 hover:bg-blue-100'; ?>">
                    <?php echo getLocalizedText('pashto', $lang); ?>
                </a>
                <a href="?lang=fa" class="px-3 py-1 rounded-lg text-sm font-semibold transition
                    <?php echo $lang == 'fa' ? 'bg-blue-600 text-white shadow' : 'text-blue-700 hover:bg-blue-100'; ?>">
                    <?php echo getLocalizedText('dari', $lang); ?>
                </a>
            </div>
            <!-- Other Links -->
            <a class="text-blue-500 hover:text-blue-700 font-medium transition" href="add_paper_entry.php"><?php echo getLocalizedText('paper', $lang); ?></a>
            <a class="text-red-500 hover:text-red-700 font-medium transition" href="logout.php"><?php echo getLocalizedText('logout', $lang); ?></a>
        </div>
    </div>
    <script>
        // Simple hamburger menu toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('nav-toggle');
            const navMenu = document.getElementById('nav-menu');
            navToggle.addEventListener('click', function() {
                navMenu.classList.toggle('hidden');
            });
        });
    </script>
</nav>

<!-- Register Book Form -->
<div class="flex justify-center items-center min-h-[70vh] px-2">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-6 sm:p-10 border border-blue-100">
        <h2 class="text-3xl font-extrabold text-center text-blue-700 mb-8 tracking-tight drop-shadow">
            <?php echo getLocalizedText('register_book', $lang); ?>
        </h2>
        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="bookName" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('book_name', $lang); ?>
                    </label>
                    <input type="text" id="bookName" name="bookName"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-blue-50"
                        required>
                </div>
                <div>
                    <label for="authorName" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('author_name', $lang); ?>
                    </label>
                    <input type="text" id="authorName" name="authorName"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-blue-50"
                        required>
                </div>
                <div>
                    <label for="isbnNumber" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('isbn_number', $lang); ?>
                    </label>
                    <input type="text" id="isbnNumber" name="isbnNumber"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-blue-50"
                        required>
                </div>
                <div>
                    <label for="genre" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('genre', $lang); ?>
                    </label>
                    <select id="genre" name="genre"
                        class="w-full border border-gray-300 p-3 rounded-lg bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="book"><?php echo getLocalizedText('book', $lang); ?></option>
                        <option value="magazine"><?php echo getLocalizedText('magazine', $lang); ?></option>
                        <option value="journal"><?php echo getLocalizedText('journal', $lang); ?></option>
                        <option value="thesis"><?php echo getLocalizedText('thesis', $lang); ?></option>
                    </select>
                </div>
                <div>
                    <label for="coverImage" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('cover_image', $lang); ?>
                    </label>
                    <input type="file" id="coverImage" name="coverImage"
                        class="w-full border border-gray-300 p-3 rounded-lg bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
                <div>
                    <label for="pdf" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('pdf', $lang); ?>
                    </label>
                    <input type="file" id="pdf" name="pdf"
                        class="w-full border border-gray-300 p-3 rounded-lg bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
                <div>
                    <label for="publicationDate" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('publication_date', $lang); ?>
                    </label>
                    <input type="date" id="publicationDate" name="publicationDate"
                        class="w-full border border-gray-300 p-3 rounded-lg bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
                <div>
                    <label for="publisher" class="block text-gray-700 font-semibold mb-1">
                        <?php echo getLocalizedText('publisher', $lang); ?>
                    </label>
                    <input type="text" id="publisher" name="publisher"
                        class="w-full border border-gray-300 p-3 rounded-lg bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-200 text-lg mt-4">
                <?php echo getLocalizedText('register', $lang); ?>
            </button>
        </form>
    </div>
</div>

</body>
</html>
