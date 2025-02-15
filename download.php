<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php?action=login");
    exit;
}

include 'connection.php';

// Check if the file ID is provided
if (!isset($_GET['file_id'])) {
    echo "Invalid file request.";
    exit;
}

$file_id = intval($_GET['file_id']);

// Fetch file details from the database
$sql = "SELECT pdf FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $file_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $file = $result->fetch_assoc();
    $file_path = $file['pdf'];

    // Check if the file exists on the server
    if (file_exists($file_path)) {
        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        // Output the file content
        readfile($file_path);
        exit;
    } else {
        echo "The requested file does not exist.";
    }
} else {
    echo "File not found in the database.";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
