<?php
// Include database connection
include('connection.php');

// Search and filter logic
$searchQuery = "";
$filterGenre = "";

// Check if search is submitted
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Check if filter is selected
if (isset($_GET['genre'])) {
    $filterGenre = $_GET['genre'];
}

// SQL query with search and genre filter
$sql = "SELECT * FROM books WHERE (book_name LIKE '%$searchQuery%' OR isbn_number LIKE '%$searchQuery%')";

// If genre is selected, add it to the query
if (!empty($filterGenre)) {
    $sql .= " AND genre = '$filterGenre'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>eLibrary</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Header -->
  <header class="bg-blue-800 text-white py-6 shadow-md">
    <h1 class="text-3xl font-bold text-center">📚 eLibrary Catalog</h1>
  </header>

  <!-- Search & Filter -->
  <section class="max-w-7xl mx-auto p-4">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
      <!-- Search Bar -->
      <form method="get" class="w-full md:w-1/2 flex gap-2">
        <input type="text" name="search" placeholder="Search by name or ISBN..." class="w-full p-2 border border-gray-300 rounded-md shadow-sm" value="<?php echo $searchQuery; ?>" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Search</button>
      </form>

      <!-- Genre Filter -->
      <form method="get" class="w-full md:w-1/4 flex gap-2">
        <select name="genre" class="w-full p-2 border border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
          <option value="">All Genres</option>
          <option value="Fiction" <?php if ($filterGenre == "Fiction") echo "selected"; ?>>Fiction</option>
          <option value="Non-fiction" <?php if ($filterGenre == "Non-fiction") echo "selected"; ?>>Non-fiction</option>
          <option value="Science" <?php if ($filterGenre == "Science") echo "selected"; ?>>Science</option>
          <option value="History" <?php if ($filterGenre == "History") echo "selected"; ?>>History</option>
        </select>
      </form>
    </div>

    <!-- Book Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      
      <?php
      if ($result->num_rows > 0) {
        // Output data of each book
        while ($row = $result->fetch_assoc()) {
          $book_id = $row['book_id'];
          $book_name = $row['book_name'];
          $author_name = $row['author_name'];
          $isbn_number = $row['isbn_number'];
          $genre = $row['genre'];
          $cover_image = $row['cover_image'];
          $pdf = $row['pdf'];
          $publication_date = $row['publication_date'];
          $publisher = $row['publisher'];
          $description = $row['description'];
          ?>

          <!-- Book Card Start -->
          <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
            <img src="<?php echo $cover_image; ?>" alt="Cover" class="w-full h-64 object-cover rounded-t-lg">
            <div class="p-4">
              <h2 class="text-lg font-bold mb-1"><?php echo $book_name; ?></h2>
              <p class="text-gray-700 text-sm mb-1">Author: <span class="font-medium"><?php echo $author_name; ?></span></p>
              <p class="text-gray-600 text-sm mb-1">Genre: <span class="font-medium"><?php echo $genre; ?></span></p>
              <p class="text-gray-600 text-sm mb-1">ISBN: <span class="font-medium"><?php echo $isbn_number; ?></span></p>
              <p class="text-gray-500 text-xs mb-2">Published: <span class="font-medium"><?php echo $publication_date; ?></span></p>
              <p class="text-gray-500 text-xs mb-2">Publisher: <span class="font-medium"><?php echo $publisher; ?></span></p>
              <div class="mt-4 flex justify-between items-center">
                <a href="<?php echo $pdf; ?>" target="_blank" class="text-sm text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-700">Read PDF</a>
                <button onclick="openModal('<?php echo addslashes($book_name); ?>', '<?php echo addslashes($description); ?>', '<?php echo addslashes($publisher); ?>', '<?php echo $isbn_number; ?>', '<?php echo $publication_date; ?>')" class="text-sm text-blue-600 hover:underline">Details</button>
              </div>
            </div>
          </div>
          <!-- Book Card End -->

          <?php
        }
      } else {
        echo "<p class='text-center col-span-4'>No books found.</p>";
      }
      ?>

    </div>
  </section>

  <!-- Modal -->
  <div id="bookModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg max-w-md w-full shadow-lg">
      <h3 id="modalTitle" class="text-xl font-bold mb-2"></h3>
      <p id="modalDescription" class="text-gray-700 mb-2"></p>
      <p id="modalPublisher" class="text-sm text-gray-500 mb-1"></p>
      <p id="modalISBN" class="text-sm text-gray-500 mb-1"></p>
      <p id="modalPublicationDate" class="text-sm text-gray-500 mb-3"></p>
      <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Close</button>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function openModal(bookName, description, publisher, isbn, publicationDate) {
      document.getElementById("modalTitle").innerText = bookName;
      document.getElementById("modalDescription").innerText = description;
      document.getElementById("modalPublisher").innerText = "Publisher: " + publisher;
      document.getElementById("modalISBN").innerText = "ISBN: " + isbn;
      document.getElementById("modalPublicationDate").innerText = "Published on: " + publicationDate;
      document.getElementById("bookModal").classList.remove("hidden");
    }

    function closeModal() {
      document.getElementById("bookModal").classList.add("hidden");
    }
  </script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
