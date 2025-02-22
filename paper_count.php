<?php  
// Database connection  
$host = 'localhost';  
$username = 'root';  
$password = ''; // Update with your actual DB password  
$dbname = 'library';  

$conn = new mysqli($host, $username, $password, $dbname);  

if ($conn->connect_error) {  
    exit("Connection failed: " . $conn->connect_error);  
}  

// Set language selection with session  
session_start();  
if (isset($_GET['lang'])) {  
    $_SESSION['lang'] = $_GET['lang'];  
}  
$lang = $_SESSION['lang'] ?? 'en';  

// Localization data  
$langData = [  
    'en' => [  
        'title' => 'The library Reaserch Count',  
        'home' => 'Home',  
        'language' => 'Language',  
        'type' => 'Type',  
        'section' => 'Departmnet',  
        'count' => 'Count',  
    ],  
    'ps' => [  
        'title' => ' د ترسره شویو څېړنو تعداد ',  
        'home' => 'کور',  
        'language' => 'ژبه',  
        'type' => 'ډول',  
        'section' => 'ډیپارتمنټ',  
        'count' => 'ګڼه',  
    ],  
    'fa' => [  
        'title' => 'تعداد تحقیق انجام شده',  
        'home' => 'خانه',  
        'language' => 'زبان',  
        'type' => 'نوع',  
        'section' => 'دیپارتمنت',  
        'count' => 'شمارش',  
    ],  
];  

// Fetch genre data  
$sql = "SELECT type, COUNT(*) AS type_count FROM research_papers GROUP BY type";  
$result = $conn->query($sql);  
$genres = [];  

if ($result->num_rows > 0) {  
    while ($row = $result->fetch_assoc()) {  
        $genres[] = $row;  
    }  
}  

// Fetch count of research papers grouped by type and section  
$sql = "SELECT type, section, COUNT(*) AS paper_count FROM research_papers GROUP BY type, section ORDER BY paper_count DESC";  
$result = $conn->query($sql);  
$papers = [];  

if ($result->num_rows > 0) {  
    while ($row = $result->fetch_assoc()) {  
        $papers[] = $row;  
    }  
}  

$conn->close();  
?>  

<!DOCTYPE html>  
<html lang="<?= htmlspecialchars($lang) ?>">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title><?= htmlspecialchars($langData[$lang]['title']) ?></title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">  
    <style>  
        .genre-box {  
            border: 1px solid #ddd;  
            border-radius: 8px;  
            padding: 20px;  
            margin-bottom: 20px;  
            text-align: center;  
            background-color: #f8f9fa;  
        }  
        .genre-icon {  
            font-size: 40px;  
            margin-bottom: 10px;  
        }  
        .genre-count {  
            font-size: 24px;  
            font-weight: bold;  
        }  
        .genre-name {  
            font-size: 18px;  
        }  
        .table-container {  
            margin: 50px auto;  
            max-width: 800px;  
        }  
    </style>  
</head>  
<body>  

<!-- Navbar with Home and Language Options -->  
<nav class="navbar navbar-expand-lg navbar-light bg-light">  
    <div class="container-fluid">  
        <a class="navbar-brand" href="#"><?= htmlspecialchars($langData[$lang]['title']) ?></a>  
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">  
            <span class="navbar-toggler-icon"></span>  
        </button>  
        <div class="collapse navbar-collapse" id="navbarNav">  
            <ul class="navbar-nav">  
                <li class="nav-item"><a class="nav-link" href="#"><?= htmlspecialchars($langData[$lang]['home']) ?></a></li>  
                <li class="nav-item"><a class="nav-link" href="?lang=en">English</a></li>  
                <li class="nav-item"><a class="nav-link" href="?lang=ps">Pashto</a></li>  
                <li class="nav-item"><a class="nav-link" href="?lang=fa">Dari</a></li>  
            </ul>  
        </div>  
    </div>  
</nav>  

<div class="container mt-5">  
    <div class="row">  
        <?php if (empty($genres)): ?>  
            <div class="col-md-12"><p class="text-center">No genres found.</p></div>  
        <?php else: ?>  
            <?php foreach ($genres as $genre): ?>  
                <div class="col-md-4">  
                    <div class="genre-box">  
                        <i class="bi bi-book genre-icon"></i>  
                        <div class="genre-count"><?= htmlspecialchars($genre['type_count']) ?></div>  
                        <div class="genre-name"><?= htmlspecialchars($genre['type']) ?></div>  
                    </div>  
                </div>  
            <?php endforeach; ?>  
        <?php endif; ?>  
    </div>  
</div>  

<div class="container table-container">  
    <h2 class="text-center mb-4"><?= htmlspecialchars($langData[$lang]['title']) ?></h2>  
    <table class="table table-bordered table-striped text-center">  
        <thead class="table-dark">  
            <tr>  
                <th><?= htmlspecialchars($langData[$lang]['type']) ?></th>  
                <th><?= htmlspecialchars($langData[$lang]['section']) ?></th>  
                <th><?= htmlspecialchars($langData[$lang]['count']) ?></th>  
            </tr>  
        </thead>  
        <tbody>  
            <?php if (empty($papers)): ?>  
                <tr><td colspan="3">No papers found.</td></tr>  
            <?php else: ?>  
                <?php foreach ($papers as $paper): ?>  
                    <tr>  
                        <td><?= htmlspecialchars($paper['type']) ?></td>  
                        <td><?= htmlspecialchars($paper['section']) ?></td>  
                        <td><?= htmlspecialchars($paper['paper_count']) ?></td>  
                    </tr>  
                <?php endforeach; ?>  
            <?php endif; ?>  
        </tbody>  
    </table>  
</div>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>  
</body>  
</html>