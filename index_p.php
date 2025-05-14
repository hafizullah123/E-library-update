<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>International University E-Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
<header class="bg-blue-800 text-white shadow">
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center">
      <!-- Website Title -->
      <h1 class="text-2xl font-bold">International University E-Library</h1>

      <!-- Mobile Menu Toggle Button -->
      <div class="md:hidden">
        <button id="menu-toggle" class="text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <!-- Desktop Menu Links -->
      <nav class="hidden md:flex space-x-4">
        <a href="#" class="hover:text-yellow-300">Home</a>
        <a href="#services" class="hover:text-yellow-300">Services</a>
        <a href="#books" class="hover:text-yellow-300">Books</a>
        <a href="#contact" class="hover:text-yellow-300">Contact</a>
      </nav>
    </div>

    <!-- Mobile Menu Links (Hidden by default, shown when toggled) -->
    <nav id="mobile-menu" class="hidden md:hidden flex-col mt-4 space-y-2">
      <a href="#" class="hover:text-yellow-300">Home</a>
      <a href="#services" class="hover:text-yellow-300">Services</a>
      <a href="#books" class="hover:text-yellow-300">Books</a>
      <a href="#contact" class="hover:text-yellow-300">Contact</a>
    </nav>
  </div>
</header>

<!-- JavaScript for Menu Toggle -->
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  menuToggle.addEventListener('click', () => {
    // Toggle visibility of the mobile menu
    mobileMenu.classList.toggle('hidden');
  });
</script>



  <!-- Hero Section -->
  <section class="bg-white py-16 shadow">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold mb-4">Welcome to the Digital Library</h2>
      <p class="text-lg text-gray-700">Access thousands of academic resources, journals, and e-books anytime, anywhere.</p>
      <a href="#books" class="mt-6 inline-block bg-blue-700 hover:bg-blue-900 text-white font-semibold py-2 px-4 rounded">Explore Books</a>
    </div>
  </section>
<<!-- Slideshow Section -->
<section id="slideshow" class="py-16 bg-white">
  <div class="container mx-auto text-center">
    <h3 class="text-3xl font-bold mb-8">Slideshow</h3>

    <div class="relative w-full max-w-2xl mx-auto overflow-hidden rounded shadow-lg">
      <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
        <img src="image/b.jpg" class="w-full flex-shrink-0" />
        <img src="image/b1.jpg" class="w-full flex-shrink-0" />
        <img src="image/b2.jpg" class="w-full flex-shrink-0" />
        <img src="image/ba3.jpg" class="w-full flex-shrink-0" />
      </div>
    </div>
  </div>
</section>

<script>
  const carousel = document.getElementById("carousel");
  const totalSlides = carousel.children.length;
  let currentSlide = 0;

  setInterval(() => {
    currentSlide = (currentSlide + 1) % totalSlides;
    carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
  }, 3000); // Change slide every 3 seconds
</script>


  <!-- Services Section -->
  <section id="services" class="py-16 bg-gray-50">
    <div class="container mx-auto text-center">
      <h3 class="text-3xl font-bold mb-12">Our Services</h3>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded shadow hover:shadow-lg">
          <h4 class="text-xl font-bold mb-2">E-Books</h4>
          <p>Access a wide collection of electronic books covering multiple disciplines.</p>
        </div>
        <div class="bg-white p-6 rounded shadow hover:shadow-lg">
          <h4 class="text-xl font-bold mb-2">Research Journals</h4>
          <p>Stay updated with the latest academic research from top journals.</p>
        </div>
        <div class="bg-white p-6 rounded shadow hover:shadow-lg">
          <h4 class="text-xl font-bold mb-2">Online Support</h4>
          <p>Get help from our librarians through chat and email support.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
<section id="gallery" class="py-16 bg-gray-50">
  <div class="container mx-auto text-center">
    <h3 class="text-3xl font-bold mb-8">Gallery</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <img src="image/b.jpg" alt="Gallery 1" class="rounded shadow">
      <img src="image/b1.jpg" alt="Gallery 2" class="rounded shadow">
      <img src="image/b2.jpg" alt="Gallery 3" class="rounded shadow">
      <img src="image/g3.jpeg" alt="Gallery 4" class="rounded shadow">
      <img src="image/g4.jpeg" alt="Gallery 5" class="rounded shadow">
      <img src="image/g5.jpeg" alt="Gallery 6" class="rounded shadow">
      <img src="image/g6.jpeg" alt="Gallery 7" class="rounded shadow">
      <img src="image/g7.jpg" alt="Gallery 8" class="rounded shadow">
            <!-- <img src="" alt="Gallery 8" class="rounded shadow"> -->

    </div>
  </div>
</section>


<script>
  const images = [
    "https://via.placeholder.com/800x400?text=Slide+1",
    "https://via.placeholder.com/800x400?text=Slide+2",
    "https://via.placeholder.com/800x400?text=Slide+3",
    "https://via.placeholder.com/800x400?text=Slide+4"
  ];
  let index = 0;
  const slideImage = document.getElementById("slideImage");

  setInterval(() => {
    index = (index + 1) % images.length;
    slideImage.src = images[index];
  }, 5000); // Change image every 5 seconds
</script>


  <!-- Explore Subjects Section -->
<section id="subjects" class="py-20 bg-gray-100">
  <div class="container mx-auto px-4">
    <h2 class="text-4xl font-bold text-center mb-12">Explore Our Collection</h2>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">

      <!-- History Section -->
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2">History</h3>
        <p class="text-gray-600 mb-4">Dive into the past with over <strong>1,200 books</strong> covering world history, civilizations, and historical figures.</p>
        <a href="#" class="text-blue-600 hover:underline">Browse History Books →</a>
      </div>

      <!-- Science Section -->
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2">Science</h3>
        <p class="text-gray-600 mb-4">Explore <strong>900+ books</strong> in Physics, Chemistry, Biology, and Environmental Science curated for students and researchers.</p>
        <a href="#" class="text-blue-600 hover:underline">Browse Science Books →</a>
      </div>

      <!-- Computer Science Section -->
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2">Computer Science</h3>
        <p class="text-gray-600 mb-4">Access <strong>1,500+ titles</strong> on programming, networking, cybersecurity, and AI technologies.</p>
        <a href="#" class="text-blue-600 hover:underline">Browse Computer Books →</a>
      </div>

      <!-- Literature Section -->
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2">Literature</h3>
        <p class="text-gray-600 mb-4">Enjoy <strong>850+ books</strong> from world-famous authors, including novels, poems, and literary criticism.</p>
        <a href="#" class="text-blue-600 hover:underline">Browse Literature →</a>
      </div>

      <!-- Islamic Studies Section -->
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2">Islamic Studies</h3>
        <p class="text-gray-600 mb-4">Explore <strong>1,000+ books</strong> on Quran, Hadith, Fiqh, and Islamic history in Arabic, English, Pashto, and Dari.</p>
        <a href="#" class="text-blue-600 hover:underline">Browse Islamic Studies →</a>
      </div>

      <!-- Economics & Management -->
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2">Economics & Management</h3>
        <p class="text-gray-600 mb-4">Find <strong>700+ books</strong> on micro/macro economics, business strategies, and management techniques.</p>
        <a href="#" class="text-blue-600 hover:underline">Browse Economics Books →</a>
      </div>

    </div>
  </div>
</section>


  <!-- Contact Section -->
  <section id="contact" class="py-16 bg-blue-50">
    <div class="container mx-auto text-center">
      <h3 class="text-3xl font-bold mb-6">Contact Us</h3>
      <p>Email: library@internationaluniv.edu</p>
      <p>Phone: +123 456 7890</p>
      <p>Address: University Rd, City, Country</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-800 text-white text-center py-4">
    <p>&copy; 2025 International University E-Library. All rights reserved.</p>
  </footer>

</body>
</html>
