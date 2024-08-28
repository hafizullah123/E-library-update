<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Navbar with Localization</title>
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>
<body>
<?php
session_start();

$translations = [
    'en' => [
        'brand' => 'digital library',
        'home' => 'Home',
        'schedul' => 'schedul',
        'book' => 'book',
        // 'report' => 'report',
        // 'another_action' => 'Another action',
        // 'something_else' => 'Something else here',
    ],
    'ps' => [
        'brand' => 'دیچتل کتابتون',
        'home' => 'کور',
        'schedul' => 'محصل ثبتول',
        'book' => 'کتاب',
        // 'report' => 'راپور',

        // 'another_action' => 'بله عمل',
        // 'something_else' => 'نور څه دلته',
    ],
    'fa' => [
        'brand' => 'کتاب خانه دیجتل',
        'home' => 'خانه',
        'schedul' => 'ثبت محصل',
        'book' => 'کتاب',
        // 'report' =>'راپور'
        // 'another_action' => 'اقدام دیگر',
        // 'something_else' => 'چیز دیگری اینجا',
    ],
];

if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $translations)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
$t = $translations[$lang];
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#"><?php echo $t['brand']; ?></a>
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#" data-target="home.php"><?php echo $t['home']; ?>
                    <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="" data-target="schedul.php"><?php echo $t['schedul']; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-target="book.php"><?php echo $t['book']; ?></a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="?lang=en">English</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?lang=ps">Pashto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?lang=fa">Dari</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="container" id="content">
    <h1 class="mt-5"><?php echo $t['home']; ?></h1>
    <!-- <p class="lead"><?php echo $t['features']; ?></p> -->
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom JS for AJAX loading -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('a[data-target]');
        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const target = this.getAttribute('data-target');
                fetch(target)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('content').innerHTML = data;
                    })
                    .catch(error => console.error('Error loading content:', error));
            });
        });
    });
</script>
</body>
</html>
