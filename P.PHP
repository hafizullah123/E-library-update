<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>International Journal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Include Font Awesome for social media icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-900">

  <!-- Header -->
  <header class="bg-white shadow-md py-4">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
      <a href="#" class="text-3xl font-semibold text-blue-600">Intl Journal</a>
      <nav class="space-x-6">
        <a href="#" class="text-lg text-gray-800 hover:text-blue-600">Home</a>
        <a href="#" class="text-lg text-gray-800 hover:text-blue-600">About</a>
        <a href="#" class="text-lg text-gray-800 hover:text-blue-600">Archives</a>
        <a href="#" class="text-lg text-gray-800 hover:text-blue-600">Contact</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="py-12">
    <div class="max-w-7xl mx-auto px-6">
      
      <!-- Language and Sort/Filter Section -->
      <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
          <!-- Language Dropdown -->
          <select id="language-select" class="p-2 border border-gray-300 rounded-md">
            <option value="en">English</option>
            <option value="es">Spanish</option>
            <option value="fr">French</option>
            <option value="de">German</option>
          </select>

          <!-- Sort Dropdown -->
          <select id="sort" class="p-2 border border-gray-300 rounded-md">
            <option value="date">Sort by Date</option>
            <option value="type">Sort by Type</option>
          </select>
          
          <!-- Search Bar -->
          <input type="text" id="search" class="w-1/3 p-2 border border-gray-300 rounded-md" placeholder="Search articles...">
          
          <!-- Filter Dropdown -->
          <select id="filter" class="p-2 border border-gray-300 rounded-md">
            <option value="">All Categories</option>
            <option value="ai">Artificial Intelligence</option>
            <option value="health">Health</option>
            <option value="climate">Climate Change</option>
          </select>
        </div>
      </section>

      <!-- Articles List -->
      <section id="article-list">
        <div class="space-y-6">
          <!-- Article 1 -->
          <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900">Advancements in AI</h3>
            <p class="text-gray-600 text-sm mt-2">Exploring the latest developments in artificial intelligence and its impact on industries worldwide.</p>
            <div class="flex justify-between items-center mt-4">
              <span class="text-gray-500 text-sm">Author: <span class="font-medium">Dr. Alice Smith</span></span>
              <span class="text-gray-500 text-sm">Type: <span class="font-medium">Research</span></span>
            </div>
            <div class="flex justify-between items-center mt-2">
              <span class="text-gray-500 text-sm">Date: <span class="font-medium">March 12, 2025</span></span>
              <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Download PDF</a>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm mt-2 block">Read Article</a>

            <!-- Social Media Share Icons -->
            <div class="flex space-x-4 mt-4">
              <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook-square text-xl"></i></a>
              <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter-square text-xl"></i></a>
              <a href="#" class="text-blue-800 hover:text-blue-900"><i class="fab fa-linkedin text-xl"></i></a>
              <a href="#" class="text-green-500 hover:text-green-600"><i class="fab fa-whatsapp text-xl"></i></a>
            </div>
          </div>

          <!-- Article 2 -->
          <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900">Global Health Challenges</h3>
            <p class="text-gray-600 text-sm mt-2">An in-depth look into the global health challenges that countries are facing in the 21st century.</p>
            <div class="flex justify-between items-center mt-4">
              <span class="text-gray-500 text-sm">Author: <span class="font-medium">Dr. Emily Green</span></span>
              <span class="text-gray-500 text-sm">Type: <span class="font-medium">Review</span></span>
            </div>
            <div class="flex justify-between items-center mt-2">
              <span class="text-gray-500 text-sm">Date: <span class="font-medium">February 25, 2025</span></span>
              <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Download PDF</a>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm mt-2 block">Read Article</a>

            <!-- Social Media Share Icons -->
            <div class="flex space-x-4 mt-4">
              <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook-square text-xl"></i></a>
              <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter-square text-xl"></i></a>
              <a href="#" class="text-blue-800 hover:text-blue-900"><i class="fab fa-linkedin text-xl"></i></a>
              <a href="#" class="text-green-500 hover:text-green-600"><i class="fab fa-whatsapp text-xl"></i></a>
            </div>
          </div>

          <!-- Article 3 -->
          <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900">Climate Change and Policy</h3>
            <p class="text-gray-600 text-sm mt-2">Analyzing the impact of climate change and the policies being implemented around the world to combat it.</p>
            <div class="flex justify-between items-center mt-4">
              <span class="text-gray-500 text-sm">Author: <span class="font-medium">Dr. Michael Brown</span></span>
              <span class="text-gray-500 text-sm">Type: <span class="font-medium">Policy</span></span>
            </div>
            <div class="flex justify-between items-center mt-2">
              <span class="text-gray-500 text-sm">Date: <span class="font-medium">January 10, 2025</span></span>
              <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Download PDF</a>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm mt-2 block">Read Article</a>

            <!-- Social Media Share Icons -->
            <div class="flex space-x-4 mt-4">
              <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook-square text-xl"></i></a>
              <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter-square text-xl"></i></a>
              <a href="#" class="text-blue-800 hover:text-blue-900"><i class="fab fa-linkedin text-xl"></i></a>
              <a href="#" class="text-green-500 hover:text-green-600"><i class="fab fa-whatsapp text-xl"></i></a>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
          <button class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Previous</button>
          <span class="px-4 py-2">Page 1 of 10</span>
          <button class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Next</button>
        </div>
      </section>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-6 flex justify-between">
      <div>
        <h4 class="text-2xl font-semibold">Intl Journal</h4>
        <p class="text-gray-400 text-sm mt-2">A place for global research, innovation, and collaboration.</p>
      </div>
      <div class="space-x-6">
        <a href="#" class="text-gray-300 hover:text-white">Privacy Policy</a>
        <a href="#" class="text-gray-300 hover:text-white">Terms of Service</a>
        <a href="#" class="text-gray-300 hover:text-white">Contact Us</a>
      </div>
    </div>
  </footer>

  <!-- Scripts for Search and Filter -->
  <script>
    // Search functionality
    document.getElementById('search').addEventListener('input', function() {
      let searchTerm = this.value.toLowerCase();
      let articles = document.querySelectorAll('#article-list .bg-white');
      articles.forEach(function(article) {
        let title = article.querySelector('h3').innerText.toLowerCase();
        let description = article.querySelector('p').innerText.toLowerCase();
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
          article.style.display = 'block';
        } else {
          article.style.display = 'none';
        }
      });
    });

    // Filter functionality
    document.getElementById('filter').addEventListener('change', function() {
      let category = this.value;
      let articles = document.querySelectorAll('#article-list .bg-white');
      articles.forEach(function(article) {
        let title = article.querySelector('h3').innerText.toLowerCase();
        if (category === '' || title.includes(category)) {
          article.style.display = 'block';
        } else {
          article.style.display = 'none';
        }
      });
    });

    // Language selection functionality
    document.getElementById('language-select').addEventListener('change', function() {
      alert('Language selected: ' + this.value);
    });

    // Sort functionality
    document.getElementById('sort').addEventListener('change', function() {
      alert('Articles sorted by: ' + this.value);
    });
  </script>

</body>
</html>
