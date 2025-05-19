<?php
session_start(); // Add this at the very top

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
  <style>
    body { min-height: 2000px; }
  </style>
</head>
<body class="bg-gray-100<?php echo ($lang == 'dbookps' || $lang == 'dbookfa') ? ' font-[Tahoma]' : ''; ?>" <?php echo ($lang == 'dbookps' || $lang == 'dbookfa') ? 'dir="rtl"' : ''; ?>>

  <!-- Header -->
  <header class="bg-blue-800 text-white py-4 shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex items-center justify-between px-4">
      <!-- Left: Translated Header Title -->
      <h1 class="text-2xl font-bold"><?php echo $translations['header']; ?></h1>
      <!-- Right: Papers and Logout -->
      <div class="flex items-center space-x-6<?php echo ($lang == 'dbookps' || $lang == 'dbookfa') ? ' flex-row-reverse space-x-reverse' : ''; ?>">
        <a href="dpaper.php" class="text-white hover:underline"><?php echo isset($translations['papers']) ? $translations['papers'] : 'Papers'; ?></a>
        <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded"><?php echo isset($translations['logout']) ? $translations['logout'] : 'Logout'; ?></a>
      </div>
    </div>
  </header>

  <!-- Language Selector -->
  <div class="text-center mt-4">
    <a href="?lang=dbooken" class="text-blue-600 mx-2<?php echo $lang == 'dbooken' ? ' font-bold underline' : ''; ?>"><?php echo $translations['english']; ?></a>
    <a href="?lang=dbookps" class="text-blue-600 mx-2<?php echo $lang == 'dbookps' ? ' font-bold underline' : ''; ?>"><?php echo $translations['pashto']; ?></a>
    <a href="?lang=dbookfa" class="text-blue-600 mx-2<?php echo $lang == 'dbookfa' ? ' font-bold underline' : ''; ?>"><?php echo $translations['dari']; ?></a>
  </div>

  <!-- Search & Filter -->
  <section class="max-w-7xl mx-auto p-4">
    <form method="get" class="flex flex-col md:flex-row gap-2 mb-6">
      <input type="hidden" name="lang" value="<?php echo htmlspecialchars($lang); ?>">
      <!-- Search Input -->
      <input
        type="text"
        name="search"
        placeholder="<?php echo $translations['search_placeholder']; ?>"
        class="flex-1 p-2 border border-gray-300 rounded-md shadow-sm"
        value="<?php echo htmlspecialchars($searchQuery); ?>"
      />
      <!-- Department/Genre Filter -->
      <select
        name="genre"
        class="w-full md:w-48 p-2 border border-gray-300 rounded-md shadow-sm"
        onchange="this.form.submit()"
      >
        <option value=""><?php echo $translations['all_genres']; ?></option>
        <?php
          // List of all genre keys you support in your DB and language files
          $genre_keys = [
            'physical_education',
            'computer',
            'english',
            'psychology',
            'biology',
            'mathematics',
            'pashto_language_and_literature',
            'dari_language_and_literature',
            'arabic_language_and_literature',
            'turkish_language',
            'russian_language',
            'islamic_sciences',
            'history_sciences',
            'sociology_sciences',
            'geography_sciences',
            'physics',
            'environmental_science',
            'educational_management',
            'motivational_books',
            'chemistry'
            // Add more keys as needed
          ];
          foreach ($genre_keys as $key) {
            $selected = ($filterGenre == $key) ? 'selected' : '';
            $label = isset($translations['genres'][$key]) ? $translations['genres'][$key] : ucfirst(str_replace('_', ' ', $key));
            echo "<option value=\"$key\" $selected>$label</option>";
          }
        ?>
      </select>
      <!-- Search Button -->
      <button
        type="submit"
        class="w-full md:w-auto bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
      >
        <?php echo $translations['search_button']; ?>
      </button>
    </form>
  </section>

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
        $type = isset($row['type']) ? $row['type'] : '';
        $type_key = strtolower($type);
    ?>
    <!-- Book Card Start -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition flex flex-col overflow-hidden border border-gray-100">
      <img src="<?php echo htmlspecialchars($cover_image); ?>" alt="Cover"
           class="w-11/12 mx-auto h-64 sm:h-72 object-contain bg-white rounded-t-xl mt-4 mb-2 transition-all duration-300" />
      <div class="p-4 flex-1 flex flex-col">
        <h2 class="text-lg font-bold mb-2 text-blue-800 break-words leading-snug">
          <?php echo htmlspecialchars($book_name); ?>
        </h2>
        <p class="text-gray-700 text-sm mb-1">
          <span class="font-semibold"><?php echo $translations['author_name']; ?>:</span>
          <span class="font-medium"><?php echo htmlspecialchars($author_name); ?></span>
        </p>
        <p class="text-gray-600 text-sm mb-1">
          <span class="font-semibold"><?php echo $translations['genre']; ?>:</span>
          <span class="font-medium">
            <?php
              $genre_key = strtolower(str_replace('-', '_', $genre));
              echo isset($translations['genres'][$genre_key]) ? $translations['genres'][$genre_key] : htmlspecialchars($genre);
            ?>
          </span>
        </p>
        <p class="text-gray-600 text-sm mb-1">
          <span class="font-semibold"><?php echo $translations['isbn']; ?>:</span>
          <span class="font-medium"><?php echo htmlspecialchars($isbn_number); ?></span>
        </p>
        <p class="text-gray-500 text-xs mb-1">
          <span class="font-semibold"><?php echo $translations['published']; ?>:</span>
          <span class="font-medium"><?php echo htmlspecialchars($publication_date); ?></span>
        </p>
        <p class="text-gray-500 text-xs mb-2">
          <span class="font-semibold"><?php echo $translations['publisher']; ?>:</span>
          <span class="font-medium"><?php echo htmlspecialchars($publisher); ?></span>
        </p>
        <div class="mt-auto flex flex-col gap-2 sm:flex-row sm:justify-between items-stretch">
          <a href="<?php echo htmlspecialchars($pdf); ?>" download
             class="text-sm text-white bg-blue-600 px-4 py-2 rounded-md hover:bg-blue-700 text-center transition">
             <?php echo $translations['download_button']; ?>
          </a>
          <!-- Uncomment for read button
          <a href="<?php echo htmlspecialchars($pdf); ?>" target="_blank"
             class="text-sm text-white bg-green-600 px-4 py-2 rounded-md hover:bg-green-700 text-center transition">
             <?php echo $translations['read_button']; ?>
          </a>
          -->
        </div>
      </div>
    </div>
    <!-- Book Card End -->
    <?php
      }
    } else {
      echo "<p class='text-center col-span-4'>" . $translations['no_books'] . "</p>";
    }
    ?>
  </div>
</section>

<!-- Scroll to Top Button -->
<button id="scrollToTopBtn" title="Go to top"
    class="hidden fixed bottom-6 right-6 z-50 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 shadow-lg transition">
    <!-- Up arrow icon (Heroicons) -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>
<script>
    // Show button when scrolled down
    const btn = document.getElementById('scrollToTopBtn');
    window.onscroll = function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    };
    // Scroll to top on click
    btn.onclick = function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };
</script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
