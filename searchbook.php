<?php
session_start();
include 'connection.php';
header('Content-Type: application/json');

// Get the search query from the AJAX request
$search_query = $_GET['search'] ?? '';

// Construct the SQL query for retrieving books based on the search query
$sql = "SELECT * FROM books WHERE book_name LIKE ? OR isbn_number LIKE ?";
$stmt = $conn->prepare($sql);

// Bind parameters
$search_param = "%$search_query%";
$stmt->bind_param("ss", $search_param, $search_param);

// Execute statement
$stmt->execute();

// Fetch results
$result = $stmt->get_result();
$books = [];

while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

// Return results as JSON
echo json_encode($books);

// Close statement and connection
$stmt->close();
$conn->close();
?>
