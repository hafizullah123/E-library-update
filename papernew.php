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
        $lang_file = "language/paper_pashto.php";  
        $dir = 'rtl';  
        break;  
    case 'dr':  
        $lang_file = "language/paper_dari.php";  
        $dir = 'rtl';  
        break;  
    case 'en':  
    default:  
        $lang_file = "language/paper_english.php";  
        $dir = 'ltr';  
        break;  
}  

$translations = include $lang_file;  

// Fetch search query from URL parameters  
$search_query = $_GET['search'] ?? '';  

// Construct the SQL query for retrieving the research papers  
$sql = "SELECT paper_id, title, description, author_name, publication_date, pdf, type FROM research_papers";  
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
<html lang="<?php echo $lang; ?>" dir="<?php echo $dir; ?>">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title><?php echo $translations['title']; ?></title>  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <style>  
        /* Custom Styles */  
        body {  
            font-family: 'Arial', sans-serif;  
            background-color: #f8f9fa;  
        }  
        .navbar {  
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);  
        }  
        .container {  
            margin-top: 20px;  
        }  
        .table-responsive {  
            overflow-x: auto;  
        }  
        .table {  
            width: 100%;  
            margin-bottom: 1rem;  
            background-color: #fff;  
            border-collapse: collapse;  
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);  
        }  
        .table th, .table td {  
            padding: 12px;  
            text-align: center;  
            vertical-align: middle;  
            border: 1px solid #dee2e6;  
        }  
        .table th {  
            background-color: #343a40;  
            color: #fff;  
            font-weight: bold;  
        }  
        .table tbody tr:hover {  
            background-color: #f1f1f1;  
        }  
        .btn-success {  
            background-color: #28a745;  
            border-color: #28a745;  
            transition: background-color 0.3s;  
        }  
        .btn-success:hover {  
            background-color: #218838;  
            border-color: #1e7e34;  
        }  
        .modal-content {  
            border-radius: 15px;  
            border: none;  
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);  
        }  
        .modal-header {  
            background-color: #007bff;  
            color: #fff;  
            border-top-left-radius: 15px;  
            border-top-right-radius: 15px;  
        }  
        .modal-title {  
            font-weight: bold;  
        }  
        .modal-body {  
            padding: 20px;  
        }  
        .modal-description {  
            max-height: 200px;  
            overflow-y: auto;  
            margin-bottom: 20px;  
        }  
        .icon-column {  
            width: 120px;  
        }  
        .truncate {  
            white-space: nowrap;  
            overflow: hidden;  
            text-overflow: ellipsis;  
        }  
        @media (max-width: 768px) {  
            .table th, .table td {  
                padding: 8px;  
            }  
            .btn-success {  
                padding: 5px 10px;  
                font-size: 14px;  
            }  
        }  
    </style>  
</head>  
<body>  

<nav class="navbar navbar-expand-lg navbar-light bg-light">  
    <a class="navbar-brand" href="#"><?php echo $translations['library']; ?></a>  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">  
        <span class="navbar-toggler-icon"></span>  
    </button>  
    <div class="collapse navbar-collapse" id="navbarNav">  
        <ul class="navbar-nav ml-auto">  
            <li class="nav-item">  
                <a class="nav-link" href="downbook.php"><?php echo $translations['books']; ?></a>  
            </li>  
            <li class="nav-item active">  
                <a class="nav-link" href="#"><?php echo $translations['papers']; ?> <span class="sr-only">(current)</span></a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="?lang=ps">پښتو</a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="?lang=dr">دری</a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="?lang=en">English</a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="logout.php"><?php echo $translations['logout']; ?></a>  
            </li>  
        </ul>  
    </div>  
</nav>  

<div class="container mt-4">  
    <form class="form-inline mb-3" method="get">  
        <input type="hidden" name="lang" value="<?php echo htmlspecialchars($lang); ?>">  
        <input class="form-control mr-sm-2" type="search" placeholder="<?php echo $translations['search_placeholder']; ?>" aria-label="Search" name="search" id="searchInput" value="<?php echo htmlspecialchars($search_query); ?>">  
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php echo $translations['search']; ?></button>  
    </form>  

    <div class="table-responsive">  
        <table class="table table-bordered table-striped">  
            <thead class="thead-dark">  
                <tr>  
                    <th><?php echo $translations['title']; ?></th>  
                    <th class="d-none d-md-table-cell"><?php echo $translations['description']; ?></th>  
                    <th class="d-none d-md-table-cell"><?php echo $translations['author']; ?></th>  
                    <th class="d-none d-md-table-cell"><?php echo $translations['publication_date']; ?></th>  
                    <th class="d-none d-md-table-cell"><?php echo $translations['type']; ?></th>  
                    <th><?php echo $translations['actions']; ?></th>  
                </tr>  
            </thead>  
            <tbody>  
                <?php if ($result && $result->num_rows > 0): ?>  
                    <?php while ($row = $result->fetch_assoc()): ?>  
                        <tr>  
                            <td>  
                                <a href="#" data-toggle="modal" data-target="#paperModal_<?php echo $row['paper_id']; ?>">  
                                    <?php echo htmlspecialchars($row['title']); ?>  
                                </a>  
                            </td>  
                            <td class="d-none d-md-table-cell truncate"><?php echo htmlspecialchars(getFirstFiveWords($row['description'])); ?></td>  
                            <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($row['author_name']); ?></td>  
                            <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($row['publication_date']); ?></td>  
                            <td class="d-none d-md-table-cell"><?php echo htmlspecialchars(array_key_exists('type', $row) && !empty($row['type']) ? $row['type'] : 'N/A'); ?></td>  
                            <td class="icon-column">  
                                <a href="paper/<?php echo htmlspecialchars($row['pdf']); ?>" class="btn btn-success" download><i class="fas fa-download"></i> <?php echo $translations['download']; ?></a>  
                            </td>  
                        </tr>  
                    <?php endwhile; ?>  
                <?php else: ?>  
                    <tr><td colspan="6"><?php echo $translations['no_papers']; ?></td></tr>  
                <?php endif; ?>  
            </tbody>  
        </table>  
    </div>  
</div>  

<!-- Modals -->  
<?php if ($result && $result->num_rows > 0): ?>  
    <?php $result->data_seek(0); ?>  
    <?php while ($row = $result->fetch_assoc()): ?>  
        <div class="modal fade" id="paperModal_<?php echo $row['paper_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel_<?php echo $row['paper_id']; ?>" aria-hidden="true">  
            <div class="modal-dialog modal-lg" role="document">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h5 class="modal-title"><?php echo htmlspecialchars($row['title']); ?></h5>  
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $translations['modal_close']; ?>">  
                            <span aria-hidden="true">&times;</span>  
                        </button>  
                    </div>  
                    <div class="modal-body">  
                        <div class="modal-description"><?php echo htmlspecialchars($row['description']); ?></div>  
                        <p><strong><?php echo $translations['author']; ?>:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>  
                        <p><strong><?php echo $translations['publication_date']; ?>:</strong> <?php echo htmlspecialchars($row['publication_date']); ?></p>  
                        <p><strong><?php echo $translations['type']; ?>:</strong> <?php echo htmlspecialchars(array_key_exists('type', $row) && !empty($row['type']) ? $row['type'] : 'N/A'); ?></p>  
                        <a href="paper/<?php echo htmlspecialchars($row['pdf']); ?>" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i> <?php echo $translations['modal_download']; ?></a>  
                    </div>  
                </div>  
            </div>  
        </div>  
    <?php endwhile; ?>  
<?php endif; ?>  

<!-- Bootstrap and JavaScript -->  
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
</body>  
</html>