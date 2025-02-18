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
                'paper_title' => 'د مقالې سرلیک:',
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
                'error_message' => 'د مقالې په اضافه کولو کې تېروتنه: '
            ];
            break;
        case 'fa':
            $translations = [
                'home' => 'خانه',
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
                'error_message' => 'خطا در افزودن مقاله: '
            ];
            break;
        default:
            $translations = [
                'home' => 'Home',
                'paper_title' => 'Paper Title:',
                'researcher_name' => 'Researcher Name:',
                'publication_date' => 'Publication Date:',
                'paper_abstract' => 'Abstract:',
                'pdf_file' => 'PDF File:',
                'type'=> 'Type:',
                'guider' => 'Guider:',
                'department' => 'Section:',
                'section' => 'Department:',
                'add_paper' => 'Add ',
                'success_message' => 'Research paper added successfully',
                'error_message' => 'Error adding research paper: '
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

    // Upload PDF file
    $pdfName = ""; 

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $pdfName = str_replace(" ", "_", $_FILES['pdf']['name']); // Fix spaces in file name
        $pdfTemp = $_FILES['pdf']['tmp_name'];
        $uploadDir = 'paper/';
    
        // Ensure the folder exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        // Move uploaded file
        if (move_uploaded_file($pdfTemp, $uploadDir . $pdfName)) {
            echo "File uploaded successfully: <a href='$uploadDir$pdfName'>$pdfName</a>";
        } else {
            echo "File upload failed!";
        }
    } else {
        echo "Error: " . $_FILES['pdf']['error']; // Show error if upload fails
    }
    

    // Insert research paper into the database (sanitization needed)
    $sql = "INSERT INTO research_papers (title, author_name, publication_date, description, pdf, type, guider, department, section) 
            VALUES ('$paperTitle', '$researcherName', '$publicationDate', '$paperAbstract', '$pdfName', '$type', '$guider', '$department', '$section')";
    if (mysqli_query($conn, $sql)) {
        $message = getLocalizedText('success_message', $lang);
    } else {
        $message = getLocalizedText('error_message', $lang) . $sql . "<br>" . mysqli_error($conn);
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
                        <a class="nav-link" href="dashboar.php"><?php echo getLocalizedText('home', $lang); ?></a>
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
        <p><?php echo $message; ?></p> <!-- Display message here -->
        <div id="addPaper">  
    <form id="addPaperForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">  
        <div class="form-group">  
            <label for="type"><?php echo getLocalizedText('type', $lang); ?></label>  
            <input type="text" class="form-control" id="type" name="type" required>  
        </div>  
        <div class="form-group">  
            <label for="paperTitle"><?php echo getLocalizedText('paper_title', $lang); ?></label>  
            <input type="text" class="form-control" id="paperTitle" name="paperTitle" required>  
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
            <input type="text" class="form-control" id="department" name="department" required>  
        </div>  
        <div class="form-group">  
            <label for="section"><?php echo getLocalizedText('section', $lang); ?></label>  
            <input type="text" class="form-control" id="section" name="section" required>  
        </div>  
        <div class="form-group">  
            <label for="paperPublicationDate"><?php echo getLocalizedText('publication_date', $lang); ?></label>  
            <input type="date" class="form-control" id="paperPublicationDate" name="paperPublicationDate" required>  
        </div>  
        <div class="form-group">  
            <label for="paperAbstract"><?php echo getLocalizedText('paper_abstract', $lang); ?></label>  
            <textarea class="form-control" id="paperAbstract" name="paperAbstract" rows="3"></textarea>  
        </div>  
        <div class="form-group">  
            <label for="pdf"><?php echo getLocalizedText('pdf_file', $lang); ?></label>  
            <input type="file" class="form-control-file" id="pdf" name="pdf" required>  
        </div>  
        <button type="submit" class="btn btn-primary"><?php echo getLocalizedText('add_paper', $lang); ?></button>  
    </form>  
</div>
        </div>
    </div>

    <!-- Bootstrap and custom scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>