<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id     = intval($_POST['book_id']);
    $book_name   = $_POST['book_name'];
    $author_name = $_POST['author_name'];
    $isbn_number = $_POST['isbn_number'];
    $genre       = $_POST['genre'];
    $publisher   = $_POST['publisher'];

    $sql  = "UPDATE books SET book_name=?, author_name=?, isbn_number=?, genre=?, publisher=? WHERE book_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $book_name, $author_name, $isbn_number, $genre, $publisher, $book_id);

    if ($stmt->execute()) {
        header("Location: books_list.php?msg=Book+updated+successfully");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
