<?php
session_start();
include 'connection.php';

// Language selection based on user preference or default to English
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';

// Language-specific text arrays
$languages = [
    'en' => [
        'navbar_home' => 'Home',
        'navbar_language' => 'Language',
        'search_placeholder' => 'Search by Title or Author',
        'search_button' => 'Search',
        'no_papers_found' => 'No research papers found.',
        'record_updated_success' => 'Record updated successfully',
        'pdf_files_allowed' => 'Only PDF files are allowed.',
        'update_paper' => 'Update Research Paper',
        'title_label' => 'Title',
        'description_label' => 'Description',
        'author_label' => 'Author',
        'publication_date_label' => 'Publication Date',
        'upload_new_pdf' => 'Upload New PDF (Optional)',
        'view' => 'View',
        'update' => 'Update',
        'close' => 'Close',
        'delete' => 'Delete'
    ],
    'ps' => [
        'navbar_home' => 'کورنی',
        'navbar_language' => 'ژبه',
        'search_placeholder' => 'د تواندنۍ یا نوی نوم لخوا لټون',
        'search_button' => 'لټون',
        'no_papers_found' => 'هیڅ تحقیقي کاغذ ونه موندل شو',
        'record_updated_success' => 'تاریخچه په بریالیتوب سره نوی شو',
        'pdf_files_allowed' => 'په ټولو پی ډی ایف داخلېدل اجازه شته',
        'update_paper' => 'تحقیقي کاغذ تازه کول',
        'title_label' => 'سرلیک',
        'description_label' => 'پیژندنه',
        'author_label' => 'لیکوال',
        'publication_date_label' => 'نشر سنډ',
        'upload_new_pdf' => 'نوی پی ډی اف اپلوډ (اختیاري)',
        'view' => 'غوره کول',
        'update' => 'تازه کول',
        'close' => 'بندول',
        'delete' => 'حذف'
    ],
    'fa' => [
        'navbar_home' => 'خانه',
        'navbar_language' => 'زبان',
        'search_placeholder' => 'بر اساس عنوان یا نویسنده جستجو کنید',
        'search_button' => 'جستجو',
        'no_papers_found' => 'هیچ کاغذ تحقیقی پیدا نشد.',
        'record_updated_success' => 'رکورد با موفقیت به روز شد',
        'pdf_files_allowed' => 'فقط فایل‌های PDF مجاز هستند.',
        'update_paper' => 'به‌روزرسانی کاغذ تحقیقی',
        'title_label' => 'عنوان',
        'description_label' => 'توضیحات',
        'author_label' => 'نویسنده',
        'publication_date_label' => 'تاریخ انتشار',
        'upload_new_pdf' => 'آپلود PDF جدید (اختیاری)',
        'view' => 'نمایش',
        'update' => 'به‌روزرسانی',
        'close' => 'بستن',
        'delete' => 'حذف'
    ]
];

// Fetch search query from URL parameters
$search_query = $_GET['search'] ?? '';

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paper_id = $_POST['paper_id'];
    $updateTitle = mysqli_real_escape_string($conn, $_POST['updateTitle']);
    $updateDescription = mysqli_real_escape_string($conn, $_POST['updateDescription']);
    $updateAuthor = mysqli_real_escape_string($conn, $_POST['updateAuthor']);
    $updatePublicationDate = $_POST['updatePublicationDate'];

    // Handle PDF file upload if provided
    $updatePDF = $_FILES['updatePDF'];

    // Check if a new PDF file is uploaded
    if (!empty($updatePDF['name'])) {
        $pdf_name = $updatePDF['name'];
        $pdf_tmp = $updatePDF['tmp_name'];
        $pdf_size = $updatePDF['size'];
        $pdf_type = $updatePDF['type'];

        // Validate file type
        $pdf_allowed_ext = array("pdf");
        $pdf_ext = pathinfo($pdf_name, PATHINFO_EXTENSION);

        if (!in_array($pdf_ext, $pdf_allowed_ext)) {
            echo $languages[$lang]['pdf_files_allowed'];
            exit();
        }

        // Move uploaded file to uploads directory
        $upload_folder = "uploads/";
        $pdf_path = $upload_folder . $pdf_name;
        move_uploaded_file($pdf_tmp, $pdf_path);

        // Update query with PDF file path
        $sql = "UPDATE research_papers SET title='$updateTitle', description='$updateDescription', author_name='$updateAuthor', publication_date='$updatePublicationDate', pdf='$pdf_name' WHERE paper_id=$paper_id";
    } else {
        // Update query without changing the PDF file
        $sql = "UPDATE research_papers SET title='$updateTitle', description='$updateDescription', author_name='$updateAuthor', publication_date='$updatePublicationDate' WHERE paper_id=$paper_id";
    }

    // Execute the update query
    if ($conn->query($sql) === TRUE) {
        echo $languages[$lang]['record_updated_success'];
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $paper_id = $_GET['paper_id'];

    // SQL to delete a record
    $sql = "DELETE FROM research_papers WHERE paper_id=$paper_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Construct the SQL query for retrieving the research papers based on search query
$sql = "SELECT * FROM research_papers";
if (!empty($search_query)) {
    $sql .= " WHERE title LIKE '%$search_query%' OR author_name LIKE '%$search_query%'";
}
$result = $conn->query($sql);

function getFirstFiveWords($text) {
    $words = explode(' ', $text);
    return implode(' ', array_slice($words, 0, 5));
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Update Research Papers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .modal-dialog {
            margin: 30px auto;
        }
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .modal-description {
            max-height: 80px;
            overflow-y: auto;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        <?php if (in_array($lang, ['ps', 'fa'])): ?>
            body { direction: rtl; }
        <?php endif; ?>
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="dashboar.php"><?php echo $languages[$lang]['navbar_home']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $languages[$lang]['navbar_language']; ?>
                </a>
                <div class="dropdown
<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="?lang=en">English</a>
    <a class="dropdown-item" href="?lang=ps">پښتو</a>
    <a class="dropdown-item" href="?lang=fa"> دری </a>
</div>
</li>
</ul>
<form class="form-inline my-2 my-lg-0" action="" method="get">
    <input class="form-control mr-sm-2" type="search" placeholder="<?php echo $languages[$lang]['search_placeholder']; ?>" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php echo $languages[$lang]['search_button']; ?></button>
</form>
</div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4"><?php echo $languages[$lang]['update_paper']; ?></h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $languages[$lang]['title_label']; ?></th>
                    <th><?php echo $languages[$lang]['description_label']; ?></th>
                    <th><?php echo $languages[$lang]['author_label']; ?></th>
                    <th><?php echo $languages[$lang]['publication_date_label']; ?></th>
                    <th><?php echo $languages[$lang]['view']; ?></th>
                    <th><?php echo $languages[$lang]['update']; ?></th>
                    <th><?php echo $languages[$lang]['delete']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['paper_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars(getFirstFiveWords($row['description'])); ?></td>
                        <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['publication_date']); ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewModal<?php echo $row['paper_id']; ?>">
                                <?php echo $languages[$lang]['view']; ?>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal<?php echo $row['paper_id']; ?>">
                                <?php echo $languages[$lang]['update']; ?>
                            </button>
                        </td>
                        <td>
                            <a href="?action=delete&paper_id=<?php echo $row['paper_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">
                                <?php echo $languages[$lang]['delete']; ?>
                            </a>
                        </td>
                    </tr>

                    <!-- View Modal -->
                    <div class="modal fade" id="viewModal<?php echo $row['paper_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo $row['paper_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel<?php echo $row['paper_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                                    <p><strong><?php echo $languages[$lang]['author_label']; ?>:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>
                                    <p><strong><?php echo $languages[$lang]['publication_date_label']; ?>:</strong> <?php echo htmlspecialchars($row['publication_date']); ?></p>
                                    <?php if (!empty($row['pdf'])): ?>
                                        <a href="uploads/<?php echo $row['pdf']; ?>" target="_blank" class="btn btn-primary"><?php echo $languages[$lang]['view']; ?> PDF</a>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $languages[$lang]['close']; ?></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal<?php echo $row['paper_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?php echo $row['paper_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel<?php echo $row['paper_id']; ?>"><?php echo $languages[$lang]['update_paper']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="paper_id" value="<?php echo $row['paper_id']; ?>">
                                        <div class="form-group">
                                            <label for="updateTitle"><?php echo $languages[$lang]['title_label']; ?></label>
                                            <input type="text" class="form-control" id="updateTitle" name="updateTitle" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="updateDescription"><?php echo $languages[$lang]['description_label']; ?></label>
                                            <textarea class="form-control" id="updateDescription" name="updateDescription" rows="3" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="updateAuthor"><?php echo $languages[$lang]['author_label']; ?></label>
                                            <input type="text" class="form-control" id="updateAuthor" name="updateAuthor" value="<?php echo htmlspecialchars($row['author_name']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="updatePublicationDate"><?php echo $languages[$lang]['publication_date_label']; ?></label>
                                            <input type="date" class="form-control" id="updatePublicationDate" name="updatePublicationDate" value="<?php echo $row['publication_date']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="updatePDF"><?php echo $languages[$lang]['upload_new_pdf']; ?></label>
                                            <input type="file" class="form-control-file" id="updatePDF" name="updatePDF">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $languages[$lang]['close']; ?></button>
                                        <button type="submit" class="btn btn-primary"><?php echo $languages[$lang]['update']; ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><?php echo $languages[$lang]['no_papers_found']; ?></p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
