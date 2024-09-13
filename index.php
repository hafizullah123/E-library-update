<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Index Page with Consistent Box Design</title>
    <link rel="stylesheet" href="styles.css" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <style>
      h1 {
        text-align: center;
        margin: 0;
      }
      .box {
        margin-bottom: 30px;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        cursor: pointer;
        text-align: center;
      }
      .box img {
        width: 100%;
        height: 200px; /* Set a fixed height for all images */
        object-fit: cover; /* Ensures the image covers the area without distortion */
        border-radius: 8px;
      }
      .custom-modal {
        background-color: #f8f9fa;
        color: #080808;
        text-emphasis-color: #080808;
        border-radius: 1px;
        border: 1px solid #ccc;
      }
      .custom-modal .modal-header {
        background-color: #252424;
        color: white;
      }
      .custom-modal .modal-footer {
        background-color: #f1f1f1;
      }
      .box:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      }
      /* Footer */
      footer {
        background-color: #343a40;
        color: white;
        padding: 20px 0;
      }
      .footer-links a {
        color: #ffffff;
        text-decoration: none;
      }
      .footer-links a:hover {
        text-decoration: underline;
      }
      /* Carousel */
      .carousel-item img {
        width: 100%;
        height: 80%;
      }
      /* Gallery */
      .gallery-item {
            position: relative;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .gallery-image {
            width: 100%;
            height: 200px; /* Fixed height for uniformity */
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            text-align: center;
            font-size: 1.2rem;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
    </style>
    <script>
      function changeLanguage() {
        const lang = document.getElementById('languageSelector').value;
        localStorage.setItem('selectedLanguage', lang); // Save the selected language to localStorage
        document.documentElement.lang = lang;
        if (lang === 'ps' || lang === 'fa') {
          document.body.dir = 'rtl'; // Set direction to RTL for Pashto and Dari
        } else {
          document.body.dir = 'ltr'; // Set direction to LTR for English
        }

        // Update text content dynamically
        const elements = document.querySelectorAll('[data-en]');
        elements.forEach(element => {
          element.textContent = element.getAttribute('data-' + lang);
          if (lang === 'ps' || lang === 'fa') {
            element.style.textAlign = 'right'; // Align text to the right for RTL languages
          } else {
            element.style.textAlign = 'left'; // Align text to the left for LTR languages
          }
        });
      }

      function startGallery() {
        const images = document.querySelectorAll('.gallery-image');
        let currentIndex = 0;

        function showNextImage() {
          images[currentIndex].classList.remove('active');
          currentIndex = (currentIndex + 1) % images.length;
          images[currentIndex].classList.add('active');
        }

        images[0].classList.add('active'); // Show the first image initially
        setInterval(showNextImage, 5000); // Change image every 5 seconds
      }

      document.addEventListener('DOMContentLoaded', () => {
        const savedLanguage = localStorage.getItem('selectedLanguage') || 'en'; // Get saved language from localStorage or default to 'en'
        document.getElementById('languageSelector').value = savedLanguage;
        changeLanguage(); // Initialize language settings on page load
        startGallery(); // Start gallery on page load
      });
    </script>
  </head>
  <body>
    <!-- Language Selector -->
    <div class="container my-3">
      <select id="languageSelector" class="form-control" onchange="changeLanguage()">
        <option value="en">English</option>
        <option value="ps">Pashto</option>
        <option value="fa">Dari</option>
      </select>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="nav-link" href="#" style="color: white;" data-en="Kabul Education University Digital Library" data-ps="کابل ښونی او روزنی پوهنتون" data-fa="کابل آموزشی پوهنتون"></a>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="about.html" data-en="About" data-ps="زموږ په اړه" data-fa="درباره ما">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php" data-en="Login" data-ps="ننوتل" data-fa="ورود">Login</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="IMG/1.jpg" alt="First slide" />
        </div>
        <div class="carousel-item">
          <img src="IMG/2.jpg" alt="Second slide" />
        </div>
        <div class="carousel-item">
          <img src="IMG/3.jpg" alt="Third slide" />
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <!-- Boxes Section -->
    <h1 class="text-center my-4" data-en="Our Services" data-ps="زموږ خدمات" data-fa="خدمات ما">Our Services</h1>

    <div class="container my-5">
      <div class="row">
        <!-- Box 1 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
            <h5 class="mt-3" data-en="Computer sense faculty" data-ps="کمپیوترساینس پوهنځی" data-fa="فاکولته علم کامپیوتر"></h5>
          </div>
        </div>

        <!-- Box 2 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal2">
          <img src="IMG/5.JPG" alt="Image 2" />
          <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
            <h5 class="mt-3" data-en="English language faculty" data-ps="انګلیسي ژبې پوهنځی" data-fa="فاکولته زبان انگلیسی"></h5>
          </div>
        </div>

        <!-- Box 3 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal3">
          <img src="IMG/6.JPG" alt="Image 3" />
          <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
            <h5 class="mt-3" data-en="Engineering faculty" data-ps="انجنیرۍ پوهنځی" data-fa="فاکولته مهندسی"></h5>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <!-- Modal 1 -->
    <div class="modal fade custom-modal" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal1Label" data-en="Computer sense faculty" data-ps="کمپیوترساینس پوهنځی" data-fa="فاکولته علم کامپیوتر"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p data-en="Details about the Computer sense faculty" data-ps="د کمپیوترساینس پوهنځی په اړه تفصیل" data-fa="جزئیات در مورد فاکولته علم کامپیوتر"></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 2 -->
    <div class="modal fade custom-modal" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal2Label" data-en="English language faculty" data-ps="انګلیسي ژبې پوهنځی" data-fa="فاکولته زبان انگلیسی"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p data-en="Details about the English language faculty" data-ps="د انګلیسي ژبې پوهنځی په اړه تفصیل" data-fa="جزئیات در مورد فاکولته زبان انگلیسی"></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 3 -->
    <div class="modal fade custom-modal" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modal3Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal3Label" data-en="Engineering faculty" data-ps="انجنیرۍ پوهنځی" data-fa="فاکولته مهندسی"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p data-en="Details about the Engineering faculty" data-ps="د انجنیرۍ پوهنځی په اړه تفصیل" data-fa="جزئیات در مورد فاکولته مهندسی"></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Gallery -->
    
    <div class="container mt-5">
        <div class="row">
            <!-- Gallery Item 1 -->
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="IMG/7.JPG" alt="Gallery Image 1" class="gallery-image">
                    <div class="gallery-overlay">Image 1</div>
                </div>
            </div>
            <!-- Gallery Item 2 -->
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="IMG/8.JPG" alt="Gallery Image 2" class="gallery-image">
                    <div class="gallery-overlay">Image 2</div>
                </div>
            </div>
            <!-- Gallery Item 3 -->
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="IMG/9.JPG" alt="Gallery Image 3" class="gallery-image">
                    <div class="gallery-overlay">Image 3</div>
                </div>
            </div>
            <!-- Gallery Item 4 -->
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="IMG/9.JPG" alt="Gallery Image 4" class="gallery-image">
                    <div class="gallery-overlay">Image 4</div>
                </div>
            </div>
            <!-- Gallery Item 5 -->
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="IMG/5.JPG" alt="Gallery Image 5" class="gallery-image">
                    <div class="gallery-overlay">Image 5</div>
                </div>
            </div>
            <!-- Gallery Item 6 -->
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="IMG/6.JPG" alt="Gallery Image 6" class="gallery-image">
                    <div class="gallery-overlay">Image 6</div>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h5>Quick Links</h5>
            <ul class="list-unstyled footer-links">
              <li><a href="#" data-en="Home" data-ps="کور" data-fa="خانه">Home</a></li>
              <li><a href="#" data-en="About" data-ps="زموږ په اړه" data-fa="درباره ما">About</a></li>
              <li><a href="#" data-en="Contact" data-ps="اړیکه" data-fa="تماس">Contact</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h5>Social Media</h5>
            <ul class="list-unstyled">
              <li><a href="#" data-en="Facebook" data-ps="فیس بوک" data-fa="فیس‌بوک">Facebook</a></li>
              <li><a href="#" data-en="Twitter" data-ps="ټویټر" data-fa="توییتر">Twitter</a></li>
              <li><a href="#" data-en="Instagram" data-ps="انسټاګرام" data-fa="اینستاگرام">Instagram</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h5>Contact Information</h5>
            <ul class="list-unstyled">
              <li><a href="mailto:info@example.com" data-en="info@example.com" data-ps="info@example.com" data-fa="info@example.com">info@example.com</a></li>
              <li><a href="tel:+1234567890" data-en="+123 456 7890" data-ps="+123 456 7890" data-fa="+123 456 7890">+123 456 7890</a></li>
              <li>123 Main Street, City, Country</li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
