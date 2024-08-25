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
      <!-- <a class="navbar-brand" href="#">Shikh Zayed university digital library</a> -->
      <a class="nav-link" href="" style="color: white;" data-en="Shikh Zayed university digital library" data-ps="شیخ زاید برښنایی کتاب تون" data-fa="کتاب خانه پوهنتون شیخ زاید"></a>

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
          <!-- <li class="nav-item active">
            <a class="nav-link" href="orders.php" data-en="Orders" data-ps="زمونږ په ا" data-fa="درباره ما">About</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="about.html" data-en="About" data-ps="زموږ په اړه" data-fa="درباره ما">About</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="product1.php" data-en="Product" data-ps="محصول" data-fa="محصول">Product</a>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link" href="contact.php" data-en="Contact" data-ps="اړیکه" data-fa="تماس">Contact</a>
          </li> -->
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
          <img src="IMG/1.jpg" alt="Second slide" />
        </div>
       
        <div class="carousel-item">
          <img src="IMG/3.jpg" alt="Third slide" />
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
    <h1 data-en="Our Services" data-ps="زموږ خدمات" data-fa="خدمات ما">Our Services</h1>
    <div class="container my-5">
      <div class="row">
        <!-- Box 1 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="LITERATURE" data-ps="ادب" data-fa="ادبیات">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="LITERATURE" data-ps="ادب" data-fa="ادبیات">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- Box 2 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal2">
          <img src="IMG/5.JPG" alt="Image 2" />
          <h5 class="mt-3" data-en="Drink" data-ps="څښاک" data-fa="نوشیدنی">Drink</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- Box 3 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal3">
          <img src="IMG/6.JPG" alt="Image 3" />
          <h5 class="mt-3" data-en="Vegetable" data-ps="سبزیجات" data-fa="سبزیجات">Vegetable</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- box 4 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="computer departemnet" data-ps="کمپیوټر ساینس پوهنځی " data-fa="  پوهنځی کمپیوتر ساینس  ">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- box 5 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="computer departemnet" data-ps="کمپیوټر ساینس پوهنځی " data-fa="  پوهنځی کمپیوتر ساینس  ">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- box 6 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="computer departemnet" data-ps="کمپیوټر ساینس پوهنځی " data-fa="  پوهنځی کمپیوتر ساینس  ">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- box 7 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="computer departemnet" data-ps="کمپیوټر ساینس پوهنځی " data-fa="  پوهنځی کمپیوتر ساینس  ">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- box 8 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="computer departemnet" data-ps="کمپیوټر ساینس پوهنځی " data-fa="  پوهنځی کمپیوتر ساینس  ">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- box 9 -->
        <div class="col-md-4 box" data-toggle="modal" data-target="#modal1">
          <img src="IMG/4.JPG" alt="Image 1" />
          <h5 class="mt-3" data-en="computer departemnet" data-ps="کمپیوټر ساینس پوهنځی " data-fa="  پوهنځی کمپیوتر ساینس  ">LITERATURE</h5>
          <p data-en="Box description goes here. It can be a brief summary of the content or service."
             data-ps="د بکس توضیحات دلته دي. دا د مینځپانګې یا خدمت لنډیز کیدی شي."
             data-fa="شرح جعبه اینجا است. این می تواند یک خلاصه کوتاه از محتوا یا خدمات باشد.">
            Box description goes here. It can be a brief summary of the content or service.
          </p>
        </div>
        <!-- Add more boxes similarly -->
      </div>
    </div>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4 footer-links">
            <h5 data-en="Quick Links" data-ps="چټک لینکونه" data-fa="لینک‌های سریع">Quick Links</h5>
            <ul>
              <li><a href="#" data-en="Home" data-ps="کور" data-fa="خانه">Home</a></li>
              <li><a href="#" data-en="About" data-ps="زموږ په اړه" data-fa="درباره ما">About</a></li>
              <li><a href="#" data-en="Contact" data-ps="اړیکه" data-fa="تماس">Contact</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h5 data-en="Social Media" data-ps="ټولنیزې رسنۍ" data-fa="شبکه‌های اجتماعی">Social Media</h5>
            <ul>
              <li><a href="https://www.facebook.com/profile.php?id=61563735099862" data-en="Facebook" data-ps="فیسبوک" data-fa="فیسبوک">Facebook</a></li>
              <li><a href="#" data-en="Twitter" data-ps="ټویټر" data-fa="تویتر">Twitter</a></li>
              <li><a href="#" data-en="Instagram" data-ps="انستګرام" data-fa="اینستاگرام">Instagram</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h5 data-en="Contact Information" data-ps="د اړیکو معلومات" data-fa="اطلاعات تماس">Contact Information</h5>
            <p data-en="Email: info@example.com" data-ps="بریښنالیک: szu.edu.af" data-fa="ایمیل:szu.edu.af ">Email: szu.edu.af</p>
            <p data-en="Phone: +123 456 7890" data-ps="تلیفون: +123 456 7890" data-fa="تلفن: +123 456 7890">Phone: +123 456 7890</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- JavaScript for Language Switching -->
    <script>
      function changeLanguage() {
        const selectedLanguage = document.getElementById("languageSelector").value;
        document.querySelectorAll("[data-en]").forEach((element) => {
          element.innerText = element.getAttribute(`data-${selectedLanguage}`);
        });
      }

      document.addEventListener("DOMContentLoaded", changeLanguage);
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
