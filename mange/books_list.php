<?php
session_start();
include 'db.php'; // Make sure this connects to your DB

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle search
$search_query = '';
$sql = "SELECT * FROM books";
if (!empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql .= " WHERE book_name LIKE '%$search_query%' OR isbn_number LIKE '%$search_query%'";
}
$result = $conn->query($sql);

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM books WHERE book_id=$delete_id");
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Books Management</h1>

        <!-- Search -->
        <form method="get" class="flex mb-4 gap-2">
            <input type="text" name="search" value="<?= htmlspecialchars($search_query) ?>"
                   placeholder="Search by Name or ISBN"
                   class="border p-2 rounded flex-1">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        </form>

        <!-- Books Table -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Cover</th>
                        <th class="px-4 py-2 text-left">Book Name</th>
                        <th class="px-4 py-2 text-left">Author</th>
                        <th class="px-4 py-2 text-left">ISBN</th>
                        <th class="px-4 py-2 text-left">Genre</th>
                        <th class="px-4 py-2 text-left">Publisher</th>
                        <th class="px-4 py-2 text-left">Publication Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- Cover Image -->
                                <td class="px-4 py-2">
                                    <?php if (!empty($row['cover_image']) && file_exists($row['cover_image'])): ?>
                                        <img src="<?= htmlspecialchars($row['cover_image']); ?>" 
                                             alt="Cover" class="w-20 h-24 object-cover rounded">
                                    <?php else: ?>
                                        <span class="text-gray-500 text-sm">No</span>
                                    <?php endif; ?>
                                </td>
                                <!-- Book Info -->
                                <td class="px-4 py-2"><?= htmlspecialchars($row['book_name']); ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($row['author_name']); ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($row['isbn_number']); ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($row['genre']); ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($row['publisher']); ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($row['publication_date']); ?></td>
                                <!-- Actions -->
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="update_book.php?id=<?= $row['book_id']; ?>" 
                                       class="px-3 py-1 bg-yellow-500 text-white rounded text-sm">Edit</a>
                                    <a href="?delete_id=<?= $row['book_id']; ?>" 
                                       onclick="return confirm('Are you sure to delete this book?')"
                                       class="px-3 py-1 bg-red-600 text-white rounded text-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">No books found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
