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
      <input type="text" placeholder="Search books..." class="w-full md:w-1/2 p-2 border border-gray-300 rounded-md shadow-sm" />
      <select class="w-full md:w-1/4 p-2 border border-gray-300 rounded-md shadow-sm">
        <option>All Genres</option>
        <option>Fiction</option>
        <option>Non-fiction</option>
        <option>Science</option>
        <option>History</option>
      </select>
    </div>

    <!-- Book Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      
      <!-- Book Card Start -->
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
        <img src="https://via.placeholder.com/300x200" alt="Cover" class="w-full h-48 object-cover rounded-t-lg">
        <div class="p-4">
          <h2 class="text-lg font-bold mb-1">Book Title</h2>
          <p class="text-gray-700 text-sm mb-1">Author: <span class="font-medium">Author Name</span></p>
          <p class="text-gray-600 text-sm mb-1">Genre: <span class="font-medium">Genre</span></p>
          <p class="text-gray-600 text-sm mb-1">ISBN: <span class="font-medium">123-4567890123</span></p>
          <p class="text-gray-500 text-xs mb-2">Published: <span class="font-medium">2024-01-01</span></p>
          <p class="text-gray-500 text-xs mb-2">Publisher: <span class="font-medium">Sample Publisher</span></p>
          <div class="mt-4 flex justify-between items-center">
            <a href="book.pdf" target="_blank" class="text-sm text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-700">Read PDF</a>
            <button onclick="openModal()" class="text-sm text-blue-600 hover:underline">Details</button>
          </div>
        </div>
      </div>
      <!-- Book Card End -->

      <!-- Repeat for other books -->

    </div>
  </section>

  <!-- Modal -->
  <div id="bookModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg max-w-md w-full shadow-lg">
      <h3 class="text-xl font-bold mb-2">Book Title</h3>
      <p class="text-gray-700 mb-2">Detailed description about the book and its contents. This could be a brief summary or key highlights of the book.</p>
      <p class="text-sm text-gray-500 mb-1">Publisher: Sample Publisher</p>
      <p class="text-sm text-gray-500 mb-1">ISBN: 123-4567890123</p>
      <p class="text-sm text-gray-500 mb-3">Published on: 2024-01-01</p>
      <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Close</button>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function openModal() {
      document.getElementById("bookModal").classList.remove("hidden");
    }
    function closeModal() {
      document.getElementById("bookModal").classList.add("hidden");
    }
  </script>

</body>
</html>
