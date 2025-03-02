<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php?action=login");
    exit;
}

include 'connection.php'; // Include your database connection file

// Define a function to get localized text
function getLocalizedText($key, $lang) {
    $translations = [
        'en' => [
            'book_name' => 'Book Name',
            'author_name' => 'Author Name',
            'isbn_number' => 'ISBN Number',
            'genre' => 'Genre',
            'publication_date' => 'Publication Date',
            'publisher' => 'Publisher',
            'description' => 'Description',
            'view_details' => 'View Details',
            'download_pdf' => 'Download PDF',
            'search_placeholder' => 'Search by Name or ISBN',
            'search_button' => 'Search',
            'no_books_found' => 'No books found.',
            'cover_image' => 'Cover Image',
            'actions' => 'Actions',
            'books' => 'Books',
            'papers' => 'Papers',
            'logout' => 'Logout',
            'language' => 'Language',
            'english' => 'English',
            'pashto' => 'Pashto',
            'dari' => 'Dari'
        ],
        'ps' => [
            'book_name' => 'د کتاب نوم',
            'author_name' => 'د لیکوال نوم',
            'isbn_number' => 'آی ایس بی این نمبر',
            'genre' => 'ژانر',
            'publication_date' => 'د خپرېدو نېټه',
            'publisher' => 'خپرونکی',
            'description' => 'تشریح',
            'view_details' => 'تفصیلات وګورئ',
            'download_pdf' => 'PDF ډاونلوډ کړئ',
            'search_placeholder' => 'د نوم یا ISBN په واسطه لټون وکړئ',
            'search_button' => 'لټون',
            'no_books_found' => 'هیڅ کتابونه ونه موندل شول.',
            'cover_image' => 'پوښ عکس',
            'actions' => 'عملونه',
            'books' => 'کتابونه',
            'papers' => 'لیکونه',
            'logout' => 'وتل',
            'language' => 'ژبه',
            'english' => 'انګلیسي',
            'pashto' => 'پښتو',
            'dari' => 'دری'
        ],
        'fa' => [
            'book_name' => 'نام کتاب',
            'author_name' => 'نام نویسنده',
            'isbn_number' => 'شماره شابک',
            'genre' => 'ژانر',
            'publication_date' => 'تاریخ انتشار',
            'publisher' => 'ناشر',
            'description' => 'توضیحات',
            'view_details' => 'مشاهده جزئیات',
            'download_pdf' => 'دانلود PDF',
            'search_placeholder' => 'جستجو بر اساس نام یا ISBN',
            'search_button' => 'جستجو',
            'no_books_found' => 'هیچ کتابی یافت نشد.',
            'cover_image' => 'تصویر جلد',
            'actions' => 'اقدامات',
            'books' => 'کتاب‌ها',
            'papers' => 'مقالات',
            'logout' => 'خروج',
            'language' => 'زبان',
            'english' => 'انگلیسی',
            'pashto' => 'پشتو',
            'dari' => 'دری'
        ]
    ];

    return $translations[$lang][$key] ?? $key;
}

// Set the language based on a session variable or default to English
$lang = $_SESSION['lang'] ?? 'en';

// Process language change request
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle file download
if (isset($_GET['download'])) {
    $file = $_GET['download'];

    // Check if the file exists
    if (file_exists($file)) {
        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "File not found.";
    }
}

// Process form submission to add a new book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    // Collect form data
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $author_name = $_POST['author_name'];
    $isbn_number = $_POST['isbn_number'];
    $genre = $_POST['genre'];
    $publication_date = $_POST['publication_date'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];

    // Handle file uploads
    $cover_image = $_FILES['cover_image']['name'];
    $pdf = $_FILES['pdf']['name'];

    // Define target directories
    $cover_image_target = "uploads/" . basename($cover_image);
    $pdf_target = "uploads/" . basename($pdf);

    // Move uploaded files to target directories
    if ($cover_image && move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image_target)) {
        echo "Cover image uploaded successfully. ";
    } else {
        echo "Error uploading cover image. ";
    }

    if ($pdf && move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_target)) {
        echo "PDF uploaded successfully.";
    } else {
        echo "Error uploading PDF.";
    }

    // Insert new book details into database
    $sql = "INSERT INTO books (book_name, author_name, isbn_number, genre, cover_image, pdf, publication_date, publisher, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssssssss", $book_name, $author_name, $isbn_number, $genre, $cover_image_target, $pdf_target, $publication_date, $publisher, $description);

    // Execute statement
    if ($stmt->execute()) {
        echo "Book details inserted successfully.";
    } else {
        echo "Error inserting book details: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Fetch category from URL parameters
$category = $_GET['category'] ?? '';

// Construct the SQL query for retrieving the books based on search query
$sql = "SELECT * FROM books";
if (!empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql .= " WHERE book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%'";
} else {
    $search_query = '';
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" <?php echo ($lang == 'ps' || $lang == 'fa') ? 'dir="rtl"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <a href="#" class="flex items-center py-4 px-2">
                        <span class="font-semibold text-gray-500 text-lg"><?php echo getLocalizedText('books', $lang); ?></span>
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="index.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300"><?php echo getLocalizedText('books', $lang); ?></a>
                    <a href="downpaper.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300"><?php echo getLocalizedText('papers', $lang); ?></a>
                    <a href="logout.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300"><?php echo getLocalizedText('logout', $lang); ?></a>
                    <div class="relative">
                        <button class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300" onclick="toggleLanguageDropdown()"><?php echo getLocalizedText('language', $lang); ?></button>
                        <div id="languageDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden">
                            <a href="?lang=en" class="block px-4 py-2 text-gray-800 hover:bg-green-500 hover:text-white"><?php echo getLocalizedText('english', $lang); ?></a>
                            <a href="?lang=ps" class="block px-4 py-2 text-gray-800 hover:bg-green-500 hover:text-white"><?php echo getLocalizedText('pashto', $lang); ?></a>
                            <a href="?lang=fa" class="block px-4 py-2 text-gray-800 hover:bg-green-500 hover:text-white"><?php echo getLocalizedText('dari', $lang); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-center mb-8"><?php echo getLocalizedText('books', $lang); ?></h2>
        <form method="GET" action="" class="mb-8">
            <div class="flex justify-center">
                <input type="text" name="search" class="w-64 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="<?php echo getLocalizedText('search_placeholder', $lang); ?>" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-r-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo getLocalizedText('search_button', $lang); ?></button>
            </div>
        </form>

        <?php if ($result->num_rows > 0) : ?>
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><?php echo getLocalizedText('cover_image', $lang); ?></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><?php echo getLocalizedText('book_name', $lang); ?></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><?php echo getLocalizedText('actions', $lang); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="<?php echo $row['cover_image']; ?>" class="w-16 h-16 object-cover rounded-lg" alt="Book Cover">
                                </td>
                                <td class="px-6 py-4"><?php echo $row['book_name']; ?></td>
                                <td class="px-6 py-4">
                                    <button onclick="toggleModal('bookModal<?php echo $row['book_id']; ?>')" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo getLocalizedText('view_details', $lang); ?></button>
                                    <a href="?download=<?php echo $row['pdf']; ?>" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo getLocalizedText('download_pdf', $lang); ?></a>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="bookModal<?php echo $row['book_id']; ?>">
                                <div class="bg-white rounded-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] flex flex-col shadow-2xl">
                                    <!-- Modal Header -->
                                    <div class="flex justify-between items-center mb-4 pb-4 border-b">
                                        <h3 class="text-xl font-bold"><?php echo $row['book_name']; ?></h3>
                                        <button class="text-gray-500 hover:text-gray-700" onclick="toggleModal('bookModal<?php echo $row['book_id']; ?>')">&times;</button>
                                    </div>
                                    <!-- Modal Body (Scrollable) -->
                                    <div class="overflow-y-auto flex-1 py-4">
                                        <img src="<?php echo $row['cover_image']; ?>" class="w-48 h-48 object-cover rounded-lg mx-auto mb-6 shadow-md" alt="Cover Image">
                                        <div class="space-y-4">
                                            <p><strong class="text-gray-700"><?php echo getLocalizedText('author_name', $lang); ?>:</strong> <?php echo $row['author_name']; ?></p>
                                            <p><strong class="text-gray-700"><?php echo getLocalizedText('isbn_number', $lang); ?>:</strong> <?php echo $row['isbn_number']; ?></p>
                                            <p><strong class="text-gray-700"><?php echo getLocalizedText('publication_date', $lang); ?>:</strong> <?php echo $row['publication_date']; ?></p>
                                            <p><strong class="text-gray-700"><?php echo getLocalizedText('publisher', $lang); ?>:</strong> <?php echo $row['publisher']; ?></p>
                                            <p><strong class="text-gray-700"><?php echo getLocalizedText('description', $lang); ?>:</strong> <?php echo $row['description']; ?></p>
                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="mt-6 flex justify-end space-x-4 pt-4 border-t">
                                        <button class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500" onclick="toggleModal('bookModal<?php echo $row['book_id']; ?>')"><?php echo getLocalizedText('close', $lang); ?></button>
                                        <a href="?download=<?php echo $row['pdf']; ?>" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo getLocalizedText('download_pdf', $lang); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500"><?php echo getLocalizedText('no_books_found', $lang); ?></p>
        <?php endif; ?>
    </div>

    <!-- Script for Modal Toggle -->
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function toggleLanguageDropdown() {
            const dropdown = document.getElementById('languageDropdown');
            dropdown.classList.toggle('hidden');
        }
    </script>
</body>
</html>