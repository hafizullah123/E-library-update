<?php
include 'connection.php';

// Get page number from request, default to 1
$page = $_GET['page'] ?? 1;

// Define number of records per page and calculate the starting record for the current page
$recordsPerPage = 10;
$startFrom = ($page - 1) * $recordsPerPage;

// Construct the SQL query for retrieving books based on search query and pagination
$searchQuery = $_GET['search'] ?? '';
$sql = "SELECT * FROM books";
if (!empty($searchQuery)) {
    $sql .= " WHERE book_name LIKE '%$searchQuery%' OR author_name LIKE '%$searchQuery%'";
}
$sql .= " LIMIT $startFrom, $recordsPerPage";
$result = $conn->query($sql);

// Generate HTML for the table
$tableHTML = '<table class="table table-bordered">';
$tableHTML .= '<thead><tr><th>Title</th><th>Description</th><th>Author</th><th>ISBN</th><th>Genre</th><th>Actions</th></tr></thead>';
$tableHTML .= '<tbody>';
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableHTML .= '<tr>';
        $tableHTML .= '<td>' . htmlspecialchars($row['book_name']) . '</td>';
        $tableHTML .= '<td>' . htmlspecialchars($row['description']) . '</td>';
        $tableHTML .= '<td>' . htmlspecialchars($row['author_name']) . '</td>';
        $tableHTML .= '<td>' . htmlspecialchars($row['isbn_number']) . '</td>';
        $tableHTML .= '<td>' . htmlspecialchars($row['genre']) . '</td>';
        $tableHTML .= '<td><button class="btn btn-info view-btn" data-book-name="' . htmlspecialchars($row['book_name']) . '">View</button></td>';
        $tableHTML .= '</tr>';
    }
} else {
    $tableHTML .= '<tr><td colspan="6">No books found.</td></tr>';
}
$tableHTML .= '</tbody></table>';

// Calculate total number of records for pagination
$totalRecords = $result->num_rows;

// Calculate total number of pages for pagination
$totalPages = ceil($totalRecords / $recordsPerPage);

// Generate HTML for pagination
$paginationHTML = '<nav><ul class="pagination">';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? ' active' : '';
    $paginationHTML .= '<li class="page-item' . $activeClass . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
}
$paginationHTML .= '</ul></nav>';

// Close database connection
$conn->close();

// Return JSON response containing table and pagination HTML
echo json_encode(array('table' => $tableHTML, 'pagination' => $paginationHTML));
?>
