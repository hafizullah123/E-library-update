<?php
session_start();

// 🌐 Default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'ps';
}
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$language = $_SESSION['lang'];

// 🌐 Translations
$translations = [
    'en' => [
        'title' => 'Digital Library',
        'search_placeholder' => 'Search by title, author, or university',
        'filter_type' => 'Filter by Type',
        'filter_department' => 'Filter by Department',
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
        'prev' => '« Prev',
        'next' => 'Next »',
    ],
    'ps' => [
        'title' => 'دیجیتلی کتابتون',
        'search_placeholder' => 'د سرلیک، لیکوال یا پوهنتون له مخې لټون',
        'filter_type' => 'د ډول له مخې فلټر',
        'filter_department' => 'د څانګې له مخې فلټر',
        'search' => 'لټون',
        'read' => 'ولولئ',
        'download' => 'ډاونلوډ',
        'no_results' => 'هیڅ مقاله ونه موندل شوه.',
        'university' => 'پوهنتون',
        'author' => 'لیکوال',
        'guider' => 'لارښود',
        'department' => 'پوهنځی',
        'section' => 'څانګه',
        'date' => 'نیټه',
        'prev' => '« مخکې',
        'next' => 'بل »',
    ],
    'fa' => [
        'title' => 'کتابخانه دیجیتال',
        'search_placeholder' => 'جستجو بر اساس عنوان، نویسنده یا پوهنتون',
        'filter_type' => 'فیلتر بر اساس نوع',
        'filter_department' => 'فیلتر بر اساس دیپارتمنت',
        'search' => 'جستجو',
        'read' => 'مطالعه',
        'download' => 'دانلود',
        'no_results' => 'هیچ مقاله‌ای پیدا نشد.',
        'university' => 'پوهنتون',
        'author' => 'نویسنده',
        'guider' => 'استاد راهنما',
        'department' => 'پوهنځی',
        'section' => 'دیپارتمنت',
        'date' => 'تاریخ',
        'prev' => '« قبلی',
        'next' => 'بعدی »',
    ],
];

$dir = ($language == 'ps' || $language == 'fa') ? 'rtl' : 'ltr';

// 🗄️ Database connection
$conn = new mysqli("localhost", "root", "", "library");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 📌 Get filter values
$search = $_GET['search'] ?? '';
$type = $_GET['type'] ?? '';
$department = $_GET['department'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// 🔹 Build WHERE clause
$where = "WHERE 1=1";
if(!empty($search)) {
    $s = $conn->real_escape_string($search);
    $where .= " AND (r.title LIKE '%$s%' OR r.author_name LIKE '%$s%' OR r.university LIKE '%$s%')";
}
if(!empty($type)) {
    $t = (int)$type;
    $where .= " AND r.type_id='$t'";
}
if(!empty($department)) {
    $d = (int)$department;
    $where .= " AND r.department_id='$d'";
}

// 🔹 Pagination: total records
$countQuery = "SELECT COUNT(*) as total 
               FROM research_papers AS r
               LEFT JOIN types AS t ON r.type_id = t.type_id
               LEFT JOIN departments AS d ON r.department_id = d.department_id
               $where";
$totalResult = $conn->query($countQuery);
$totalRecords = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// 🔹 Fetch research papers with joins
$sql = "SELECT r.*, t.type_name, d.department_name 
        FROM research_papers AS r
        LEFT JOIN types AS t ON r.type_id = t.type_id
        LEFT JOIN departments AS d ON r.department_id = d.department_id
        $where
        ORDER BY r.paper_id DESC
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// 🔹 Fetch types and departments for filter dropdowns
$typeResult = $conn->query("SELECT * FROM types ORDER BY type_name ASC");
$deptResult = $conn->query("SELECT * FROM departments ORDER BY department_name ASC");
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" dir="<?= $dir ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $translations[$language]['title'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans p-4">

  <!-- Header & Language Selection -->
  <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
      <h1 class="text-2xl font-bold text-blue-700"><?= $translations[$language]['title'] ?></h1>
      <form method="get">
          <select name="lang" onchange="this.form.submit()" class="border rounded p-2 bg-white text-gray-700">
              <option value="en" <?= $language == 'en' ? 'selected' : '' ?>>English</option>
              <option value="ps" <?= $language == 'ps' ? 'selected' : '' ?>>پښتو</option>
              <option value="fa" <?= $language == 'fa' ? 'selected' : '' ?>>دری</option>
          </select>
      </form>
  </div>

  <!-- Filters -->
  <form method="get" class="flex flex-col md:flex-row gap-3 mb-6">
      <input type="text" name="search" placeholder="<?= $translations[$language]['search_placeholder'] ?>"
             value="<?= htmlspecialchars($search) ?>"
             class="flex-1 border p-2 rounded focus:ring-2 focus:ring-blue-400" />

      <select name="type" class="border p-2 rounded">
          <option value=""><?= $translations[$language]['filter_type'] ?></option>
          <?php while ($t = $typeResult->fetch_assoc()): ?>
              <option value="<?= $t['type_id'] ?>" <?= $type == $t['type_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($t['type_name']) ?>
              </option>
          <?php endwhile; ?>
      </select>

      <select name="department" class="border p-2 rounded">
          <option value=""><?= $translations[$language]['filter_department'] ?></option>
          <?php while ($d = $deptResult->fetch_assoc()): ?>
              <option value="<?= $d['department_id'] ?>" <?= $department == $d['department_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($d['department_name']) ?>
              </option>
          <?php endwhile; ?>
      </select>

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
          <?= $translations[$language]['search'] ?>
      </button>
  </form>

  <!-- Research Papers -->
  <div class="space-y-4 max-w-5xl mx-auto">
      <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
              <?php
                  $displayTitle = ($language=='ps' && $row['title_pashto']) ? $row['title_pashto']
                                 : (($language=='fa' && $row['title_dari']) ? $row['title_dari'] : $row['title']);
              ?>
              <div class="bg-white rounded-2xl shadow p-4 border border-gray-200">
                  <p class="text-lg font-semibold text-gray-900 mb-2">
                      <span class="text-blue-600">عنوان:</span> <?= htmlspecialchars($displayTitle) ?>
                  </p>
                  <p class="text-gray-700 text-sm md:text-base leading-7">
                      <span class="font-semibold text-blue-600"><?= $translations[$language]['university'] ?>:</span> <?= htmlspecialchars($row['university']) ?> |
                      <span class="font-semibold text-blue-600"><?= $translations[$language]['author'] ?>:</span> <?= htmlspecialchars($row['author_name']) ?> |
                      <span class="font-semibold text-blue-600"><?= $translations[$language]['guider'] ?>:</span> <?= htmlspecialchars($row['guider']) ?> |
                      <span class="font-semibold text-blue-600"><?= $translations[$language]['department'] ?>:</span> <?= htmlspecialchars($row['department_name'] ?? '') ?> |
                      <span class="font-semibold text-blue-600"><?= $translations[$language]['section'] ?>:</span> <?= htmlspecialchars($row['section'] ?? '') ?> |
                      <span class="font-semibold text-blue-600"><?= $translations[$language]['date'] ?>:</span> <?= htmlspecialchars($row['publication_date']) ?>
                  </p>
                  <?php if(!empty($row['pdf'])): ?>
                      <div class="mt-3 flex gap-3">
                          <a href="../uploads/<?= htmlspecialchars($row['pdf']) ?>" target="_blank"
                             class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-1.5 rounded-md transition">
                              <?= $translations[$language]['read'] ?>
                          </a>
                          <a href="../uploads/<?= htmlspecialchars($row['pdf']) ?>" download
                             class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-1.5 rounded-md transition">
                              <?= $translations[$language]['download'] ?>
                          </a>
                      </div>
                  <?php endif; ?>
              </div>
          <?php endwhile; ?>
      <?php else: ?>
          <p class="text-center text-gray-600 bg-white p-4 rounded shadow">
              <?= $translations[$language]['no_results'] ?>
          </p>
      <?php endif; ?>
  </div>

  <!-- Pagination -->
  <?php if($totalPages > 1): ?>
      <div class="flex justify-center mt-8 space-x-2">
          <?php if($page > 1): ?>
              <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>&type=<?= urlencode($type) ?>&department=<?= urlencode($department) ?>&lang=<?= $language ?>"
                 class="px-3 py-1 border rounded-md bg-white hover:bg-gray-200"><?= $translations[$language]['prev'] ?></a>
          <?php endif; ?>
          <span class="px-3 py-1 border rounded-md bg-blue-600 text-white"><?= $page ?> / <?= $totalPages ?></span>
          <?php if($page < $totalPages): ?>
              <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>&type=<?= urlencode($type) ?>&department=<?= urlencode($department) ?>&lang=<?= $language ?>"
                 class="px-3 py-1 border rounded-md bg-white hover:bg-gray-200"><?= $translations[$language]['next'] ?></a>
          <?php endif; ?>
      </div>
  <?php endif; ?>

</body>
</html>
