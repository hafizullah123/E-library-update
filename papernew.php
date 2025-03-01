<?php  
session_start();  

// Check if the user is logged in  
if (!isset($_SESSION['user_id'])) {  
    header("Location: index.php?action=login");  
    exit;  
}  

include 'connection.php';  

// Detect and load the selected language  
$lang = $_GET['lang'] ?? 'en';  
$dir = 'ltr';  

switch ($lang) {  
    case 'ps':  
        $translations = [  
            'title' => 'تحقیقي مقالې',  
            'search' => 'لټون',  
            'search_placeholder' => 'د سرلیک یا لیکوال له مخې لټون...',  
            'author' => 'لیکوال',  
            'publication_date' => 'د خپرېدو نیټه',  
            'type' => 'ډول',  
            'department' => 'د څانګې',  
            'actions' => 'اقدامات',  
            'no_papers' => 'هیڅ تحقیقي مقاله نه موندل شوه.',  
            'logout' => 'وتل',  
            'pashto' => 'پښتو',  
            'dari' => 'دری',  
            'english' => 'English',  
            'modal_download' => 'مقاله ښکته کړئ',  
            'description' => 'توضیحات',  
            'close' => 'بندول', // Added for close button  
            'books' => 'کتابونه', // Added Books translation  
        ];  
        $dir = 'rtl';  
        break;  
    case 'dr':  
        $translations = [  
            'title' => 'مقالات تحقیقی',  
            'search' => 'جستجو',  
            'search_placeholder' => 'جستجو بر اساس عنوان یا نویسنده...',  
            'author' => 'نویسنده',  
            'publication_date' => 'تاریخ نشر',  
            'type' => 'نوع',  
            'department' => 'بخش',  
            'actions' => 'عملیات',  
            'no_papers' => 'هیچ مقاله تحقیقی پیدا نشد.',  
            'logout' => 'خروج',  
            'pashto' => 'پښتو',  
            'dari' => 'دری',   
            'english' => 'English',  
            'modal_download' => 'دانلود مقاله',  
            'description' => 'توضیحات',  
            'close' => 'بندول', // Added for close button  
            'books' => 'کتابونه', // Added Books translation  
        ];  
        $dir = 'rtl';  
        break;  
    case 'en':  
    default:  
        $translations = [  
            'title' => 'Research Papers',  
            'search' => 'Search',  
            'search_placeholder' => 'Search by title or author...',  
            'author' => 'Author',  
            'publication_date' => 'Publication Date',  
            'type' => 'Type',  
            'department' => 'Department',  
            'actions' => 'Actions',  
            'no_papers' => 'No research papers found.',  
            'logout' => 'Logout',  
            'pashto' => 'Pashto',  
            'dari' => 'Dari',  
            'modal_download' => 'Download Paper',  
            'description' => 'Description',  
            'english' => 'English',  
            'close' => 'Close', // Added for close button  
            'books' => 'Books', // Added Books translation  
        ];  
        $dir = 'ltr';   
        break;   
}  

// Fetch search query from URL parameters  
$search_query = $_GET['search'] ?? '';  

// Construct the SQL query for retrieving the research papers  
$sql = "SELECT paper_id, title, description, author_name, publication_date, pdf, type, department FROM research_papers";  
if (!empty($search_query)) {  
    $sql .= " WHERE title LIKE '%$search_query%' OR author_name LIKE '%$search_query%'";  
}  
$result = $conn->query($sql);  
?>  
<!DOCTYPE html>  
<html lang="<?php echo htmlspecialchars($lang); ?>" dir="<?php echo htmlspecialchars($dir); ?>">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title><?php echo htmlspecialchars($translations['title']); ?></title>  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">  
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">  
</head>  
<body class="bg-gray-100">  

<nav class="bg-white shadow">  
    <div class="max-w-7xl mx-auto px-6">  
        <div class="flex justify-between items-center h-16">  
            <a href="#" class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($translations['title']); ?></a>  
            <div class="flex space-x-4">  
                <a href="?lang=ps" class="text-blue-600"><?php echo htmlspecialchars($translations['pashto']); ?></a>  
                <a href="?lang=dr" class="text-blue-600"><?php echo htmlspecialchars($translations['dari']); ?></a>  
                <a href="?lang=en" class="text-blue-600"><?php echo htmlspecialchars($translations['english']); ?></a>  
                <a href="books.php" class="text-blue-600"><?php echo htmlspecialchars($translations['books']); ?></a>  <!-- Books link added -->  
                <a href="logout.php" class="text-blue-600"><?php echo htmlspecialchars($translations['logout']); ?></a>  
            </div>  
        </div>  
    </div>  
</nav>  

<div class="max-w-5xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">  
    <form class="mb-6 flex" method="get" action="">  
        <input type="hidden" name="lang" value="<?php echo htmlspecialchars($lang); ?>">  
        <input class="flex-grow border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-500" type="search" placeholder="<?php echo htmlspecialchars($translations['search_placeholder']); ?>" name="search" value="<?php echo htmlspecialchars($search_query); ?>">  
        <button class="ml-2 bg-blue-600 text-white rounded-md px-4 py-2 shadow-md hover:bg-blue-700" type="submit"><?php echo htmlspecialchars($translations['search']); ?></button>  
    </form>  

    <div class="overflow-x-auto">  
        <table class="min-w-full bg-white">  
            <thead class="bg-gray-200">  
                <tr>  
                    <th class="py-3 px-4 text-left text-gray-600"><?php echo htmlspecialchars($translations['title']); ?></th>  
                    <th class="hidden md:table-cell py-3 px-4 text-left text-gray-600"><?php echo htmlspecialchars($translations['author']); ?></th>  
                    <th class="hidden md:table-cell py-3 px-4 text-left text-gray-600"><?php echo htmlspecialchars($translations['publication_date']); ?></th>  
                    <th class="hidden md:table-cell py-3 px-4 text-left text-gray-600"><?php echo htmlspecialchars($translations['type']); ?></th>  
                    <th class="hidden md:table-cell py-3 px-4 text-left text-gray-600"><?php echo htmlspecialchars($translations['department']); ?></th>  
                    <th class="py-3 px-4 text-left text-gray-600"><?php echo htmlspecialchars($translations['actions']); ?></th>  
                </tr>  
            </thead>  
            <tbody>  
                <?php if ($result && $result->num_rows > 0): ?>  
                    <?php while ($row = $result->fetch_assoc()): ?>  
                        <tr class="border-t hover:bg-gray-50">  
                            <td class="py-3 px-4 border-b">  
                                <a href="#" class="text-blue-600 hover:underline" data-toggle="modal" data-target="#paperModal_<?php echo htmlspecialchars($row['paper_id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>  
                            </td>  
                            <td class="hidden md:table-cell py-3 px-4 border-b"><?php echo htmlspecialchars($row['author_name']); ?></td>  
                            <td class="hidden md:table-cell py-3 px-4 border-b"><?php echo htmlspecialchars($row['publication_date']); ?></td>  
                            <td class="hidden md:table-cell py-3 px-4 border-b"><?php echo htmlspecialchars($row['type']); ?></td>  
                            <td class="hidden md:table-cell py-3 px-4 border-b"><?php echo htmlspecialchars($row['department']); ?></td>  
                            <td class="py-3 px-4 border-b">  
                                <a href="paper/<?php echo htmlspecialchars($row['pdf']); ?>" class="bg-green-500 hover:bg-green-600 text-white text-sm py-1 px-2 rounded" download><?php echo htmlspecialchars($translations['modal_download']); ?></a>  
                            </td>  
                        </tr>  

                        <!-- Modal for Paper Details -->  
                        <div class="modal fade" id="paperModal_<?php echo htmlspecialchars($row['paper_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel_<?php echo htmlspecialchars($row['paper_id']); ?>" aria-hidden="true">  
                            <div class="modal-dialog" role="document">  
                                <div class="modal-content" dir="<?php echo htmlspecialchars($dir); ?>">  <!-- Set direction here -->  
                                    <div class="modal-header">  
                                        <h5 class="modal-title"><?php echo htmlspecialchars($row['title']); ?></h5>  
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">  
                                            <span>&times;</span>  
                                        </button>  
                                    </div>  
                                    <div class="modal-body">  
                                        <p><strong><?php echo htmlspecialchars($translations['author']); ?>:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>  
                                        <p><strong><?php echo htmlspecialchars($translations['publication_date']); ?>:</strong> <?php echo htmlspecialchars($row['publication_date']); ?></p>  
                                        <p><strong><?php echo htmlspecialchars($translations['type']); ?>:</strong> <?php echo htmlspecialchars($row['type']); ?></p>  
                                        <p><strong><?php echo htmlspecialchars($translations['department']); ?>:</strong> <?php echo htmlspecialchars($row['department']); ?></p>  
                                        <p><strong><?php echo htmlspecialchars($translations['description']); ?>:</strong> <?php echo htmlspecialchars($row['description']); ?></p>  
                                    </div>  
                                    <div class="modal-footer">  
                                        <a href="paper/<?php echo htmlspecialchars($row['pdf']); ?>" class="btn btn-success"><?php echo htmlspecialchars($translations['modal_download']); ?></a>  
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo htmlspecialchars($translations['close']); ?></button>  
                                    </div>  
                                </div>  
                            </div>  
                        </div>  
                    <?php endwhile; ?>  
                <?php else: ?>  
                    <tr><td colspan="6" class="py-4 text-center text-gray-600"><?php echo htmlspecialchars($translations['no_papers']); ?></td></tr>  
                <?php endif; ?>  
            </tbody>  
        </table>  
    </div>  
</div>  

<!-- Bootstrap and JavaScript -->  
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>  