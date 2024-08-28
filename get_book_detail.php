<?php
include 'connection.php';

// Get the book name from the request
$bookName = $_GET['bookName'] ?? '';

// Construct the SQL query to fetch the details of the book
$sql = "SELECT * FROM books WHERE book_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $bookName);
$stmt->execute();
$result = $stmt->get_result();

// Check if the book exists
if ($result && $result->num_rows > 0) {
    $bookDetails = $result->fetch_assoc();
    // Return the book details as JSON response
    echo json_encode($bookDetails);
} else {
    // Return an error message if the book is not found
    echo json_encode(array('error' => 'Book not found'));
}

// Close the database connection
$stmt->close();
$conn->close();
?>
