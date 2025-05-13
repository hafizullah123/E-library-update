<?php
session_start();

<<<<<<< HEAD
// Default language is English
$lang = 'en';
=======
// Load language files  
$translations = [  
    'en' => [  
        'page_title' => 'Library Page',  
        'library_name' => 'Wellcome to Samangan university library',  
        'nav_home' => 'Home',  
        'about_us' => 'About Us',  
        'welcome_message' => 'Welcome to our library!',  
        'mission_heading' => 'Our Mission',  
        'mission_text' => 'To provide access to knowledge and resources.',  
        'what_we_offer' => 'What We Offer',  
        'extensive_collection' => 'An extensive collection of books and',  
        'digital_resources' => 'digital resources.',  
        'programs_events' => 'Programs and events for the community.',  
        'support_guidance' => 'Support and guidance for research.',  
        'our_history' => 'Our History',  
        'history_text' => 'Established in 2024, we have served the community.',  
        'get_involved' => 'Get Involved',  
        'membership' => 'Become a member.',  
       
       
        'friends_of_library' => 'Join the Friends of the Library.',  
        'visit_us' => 'Visit Us',  
        'location' => 'smangan university',  
        'hours' => 'Mon-Fri: 9 AM - 5 PM',  
        'contact' => 'Contact us at info@mylibrary.com',  
        'meet_team' => 'Meet Our Team',  
        'footer_text' => 'All rights reserved.'  
    ],  
    'ps' => [  
        'page_title' => 'کتابخانه',  
        'library_name' => 'سمنګان لوړو زدکړو موسسه کتابتون ته ښه راغلاست',  
        'nav_home' => 'کور',  
        'about_us' => 'زموږ په اړه',  
        'welcome_message' => ' کتابتون ته ښه راغلاست ',  
        'mission_heading' => 'زموږ ماموریت',  
        'mission_text' => 'د علم او منابعو ته لاسرسی چمتو کول.',  
        'what_we_offer' => 'موږ څه وړاندې کوو',  
        'extensive_collection' => 'د کتابونو پراخ مجموعه او',  
        'digital_resources' => 'ډیجیټل منابع.',  
        'programs_events' => 'د ټولنې لپاره پروګرامونه او پیښې.',  
        'support_guidance' => 'د څیړنې لپاره مرستې او لارښوونه.',  
        'our_history' => 'زموږ تاریخ',  
        'history_text' => 'په ۲۰۲۴ کې تاسیس شو، موږ ټولنې ته خدمت کړی دی.',  
        'get_involved' => 'ګډون وکړئ',  
        'membership' => 'غړیتوب واخلئ.',  
         
        
        'friends_of_library' => 'د کتابخانې دوستانو سره یوځای شئ.',  
        'visit_us' => 'زموږ لیدنه وکړئ',  
        'location' => 'د سمنگانو لوٰړو زدکړو موسسه',  
        'hours' => 'د شنبې څخه تر پنجشنبې: سهارڅخه تر ماښام ',  
         
        'meet_team' => 'زموږ ټیم سره ملاقات وکړئ',  
        'footer_text' => 'ټول حقوق محفوظ دي.'  
    ],  
    'fa' => [  
        'page_title' => 'صفحه کتابخانه',  
        'library_name' => 'به کتابخانه موسسه تحصیلات عالی سمنگان خوش آمدید',  
        'nav_home' => 'خانه',  
        'about_us' => 'درباره ما',  
        'welcome_message' => 'به کتابخانه ما خوش آمدید!',  
        'mission_heading' => 'مأموریت ما',  
        'mission_text' => 'تأمین دسترسی به دانش و منابع.',  
        'what_we_offer' => 'ما چه خدماتی ارائه می‌دهیم',  
        'extensive_collection' => 'مجموعه‌ای گسترده از کتاب‌ها و',  
        'digital_resources' => 'منابع دیجیتال.',  
        'programs_events' => 'برنامه‌ها و رویدادها برای جامعه.',  
        'support_guidance' => 'کمک و راهنمایی برای تحقیق.',  
        'our_history' => 'تاریخچه ما',  
        'history_text' => 'از سال ۲۰۲۴ تأسیس شده، ما به جامعه خدمت کرده‌ایم.',  
        'get_involved' => 'درگیر شوید',  
        'membership' => 'عضو شوید.',  
        
         
        'friends_of_library' => 'به دوستان کتابخانه ملحق شوید.',  
        'visit_us' => 'به ما مراجعه کنید',  
        'location' => 'موسسه تحصیلات عالی سمنگان',  
        'hours' => 'شنبه تا پنج‌شنبه: صبح تا شام ',  
       
        'meet_team' => 'با تیم ما آشنا شوید',  
        'footer_text' => 'کلیه حقوق محفوظ است.'  
    ]  
];  
?>  
>>>>>>> b84bf78460e01f7be5de5c46a9de4d82feb20d76

// Check if a language is specified in the URL
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
}

// Set the session language based on URL parameter or default to 'en'
$_SESSION['lang'] = $lang;

// Include language files based on selected language
switch ($lang) {
    case 'ps':
        $lang_file = 'locale_ps.php';
        $dir = 'rtl'; // Right-to-Left direction for Pashto
        break;
    case 'fa':
        $lang_file = 'locale_fa.php';
        $dir = 'rtl'; // Right-to-Left direction for Dari
        break;
    default:
        $lang_file = 'locale_en.php';
        $dir = 'ltr'; // Left-to-Right direction for English
        break;
}

// Construct the correct language file path
$lang_file_path = "language/" . $lang_file;

// Check if the language file exists before including
if (file_exists($lang_file_path)) {
    $lang_arr = include_once($lang_file_path);
} else {
    // Handle the case where the language file doesn't exist
    die("Language file not found for {$_SESSION['lang']}.");
}

// Function to translate strings
function translate($key) {
    global $lang_arr;
    return isset($lang_arr[$key]) ? $lang_arr[$key] : '';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo translate('page_title'); ?></title>
    <style>
      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        color: #333;
        direction: <?php echo $dir; ?>;
      }
      .container {
        width: 80%;
        margin: auto;
        overflow: hidden;
      }
      header {
        background: #003366;
        color: #fff;
        padding: 20px 0;
        text-align: center;
        border-bottom: #3399ff 3px solid;
      }
      header h1 {
        margin: 0;
        font-size: 2.5em;
      }
      nav {
        margin: 20px 0;
        text-align: center;
      }
      nav ul {
        padding: 0;
        list-style: none;
      }
      nav ul li {
        display: inline;
        margin: 0 15px;
      }
      nav ul li a {
        color: #003366;
        text-decoration: none;
        font-weight: bold;
      }
      .content {
        padding: 20px;
        background: #fff;
        margin: 20px 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      h1,
      h2,
      h3 {
        color: #003366;
      }
      ul {
        list-style: disc inside;
      }
      .team-section {
        display: flex;
        justify-content: space-around;
        margin-top: 40px;
      }
      .team-member {
        background: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        flex: 1;
        margin: 10px;
        border-radius: 10px;
        cursor: pointer;
        transition: transform 0.3s;
        position: relative; /* Ensure relative positioning for nested popup */
      }
      .team-member:hover {
        transform: scale(1.05);
      }
      .team-member h3 {
        margin: 10px 0 5px;
        font-size: 1.2em;
      }
      .team-member p {
        color: #666;
        font-size: 0.9em;
      }
      .team-member img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-bottom: 10px;
      }
      footer {
        background: #003366;
        color: #fff;
        text-align: center;
        padding: 30px 0;
        margin-top: 20px;
        border-top: #3399ff 3px solid;
      }
      .popup {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
      }
      .popup-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
        text-align: center;
        position: relative; /* Ensure relative positioning for nested popup */
      }
      .popup-content img {
        border-radius: 50%;
        width: 150px;
        height: 150px;
        object-fit: cover;
        margin-bottom: 20px;
      }
      .popup-close {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
      }
      .popup-close:hover,
      .popup-close:focus {
        color: black;
        text-decoration: none;
      }
    </style>
</head>
<body>
    <header>
      <div class="container">
        <h1><?php echo translate('library_name'); ?></h1>
      </div>
    </header>

    <nav>
  <div class="container">
    <ul>
      <li><a href="index.php"><?php echo translate('nav_home'); ?></a></li>
      
      <!--  -->
      <li><a href="?lang=ps">پښتو</a></li>
      <li><a href="?lang=fa">دری</a></li>
      <li><a href="?lang=en">English</a></li>
    </ul>
  </div>
</nav>


    <div class="container">
      <div class="content">
        <h1><?php echo translate('about_us'); ?></h1>
        <p>
          <?php echo translate('welcome_message'); ?>
        </p>

        <h2><?php echo translate('mission_heading'); ?></h2>
        <p>
          <?php echo translate('mission_text'); ?>
        </p>

        <h2><?php echo translate('what_we_offer'); ?></h2>
        <ul>
          <li><?php echo translate('extensive_collection'); ?> <?php echo translate('digital_resources'); ?></li>
          <li><?php echo translate('programs_events'); ?> <?php echo translate('community_services'); ?></li>
          <li><?php echo translate('support_guidance'); ?> <?php echo translate('support_guidance'); ?></li>
        </ul>

        <h2><?php echo translate('our_history'); ?></h2>
        <p>
          <?php echo translate('history_text'); ?>
        </p>

        <h2><?php echo translate('get_involved'); ?></h2>
        <ul>
          <li><?php echo translate('membership'); ?> <?php echo translate('membership'); ?></li>
          <li><?php echo translate('volunteer'); ?> <?php echo translate('volunteer'); ?></li>
          <li><?php echo translate('donate'); ?> <?php echo translate('donate'); ?></li>
          <li><?php echo translate('friends_of_library'); ?> <?php echo translate('friends_of_library'); ?></li>
        </ul>

        <h2><?php echo translate('visit_us'); ?></h2>
        <p>
          <?php echo translate('visit_text'); ?>
        </p>
        <p><strong><?php echo translate('location'); ?>:</strong> <?php echo translate('location'); ?></p>
        <p><strong><?php echo translate('hours'); ?>:</strong> <?php echo translate('hours'); ?></p>
        <p><strong><?php echo translate('contact'); ?>:</strong> <?php echo translate('contact'); ?></p>

        <h2><?php echo translate('meet_team'); ?></h2>
        <div class="team-section">
          <div class="team-member" onclick="openPopup('member1')">
            <img src="image/ha.jpg" alt="<?php echo translate('library_manager'); ?>">
            <h3><?php echo translate('library_manager'); ?></h3>
            <p><?php echo translate('manager_text'); ?></p>
          </div>
          <div class="team-member" onclick="openPopup('member2')">
            <img src="image/im.jpg" alt="<?php echo translate('head_librarian'); ?>">
            <h3><?php echo translate('head_librarian'); ?></h3>
            <p><?php echo translate('librarian_text'); ?></p>
          </div>
          <div class="team-member" onclick="openPopup('member3')">
            <img src="image/nur.jpg" alt="<?php echo translate('library_assistant'); ?>">
            <h3><?php echo translate('library_assistant'); ?></h3>
            <p><?php echo translate('assistant_text'); ?></p>
          </div>
          <!-- Add more team members as needed -->
        </div>
      </div>
    </div>

    <!-- Popup for Team Members -->
    <div id="member1-popup" class="popup">
      <div class="popup-content">
        <span class="popup-close" onclick="closePopup('member1')">&times;</span>
        <img src="image/ha.jpg" alt="<?php echo translate('library_manager'); ?>">
        <h2><?php echo translate('library_manager'); ?></h2>
        <p><?php echo translate('manager_text'); ?></p>
      </div>
    </div>
    <div id="member2-popup" class="popup">
      <div class="popup-content">
        <span class="popup-close" onclick="closePopup('member2')">&times;</span>
        <img src="image/im.jpg" alt="<?php echo translate('head_librarian'); ?>">
        <h2><?php echo translate('head_librarian'); ?></h2>
        <p><?php echo translate('librarian_text'); ?></p>
      </div>
    </div>
    <div id="member3-popup" class="popup">
      <div class="popup-content">
        <span class="popup-close" onclick="closePopup('member3')">&times;</span>
        <img src="image/nur.jpg" alt="<?php echo translate('library_assistant'); ?>">
        <h2><?php echo translate('library_assistant'); ?></h2>
        <p><?php echo translate('assistant_text'); ?></p>
      </div>
    </div>

    <footer>
      <div class="container">
        <p>&copy; <?php echo date('Y'); ?> <?php echo translate('library_name'); ?>. <?php echo translate('footer_text'); ?></p>
      </div>
    </footer>

    <script>
      // Function to open popup
      function openPopup(id) {
        var popup = document.getElementById(id + '-popup');
        popup.style.display = 'block';
      }

<<<<<<< HEAD
      // Function to close popup
      function closePopup(id) {
        var popup = document.getElementById(id + '-popup');
        popup.style.display = 'none';
      }
    </script>
</body>
=======
<nav>  
<li id="nav_home"><a href="index.php" style="color: white;"><?php echo $translations[$lang]['nav_home']; ?></a></li>  
<li id="about_us"><a href="#about" style="color: white;"><?php echo $translations[$lang]['about_us']; ?></a></li>
 
</nav>  

<div class="container">  
    <h2 id="welcome_message"><?php echo $translations[$lang]['welcome_message']; ?></h2>  

    <p id="mission_heading"><?php echo $translations[$lang]['mission_heading']; ?></p>  
    <p id="mission_text"><?php echo $translations[$lang]['mission_text']; ?></p>  

    <h2 id="what_we_offer"><?php echo $translations[$lang]['what_we_offer']; ?></h2>  
    <p id="extensive_collection"><?php echo $translations[$lang]['extensive_collection']; ?></p>  
    <p id="digital_resources"><?php echo $translations[$lang]['digital_resources']; ?></p>  
    <p id="programs_events"><?php echo $translations[$lang]['programs_events']; ?></p>  
    <p id="support_guidance"><?php echo $translations[$lang]['support_guidance']; ?></p>  

    <h2 id="our_history"><?php echo $translations[$lang]['our_history']; ?></h2>  
    <p id="history_text"><?php echo $translations[$lang]['history_text']; ?></p>  

    <h2 id="get_involved"><?php echo $translations[$lang]['get_involved']; ?></h2>  
    <ul>  
        <li id="membership"><?php echo $translations[$lang]['membership']; ?></li>  
          
         
        <li id="friends_of_library"><?php echo $translations[$lang]['friends_of_library']; ?></li>  
    </ul>  

    <h2 id="visit_us"><?php echo $translations[$lang]['visit_us']; ?></h2>  
    <p id="location"><?php echo $translations[$lang]['location']; ?></p>  
    <p id="hours"><?php echo $translations[$lang]['hours']; ?></p>  
     

    <div class="team-section">  
        <div class="team-member" id="team_member_1">  
            <img src="image/ع.jpg" alt="Team Member 1">  
            <p>محمد نسیم صفا</p>  
            <p>مدیر عمومی کتابخانه</p>  
        </div>  
        <div class="team-member" id="team_member_2">  
            <img src="image/مدیر.png" alt="Team Member 2">  
            <p>عصمت الله صدیقیار</p>  
            <p>مدیر تنظیم کتب و کارت کتلاک</p>  
        </div>  
        <div class="team-member" id="team_member_3">  
            <img src="image/ha.jpg" alt="Team Member 3">  
            <p>حفیظ الله جهادوال </p>  
            <p>ایجاد کننده کتابخانه دیجیتلی</p>  
        </div>  
    </div>  
</div>  

<footer>  
    <div class="container">  
        <p id="footer_text"><?php echo $translations[$lang]['footer_text']; ?></p>  
    </div>  
</footer>  

</body>  
>>>>>>> b84bf78460e01f7be5de5c46a9de4d82feb20d76
</html>
