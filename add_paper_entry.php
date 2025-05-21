<?php
include("connection.php");
session_start();

// AJAX check for duplicate title
if (isset($_POST['ajax_check_title'])) {
    $title = $_POST['ajax_check_title'];
    $result = mysqli_query($conn, "SELECT 1 FROM research_papers WHERE title = '" . mysqli_real_escape_string($conn, $title) . "'");
    echo mysqli_num_rows($result) > 0 ? "exists" : "ok";
    exit;
}

// Handle language switch
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Get selected language
$lang = $_SESSION['lang'] ?? 'en';

// Determine direction
$dir = ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr';

// Localization function
function getLocalizedText($key, $lang)
{
    $translations = [
        'en' => [
            'add_new_paper' => 'Add New Paper',
            'university' => 'University name ',
            'title' => 'Title in English',
            'title_pashto' => 'Title in Pashto',
            'title_dari' => 'Title in Dari',
            'author_name' => 'Author Name',
            'publication_date' => 'Publication Date',
            'description' => 'Description',
            'upload_pdf' => 'Upload PDF',
            'type' => 'Type',
            'submit' => 'Submit',
            'guider' => 'Guider Name',
            'department' => 'Department',
            'section' => 'Section',
            'success_message' => 'Paper added successfully.',
            'error_message' => 'Error: ',
            'title_exists' => 'This title is already in use. Please choose another.',
            'select_type' => 'Select Type',
            'thesis' => 'Thesis',
            'research' => 'Research',
            'article' => 'Article',
            'language' => 'Language',
        ],
        'ps' => [
            'add_new_paper' => 'نوې څېړنه ور اضافه کړئ',
            'university' => 'پوهنتون',
            'title' => 'انګلیسی سرلک',
            'title_pashto' => 'پښتو سرلیک',
            'title_dari' => 'دري سرلیک',
            'author_name' => 'د لیکوال نوم',
            'publication_date' => 'د خپریدو نېټه',
            'description' => 'تشریح',
            'upload_pdf' => 'PDF پورته کړئ',
            'type' => 'ډول',
            'submit' => 'سپارل',
            'guider' => 'مشاور',
            'department' => 'څانګه',
            'section' => 'برخه',
            'success_message' => 'څېړنه بریالۍ اضافه شوه.',
            'error_message' => 'تېروتنه: ',
            'title_exists' => 'دا سرلیک له مخکې نه شته. مهرباني وکړئ بل انتخاب کړئ.',
            'select_type' => 'ډول غوره کړئ',
            'thesis' => 'تز',
            'research' => 'څېړنه',
            'article' => 'مقاله',
            'language' => 'ژبه',
        ],
        'fa' => [
            'add_new_paper' => 'اضافه‌کردن تحقیق جدید',
            'university' => 'پوهنتون',
            'title' => ' عنوان به انگلیسی',
            'title_pashto' => 'عنوان به پشتو',
            'title_dari' => 'عنوان به دری',
            'author_name' => 'نام نویسنده',
            'publication_date' => 'تاریخ نشر',
            'description' => 'توضیحات',
            'upload_pdf' => 'بارگذاری PDF',
            'type' => 'نوع',
            'submit' => 'ارسال',
            'guider' => 'راهنما',
            'department' => 'دیپارتمنت',
            'section' => 'بخش',
            'success_message' => 'تحقیق موفقانه اضافه شد.',
            'error_message' => 'خطا: ',
            'title_exists' => 'این عنوان قبلاً استفاده شده است. لطفاً عنوان دیگری را انتخاب کنید.',
            'select_type' => 'نوع را انتخاب کنید',
            'thesis' => 'تز',
            'research' => 'تحقیق',
            'article' => 'مقاله',
            'language' => 'زبان',
        ]
    ];
    return $translations[$lang][$key] ?? $key;
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $university = $_POST["university"] ?? '';
    $title = $_POST["paperTitle"] ?? '';
    $title_ps = $_POST["paperTitle_ps"] ?? '';
    $title_fa = $_POST["paperTitle_fa"] ?? '';
    $author = $_POST["author"] ?? '';
    $date = $_POST["date"] ?? '';
    $description = $_POST["description"] ?? '';
    $type = $_POST["type"] ?? '';
    $guider = $_POST["guider"] ?? '';
    $department = $_POST["department"] ?? '';
    $section = $_POST["section"] ?? '';

    $check = mysqli_query($conn, "SELECT * FROM research_papers WHERE title = '$title'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('" . getLocalizedText('title_exists', $lang) . "');</script>";
    } else {
        $pdfName = "";
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $pdfName = time() . '_' . str_replace(" ", "_", $_FILES['pdf']['name']);
            $pdfTemp = $_FILES['pdf']['tmp_name'];
            $uploadDir = 'paper/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            move_uploaded_file($pdfTemp, $uploadDir . $pdfName);
        }

        $sql = "INSERT INTO research_papers 
            (university, title, title_pashto, title_dari, author_name, publication_date, description, pdf, type, guider, department, section) 
            VALUES ('$university', '$title', '$title_ps', '$title_fa', '$author', '$date', '$description', '$pdfName', '$type', '$guider', '$department', '$section')";

        $message = mysqli_query($conn, $sql)
            ? getLocalizedText('success_message', $lang)
            : getLocalizedText('error_message', $lang) . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <title><?= getLocalizedText('add_new_paper', $lang); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-200 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white text-blue-700 px-4 py-4 flex flex-col md:flex-row justify-between items-center shadow <?= $dir === 'rtl' ? 'flex-row-reverse' : '' ?>">
        <h1 class="text-2xl font-bold tracking-tight"><?= getLocalizedText('add_new_paper', $lang); ?></h1>
        <div class="flex gap-2 mt-2 md:mt-0 items-center">
            <span><?= getLocalizedText('language', $lang); ?>:</span>
            <a href="?lang=en" class="px-2 py-1 rounded hover:bg-blue-100 transition <?= $lang == 'en' ? 'bg-blue-200 font-bold' : '' ?>">EN</a>
            <a href="?lang=ps" class="px-2 py-1 rounded hover:bg-blue-100 transition <?= $lang == 'ps' ? 'bg-blue-200 font-bold' : '' ?>">PS</a>
            <a href="?lang=fa" class="px-2 py-1 rounded hover:bg-blue-100 transition <?= $lang == 'fa' ? 'bg-blue-200 font-bold' : '' ?>">DR</a>
            <a href="add_book_entry.php" class="ml-4 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded transition text-blue-700 font-semibold border border-blue-300">Books</a>
            <a href="logout.php" class="ml-2 bg-red-600 hover:bg-red-700 px-3 py-1 rounded transition text-white font-semibold"><?= $lang == 'ps' ? 'وتل' : ($lang == 'fa' ? 'خروج' : 'Logout') ?></a>
        </div>
    </nav>

    <!-- Form Container -->
    <div class="flex justify-center items-center py-12 px-2 bg-gradient-to-br from-blue-50 to-blue-200 min-h-[80vh]">
      <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl p-12 sm:p-16 border border-blue-100 transition-all duration-300">
        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg text-center text-lg font-semibold shadow">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('university', $lang); ?></label>
                    <input type="text" name="university" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('author_name', $lang); ?></label>
                    <input type="text" name="author" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('title', $lang); ?></label>
                    <input type="text" name="paperTitle" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('title_pashto', $lang); ?></label>
                    <input type="text" name="paperTitle_ps" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm">
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('title_dari', $lang); ?></label>
                    <input type="text" name="paperTitle_fa" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm">
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('publication_date', $lang); ?></label>
                    <input type="date" name="date" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm">
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('guider', $lang); ?></label>
                    <input type="text" name="guider" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm">
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('department', $lang); ?></label>
                    <select name="department" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm">
                        <option value="Computer Science">Computer Science</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Literature">Literature</option>
                        <option value="Physics">Physics</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('section', $lang); ?></label>
                    <select name="section" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('type', $lang); ?></label>
                    <select name="type" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm">
                        <option value=""><?= getLocalizedText('select_type', $lang); ?></option>
                        <option value="Thesis"><?= getLocalizedText('thesis', $lang); ?></option>
                        <option value="Research"><?= getLocalizedText('research', $lang); ?></option>
                        <option value="Article"><?= getLocalizedText('article', $lang); ?></option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('description', $lang); ?></label>
                <textarea name="description" rows="3" class="w-full border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 bg-blue-50 shadow-sm"></textarea>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-gray-700"><?= getLocalizedText('upload_pdf', $lang); ?></label>
                <input type="file" name="pdf" class="w-full border border-blue-200 rounded-xl p-3 bg-white focus:ring-2 focus:ring-blue-400 shadow-sm">
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-700 to-blue-400 hover:from-blue-800 hover:to-blue-500 text-white font-bold py-4 rounded-2xl shadow-xl transition-all duration-200 text-xl tracking-wide">
                    <?= getLocalizedText('submit', $lang); ?>
                </button>
            </div>
        </form>
      </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.querySelector('input[name="paperTitle"]');
    let lastChecked = "";

    titleInput.addEventListener('blur', function() {
        const title = titleInput.value.trim();
        if (!title || title === lastChecked) return;
        lastChecked = title;
        fetch(window.location.pathname, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'ajax_check_title=' + encodeURIComponent(title)
        })
        .then(res => res.text())
        .then(data => {
            if (data === 'exists') {
                alert("<?= getLocalizedText('title_exists', $lang); ?>");
                titleInput.focus();
            }
        });
    });
});
</script>
</body>
</html>
