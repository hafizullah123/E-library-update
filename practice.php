<?php
session_start();

// Handle language selection
$allowed_langs = ['en', 'ps', 'dr'];
if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = $_SESSION['lang'] ?? 'en';
$dir = ($lang == 'ps' || $lang == 'dr') ? 'rtl' : 'ltr';

// Load translations
$translations = [
    'en' => [
        'add_paper' => 'Add Research Paper',
        'home' => 'Home',
        'upload' => 'Upload Paper',
        'university' => 'University Name',
        'title' => 'Title',
        'title_pashto' => 'Title (Pashto)',
        'title_dari' => 'Title (Dari)',
        'author' => 'Author Name',
        'pub_date' => 'Publication Date',
        'description' => 'Description',
        'file' => 'PDF File',
        'type' => 'Type (e.g., Thesis, Research)',
        'guider' => 'Guider Name',
        'department' => 'Department',
        'section' => 'Section',
        'submit' => 'Submit',
        'success' => 'Research Paper Successfully Submitted!',
        'error_exists' => 'Title already exists. Please use a different title.',
        'error_pdf' => 'Invalid file type. Only PDF allowed.',
        'error_upload' => 'Failed to upload PDF.',
        'error_general' => 'No PDF uploaded or an error occurred.'
    ],
    'ps' => [
        'add_paper' => 'د څېړنې مقالې اضافه کول',
        'home' => 'کور',
        'upload' => 'مقاله اپلود کول',
        'university' => 'د پوهنتون نوم',
        'title' => 'عنوان',
        'title_pashto' => 'عنوان (پښتو)',
        'title_dari' => 'عنوان (دری)',
        'author' => 'د لیکوال نوم',
        'pub_date' => 'د خپرولو نیټه',
        'description' => 'تفصیل',
        'file' => 'PDF فایل',
        'type' => 'ډول (د بیلګې په توګه، پایان نامه، څیړنه)',
        'guider' => 'د لارښود نوم',
        'department' => 'څانګه',
        'section' => 'برخه',
        'submit' => 'سپارل',
        'success' => 'د څیړنې مقاله په بریالیتوب سره وسپارل شوه!',
        'error_exists' => 'عنوان دمخه شته. مهرباني وکړئ یو مختلف عنوان وکاروئ.',
        'error_pdf' => 'ناسم فایل ډول. یوازې PDF اجازه لري.',
        'error_upload' => 'د PDF اپلود کولو کې پاتې راغلی.',
        'error_general' => 'هیڅ PDF اپلود شوی نه دی یا یوه تېروتنه رامنځته شوې.'
    ],
    'dr' => [
        'add_paper' => 'اضافه کردن مقاله تحقیقی',
        'home' => 'صفحه اصلی',
        'upload' => 'آپلود مقاله',
        'university' => 'نام دانشگاه',
        'title' => 'عنوان',
        'title_pashto' => 'عنوان (پشتو)',
        'title_dari' => 'عنوان (دری)',
        'author' => 'نام نویسنده',
        'pub_date' => 'تاریخ نشر',
        'description' => 'توضیحات',
        'file' => 'فایل PDF',
        'type' => 'نوع (مثال: تیزس، تحقیق)',
        'guider' => 'نام راهنما',
        'department' => 'دیپارتمنت',
        'section' => 'بخش',
        'submit' => 'ثبت',
        'success' => 'مقاله تحقیقی با موفقیت ثبت شد!',
        'error_exists' => 'عنوان قبلا موجود است. لطفا یک عنوان دیگر استفاده کنید.',
        'error_pdf' => 'نوع فایل نامعتبر. فقط PDF مجاز است.',
        'error_upload' => 'آپلود PDF ناموفق بود.',
        'error_general' => 'هیچ PDF آپلود نشد یا خطایی رخ داد.'
    ]
];

$t = $translations[$lang];

// ... rest of your database connection and form handling code ...

// Modify the message strings to use translations
// if ($result->num_rows > 0) {
//     echo "<script>alert('".$t['error_exists']."');</script>";
// }

// Modify other message variables to use translations:
// $message = "<p...>".$t['success']."</p>";
// ... other error messages ...
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $t['add_paper'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if($dir === 'rtl'): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-rtl@5.3.0/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Research Portal</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><?= $t['home'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload.php"><?= $t['upload'] ?></a>
                </li>
            </ul>
            <div class="ms-auto">
                <a href="?lang=en" class="btn btn-sm <?= $lang === 'en' ? 'btn-primary' : 'btn-outline-secondary' ?>">EN</a>
                <a href="?lang=ps" class="btn btn-sm <?= $lang === 'ps' ? 'btn-primary' : 'btn-outline-secondary' ?>">پښتو</a>
                <a href="?lang=dr" class="btn btn-sm <?= $lang === 'dr' ? 'btn-primary' : 'btn-outline-secondary' ?>">دری</a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
    <?= isset($message) ? $message : '' ?>
    <div class="card p-4 shadow">
        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="university" placeholder="<?= $t['university'] ?>" required class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="title" placeholder="<?= $t['title'] ?>" required class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="title_pashto" placeholder="<?= $t['title_pashto'] ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="title_dari" placeholder="<?= $t['title_dari'] ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="author_name" placeholder="<?= $t['author'] ?>" required class="form-control">
            </div>
            <div class="col-md-6">
                <input type="date" name="publication_date" class="form-control" title="<?= $t['pub_date'] ?>">
            </div>
            <div class="col-md-12">
                <textarea name="description" placeholder="<?= $t['description'] ?>" class="form-control"></textarea>
            </div>
            <div class="col-md-12">
                <input type="file" name="pdf" accept="application/pdf" required class="form-control" title="<?= $t['file'] ?>">
            </div>
            <div class="col-md-6">
                <input type="text" name="type" placeholder="<?= $t['type'] ?>" required class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="guider" placeholder="<?= $t['guider'] ?>" required class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="department" placeholder="<?= $t['department'] ?>" required class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="section" placeholder="<?= $t['section'] ?>" required class="form-control">
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary w-100"><?= $t['submit'] ?></button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>