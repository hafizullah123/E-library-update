<?php
// session_start();

// // Generate a unique session identifier if it doesn't exist
// if (!isset($_SESSION['session_id'])) {
//     $_SESSION['session_id'] = uniqid();
// }

// // Set a cookie with the session id
// setcookie('session_id', $_SESSION['session_id'], time() + (86400 * 30), "/"); // 86400 = 1 day

// // Check if the session identifier in the browser matches the one stored in the session
// if (isset($_COOKIE['session_id']) && $_COOKIE['session_id'] !== $_SESSION['session_id']) {
//     // If not, invalidate the session
//     session_unset();
//     session_destroy();
//     // Redirect the user to the login page or any other appropriate action
//     header("Location: login.php");
//     exit();
// }

include 'connection.php'; // Include your database connection file

// Rest of your PHP code goes here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .Register {
            text-align: center;
        }

        .Register1 {
            background-color: rgb(77, 130, 156);
        }

        .Register1:hover {
            background-color: rgb(10, 80, 100);
            color: white;
        }

        .navbar {
            background-color: rgb(77, 130, 156);
            color: white;
            padding: 10px 20px;
        }
        .navbar a{
            color:white;
        }
        .dropdown-menu a{
            color:black;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(10, 80, 100);
            padding-top: 80px; /* Adjusted padding-top */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .sidebar a {
            padding: 15px;
            font-size: 14px; /* Smaller font size */
            text-decoration: none;
            color: white;
            display: block;
            
        }

        .sidebar a:hover {
            background-color: rgb(77, 130, 156);
        }

        .dropdown-container {
            display: none;
            padding-left: 10px;
        }

        .dropdown-btn {
            cursor: pointer;
            display: block;
            padding: 15px;
            text-decoration: none;
            font-size: 14px;
            color: white;
            background: none;
            border: none;
            text-align: left;
            outline: none;
        }

        .main {
            margin-left: 200px;
            height: 100%; /* Make main container take full height */
            display: flex;
            flex-direction: column;
            margin-top:60px;
           
            
        }

        .iframe-container {
            flex: 1; /* Allow iframe-container to take all available space */
            overflow: hidden; /* Hide overflow to avoid extra scrolls */
        }

        iframe {
            height: 90%;
            width: 100%;
            border: none;
            outline: none;
        }

        .input-icon {
            position: relative;
        }

        .input-icon > input,
        .input-icon > textarea {
            padding-left: 2.5rem;
        }

        .input-icon > .fa {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .file-input-wrapper .input-group-text {
            background-color: white;
            border-right: 0;
        }

        .file-input-wrapper .custom-file {
            border-left: 0;
        }

        .file-input-wrapper .custom-file-input:focus ~ .custom-file-label {
            border-color: #ced4da;
            box-shadow: none;
        }

        .dropdown-btn i {
            font-size: 12px; /* Smaller icon size */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">digital library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> labor
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" >Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

 
<div class="sidebar">
    <!-- <button class="dropdown-btn"><i class="fas fa-headphones"></i> Computer
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="view.php" target="content"><i class="fas fa-eye"></i> View</a>
        <a href="add_book.php" target="content"><i class="fas fa-clipboard"></i> Register</a>
        <a href="update.php.php" target="content"><i class="fas fa-edit"></i> Manage</a>
    </div> -->
    <button class="dropdown-btn"><i class="fas "></i> Books
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="view.php" target="content"><i class="fas fa-eye"></i> View</a>
        <a href="add_book.php" target="content"><i class="fas fa-clipboard"></i> Register</a>
        <a href="update.php" target="content"><i class="fas fa-edit"></i> Manage</a>
    </div>
    <button class="dropdown-btn"><i class="fas"></i> Research _ paper
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="view1.php" target="content"><i class="fas fa-eye"></i> View</a>
        <a href="add_paper.php" target="content"><i class="fas fa-clipboard"></i> Register</a>
        <a href="update1.php" target="content"><i class="fas fa-edit"></i> Manage</a>
    </div>
</div>

<div class="main">
    <div class="iframe-container">
        <iframe name="content"></iframe>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Show the file name when a file is selected
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    // Toggle dropdown menus
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
</body>
</html>
