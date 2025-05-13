<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>International University Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow fixed top-0 w-full z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="text-2xl font-bold text-blue-700">University Library</div>
      <ul class="hidden md:flex space-x-6 font-medium">
        <li><a href="#" class="hover:text-blue-600">Home</a></li>
        <li><a href="#faculties" class="hover:text-blue-600">Faculties</a></li>
        <li><a href="#gallery" class="hover:text-blue-600">Gallery</a></li>
        <li><a href="#events" class="hover:text-blue-600">Events</a></li>
        <li><a href="#" onclick="toggleModal()" class="hover:text-blue-600">Login</a></li>
      </ul>
      <select class="ml-4 border px-2 py-1 rounded text-sm">
        <option>English</option>
        <option>French</option>
        <option>Arabic</option>
        <option>Pashto</option>
        <option>Dari</option>
      </select>
    </div>
  </nav>

  <!-- Slideshow / Hero -->
  <div class="mt-20">
    <div class="relative h-[400px] overflow-hidden">
      <img id="heroImage" src="https://source.unsplash.com/1600x400/?library,books" class="w-full h-full object-cover transition-all duration-500" />
      <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <h1 class="text-white text-4xl font-bold">Welcome to Our International Library</h1>
      </div>
    </div>
  </div>

  <!-- Faculties Section -->
  <section id="faculties" class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-10">Our Faculties</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <!-- 9 Faculties -->
      ${[...Array(9)].map((_, i) => `
      <div class="bg-white shadow rounded-xl p-4 text-center">
        <img src="https://source.unsplash.com/150x150/?faculty,education,${i}" class="w-full h-40 object-cover rounded-lg mb-4" />
        <h3 class="text-xl font-semibold">Faculty ${i+1}</h3>
        <p class="text-sm text-gray-600 mt-2">Details about Faculty ${i+1}.</p>
      </div>`).join('')}
    </div>
  </section>

  <!-- Book Search -->
  <section class="container mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-4">Live Book Search</h2>
    <input type="text" id="bookSearch" placeholder="Search books..." class="w-full p-2 border rounded" />
    <ul id="bookResults" class="mt-4 space-y-2 text-gray-700"></ul>
  </section>

  <!-- Featured Books Carousel -->
  <section class="bg-blue-50 py-10">
    <div class="container mx-auto px-4">
      <h2 class="text-2xl font-bold mb-6 text-center">Featured Books</h2>
      <div class="flex overflow-x-auto gap-4 scrollbar-hide">
        ${[1,2,3,4,5].map(i => `
        <div class="min-w-[200px] bg-white p-4 rounded shadow">
          <img src="https://source.unsplash.com/200x250/?book,${i}" class="mb-2 rounded" />
          <h3 class="text-lg font-semibold">Book Title ${i}</h3>
        </div>`).join('')}
      </div>
    </div>
  </section>

  <!-- Gallery -->
  <section id="gallery" class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-8">Library Gallery</h2>
    <div class="flex justify-center">
      <img id="galleryImage" src="https://source.unsplash.com/800x400/?library,1" class="w-full max-w-4xl h-64 rounded-xl object-cover shadow" />
    </div>
  </section>

  <!-- Events Section -->
  <section id="events" class="container mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-4">Upcoming Events</h2>
    <ul class="space-y-3">
      <li class="bg-white p-4 rounded shadow">
        <strong>📅 Book Fair:</strong> August 22, 2025 – Explore rare books.
      </li>
      <li class="bg-white p-4 rounded shadow">
        <strong>📖 Reading Workshop:</strong> September 5, 2025 – Improve reading skills.
      </li>
    </ul>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-10 mt-10">
    <div class="container mx-auto px-4 grid grid-cols-1 sm:grid-cols-3 gap-6">
      <div>
        <h3 class="font-semibold text-lg mb-2">About Us</h3>
        <p>We are an international university library offering digital and physical resources worldwide.</p>
      </div>
      <div>
        <h3 class="font-semibold text-lg mb-2">Quick Links</h3>
        <ul class="space-y-1">
          <li><a href="#" class="hover:underline">Home</a></li>
          <li><a href="#" class="hover:underline">Gallery</a></li>
          <li><a href="#" class="hover:underline">Faculties</a></li>
        </ul>
      </div>
      <div>
        <h3 class="font-semibold text-lg mb-2">Contact</h3>
        <p>Email: info@library.edu</p>
        <p>Phone: +93 700 123 456</p>
        <p>Address: Kabul, Afghanistan</p>
      </div>
    </div>
  </footer>

  <!-- Login Modal -->
  <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-sm relative">
      <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">✕</button>
      <h2 class="text-xl font-bold mb-4">Login</h2>
      <input type="text" placeholder="Username" class="w-full p-2 border mb-3 rounded" />
      <input type="password" placeholder="Password" class="w-full p-2 border mb-3 rounded" />
      <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Submit</button>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // Slideshow images
    const heroImages = [
      'https://source.unsplash.com/1600x400/?library,students',
      'https://source.unsplash.com/1600x400/?bookshelf',
      'https://source.unsplash.com/1600x400/?reading'
    ];
    const galleryImages = [
      'https://source.unsplash.com/800x400/?library,1',
      'https://source.unsplash.com/800x400/?library,2',
      'https://source.unsplash.com/800x400/?library,3'
    ];
    let heroIndex = 0;
    let galleryIndex = 0;

    setInterval(() => {
      heroIndex = (heroIndex + 1) % heroImages.length;
      document.getElementById('heroImage').src = heroImages[heroIndex];
    }, 5000);

    setInterval(() => {
      galleryIndex = (galleryIndex + 1) % galleryImages.length;
      document.getElementById('galleryImage').src = galleryImages[galleryIndex];
    }, 4000);

    // Book Search
    const books = ['Digital Marketing', 'Python Programming', 'Machine Learning', 'History of Libraries', 'AI in Education'];
    const bookSearch = document.getElementById('bookSearch');
    const bookResults = document.getElementById('bookResults');
    bookSearch.addEventListener('input', () => {
      const query = bookSearch.value.toLowerCase();
      bookResults.innerHTML = '';
      books.filter(b => b.toLowerCase().includes(query)).forEach(book => {
        const li = document.createElement('li');
        li.textContent = book;
        bookResults.appendChild(li);
      });
    });

    function toggleModal() {
      document.getElementById('loginModal').classList.toggle('hidden');
      document.getElementById('loginModal').classList.toggle('flex');
    }
  </script>
</body>
</html>
