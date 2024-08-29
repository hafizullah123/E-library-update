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
      }
      /* Custom Modal Styling */
      .custom-modal {
        background-color: #f8f9fa; /* Light gray background color */
        color: #080808; /* Dark text color */
        text-emphasis-color: #080808;
        border-radius: 1px; /* Rounded corners */
        border: 1px solid #ccc; /* Border color */
      }
      .custom-modal .modal-header {
        background-color: #252424; /* Header background color */
        color: white; /* Header text color */
      }
      .custom-modal .modal-footer {
        background-color: #f1f1f1; /* Footer background color */
      }
      .box:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      }
      .box img {
        width: 100%;
        height: auto;
        border-radius: 8px;
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
        height: auto;
      }
    </style>
    <script>
      function changeLanguage() {
        const lang = document.getElementById('languageSelector').value;
        document.documentElement.lang = lang;
        localStorage.setItem('preferredLanguage', lang); // Save selected language to local storage

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

      document.addEventListener('DOMContentLoaded', () => {
        const savedLanguage = localStorage.getItem('preferredLanguage') || 'en'; // Get saved language from local storage or default to 'en'
        document.getElementById('languageSelector').value = savedLanguage;
        changeLanguage(); // Initialize language settings on page load
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
    <!-- Centered Heading -->
    <h1 class="text-center my-4" data-en="Our Services" data-ps="زموږ خدمات" data-fa="خدمات ما">Our Services</h1>

    <div class="container my-5">
      <div class="row">
        <!-- Box 1 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
            <h5 class="mt-3" data-en="Computer sense faculty" data-ps="کمپیوترساینس پوهنځی" data-fa="پوهنځی کمپیوتر ساینس">LITERATURE</h5>
          </div>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- Additional Boxes... -->
      </div>
    </div>

    <!-- Modal Templates... -->

    <!-- Footer -->
    <footer class="text-center">
      <div class="container">
        <p>&copy; 2024 Kabul Education University Digital Library</p>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
