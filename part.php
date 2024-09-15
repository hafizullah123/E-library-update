<?php
// Connect to MySQL database
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the part name from the form
    $part_name = $_POST["part_name"];

    // Insert query to add new part
    $sql = "INSERT INTO part (part_name) VALUES ('$part_name')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center'>New part inserted successfully</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Part</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Insert New Part</h2>

    <!-- Form to Insert Part -->
    <form action="" method="POST">
        <div class="form-group">
            <label for="part_name">Part Name:</label>
            <input type="text" class="form-control" id="part_name" name="part_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Insert Part</button>
    </form>

    <!-- Display Inserted Parts -->
    <h2 class="text-center mt-5">Part Table</h2>
    <table class="table table-bordered table-striped mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Part Name</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Query to fetch data from part table
        $sql = "SELECT id, part_name FROM part";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["part_name"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='text-center'>No records found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
