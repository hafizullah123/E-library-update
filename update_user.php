<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .form-container, .search-box {
            margin: 20px 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-container input[type="text"], 
        .form-container input[type="password"],
        .form-container input[type="email"], 
        .search-box input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #888;
        }
        /* Popup CSS */
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1;
        }
        .popup-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="#home">Home</a>
    <a href="schedul.php">Schedule</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <div class="form-container">
        <form method="POST" action="">
            <input type="hidden" name="action" value="insert">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <select name="user_type" required>
                <option value="user">User</option>
                <option value="labor">Labor</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" value="Add User">
        </form>
    </div>

    <div class="search-box">
        <input type="text" id="search" placeholder="Search...">
    </div>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody id="user-table">
            <!-- Dynamic content will be added here -->
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

            // Insert data
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
                $username = $_POST['username'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $email = $_POST['email'];
                $user_type = $_POST['user_type'];

                $sql = "INSERT INTO users (username, password, email, user_type) 
                        VALUES ('$username', '$password', '$email', '$user_type')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Update data
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
                $user_id = $_POST['user_id'];
                $username = $_POST['username'];
                $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
                $email = $_POST['email'];
                $user_type = $_POST['user_type'];

                $sql = "UPDATE users SET username='$username', email='$email', user_type='$user_type'";
                if ($password) {
                    $sql .= ", password='$password'";
                }
                $sql .= " WHERE user_id='$user_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Fetch data to display
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["user_id"]) . "</td>
                            <td class='edit-username'>" . htmlspecialchars($row["username"]) . "</td>
                            <td>" . htmlspecialchars($row["email"]) . "</td>
                            <td>" . htmlspecialchars($row["user_type"]) . "</td>
                            <td><button class='edit-btn' data-id='" . $row["user_id"] . "'>Edit</button></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-records'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Popup HTML -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <form id="update-form" method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="user_id" id="popup-user-id">
            <input type="text" name="username" id="popup-username" placeholder="Username" required>
            <input type="password" name="password" id="popup-password" placeholder="Password">
            <input type="email" name="email" id="popup-email" placeholder="Email" required>
            <select name="user_type" id="popup-user-type" required>
                <option value="user">User</option>
                <option value="labor">Labor</option>
                <option value="admin">Admin</option>
            </select>
            <div>
                <input type="submit" value="Update User">
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('search').addEventListener('input', function() {
    const searchTerm = this.value.trim();

    fetch(`search_users.php?term=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('user-table');
            tableBody.innerHTML = '';

            if (data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" class="no-records">No records found</td></tr>';
            } else {
                data.forEach(user => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${user.user_id}</td>
                        <td class="edit-username">${user.username}</td>
                        <td>${user.email}</td>
                        <td>${user.user_type}</td>
                        <td><button class="edit-btn" data-id="${user.user_id}">Edit</button></td>
                    `;

                    tableBody.appendChild(row);
                });

                // Attach event listeners to newly added edit buttons
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const row = button.closest('tr');
                        const user_id = button.getAttribute('data-id');
                        const username = row.querySelector('.edit-username').textContent;
                        const email = row.children[2].textContent;
                        const user_type = row.children[3].textContent;

                        document.getElementById('popup-user-id').value = user_id;
                        document.getElementById('popup-username').value = username;
                        document.getElementById('popup-email').value = email;
                        document.getElementById('popup-user-type').value = user_type;

                        document.getElementById('popup').style.display = 'block';
                    });
                });
            }
        })
        .catch(error => console.error('Error fetching data:', error));
});

// Get the popup
const popup = document.getElementById('popup');

// Get the <span> element that closes the popup
const popupCloseBtn = document.querySelector('.popup .close');

// Close the popup when the close button is clicked
popupCloseBtn.addEventListener('click', function() {
    popup.style.display = 'none';
});

// Close the popup when clicking outside of it
window.addEventListener('click', function(event) {
    if (event.target === popup) {
        popup.style.display = 'none';
    }
});

// Attach event listeners to existing edit buttons
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const row = button.closest('tr');
        const user_id = button.getAttribute('data-id');
        const username = row.querySelector('.edit-username').textContent;
        const email = row.children[2].textContent;
        const user_type = row.children[3].textContent;

        document.getElementById('popup-user-id').value = user_id;
        document.getElementById('popup-username').value = username;
        document.getElementById('popup-email').value = email;
        document.getElementById('popup-user-type').value = user_type;

        popup.style.display = 'block';
    });
});
</script>

</body>
</html>
