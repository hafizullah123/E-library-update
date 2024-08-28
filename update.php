<?php

session_start();
error_reporting();
include ('connection.php');
$userprofile=$_SESSION['user_id'];
if ($userprofile==true){
    
}
else{
    header('location: login.php ');
}


// Check if the language is set in the session
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; // Default to English
}

// Handle language switching
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

// Get the current language
$lang = $_SESSION['lang'];

// Localization function
function getLocalizedText($key, $lang) {
    $translations = [
        'en' => [
            'update_book_details' => 'Update Book Details',
            'book_name' => 'Book Name',
            'author_name' => 'Author Name',
            'isbn_number' => 'ISBN Number',
            'genre' => 'Genre',
            'cover_image' => 'Cover Image',
            'pdf' => 'PDF',
            'publication_date' => 'Publication Date',
            'publisher' => 'Publisher',
            'description' => 'Description',
            'update' => 'Update',
            'search_placeholder' => 'Search by Name or ISBN',
            'search' => 'Search',
            'cover_image_uploaded' => 'Cover image uploaded successfully.',
            'cover_image_upload_error' => 'Error uploading cover image.',
            'pdf_uploaded' => 'PDF uploaded successfully.',
            'pdf_upload_error' => 'Error uploading PDF.',
            'update_success' => 'Book details updated successfully.',
            'update_error' => 'Error updating book details: ',
            
            'no_books_found' => 'No books found.',
            'actions' => 'Actions',
            'language' => 'Language:',
            'english' => 'English',
            'pashto' => 'Pashto',
            'dari' => 'Dari',
            'home' => 'Home',
        ],
        'ps' => [
            'update_book_details' => 'د کتاب جزئیات تازه کړئ',
            'book_name' => 'د کتاب نوم',
            'author_name' => 'د لیکوال نوم',
            'isbn_number' => 'د ISBN شمېره',
            'genre' => 'ژانر',
            'cover_image' => 'د پوښ انځور',
            'pdf' => 'PDF',
            'publication_date' => 'د خپرېدو نېټه',
            'publisher' => 'خپرندوی',
            'description' => 'تشریح',
            'update' => 'تازه کړئ',
            'search_placeholder' => 'د نوم یا ISBN له مخې پلټنه',
            'search' => 'پلټنه',
            'cover_image_uploaded' => 'د پوښ انځور په بریالیتوب سره پورته شو.',
            'cover_image_upload_error' => 'د پوښ انځور پورته کولو تېروتنه.',
            'pdf_uploaded' => 'PDF په بریالیتوب سره پورته شو.',
            'pdf_upload_error' => 'د PDF پورته کولو تېروتنه.',
            'update_success' => 'د کتاب جزئیات په بریالیتوب سره تازه شول.',
            'update_error' => 'د کتاب جزئیات تازه کولو تېروتنه: ',
           
            'no_books_found' => 'هیڅ کتاب ونه موندل شو.',
            'actions' => 'عملیات',
            'language' => 'ژبه:',
            'english' => 'انګلیسي',
            'pashto' => 'پښتو',
            'dari' => 'دري',
            'home' => 'کور',
        ],
        'fa' => [
            'update_book_details' => 'جزئیات کتاب را به روز کنید',
            'book_name' => 'نام کتاب',
            'author_name' => 'نام نویسنده',
            'isbn_number' => 'شماره ISBN',
            'genre' => 'ژانر',
            'cover_image' => 'تصویر جلد',
            'pdf' => 'PDF',
            'publication_date' => 'تاریخ انتشار',
            'publisher' => 'ناشر',
            'description' => 'توضیحات',
            'update' => 'به روز رسانی',
            'search_placeholder' => 'جستجو بر اساس نام یا ISBN',
            'search' => 'جستجو',
            'cover_image_uploaded' => 'تصویر جلد با موفقیت آپلود شد.',
            'cover_image_upload_error' => 'خطا در آپلود تصویر جلد.',
            'pdf_uploaded' => 'PDF با موفقیت آپلود شد.',
            'pdf_upload_error' => 'خطا در آپلود PDF.',
            'update_success' => 'جزئیات کتاب با موفقیت به روز شد.',
            'update_error' => 'خطا در به روز رسانی جزئیات کتاب: ',
          
            'no_books_found' => 'هیچ کتابی یافت نشد.',
            'actions' => 'عملیات',
            'language' => 'زبان:',
            'english' => 'انگلیسی',
            'pashto' => 'پشتو',
            'dari' => 'دری',
            'home' => 'خانه',
        ],
    ];
    return $translations[$lang][$key] ?? $key;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $author_name = $_POST['author_name'];
    $isbn_number = $_POST['isbn_number'];
    $genre = $_POST['genre'];
    $publication_date = $_POST['publication_date'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];

    $cover_image = $_FILES['cover_image']['name'];
    $pdf = $_FILES['pdf']['name'];

    $cover_image_target = "uploads/" . basename($cover_image);
    $pdf_target = "uploads/" . basename($pdf);

    if ($cover_image && move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image_target)) {
        echo getLocalizedText('cover_image_uploaded', $lang) . ' ';
    } else {
        echo getLocalizedText('cover_image_upload_error', $lang) . ' ';
    }

    if ($pdf && move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_target)) {
        echo getLocalizedText('pdf_uploaded', $lang);
    } else {
        echo getLocalizedText('pdf_upload_error', $lang);
    }

    $sql = "UPDATE books SET book_name=?, author_name=?, isbn_number=?, genre=?, cover_image=?, pdf=?, publication_date=?, publisher=?, description=? WHERE book_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $book_name, $author_name, $isbn_number, $genre, $cover_image_target, $pdf_target, $publication_date, $publisher, $description, $book_id);

    if ($stmt->execute()) {
        echo getLocalizedText('update_success', $lang);
    } else {
        echo getLocalizedText('update_error', $lang) . $conn->error;
    }

    $stmt->close();
} else {
    echo getLocalizedText('', $lang);
}

$search_query = '';
$sql = "SELECT * FROM books";
if (!empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql .= " WHERE book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getLocalizedText('update_book_details', $lang); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .modal-dialog {
            margin: 30px auto;
        }
        .modal-cover-image {
            max-width: 100px;
            height: auto;
        }
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .modal-description {
            max-height: 200px;
            overflow-y: auto;
        }
        .book-image {
            max-width: 100px;
            height: auto;
        }
        th, td {
            white-space: nowrap;
        }
    </style>
</head>
<body class="<?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo getLocalizedText('language', $lang); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="?lang=en"><?php echo getLocalizedText('english', $lang); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?lang=ps"><?php echo getLocalizedText('pashto', $lang); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?lang=fa"><?php echo getLocalizedText('dari', $lang); ?></a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="dashboar.php"><?php echo getLocalizedText('home', $lang); ?></a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid mt-5">
    <form class="form-inline mb-3" method="get">
        <input class="form-control mr-sm-2" type="search" placeholder="<?php echo getLocalizedText('search_placeholder', $lang); ?>" aria-label="Search" name="search" id="searchInput" value="<?php echo htmlspecialchars($search_query); ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php echo getLocalizedText('search', $lang); ?></button>
    </form>
    <div class="table-responsive" id="tableContainer">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo getLocalizedText('cover_image', $lang); ?></th>
                    <th><?php echo getLocalizedText('book_name', $lang); ?></th>
                    <th><?php echo getLocalizedText('description', $lang); ?></th>
                    <th><?php echo getLocalizedText('genre', $lang); ?></th>
                    <th><?php echo getLocalizedText('author_name', $lang); ?></th>
                    <th><?php echo getLocalizedText('isbn_number', $lang); ?></th>
                    <th><?php echo getLocalizedText('publication_date', $lang); ?></th>
                    <th><?php echo getLocalizedText('publisher', $lang); ?></th>
                    <th><?php echo getLocalizedText('actions', $lang); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && $result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $description = htmlspecialchars($row['description']);
                        $short_description = implode(' ', array_slice(explode(' ', $description), 0, 5)) . '...';
                        ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($row['cover_image']); ?>" alt="Cover Image" class="modal-cover-image"></td>
                            <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                            <td class="truncate"><?php echo $short_description; ?></td>
                            <td><?php echo htmlspecialchars($row['genre']); ?></td>
                            <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['isbn_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['publication_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['publisher']); ?></td>
                            <td class="icon-column"><a href="#" class="btn btn-warning update-btn" data-toggle="modal" data-target="#updateModal_<?php echo $row['book_id']; ?>"><i class="fas fa-pencil-alt"></i> <?php echo getLocalizedText('update', $lang); ?></a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9"><?php echo getLocalizedText('no_books_found', $lang); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Update Modals -->
<div id="modalContainer">
    <?php if (isset($result) && $result && $result->num_rows > 0): ?>
        <?php $result->data_seek(0); ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="modal fade" id="updateModal_<?php echo $row['book_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel_<?php echo $row['book_id']; ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel_<?php echo $row['book_id']; ?>"><?php echo getLocalizedText('update_book_details', $lang); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                <div class="form-group">
                                    <label for="book_name"><?php echo getLocalizedText('book_name', $lang); ?></label>
                                    <input type="text" class="form-control" id="book_name" name="book_name" value="<?php echo htmlspecialchars($row['book_name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="author_name"><?php echo getLocalizedText('author_name', $lang); ?></label>
                                    <input type="text" class="form-control" id="author_name" name="author_name" value="<?php echo htmlspecialchars($row['author_name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="isbn_number"><?php echo getLocalizedText('isbn_number', $lang); ?></label>
                                    <input type="text" class="form-control" id="isbn_number" name="isbn_number" value="<?php echo htmlspecialchars($row['isbn_number']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="genre"><?php echo getLocalizedText('genre', $lang); ?></label>
                                    <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($row['genre']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cover_image"><?php echo getLocalizedText('cover_image', $lang); ?></label>
                                    <input type="file" class="form-control" id="cover_image" name="cover_image">
                                </div>
                                <div class="form-group">
                                    <label for="pdf"><?php echo getLocalizedText('pdf', $lang); ?></label>
                                    <input type="file" class="form-control" id="pdf" name="pdf">
                                </div>
                                <div class="form-group">
                                    <label for="publication_date"><?php echo getLocalizedText('publication_date', $lang); ?></label>
                                    <input type="date" class="form-control" id="publication_date" name="publication_date" value="<?php echo htmlspecialchars($row['publication_date']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="publisher"><?php echo getLocalizedText('publisher', $lang); ?></label>
                                    <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo htmlspecialchars($row['publisher']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="description"><?php echo getLocalizedText('description', $lang); ?></label>
                                    <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($row['description']); ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary"><?php echo getLocalizedText('update', $lang); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
