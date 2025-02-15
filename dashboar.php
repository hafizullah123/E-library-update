<?php
// session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // Redirect to the login page if not logged in
//     header("Location: index.php?action=login");
//     exit;
// }

// include 'connection.php';

session_start();
error_reporting();
include ('connection.php');
$userprofile=$_SESSION['user_id'];
if ($userprofile==true){
    
}
else{
    header('location: login.php ');
}


// Define language files and load the selected language
$lang_files = [
    'en' => [
        'admin_dashboard' => 'Admin Dashboard',
        'books' => 'Books',
        'papers' => 'Papers',
        'users' => 'Users',
        'labor' => 'Labor',
        'admin' => 'Admin',
        'logs' => 'Logs',
        'enduser' => 'Enduser',
        'genres' => 'Genres',
        'view_books' => 'View Books',
        'add_book' => 'Add Book',
        'manage_books' => 'Manage Books',
        'view_papers' => 'View Papers',
        'add_paper' => 'Add Paper',
        'manage_papers' => 'Manage Papers',
        'view_users' => 'View Users',
        'add_user' => 'Add User',
        'manage_users' => 'Manage Users',
        'add_manager' => 'Add manager',
        'add_public_manager' => 'Add Public manager',
        'add_labor' => 'Add Labor',
        'manage_labor' => 'Manage Labor',
        'change_password' => 'Change Password',
        'logout' => 'Logout',
        'update_enduser' => 'Update Enduser',
        'add_book_paper' => 'Add Book and Papers',
        'update_books' => 'Update Books',
        'update_schedule' => 'Update Schedule',
        
        'report' => 'Report',
        'paper report' => 'Report',
        'books_count' => 'Books Count',
        'papers_count' => 'Papers Count',
        'users_count' => 'Users Count',
        'labor_count' => 'Labor Count',
    ],
    'ps' => [
        'admin_dashboard' => 'د اډمین ډشبورډ',
        'books' => 'کتابونه',
        'papers' => 'مقالې',
        'users' => 'کارونکي',
        'labor' => 'کارګران',
        'admin' => 'ادمين',
        'logs' => 'لاګونه',
        'enduser' => 'وروستنی کاروونکی',
        'genres' => 'ژانرونه',
        'view_books' => 'کتابونه وګورئ',
        'add_book' => 'کتاب اضافه کړئ',
        'manage_books' => 'کتابونه اداره کړئ',
        'view_papers' => 'مقالې وګورئ',
        'add_paper' => 'مقاله اضافه کړئ',
        'manage_papers' => 'مقالې اداره کړئ',
        'view_users' => 'کارونکي وګورئ',
        'add_user' => 'کارونکی اضافه کړئ',
        'manage_users' => 'کارونکي اداره کړئ',
        'view_labor' => 'کارګران وګورئ',
        'add_labor' => 'کارګر اضافه کړئ',
        'manage_labor' => 'کارګران اداره کړئ',
        'change_password' => 'پاسورډ بدل کړئ',
        'logout' => 'وتل',
        'update_enduser' => 'وروستی کارونکی تازه کړئ',
        'add_book_paper' => 'کتاب او مقالې اضافه کړئ',
        'update_books' => 'کتابونه تازه کړئ',
        'update_schedule' => 'مهالوېش تازه کړئ',
        'report' => 'راپور',
        'paper report' => 'مقلو شمیر',
        'books_count' => 'د کتابونو شمېر',
        'papers_count' => 'د مقالو شمېر',
        'users_count' => 'د کارونکو شمېر',
        'labor_count' => 'د کارګرانو شمېر',
    ],
    'fa' => [
        'admin_dashboard' => 'داشبورد مدیر',
        'books' => 'کتاب‌ها',
        'papers' => 'مقاله‌ها',
        'users' => 'کاربران',
        'labor' => 'کارگران',
        'admin' => 'مدیر',
        'logs' => 'لاگ‌ها',
        'enduser' => 'کاربر نهایی',
        'genres' => 'ژانرها',
        'view_books' => 'مشاهده کتاب‌ها',
        'add_book' => 'اضافه کردن کتاب',
        'manage_books' => 'مدیریت کتاب‌ها',
        'view_papers' => 'مشاهده مقاله‌ها',
        'add_paper' => 'اضافه کردن مقاله',
        'manage_papers' => 'مدیریت مقاله‌ها',
        'view_users' => 'مشاهده کاربران',
        'add_user' => 'اضافه کردن کاربر',
        'manage_users' => 'مدیریت کاربران',
        'view_labor' => 'مشاهده کارگران',
        'add_labor' => 'اضافه کردن کارگر',
        'manage_labor' => 'مدیریت کارگران',
        'change_password' => 'تغییر گذرواژه',
        'logout' => 'خروج',
        'update_enduser' => 'بروزرسانی کاربر نهایی',
        'add_book_paper' => 'اضافه کردن کتاب و مقاله',
        'update_books' => 'بروزرسانی کتاب‌ها',
        'update_schedule' => 'بروزرسانی برنامه',
        'report' => 'گزارش',
        'paper report' => 'تعداد مقاله',
        'books_count' => 'تعداد کتاب‌ها',
        'papers_count' => 'تعداد مقاله‌ها',
        'users_count' => 'تعداد کاربران',
        'labor_count' => 'تعداد کارگران',
    ],
];

$lang_code = isset($_GET['lang']) ? $_GET['lang'] : 'en';
$lang = $lang_files[$lang_code];

if ($lang_code == 'ps' || $lang_code == 'fa') {
    echo '<style>body { direction: rtl; }</style>';
} else {
    echo '<style>body { direction: ltr; }</style>';
}

// Fetch the counts for books, papers, users, and labor
$book_count_query = "SELECT COUNT(*) AS count FROM books";
$paper_count_query = "SELECT COUNT(*) AS count FROM research_papers";
$user_count_query = "SELECT COUNT(*) AS count FROM users";
// $labor_count_query = "SELECT COUNT(*) AS count FROM users";  // Ensure the table name is correct

$book_count_result = $conn->query($book_count_query);
$paper_count_result = $conn->query($paper_count_query);
$user_count_result = $conn->query($user_count_query);
// $labor_count_result = $conn->query($labor_count_query);

if (!$book_count_result || !$paper_count_result || !$user_count_result ) {
    die("Error executing query: " . $conn->error);
}

$book_count = $book_count_result->fetch_assoc()['count'];
$paper_count = $paper_count_result->fetch_assoc()['count'];
$user_count = $user_count_result->fetch_assoc()['count'];
// $labor_count = $labor_count_result->fetch_assoc()['count'];

// Fetch book genres and their counts
$genres_query = "
    SELECT genres.id, genres.name, COUNT(books.book_id) AS book_count 
    FROM genres 
    LEFT JOIN books ON genres.id = books.genre_id 
    GROUP BY genres.id, genres.name";
$genres_result = $conn->query($genres_query);

if (!$genres_result) {
    die("Error executing genres query: " . $conn->error);
}

$genres = [];
if ($genres_result->num_rows > 0) {
    while ($row = $genres_result->fetch_assoc()) {
        $genres[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['admin_dashboard']; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card {
            margin: 10px;
            padding: 20px;
            text-align: center;
        }
        .icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo $lang['admin_dashboard']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $lang['books']; ?> <i class="fas fa-book"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="booksDropdown">
                    <a class="dropdown-item" href="view.php"><?php echo $lang['view_books']; ?></a>
                    <a class="dropdown-item" href="add_book.php"><?php echo $lang['add_book']; ?></a>
                    <a class="dropdown-item" href="update.php"><?php echo $lang['manage_books']; ?></a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header"><?php echo $lang['genres']; ?></h6>
                    <?php foreach ($genres as $genre): ?>
                        <a class="dropdown-item" href="view_genre.php?genre_id=<?php echo $genre['id']; ?>">
                            <i class="fas fa-book-open"></i> <?php echo $genre['name']; ?> 
                            <span class="badge badge-secondary"><?php echo $genre['book_count']; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="papersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $lang['papers']; ?> <i class="fas fa-file-alt"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="papersDropdown">
                    <a class="dropdown-item" href="view1.php"><?php echo $lang['view_papers']; ?></a>
                    <a class="dropdown-item" href="add_paper.php"><?php echo $lang['add_paper']; ?></a>
                    <a class="dropdown-item" href="update1.php"><?php echo $lang['manage_papers']; ?></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $lang['users']; ?> <i class="fas fa-users"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="usersDropdown">
                    <a class="dropdown-item" href="#"><?php echo $lang['view_users']; ?></a>
                    <a class="dropdown-item" href="#"><?php echo $lang['add_user']; ?></a>
                    <a class="dropdown-item" href="#"><?php echo $lang['manage_users']; ?></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="laborDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $lang['labor']; ?> <i class="fas fa-tools"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="laborDropdown">
                    <a class="dropdown-item" href="manager.php"><?php echo $lang['add_manager']; ?></a>
                    <a class="dropdown-item" href="public_manager.php"><?php echo $lang['add_public_manager']; ?></a>
                    <a class="dropdown-item" href="labor_register.php"><?php echo $lang['add_labor']; ?></a>
                    <a class="dropdown-item" href="labor_managment.php"><?php echo $lang['manage_labor']; ?></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $lang['admin']; ?> <i class="fas fa-tools"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="adminDropdown">
                    <a class="dropdown-item" href="#"><?php echo $lang['admin']; ?></a>
                    <a class="dropdown-item" href="#"><?php echo $lang['change_password']; ?></a>
                    <a class="dropdown-item" href="logout.php"><?php echo $lang['logout']; ?></a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo $lang['logs']; ?> <i class="fas fa-tools"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="enduserDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $lang['enduser']; ?> <i class="fas fa-tools"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="EnduserDropdown">
                    <a class="dropdown-item" href="#"><?php echo $lang['update_enduser']; ?></a>
                    <a class="dropdown-item" href="book.php"><?php echo $lang['add_book_paper']; ?></a>
                    <a class="dropdown-item" href="update_booktable.php"><?php echo $lang['update_books']; ?></a>
                    <a class="dropdown-item" href="update_schedul.php"><?php echo $lang['update_schedule']; ?></a>
                    <a class="dropdown-item" href="report.php"><?php echo $lang['report']; ?></a>
                    <a class="dropdown-item" href="genre.php"><?php echo $lang['report']; ?></a>
                    <a class="dropdown-item" href="paper_count.php"><?php echo $lang['paper report']; ?></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Language <i class="fas fa-globe"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="?lang=en">English</a>
                    <a class="dropdown-item" href="?lang=ps">Pashto</a>
                    <a class="dropdown-item" href="?lang=fa">Dari</a>
                </div>
            </li>
        </ul>
    </div>
    <!-- <dev><a href="logout.php">logout</a> </dev> -->
</nav>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <i class="fas fa-book icon"></i>
                <h3><?php echo $lang['books_count']; ?></h3>
                <p><?php echo $book_count; ?></p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <i class="fas fa-file-alt icon"></i>
                <h3><?php echo $lang['papers_count']; ?></h3>
                <p><?php echo $paper_count; ?></p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <i class="fas fa-users icon"></i>
                <h3><?php echo $lang['users_count']; ?></h3>
                <p><?php echo $user_count; ?></p>
            </div>
        </div>
        <!--  -->
    </div>
</div>

<!-- Bootstrap and custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
