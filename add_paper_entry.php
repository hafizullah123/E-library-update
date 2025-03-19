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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            direction: <?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <!-- Language Selection Navbar -->
        <nav class="bg-white shadow-md p-4 mb-6">
    <div class="flex justify-between items-center">
        <a class="text-xl font-bold" href="#"><?php echo getLocalizedText('language', $lang); ?></a>
        <div class="flex space-x-6"> <!-- Increased spacing between all elements -->
            <a class="text-blue-500 hover:text-blue-700" href="add_book_entry.php"><?php echo getLocalizedText('book', $lang); ?></a>
            <a class="text-blue-500 hover:text-blue-700" href="?lang=en">English</a>
            <a class="text-blue-500 hover:text-blue-700" href="?lang=ps">پښتو</a>
            <a class="text-blue-500 hover:text-blue-700" href="?lang=fa">دری</a>
        </div>
    </div>
</nav>
        <h2 class="text-2xl font-bold mb-4"><?php echo getLocalizedText('add_paper', $lang); ?></h2>
        <p class="mb-4 text-green-600"><?php echo $message; ?></p> <!-- Display message here -->
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form id="addPaperForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('type', $lang); ?></label>
                    <select class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="type" name="type" required>
                        <option value="Research Paper">Research Paper</option>
                        <option value="Thesis">Thesis</option>
                        <option value="Dissertation">Dissertation</option>
                        <option value="Article">Article</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="paperTitle" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('paper_title', $lang); ?></label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="paperTitle" name="paperTitle" required>
                </div>
                <div class="mb-4">
                    <label for="researcherName" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('researcher_name', $lang); ?></label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="researcherName" name="researcherName" required>
                </div>
                <div class="mb-4">
                    <label for="guider" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('guider', $lang); ?></label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="guider" name="guider" required>
                </div>
                <div class="mb-4">
                    <label for="department" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('department', $lang); ?></label>
                    <select class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="department" name="department" required>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Physics">Physics</option>
                        <option value="Chemistry">Chemistry</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="section" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('section', $lang); ?></label>
                    <select class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="section" name="section" required>
                        <option value="Software Engineering">Software Engineering</option>
                        <option value="Data Science">Data Science</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                        <option value="Networking">Networking</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="paperPublicationDate" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('publication_date', $lang); ?></label>
                    <input type="date" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="paperPublicationDate" name="paperPublicationDate" required>
                </div>
                <div class="mb-4">
                    <label for="paperAbstract" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('paper_abstract', $lang); ?></label>
                    <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="paperAbstract" name="paperAbstract" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label for="pdf" class="block text-sm font-medium text-gray-700"><?php echo getLocalizedText('pdf_file', $lang); ?></label>
                    <input type="file" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="pdf" name="pdf" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700"><?php echo getLocalizedText('add_paper', $lang); ?></button>
            </form>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>