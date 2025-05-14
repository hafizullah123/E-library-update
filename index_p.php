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
    <div class="container mx-auto flex justify-between items-center p-4">
      <h1 class="text-2xl font-bold">International University E-Library</h1>
      <nav class="space-x-4">
        <a href="#" class="hover:text-yellow-300">Home</a>
        <a href="#services" class="hover:text-yellow-300">Services</a>
        <a href="#books" class="hover:text-yellow-300">Books</a>
        <a href="#contact" class="hover:text-yellow-300">Contact</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-white py-16 shadow">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold mb-4">Welcome to the Digital Library</h2>
      <p class="text-lg text-gray-700">Access thousands of academic resources, journals, and e-books anytime, anywhere.</p>
      <a href="#books" class="mt-6 inline-block bg-blue-700 hover:bg-blue-900 text-white font-semibold py-2 px-4 rounded">Explore Books</a>
    </div>
  </section>

  <!-- Slideshow Section -->
<section id="slideshow" class="py-16 bg-white">
  <div class="container mx-auto text-center">
    <h3 class="text-3xl font-bold mb-8">Slideshow</h3>
    <div class="relative w-full max-w-2xl mx-auto">
      <div class="overflow-hidden rounded shadow-lg">
        <img id="slideImage" src="https://via.placeholder.com/800x400" class="w-full h-auto transition duration-700" alt="Slideshow">
      </div>
    </div>
  </div>
</section>

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
      <img src="https://via.placeholder.com/200" alt="Gallery 1" class="rounded shadow">
      <img src="https://via.placeholder.com/200" alt="Gallery 2" class="rounded shadow">
      <img src="https://via.placeholder.com/200" alt="Gallery 3" class="rounded shadow">
      <img src="https://via.placeholder.com/200" alt="Gallery 4" class="rounded shadow">
      <img src="https://via.placeholder.com/200" alt="Gallery 5" class="rounded shadow">
      <img src="https://via.placeholder.com/200" alt="Gallery 6" class="rounded shadow">
      <img src="https://via.placeholder.com/200" alt="Gallery 7" class="rounded shadow">
      <img src="https://via.placeholder.com/200" alt="Gallery 8" class="rounded shadow">
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


  <!-- Featured Books Section -->
  <section id="books" class="py-16">
    <div class="container mx-auto text-center">
      <h3 class="text-3xl font-bold mb-12">Featured Books</h3>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
        <div class="bg-white rounded shadow p-4">
          <img src="https://via.placeholder.com/150" alt="Book 1" class="mx-auto mb-4">
          <h5 class="font-bold">Book Title 1</h5>
          <p class="text-sm text-gray-600">Author Name</p>
        </div>
        <div class="bg-white rounded shadow p-4">
          <img src="https://via.placeholder.com/150" alt="Book 2" class="mx-auto mb-4">
          <h5 class="font-bold">Book Title 2</h5>
          <p class="text-sm text-gray-600">Author Name</p>
        </div>
        <div class="bg-white rounded shadow p-4">
          <img src="https://via.placeholder.com/150" alt="Book 3" class="mx-auto mb-4">
          <h5 class="font-bold">Book Title 3</h5>
          <p class="text-sm text-gray-600">Author Name</p>
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
