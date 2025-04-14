<?php   
// Language selection logic  
$lang = 'en'; // Default language  
if (isset($_GET['lang'])) {  
    $lang = $_GET['lang'];  
}  

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

<!DOCTYPE html>  
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ps' || $lang == 'fa') ? 'rtl' : 'ltr'; ?>">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title><?php echo $translations[$lang]['page_title']; ?></title>  
    <style>  
        body {  
            font-family: Arial, sans-serif;  
            line-height: 1.6;  
        }  
        body[dir="rtl"] {
            text-align: right;
        }

        body[dir="ltr"] {
            text-align: left;
        }

        header, nav, footer {  
            background: #333;  
            color: #fff;  
            padding: 1rem;  
            text-align: center;  
        }

        nav ul {  
            list-style: none;  
            padding: 0;  
            text-align: right; /* Ensure nav is right-aligned for RTL */
        }

        nav ul li {  
            display: inline-block;  
            margin: 0 15px;  
        }

        .container {  
            width: 80%;  
            margin: 0 auto;  
            text-align: <?php echo ($lang == 'en') ? 'left' : 'right'; ?>; /* Left for English and right for RTL languages */
        }

        .team-section {  
            display: flex;  
            justify-content: space-between;  
            margin: 20px 0;  
            flex-direction: <?php echo ($lang == 'en') ? 'row' : 'row-reverse'; ?>; /* Row for LTR, reversed for RTL */
            flex-wrap: wrap; /* Ensure the items wrap in smaller screens */
        }

        .team-member {  
            text-align: center;  
            border: 2px solid #ddd;  
            padding: 20px;  
            margin: 10px;  
            width: 30%;  
            box-sizing: border-box;  
            border-radius: 8px;  
            transition: transform 0.3s ease;  
        }

        .team-member:hover {
            transform: scale(1.05);
        }

        .team-member img {  
            width: 100px;  
            height: 100px;  
            border-radius: 50%;  
            margin-bottom: 10px;  
        }

        footer {  
            text-align: center;  
        }

        select {
            margin-top: 10px;
            padding: 5px;
            font-size: 16px;
            background-color: #f0f0f0;
        }

        .language-selector {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Media Query for Mobile Devices */
        @media (max-width: 768px) {
            .team-member {
                width: 100%; /* Each team member box will take full width on small screens */
                margin: 10px 0; /* Adjust margin for vertical stacking */
            }

            .team-section {
                flex-direction: column; /* Stack the team members vertically on small screens */
                align-items: center; /* Center the team members horizontally */
            }

            .container {
                width: 90%; /* Make container a bit narrower on mobile screens */
            }
        }
    </style>  
</head>  
<body>  

<div class="language-selector">
    <form method="get">
        <label for="lang">Select Language: </label>
        <select name="lang" id="lang" onchange="this.form.submit()">
            <option value="en" <?php echo ($lang == 'en') ? 'selected' : ''; ?>>English</option>
            <option value="ps" <?php echo ($lang == 'ps') ? 'selected' : ''; ?>>Pashto</option>
            <option value="fa" <?php echo ($lang == 'fa') ? 'selected' : ''; ?>>Dari</option>
        </select>
    </form>
</div>

<header>  
    <h1 id="library_name"><?php echo $translations[$lang]['library_name']; ?></h1>  
</header>  

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
</html>
