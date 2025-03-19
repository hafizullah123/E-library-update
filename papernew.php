<?php
session_start();
include 'connection.php';

// Initialize message variable
$message = "";

// Handle language switching
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
} else {
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'en'; // Default language
    }
    $lang = $_SESSION['lang'];
}

// Localization function
function getLocalizedText($key, $lang) {
    switch ($lang) {
        case 'ps':
            $translations = [
                'home' => 'کور',
                'university' => 'پوهنتون:',
                'paper_title' => 'د مقاله عنوان:',
                'researcher_name' => 'د څیړونکي نوم:',
                'publication_date' => 'د خپریدو نیټه:',
                'paper_abstract' => 'خلاصه:',
                'pdf_file' => 'PDF فایل:',
                'type' => 'ډول:',
                'guider' => 'لار ښود ښوونکی: ',
                'department' => 'پوهنځی:',
                'section' => 'ډیپارټمنټ:',
                'add_paper' => ' اضافه کړئ',
                'success_message' => 'مقاله په بریالیتوب سره اضافه شوه',
                'error_message' => 'د مقالې په اضافه کولو کې تېروتنه: ',
                'duplicate_error' => 'دا عنوان دمخه شته!'
            ];
            break;
        case 'fa':
            $translations = [
                'home' => 'خانه',
                'university' => 'پوهنتون:',
                'paper_title' => 'عنوان مقاله:',
                'researcher_name' => 'نام محقق:',
                'publication_date' => 'تاریخ انتشار:',
                'paper_abstract' => 'خلاصه:',
                'pdf_file' => 'فایل PDF:',
                'type' => 'نوعیت',
                'guider' => 'استاد راهنما:',
                'department' => 'پوهنځی:',
                'section' => 'دیپارتمنت:',
                'add_paper' => 'افزودن',
                'success_message' => 'مقاله با موفقیت اضافه شد',
                'error_message' => 'خطا در افزودن مقاله: ',
                'duplicate_error' => 'این عنوان قبلاً وجود دارد!'
            ];
            break;
        default:
            $translations = [
                'home' => 'Home',
                'university' => 'University:',
                'paper_title' => 'Paper Title:',
                'researcher_name' => 'Researcher Name:',
                'publication_date' => 'Publication Date:',
                'paper_abstract' => 'Abstract:',
                'pdf_file' => 'PDF File:',
                'type' => 'Type:',
                'guider' => 'Guider:',
                'department' => 'Section:',
                'section' => 'Department:',
                'add_paper' => 'Add',
                'success_message' => 'Research paper added successfully',
                'error_message' => 'Error adding research paper: ',
                'duplicate_error' => 'This title already exists!'
            ];
            break;
    }
    return $translations[$key] ?? $key;
}

// Handle add research paper form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paperTitle = isset($_POST["paperTitle"]) ? $_POST["paperTitle"] : "";
    $researcherName = isset($_POST["researcherName"]) ? $_POST["researcherName"] : "";
    $publicationDate = isset($_POST["paperPublicationDate"]) ? $_POST["paperPublicationDate"] : "";
    $paperAbstract = isset($_POST["paperAbstract"]) ? $_POST["paperAbstract"] : "";
    $type = isset($_POST["type"]) ? $_POST["type"] : "";
    $guider = isset($_POST["guider"]) ? $_POST["guider"] : "";
    $department = isset($_POST["department"]) ? $_POST["department"] : "";
    $section = isset($_POST["section"]) ? $_POST["section"] : "";

    // Check for duplicate title
    $check_sql = "SELECT id FROM research_papers WHERE title = '$paperTitle'";
    $result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($result) > 0) {
        $message = getLocalizedText('duplicate_error', $lang);
    } else {
        // Upload PDF file
        $pdfName = "";
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $pdfName = str_replace(" ", "_", $_FILES['pdf']['name']);
            $pdfTemp = $_FILES['pdf']['tmp_name'];
            $uploadDir = 'paper/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($pdfTemp, $uploadDir . $pdfName)) {
                // File uploaded successfully
            } else {
                $message = getLocalizedText('error_message', $lang) . "File upload failed!";
            }
        }

        // Insert into database if no error
        if (empty($message)) {
            $sql = "INSERT INTO research_papers (title, author_name, publication_date, description, pdf, type, guider, department, section) 
                    VALUES ('$paperTitle', '$researcherName', '$publicationDate', '$paperAbstract', '$pdfName', '$type', '$guider', '$department', '$section')";
            
            if (mysqli_query($conn, $sql)) {
                $message = getLocalizedText('success_message', $lang);
            } else {
                $message = getLocalizedText('error_message', $lang) . mysqli_error($conn);
            }
        }
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getLocalizedText('add_paper', $lang); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 20px;
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
        .form-control, .form-control-file, .btn {
            text-align: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'right' : 'left'; ?>;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Language Selection Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><?php echo getLocalizedText('language', $lang); ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><?php echo getLocalizedText('home', $lang); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?lang=en">English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?lang=ps">پښتو</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?lang=fa"> دری</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h2 class="mt-4"><?php echo getLocalizedText('add_paper', $lang); ?></h2>
        <?php if (!empty($message)): ?>
            <script>
                alert('<?php echo addslashes($message); ?>');
            </script>
        <?php endif; ?>
        
        <div id="addPaper">  
            <form id="addPaperForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">  
                <div class="form-group">  
                    <label for="paperTitle"><?php echo getLocalizedText('paper_title', $lang); ?></label>  
                    <input type="text" class="form-control" id="paperTitle" name="paperTitle" required>  
                </div>  
                <div class="form-group">  
                    <label for="type"><?php echo getLocalizedText('type', $lang); ?></label>  
                    <select class="form-control" id="type" name="type" required>
                        <option value="Research Paper">Research Paper</option>
                        <option value="Thesis">Thesis</option>
                        <option value="Dissertation">Dissertation</option>
                        <option value="Article">Article</option>
                    </select>
                </div>  
                <div class="form-group">  
                    <label for="researcherName"><?php echo getLocalizedText('researcher_name', $lang); ?></label>  
                    <input type="text" class="form-control" id="researcherName" name="researcherName" required>  
                </div>  
                <div class="form-group">  
                    <label for="guider"><?php echo getLocalizedText('guider', $lang); ?></label>  
                    <input type="text" class="form-control" id="guider" name="guider" required>  
                </div>  
                <div class="form-group">  
                    <label for="department"><?php echo getLocalizedText('department', $lang); ?></label>  
                    <select class="form-control" id="department" name="department" required>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Physics">Physics</option>
                        <option value="Chemistry">Chemistry</option>
                    </select>
                </div>  
                <div class="form-group">  
                    <label for="section"><?php echo getLocalizedText('section', $lang); ?></label>  
                    <select class="form-control" id="section" name="section" required>
                        <option value="Software Engineering">Software Engineering</option>
                        <option value="Data Science">Data Science</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                        <option value="Networking">Networking</option>
                    </select>
                </div>  
                <div class="form-group">  
                    <label for="paperPublicationDate"><?php echo getLocalizedText('publication_date', $lang); ?></label>  
                    <input type="date" class="form-control" id="paperPublicationDate" name="paperPublicationDate" required>  
                </div>  
                <div class="form-group">  
                    <label for="paperAbstract"><?php echo getLocalizedText('paper_abstract', $lang); ?></label>  
                    <textarea class="form-control" id="paperAbstract" name="paperAbstract" rows="4" required></textarea>  
                </div>  
                <div class="form-group">  
                    <label for="pdf"><?php echo getLocalizedText('pdf_file', $lang); ?></label>  
                    <input type="file" class="form-control-file" id="pdf" name="pdf" required>  
                </div>  
                <button type="submit" class="btn btn-primary"><?php echo getLocalizedText('add_paper', $lang); ?></button>  
            </form>  
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>