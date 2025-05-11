<?php
include("connection.php");
session_start();

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
            'university' => 'University',
            'title' => 'Title',
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
            'title' => 'سرلیک',
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
            'title' => 'عنوان',
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-700 text-white p-4 flex justify-between items-center <?= $dir === 'rtl' ? 'flex-row-reverse' : '' ?>">
        <h1 class="text-lg font-bold"><?= getLocalizedText('add_new_paper', $lang); ?></h1>
        <div>
            <span class="mr-2"><?= getLocalizedText('language', $lang); ?>:</span>
            <a href="?lang=en" class="mr-2 hover:underline">EN</a>
            <a href="?lang=ps" class="mr-2 hover:underline">PS</a>
            <a href="?lang=fa" class="hover:underline">DR</a>
        </div>
    </nav>

    <!-- Form Container -->
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-6 <?= $dir === 'rtl' ? 'text-right' : 'text-left' ?>">
        <?php if (!empty($message)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded"><?= $message; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block mb-1"><?= getLocalizedText('university', $lang); ?></label>
                <input type="text" name="university" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('title', $lang); ?></label>
                <input type="text" name="paperTitle" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('title_pashto', $lang); ?></label>
                <input type="text" name="paperTitle_ps" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('title_dari', $lang); ?></label>
                <input type="text" name="paperTitle_fa" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('author_name', $lang); ?></label>
                <input type="text" name="author" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('publication_date', $lang); ?></label>
                <input type="date" name="date" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('description', $lang); ?></label>
                <textarea name="description" class="w-full border rounded p-2"></textarea>
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('upload_pdf', $lang); ?></label>
                <input type="file" name="pdf" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('type', $lang); ?></label>
                <select name="type" class="w-full border rounded p-2">
                    <option value=""><?= getLocalizedText('select_type', $lang); ?></option>
                    <option value="Thesis"><?= getLocalizedText('thesis', $lang); ?></option>
                    <option value="Research"><?= getLocalizedText('research', $lang); ?></option>
                    <option value="Article"><?= getLocalizedText('article', $lang); ?></option>
                </select>
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('guider', $lang); ?></label>
                <input type="text" name="guider" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('department', $lang); ?></label>
                <select name="department" class="w-full border rounded p-2">
                    <option value="Computer Science">Computer Science</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Literature">Literature</option>
                    <option value="Physics">Physics</option>
                </select>
            </div>
            <div>
                <label class="block mb-1"><?= getLocalizedText('section', $lang); ?></label>
                <select name="section" class="w-full border rounded p-2">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    <?= getLocalizedText('submit', $lang); ?>
                </button>
            </div>
        </form>
    </div>
</body>
</html>
