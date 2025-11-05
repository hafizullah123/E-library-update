<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$book_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id=?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    die("Book not found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Book</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
  <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Update Book</h2>
    <form action="update_book_action.php" method="POST" class="space-y-4">
      <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">

      <div>
        <label class="block text-sm font-medium">Book Name</label>
        <input type="text" name="book_name" value="<?= htmlspecialchars($book['book_name']) ?>" required class="w-full border rounded p-2">
      </div>

      <div>
        <label class="block text-sm font-medium">Author Name</label>
        <input type="text" name="author_name" value="<?= htmlspecialchars($book['author_name']) ?>" class="w-full border rounded p-2">
      </div>

      <div>
        <label class="block text-sm font-medium">ISBN Number</label>
        <input type="text" name="isbn_number" value="<?= htmlspecialchars($book['isbn_number']) ?>" class="w-full border rounded p-2">
      </div>

      <div>
        <label class="block text-sm font-medium">Genre</label>
        <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" class="w-full border rounded p-2">
      </div>

      <div>
        <label class="block text-sm font-medium">Publisher</label>
        <input type="text" name="publisher" value="<?= htmlspecialchars($book['publisher']) ?>" class="w-full border rounded p-2">
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
      <a href="books_list.php" class="ml-2 text-gray-600">Cancel</a>
    </form>
  </div>
</body>
</html>
