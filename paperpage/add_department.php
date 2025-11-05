<?php
include 'db.php'; // Database connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = trim($_POST['department_name']);

    if (!empty($department_name)) {
        $stmt = $conn->prepare("INSERT INTO departments (department_name) VALUES (?)");
        $stmt->bind_param("s", $department_name);

        if ($stmt->execute()) {
            $message = "<p class='text-green-600 mt-2'>✅ New department added successfully!</p>";
        } else {
            $message = "<p class='text-red-600 mt-2'>❌ Error: " . $stmt->error . "</p>";
        }
    } else {
        $message = "<p class='text-red-600 mt-2'>⚠️ Department name cannot be empty!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Add Department</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Department</h1>

  <form method="POST" class="space-y-4">
    <div>
      <label class="block text-gray-700 font-semibold mb-2">Department Name</label>
      <input type="text" name="department_name" required
        class="w-full border border-gray-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit"
      class="w-full bg-green-600 text-white p-3 rounded-xl hover:bg-green-700 transition">Save Department</button>
  </form>

  <?= $message ?>
</div>

</body>
</html>
