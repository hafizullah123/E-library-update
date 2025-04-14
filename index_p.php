<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Full Service Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow-md px-6 py-4">
    <div class="container mx-auto flex justify-between items-center">
      <div class="text-xl font-bold text-blue-600">MyCompany</div>
      <ul class="flex space-x-4">
        <li><a href="#" class="hover:text-blue-500">Home</a></li>
        <li><a href="#" class="hover:text-blue-500">Services</a></li>
        <li><a href="#" class="hover:text-blue-500">Gallery</a></li>
        <li><a href="#" class="hover:text-blue-500">Contact</a></li>
      </ul>
    </div>
  </nav>

  <!-- Services Section -->
  <div class="container mx-auto py-10 px-4">
    <h2 class="text-3xl font-bold mb-8 text-center">Our Services</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <!-- Repeat this block for 9 boxes -->
      <div class="bg-white rounded-2xl shadow-md p-4 text-center">
        <img src="https://via.placeholder.com/150"
             alt="Service" class="w-full h-40 object-cover rounded-lg cursor-pointer"
             onclick="openModal('modal1')" />
        <h3 class="text-xl font-semibold mt-4">Service Title</h3>
        <p class="text-sm mt-2">Short description here...</p>
      </div>
      <!-- Repeat above block 8 more times with different content if needed -->
    </div>
  </div>

  <!-- Modal Example -->
  <div id="modal1" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full relative">
      <button class="absolute top-2 right-2 text-gray-500 hover:text-red-500" onclick="closeModal('modal1')">✕</button>
      <h2 class="text-2xl font-bold mb-2">Service Title</h2>
      <p class="text-gray-600">Full details about the service...</p>
    </div>
  </div>

  <!-- Gallery Section -->
  <div class="container mx-auto py-10 px-4">
    <h2 class="text-3xl font-bold mb-6 text-center">Gallery</h2>
    <div class="flex justify-center">
      <img id="galleryImage" src="https://via.placeholder.com/600x300"
           alt="Gallery Image" class="rounded-xl shadow-md w-full max-w-3xl h-64 object-cover" />
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-10">
    <div class="container mx-auto px-4 grid grid-cols-1 sm:grid-cols-3 gap-6">
      <!-- Social Media -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Follow Us</h3>
        <div class="flex space-x-4">
          <a href="#" class="hover:text-blue-400">Facebook</a>
          <a href="#" class="hover:text-sky-400">Twitter</a>
          <a href="#" class="hover:text-pink-400">Instagram</a>
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Quick Links</h3>
        <ul class="space-y-1">
          <li><a href="#" class="hover:text-blue-400">Home</a></li>
          <li><a href="#" class="hover:text-blue-400">Services</a></li>
          <li><a href="#" class="hover:text-blue-400">Gallery</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
        <p>Email: info@example.com</p>
        <p>Phone: +93 700 000 000</p>
        <p>Address: Kabul, Afghanistan</p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    function openModal(id) {
      document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
    }

    // Gallery image slider
    const galleryImages = [
      'https://via.placeholder.com/600x300?text=Image+1',
      'https://via.placeholder.com/600x300?text=Image+2',
      'https://via.placeholder.com/600x300?text=Image+3'
    ];
    let index = 0;
    setInterval(() => {
      index = (index + 1) % galleryImages.length;
      document.getElementById('galleryImage').src = galleryImages[index];
    }, 5000);
  </script>
</body>
</html>
