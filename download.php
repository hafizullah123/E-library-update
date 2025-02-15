<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php?action=login");
    exit;
}

// Check if the file_id parameter is provided in the URL
if (!isset($_GET['file_id']) || empty($_GET['file_id'])) {
    echo "Invalid file request. File ID is missing or empty.";
    exit;
}

// Sanitize and validate the file_id parameter
$file_id = intval($_GET['file_id']); // Convert to integer

// Include database connection
include 'connection.php';

// Query to retrieve the file details
$sql = "SELECT name, pdf FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $file_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if a file was found
if ($result->num_rows > 0) {
    // Fetch the file details
    $file = $result->fetch_assoc();
    $file_path = $file['pdf']; // Path to the file from the database

    // Check if the file exists on the server
    if (file_exists($file_path)) {
        // Send appropriate headers to initiate a file download
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
        // File does not exist on the server
        echo "The requested file does not exist on the server.";
    }
} else {
    // File ID not found in the database
    echo "File not found in the database.";
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>
