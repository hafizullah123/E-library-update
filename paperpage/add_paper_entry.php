<?php
session_start();
include 'db.php';

// Default language
if (!isset($_SESSION['lang'])) $_SESSION['lang'] = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en','ps','fa'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'];

// Localization function
function getLocalizedText($key, $lang){
    $translations = [
        'en' => [
            'home'=>'Home',
            'register_paper'=>'Register Paper',
            'logout'=>'Logout',
            'university'=>'University',
            'paper_title'=>'Paper Title',
            'paper_title_ps'=>'Paper Title (Pashto)',
            'paper_title_fa'=>'Paper Title (Dari)',
            'author_name'=>'Author Name',
            'publication_date'=>'Publication Date',
            'description'=>'Description',
            'guider'=>'Guider',
            'type'=>'Type',
            'department'=>'Department',
            'pdf'=>'PDF File',
            'submit'=>'Submit Paper',
            'language'=>'Language',
            'success'=>'Paper registered successfully!',
            'error_upload'=>'Failed to upload file!',
        ],
        'ps'=>[
            'home'=>'کور',
            'book'=>'کتاب',
            'register_paper'=>'مقاله ثبت کړئ',
            'logout'=>'وتل',
            'university'=>'پوهنتون',
            'paper_title'=>'د مقالې نوم په انګلیسي',
            'paper_title_ps'=>'د مقالې نوم (پښتو)',
            'paper_title_fa'=>'د مقالې نوم (دري)',
            'author_name'=>'د لیکوال نوم',
            'publication_date'=>'د خپرېدو نېټه',
            'description'=>'تشريح',
            'guider'=>'لارښودښونکی',
            'type'=>'ډول',
            'department'=>'څانګه',
            'pdf'=>'PDF فایل',
            'submit'=>'مقاله ثبت کړئ',
            'language'=>'ژبه',
            'success'=>'مقاله په بریالیتوب سره ثبت شوه!',
            'error_upload'=>'فایل اپلوډ نشو کړای!',
        ],
        'fa'=>[
            'home'=>'خانه',
            'book'=>'کتاب',
            'register_paper'=>'ثبت مقاله',
            'logout'=>'خروج',
            'university'=>'نام پوهنتون',
            'paper_title'=>'عنوان مقاله به انگلیسی',
            'paper_title_ps'=>'عنوان مقاله (پشتو)',
            'paper_title_fa'=>'عنوان مقاله (دری)',
            'author_name'=>'نام نویسنده',
            'publication_date'=>'تاریخ انتشار',
            'description'=>'توضیحات',
            'guider'=>'استاد راهنما',
            'type'=>'نوعیت',
            'department'=>'دیپارتمنت',
            'pdf'=>'فایل PDF',
            'submit'=>'ثبت مقاله',
            'language'=>'زبان',
            'success'=>'مقاله با موفقیت ثبت شد!',
            'error_upload'=>'بارگذاری فایل موفقیت آمیز نبود!',
        ]
    ];
    return $translations[$lang][$key] ?? $key;
}

// Fetch types
$types = [];
$typeQuery = $conn->query("SELECT type_id, type_name FROM types");
while($row = $typeQuery->fetch_assoc()){
    $types[] = $row;
}

// Fetch departments
$departments = [];
$deptQuery = $conn->query("SELECT department_id, department_name FROM departments");
while($row = $deptQuery->fetch_assoc()){
    $departments[] = $row;
}

// Handle form submission
if($_SERVER['REQUEST_METHOD']==='POST'){
    $university = $_POST['university'] ?? '';
    $title = $_POST['title'] ?? '';
    $title_ps = $_POST['title_ps'] ?? '';
    $title_fa = $_POST['title_fa'] ?? '';
    $author_name = $_POST['author_name'] ?? '';
    $publication_date = $_POST['publication_date'] ?? '';
    $description = $_POST['description'] ?? '';
    $guider = $_POST['guider'] ?? '';
    $type_id = $_POST['type_id'] ?? null;
    $department_id = $_POST['department_id'] ?? null;

    // File upload handling
    $pdf = '';
    $uploadDir = __DIR__ . '/paperpage/'; // ensure folder path

    // Create folder if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        // Sanitize filename
        $filename = time() . '_' . preg_replace('/[^\w.-]/u', '_', $_FILES['pdf']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $targetFile)) {
            $pdf = $filename; // store filename in DB
        } else {
            $error = getLocalizedText('error_upload', $lang);
        }
    }

    if(empty($error)){
        $stmt = $conn->prepare("INSERT INTO research_papers 
            (university, title, title_pashto, title_dari, author_name, publication_date, description, pdf, guider, type_id, department_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssiii",
            $university, $title, $title_ps, $title_fa, $author_name, 
            $publication_date, $description, $pdf, $guider, $type_id, $department_id
        );

        if($stmt->execute()){
            $success = getLocalizedText('success',$lang);
        } else {
            $error = $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= ($lang=='ps' || $lang=='fa') ? 'rtl':'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <title><?= getLocalizedText('register_paper',$lang) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Form Section -->
<div class="flex justify-center items-center py-10 px-4">
    <div class="w-full max-w-4xl bg-white p-10 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6"><?= getLocalizedText('register_paper',$lang) ?></h2>

        <?php if(!empty($success)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-center">✅ <?= $success ?></div>
        <?php elseif(!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-center">❌ <?= $error ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label><?= getLocalizedText('university',$lang) ?></label>
                <input type="text" name="university" class="w-full border p-2 rounded-lg" required>
            </div>
            <div>
                <label><?= getLocalizedText('paper_title',$lang) ?></label>
                <input type="text" name="title" class="w-full border p-2 rounded-lg" required>
            </div>
            <div>
                <label><?= getLocalizedText('paper_title_ps',$lang) ?></label>
                <input type="text" name="title_ps" class="w-full border p-2 rounded-lg">
            </div>
            <div>
                <label><?= getLocalizedText('paper_title_fa',$lang) ?></label>
                <input type="text" name="title_fa" class="w-full border p-2 rounded-lg">
            </div>
            <div>
                <label><?= getLocalizedText('author_name',$lang) ?></label>
                <input type="text" name="author_name" class="w-full border p-2 rounded-lg" required>
            </div>
            <div>
                <label><?= getLocalizedText('publication_date',$lang) ?></label>
                <input type="date" name="publication_date" class="w-full border p-2 rounded-lg">
            </div>
            <div>
                <label><?= getLocalizedText('description',$lang) ?></label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded-lg"></textarea>
            </div>
            <div>
                <label><?= getLocalizedText('guider',$lang) ?></label>
                <input type="text" name="guider" class="w-full border p-2 rounded-lg" required>
            </div>
            <div>
                <label><?= getLocalizedText('type',$lang) ?></label>
                <select name="type_id" class="w-full border p-2 rounded-lg" required>
                    <option value="">--Select Type--</option>
                    <?php foreach($types as $t): ?>
                        <option value="<?=$t['type_id']?>"><?=htmlspecialchars($t['type_name'])?></option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div>
                <label><?= getLocalizedText('department',$lang) ?></label>
                <select name="department_id" class="w-full border p-2 rounded-lg" required>
                    <option value="">--Select Department--</option>
                    <?php foreach($departments as $d): ?>
                        <option value="<?=$d['department_id']?>"><?=htmlspecialchars($d['department_name'])?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label><?= getLocalizedText('pdf',$lang) ?></label>
                <input type="file" name="pdf" class="w-full border p-2 rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">
                <?= getLocalizedText('submit',$lang) ?>
            </button>
        </form>
    </div>
</div>
</body>
</html>
