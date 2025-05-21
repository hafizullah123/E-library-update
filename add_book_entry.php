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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
    $book_name = $_POST['bookName'] ?? '';
    $author_name = $_POST['authorName'] ?? '';
    $isbn_number = $_POST['isbnNumber'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $publication_date = $_POST['publicationDate'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    // $description = $_POST['description'] ?? ''; // Uncomment if you add description field
    $description = ''; // No description field in form currently

    // Handle file uploads
    $cover_image = '';
    if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
        $cover_image = time() . '_' . basename($_FILES['coverImage']['name']);
        move_uploaded_file($_FILES['coverImage']['tmp_name'], 'uploads/' . $cover_image);
    }

    $pdf = '';
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $pdf = time() . '_' . basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], 'uploads/' . $pdf);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO books (book_name, author_name, isbn_number, genre, cover_image, pdf, publication_date, publisher, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $book_name, $author_name, $isbn_number, $genre, $cover_image, $pdf, $publication_date, $publisher, $description);

    if ($stmt->execute()) {
        // Success message (you can show this in your HTML)
        $success = true;
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
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
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl p-10 sm:p-16 border border-blue-100 transition-all duration-300">
        <h2 class="text-5xl font-extrabold text-center text-blue-700 mb-12 tracking-tight drop-shadow-lg">
            <?php echo getLocalizedText('register_book', $lang); ?>
        </h2>
        <?php if (!empty($success)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-center">Book registered successfully!</div>
        <?php elseif (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-center"><?= $error ?></div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data" class="space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label for="bookName" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('book_name', $lang); ?>
                    </label>
                    <input type="text" id="bookName" name="bookName"
                        class="w-full border border-blue-300 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50 shadow"
                        placeholder="<?php echo getLocalizedText('book_name', $lang); ?>" required>
                </div>
                <div>
                    <label for="authorName" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('author_name', $lang); ?>
                    </label>
                    <input type="text" id="authorName" name="authorName"
                        class="w-full border border-blue-300 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50 shadow"
                        placeholder="<?php echo getLocalizedText('author_name', $lang); ?>" required>
                </div>
                <div>
                    <label for="isbnNumber" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('isbn_number', $lang); ?>
                    </label>
                    <input type="text" id="isbnNumber" name="isbnNumber"
                        class="w-full border border-blue-300 p-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50 shadow"
                        placeholder="<?php echo getLocalizedText('isbn_number', $lang); ?>" required>
                </div>
                <div>
                    <label for="genre" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('genre', $lang); ?>
                    </label>
                    <select id="genre" name="genre"
                        class="w-full border border-blue-300 p-4 rounded-2xl bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow"
                        required>
                        <option value="book"><?php echo getLocalizedText('book', $lang); ?></option>
                        <option value="magazine"><?php echo getLocalizedText('magazine', $lang); ?></option>
                        <option value="journal"><?php echo getLocalizedText('journal', $lang); ?></option>
                        <option value="thesis"><?php echo getLocalizedText('thesis', $lang); ?></option>
                    </select>
                </div>
                <div>
                    <label for="coverImage" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('cover_image', $lang); ?>
                    </label>
                    <input type="file" id="coverImage" name="coverImage"
                        class="w-full border border-blue-300 p-4 rounded-2xl bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow"
                        required>
                </div>
                <div>
                    <label for="pdf" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('pdf', $lang); ?>
                    </label>
                    <input type="file" id="pdf" name="pdf"
                        class="w-full border border-blue-300 p-4 rounded-2xl bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow"
                        required>
                </div>
                <div>
                    <label for="publicationDate" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('publication_date', $lang); ?>
                    </label>
                    <input type="date" id="publicationDate" name="publicationDate"
                        class="w-full border border-blue-300 p-4 rounded-2xl bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow"
                        required>
                </div>
                <div>
                    <label for="publisher" class="block text-gray-700 font-semibold mb-2">
                        <?php echo getLocalizedText('publisher', $lang); ?>
                    </label>
                    <input type="text" id="publisher" name="publisher"
                        class="w-full border border-blue-300 p-4 rounded-2xl bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow"
                        placeholder="<?php echo getLocalizedText('publisher', $lang); ?>" required>
                </div>
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-700 to-blue-400 hover:from-blue-800 hover:to-blue-500 text-white font-bold py-5 px-10 rounded-3xl shadow-2xl transition-all duration-200 text-2xl mt-8 tracking-wider">
                <?php echo getLocalizedText('register', $lang); ?>
            </button>
        </form>

        <!-- Display uploaded cover image after successful registration -->
        <?php if (!empty($success) && !empty($cover_image)): ?>
            <div class="mb-6 flex flex-col items-center">
                <span class="mb-2 text-blue-700 font-semibold"><?php echo getLocalizedText('cover_image', $lang); ?>:</span>
                <img src="uploads/<?php echo htmlspecialchars($cover_image); ?>" alt="Cover Image" class="w-40 h-56 object-cover rounded shadow border border-blue-200">
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
