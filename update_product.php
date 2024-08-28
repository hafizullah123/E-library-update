<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $affiliate_link = $conn->real_escape_string($_POST['affiliate_link']);
    
    // Check if a new image is uploaded
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $target_directory = 'uploads/';
        $image_path = $target_directory . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $image_path)) {
            // Image uploaded successfully
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    // Construct the SQL update query
    $sql = "UPDATE products SET name='$name', description='$description', affiliate_link='$affiliate_link'";
    if (!empty($image_path)) {
        $sql .= ", image='$image_path'";
    }
    $sql .= " WHERE id=$id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Redirect back to the view products page
    header("Location: manage.php");
    exit();
} else {
    echo "Invalid request method.";
}
?>
