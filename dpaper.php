<?php
// Start the session to store the selected language
session_start();

// Set default language to English if not set
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Handle language change
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Load language file based on selected language
$language = $_SESSION['lang'];

// Translation arrays
$translations = [
    'en' => [
        'title' => 'Digital Library',
        'search_placeholder' => 'Search by title, author, or university',
        'all_types' => 'All Types',
        'thesis' => 'Thesis',
        'dissertation' => 'Dissertation',
        'journal' => 'Journal',
        'other' => 'Other',
        'search' => 'Search',
        'read' => 'Read',
        'download' => 'Download',
        'no_results' => 'No research papers found.',
        'university' => 'University',
        'author' => 'Author',
        'guider' => 'Guider',
        'department' => 'Department',
        'section' => 'Section',
        'date' => 'Date',
        'book' => 'Books',
        'logout' => 'Logout',
    ],
    'ps' => [
        'title' => ' دیجیتلی کتابتون',
        'search_placeholder' => 'د سرلیک، لیکوال یا پوهنتون له مخې لټون',
        'all_types' => 'ټول ډولونه',
        'thesis' => 'تېزس',
        'dissertation' => 'دکتوراه',
        'journal' => 'مجله',
        'other' => 'نور',
        'search' => 'لټون',
        'read' => 'ولولئ',
        'download' => 'ډاونلوډ',
        'no_results' => 'هیڅ تحقیق نه دی موندل شوی.',
        'university' => 'پوهنتون',
        'author' => 'لیکوال',
        'guider' => ' لارښود',
        'department' => 'پوهنځی',
        'section' => 'څانګه',
        'date' => 'نیټه',
        'book' => 'کتابونه',
        'logout' => 'وتل',
    ],
    'fa' => [
        'title' => 'کتابخانه دیجیتال',
        'search_placeholder' => 'جستجو بر اساس عنوان، نویسنده یا پوهنتون',
        'all_types' => 'تمام نوع ها',
        'thesis' => 'پایان نامه',
        'dissertation' => 'رساله',
        'journal' => 'مجله',
        'other' => 'سایر',
        'search' => 'جستجو',
        'read' => 'مطالعه',
        'download' => 'دانلود',
        'no_results' => 'هیچ مقاله تحقیقاتی پیدا نشد.',
        'university' => 'پوهنتون',
        'author' => 'نویسنده',
        'guider' => ' استاد راهنما',
        'department' => 'پوهنځی',
        'section' => 'دیپارتمنت',
        'date' => 'تاریخ',
        'book' => 'کتاب ها',
        'logout' => 'خروج',
    ],
];

// Set language direction
$dir = ($language == 'ps' || $language == 'fa') ? 'rtl' : 'ltr';

// Database connection
include('connection.php');

// Handle search and filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Prepare the base query
$sql = "SELECT * FROM research_papers WHERE 1";

// Apply search filter if there's a search term
if (!empty($search)) {
    $sql .= " AND (title LIKE '%$search%' OR author_name LIKE '%$search%' OR university LIKE '%$search%')";
}

// Apply type filter if a type is selected
if (!empty($type)) {
    $sql .= " AND type = '$type'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $translations[$language]['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {},
            },
            plugins: [require('@tailwindcss/line-clamp')],
        }
    </script>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-blue-600 text-white p-4 mb-6">
    <div class="container mx-auto flex justify-between items-center">
        <a href="#" class="text-xl font-semibold"><?= $translations[$language]['title'] ?></a>

        <!-- Language Selection -->
        <form method="get" class="flex items-center gap-4">
            <select name="lang" onchange="this.form.submit()" class="p-2 border rounded bg-blue-600 text-white">
                <option value="en" <?= $language == 'en' ? 'selected' : '' ?>>English</option>
                <option value="ps" <?= $language == 'ps' ? 'selected' : '' ?>>Pashto</option>
                <option value="fa" <?= $language == 'fa' ? 'selected' : '' ?>>Dari</option>
            </select>
        </form>

        <!-- Navbar Links -->
        <div class="flex gap-4">
            <a href="books.php" class="text-white"><?= $translations[$language]['book'] ?></a>
            <a href="logout.php" class="text-white"><?= $translations[$language]['logout'] ?></a>
        </div>
    </div>
</nav>

<!-- Content Section -->
<div class="container mx-auto px-4">
    <!-- Search & Filter -->
    <form class="flex flex-wrap gap-4 mb-6" method="get">
        <input type="text" name="search" placeholder="<?= $translations[$language]['search_placeholder'] ?>"
               value="<?= htmlspecialchars($search) ?>"
               class="flex-1 min-w-[200px] p-2 border rounded">

        <select name="type" class="p-2 border rounded min-w-[150px]">
            <option value=""><?= $translations[$language]['all_types'] ?></option>
            <option value="Thesis" <?= $type == 'Thesis' ? 'selected' : '' ?>><?= $translations[$language]['thesis'] ?></option>
            <option value="Dissertation" <?= $type == 'Dissertation' ? 'selected' : '' ?>><?= $translations[$language]['dissertation'] ?></option>
            <option value="Journal" <?= $type == 'Journal' ? 'selected' : '' ?>><?= $translations[$language]['journal'] ?></option>
            <option value="Other" <?= $type == 'Other' ? 'selected' : '' ?>><?= $translations[$language]['other'] ?></option>
        </select>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded"><?= $translations[$language]['search'] ?></button>
    </form>

    <!-- Paper Cards -->
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="bg-white p-4 mb-6 rounded shadow border">
                <div class="font-bold text-lg mb-2">
                    <?= htmlspecialchars($row['title']) ?>
                    <span class="ml-2 bg-gray-300 text-gray-700 px-2 py-1 rounded text-sm"><?= htmlspecialchars($row['type']) ?></span>
                </div>
                <div class="text-sm text-gray-600 mb-2">
                    <?= $translations[$language]['university'] ?>: <?= htmlspecialchars($row['university']) ?> |
                    <?= $translations[$language]['author'] ?>: <?= htmlspecialchars($row['author_name']) ?> |
                    <?= $translations[$language]['guider'] ?>: <?= htmlspecialchars($row['guider']) ?> |
                    <?= $translations[$language]['department'] ?>: <?= htmlspecialchars($row['department']) ?> |
                    <?= $translations[$language]['section'] ?>: <?= htmlspecialchars($row['section']) ?> |
                    <?= $translations[$language]['date'] ?>: <?= htmlspecialchars($row['publication_date']) ?>
                </div>
                <div class="text-gray-700 line-clamp-3">
                    <?= nl2br(htmlspecialchars($row['description'])) ?>
                </div>
                <div class="mt-3 space-x-2">
                    <!-- Read and Download buttons -->
                    <a href="paper/<?= htmlspecialchars($row['pdf']) ?>" target="_blank"
                       class="bg-blue-600 text-white px-4 py-1 rounded text-sm"><?= $translations[$language]['read'] ?></a>
                    <a href="paper/<?= htmlspecialchars($row['pdf']) ?>" download
                       class="bg-gray-700 text-white px-4 py-1 rounded text-sm"><?= $translations[$language]['download'] ?></a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-red-500"><?= $translations[$language]['no_results'] ?></p>
    <?php endif; ?>
</div>

</body>
</html>
