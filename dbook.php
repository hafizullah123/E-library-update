<?php
// Language selection (defaults to English if not set)
$lang = 'dbooken'; // Default language
if (isset($_GET['lang']) && in_array($_GET['lang'], ['dbooken', 'dbookps', 'dbookfa'])) {
    $lang = $_GET['lang'];
}

// Load the corresponding language file
$translations = include("language/$lang.php");

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
<html lang="<?php echo ($lang == 'dbookps' || $lang == 'dbookfa') ? 'ps' : 'en'; ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $translations['header']; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Header -->
 <header class="bg-blue-800 text-white py-4 shadow-md">
  <div class="container mx-auto flex items-center justify-between px-4">
    
    <!-- Left: Translated Header Title -->
    <h1 class="text-2xl font-bold"><?php echo $translations['header']; ?></h1>
    
    <!-- Right: Papers and Logout -->
    <div class="flex items-center space-x-6">
      <a href="dpaper.php" class="text-white hover:underline">Papers</a>
      <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded">Logout</a>
    </div>
    
  </div>
</header>


  <!-- Language Selector -->
  <div class="text-center mt-4">
    <a href="?lang=dbooken" class="text-blue-600 mx-2"><?php echo $translations['english']; ?></a>
    <a href="?lang=dbookps" class="text-blue-600 mx-2"><?php echo $translations['pashto']; ?></a>
    <a href="?lang=dbookfa" class="text-blue-600 mx-2"><?php echo $translations['dari']; ?></a>
  </div>

  <!-- Search & Filter -->
  <section class="max-w-7xl mx-auto p-4">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
      <!-- Search Bar -->
      <form method="get" class="w-full md:w-1/2 flex gap-2">
        <input type="text" name="search" placeholder="<?php echo $translations['search_placeholder']; ?>" class="w-full p-2 border border-gray-300 rounded-md shadow-sm" value="<?php echo $searchQuery; ?>" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"><?php echo $translations['search_button']; ?></button>
      </form>

      <!-- Genre Filter -->
      <form method="get" class="w-full md:w-1/4 flex gap-2">
        <select name="genre" class="w-full p-2 border border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
          <option value=""><?php echo $translations['all_genres']; ?></option>
          <option value="Fiction" <?php if ($filterGenre == "Fiction") echo "selected"; ?>><?php echo $translations['genres']['fiction']; ?></option>
          <option value="Non-fiction" <?php if ($filterGenre == "Non-fiction") echo "selected"; ?>><?php echo $translations['genres']['non_fiction']; ?></option>
          <option value="Science" <?php if ($filterGenre == "Science") echo "selected"; ?>><?php echo $translations['genres']['science']; ?></option>
          <option value="History" <?php if ($filterGenre == "History") echo "selected"; ?>><?php echo $translations['genres']['history']; ?></option>
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
          $pdf = $row['pdf']; // PDF download link
          $publication_date = $row['publication_date'];
          $publisher = $row['publisher'];
          ?>

          <!-- Book Card Start -->
          <!-- Book Card Start -->
<div class="bg-white rounded-lg shadow hover:shadow-lg transition">
  <img src="<?php echo $cover_image; ?>" alt="Cover" class="w-full h-64 object-cover rounded-t-lg">
  <div class="p-4">
    <h2 class="text-lg font-bold mb-1"><?php echo $book_name; ?></h2>
    <p class="text-gray-700 text-sm mb-1"><?php echo $translations['author_name']; ?>: <span class="font-medium"><?php echo $author_name; ?></span></p>
    <p class="text-gray-600 text-sm mb-1"><?php echo $translations['genre']; ?>: <span class="font-medium"><?php echo $genre; ?></span></p>
    <p class="text-gray-600 text-sm mb-1"><?php echo $translations['isbn']; ?>: <span class="font-medium"><?php echo $isbn_number; ?></span></p>
    <p class="text-gray-500 text-xs mb-2"><?php echo $translations['published']; ?>: <span class="font-medium"><?php echo $publication_date; ?></span></p>
    <p class="text-gray-500 text-xs mb-2"><?php echo $translations['publisher']; ?>: <span class="font-medium"><?php echo $publisher; ?></span></p>
    <div class="mt-4 flex justify-between items-center">
      <!-- Download Button -->
      <a href="<?php echo $pdf; ?>" download class="text-sm text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-700"><?php echo $translations['download_button']; ?></a>
      <!-- Read Button -->
      <!-- <a href="<?php echo $pdf; ?>" target="_blank" class="text-sm text-white bg-green-600 px-3 py-1 rounded hover:bg-green-700"><?php echo $translations['read_button']; ?></a> -->
    </div>
  </div>
</div>
<!-- Book Card End -->

          <!-- Book Card End -->

          <?php
        }
      } else {
        echo "<p class='text-center col-span-4'>" . $translations['no_books'] . "</p>";
      }
      ?>

    </div>
  </section>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
