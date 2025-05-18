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

// Apply search filter
if (!empty($search)) {
    $sql .= " AND (title LIKE '%$search%' OR author_name LIKE '%$search%' OR university LIKE '%$search%')";
}

// Apply type filter
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
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-blue-800 text-white py-4 shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <a href="#" class="text-xl font-semibold"><?= $translations[$language]['title'] ?></a>

        <!-- Language Selection -->
        <form method="get" class="flex items-center gap-4">
            <select name="lang" onchange="this.form.submit()"
                class="p-2 border border-blue-700 rounded bg-blue-800 text-white focus:ring-2 focus:ring-blue-400 transition">
                <option value="en" <?= $language == 'en' ? 'selected' : '' ?>>English</option>
                <option value="ps" <?= $language == 'ps' ? 'selected' : '' ?>>Pashto</option>
                <option value="fa" <?= $language == 'fa' ? 'selected' : '' ?>>Dari</option>
            </select>
        </form>

        <div class="flex gap-4">
            <a href="dbook.php" class="text-white font-semibold"><?= $translations[$language]['book'] ?></a>
            <a href="logout.php"
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-md transition font-semibold">
               <?= $translations[$language]['logout'] ?>
            </a>
        </div>
    </div>
</nav>

<!-- Content Section -->
<div class="container mx-auto px-4 mt-6">
    <!-- Search & Filter -->
    <form class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4 mb-6" method="get">
        <input
            type="text"
            name="search"
            placeholder="<?= $translations[$language]['search_placeholder'] ?>"
            value="<?= htmlspecialchars($search) ?>"
            class="w-full md:flex-1 p-2 border rounded"
        />

        <select
            name="type"
            class="w-full md:w-48 p-2 border rounded"
        >
            <option value=""><?= $translations[$language]['all_types'] ?></option>
            <option value="Thesis" <?= $type == 'Thesis' ? 'selected' : '' ?>><?= $translations[$language]['thesis'] ?></option>
            <option value="Dissertation" <?= $type == 'Dissertation' ? 'selected' : '' ?>><?= $translations[$language]['dissertation'] ?></option>
            <option value="Journal" <?= $type == 'Journal' ? 'selected' : '' ?>><?= $translations[$language]['journal'] ?></option>
            <option value="Other" <?= $type == 'Other' ? 'selected' : '' ?>><?= $translations[$language]['other'] ?></option>
        </select>

        <button
            type="submit"
            class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow transition"
        >
            <?= $translations[$language]['search'] ?>
        </button>
    </form>

    <!-- Paper Cards -->
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
                // Show title based on language
                if ($language == 'ps' && !empty($row['title_pashto'])) {
                    $titleToShow = $row['title_pashto'];
                } elseif ($language == 'fa' && !empty($row['title_dari'])) {
                    $titleToShow = $row['title_dari'];
                } else {
                    $titleToShow = $row['title'];
                }
            ?>
            <div class="bg-white p-4 mb-6 rounded shadow border">
                <div class="font-bold text-lg mb-2">
                    <?= htmlspecialchars($titleToShow) ?>
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
                    <a href="paper/<?= htmlspecialchars($row['pdf']) ?>" target="_blank"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-md text-sm transition"><?= $translations[$language]['read'] ?></a>
                    <a href="paper/<?= htmlspecialchars($row['pdf']) ?>" download
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-md text-sm transition"><?= $translations[$language]['download'] ?></a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-gray-600 text-center"><?= $translations[$language]['no_results'] ?></p>
    <?php endif; ?>
</div>

<!-- Scroll to Top Button -->
<button id="scrollToTopBtn" title="Go to top"
    class="hidden fixed bottom-6 right-6 z-50 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 shadow-lg transition">
    <!-- Up arrow icon (Heroicons) -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>
<script>
    // Show button when scrolled down
    const btn = document.getElementById('scrollToTopBtn');
    window.onscroll = function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    };
    // Scroll to top on click
    btn.onclick = function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };
</script>

</body>
</html>
