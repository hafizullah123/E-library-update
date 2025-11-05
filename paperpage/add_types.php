<?php
include 'db.php'; // Database connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type_name = trim($_POST['type_name']);

    if (!empty($type_name)) {
        $stmt = $conn->prepare("INSERT INTO types (type_name) VALUES (?)");
        $stmt->bind_param("s", $type_name);

        if ($stmt->execute()) {
            $message = "<p class='text-green-600 mt-2'>✅ New type added successfully!</p>";
        } else {
            $message = "<p class='text-red-600 mt-2'>❌ Error: " . $stmt->error . "</p>";
        }
    } else {
        $message = "<p class='text-red-600 mt-2'>⚠️ Type name cannot be empty!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Add Type</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Type</h1>

  <form method="POST" class="space-y-4">
    <div>
      <label class="block text-gray-700 font-semibold mb-2">Type Name</label>
      <input type="text" name="type_name" required
        class="w-full border border-gray-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit"
      class="w-full bg-blue-600 text-white p-3 rounded-xl hover:bg-blue-700 transition">Save Type</button>
  </form>

  <?= $message ?>
</div>

</body>
</html>
