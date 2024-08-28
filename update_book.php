<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    // Collect form data
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $author_name = $_POST['author_name'];
    $isbn_number = $_POST['isbn_number'];
    $genre = $_POST['genre'];
    $cover_image = $_POST['cover_image'];
    $pdf = $_POST['pdf'];
    $publication_date = $_POST['publication_date'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];

    // Prepare UPDATE query
    $sql = "UPDATE books SET book_name=?, author_name=?, isbn_number=?, genre=?, cover_image=?, pdf=?, publication_date=?, publisher=?, description=? WHERE book_id=?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssssssssi", $book_name, $author_name, $isbn_number, $genre, $cover_image, $pdf, $publication_date, $publisher, $description, $book_id);

    // Execute statement
    if ($stmt->execute()) {
        echo "Book details updated successfully.";
    } else {
        echo "Error updating book details: " . $conn->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid request.";
}

// Close connection
$conn->close();
?>
