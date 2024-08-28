<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['term'])) {
    $searchTerm = $conn->real_escape_string($_GET['term']);

    $sql = "SELECT * FROM book WHERE name LIKE '%$searchTerm%' OR number LIKE '%$searchTerm%' OR part LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    $books = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    echo json_encode($books);
}

$conn->close();
?>
