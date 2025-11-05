<?php
require 'db.php';

// fetch books
$result = $conn->query("SELECT * FROM books ORDER BY book_id DESC");
$books = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Books Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-slate-50 p-6">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Books Management</h1>

      <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
          <thead class="bg-slate-100">
            <tr>
              <th class="px-4 py-2 text-left text-sm">ID</th>
              <th class="px-4 py-2 text-left text-sm">Cover</th>
              <th class="px-4 py-2 text-left text-sm">Name</th>
              <th class="px-4 py-2 text-left text-sm">Author</th>
              <th class="px-4 py-2 text-left text-sm">ISBN</th>
              <th class="px-4 py-2 text-left text-sm">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <?php foreach ($books as $b): ?>
            <tr>
              <td class="px-4 py-2"><?= $b['book_id'] ?></td>
              <td class="px-4 py-2">
                <?php 
                  $imagePath = "image/" . $b['cover_image'];
                  if (!empty($b['cover_image']) && file_exists($imagePath)): 
                ?>
                  <img
                    src="<?= $imagePath ?>"
                    class="w-12 h-16 object-cover rounded"
                    alt="Book Cover"
                  />
                <?php else: ?>
                  <div
                    class="w-12 h-16 bg-slate-200 flex items-center justify-center text-[10px] text-slate-500"
                  >
                    Book Cover
                  </div>
                <?php endif; ?>
              </td>
              <td class="px-4 py-2">
                <?= htmlspecialchars($b['book_name']) ?>
              </td>
              <td class="px-4 py-2">
                <?= htmlspecialchars($b['author_name']) ?>
              </td>
              <td class="px-4 py-2">
                <?= htmlspecialchars($b['isbn_number']) ?>
              </td>
              <td class="px-4 py-2 flex gap-2">
                <a
                  href="update_book.php?id=<?= $b['book_id'] ?>"
                  class="px-3 py-1 rounded bg-blue-600 text-white text-sm"
                >
                  Edit
                </a>
                <a
                  href="delete_book.php?id=<?= $b['book_id'] ?>"
                  class="px-3 py-1 rounded bg-red-600 text-white text-sm"
                  onclick="return confirm('Delete this book?')"
                >
                  Delete
                </a>
              </td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($books)): ?>
            <tr>
              <td colspan="6" class="px-4 py-4 text-center text-slate-500">
                No books found.
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
