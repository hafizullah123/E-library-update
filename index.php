<?php

// Simple language switcher using GET parameter (?lang=ps or ?lang=fa or ?lang=en)
$lang = $_GET['lang'] ?? 'en';

$texts = [
  'en' => [
    'title' => 'International University E-Library',
    'site_title' => 'Kabul Education University E-Library',
    'home' => 'Home',
    'services' => 'Services',
    'books' => 'Books',
    'contact' => 'Contact',
    'welcome' => 'Welcome to the Digital Library',
    'welcome_desc' => 'Access thousands of academic resources, journals, and e-books anytime, anywhere.',
    'explore_books' => 'Explore Books',
    'usage_title' => 'How to Use the eLibrary',
    'usage_desc' => "Our eLibrary offers an easy-to-use platform to access a variety of academic resources. Whether you are a student, teacher, or researcher, here's how you can make the most of our digital library.",
    'register' => '1. Register and Login',
    'register_desc' => 'To access exclusive content and personalized features, you need to register for an account. After registration, simply log in to start browsing, saving your favorite books, and receiving recommendations based on your interests.',
    'search' => '2. Search for Books',
    'search_desc' => 'Use the search bar to find books, articles, or other academic resources. You can search by title, author, or keywords related to your research topic.',
    'browse' => '3. Browse by Category',
    'browse_desc' => 'Browse through our extensive collection categorized by subject areas such as Computer Science, History, Literature, and more. Find the resources most relevant to your field of interest.',
    'download' => '4. Download or Read Online',
    'download_desc' => 'Once you find a book, you can either download it to read offline or use the online reader to access it directly from your browser without the need for downloading.',
    'anywhere' => '5. Access from Anywhere',
    'anywhere_desc' => "Our eLibrary is accessible 24/7, so you can study or research from anywhere, whether you're on campus, at home, or on the go.",
    'updated' => '6. Stay Updated with New Additions',
    'updated_desc' => 'Stay informed about new books, journals, and resources added to the library by subscribing to our newsletter or visiting the "New Arrivals" section regularly.',
    'start_exploring' => 'Start Exploring the eLibrary Now',
    'slideshow' => 'Slideshow',
    'our_services' => 'Our Services',
    'ebooks' => 'E-Books',
    'ebooks_desc' => 'Access a wide collection of electronic books covering multiple disciplines.',
    'journals' => 'Research Journals',
    'journals_desc' => 'Stay updated with the latest academic research from top journals.',
    'support' => 'Online Support',
    'support_desc' => 'Get help from our librarians through chat and email support.',
    'gallery' => 'Gallery',
    'explore_collection' => 'Explore Our Collection',
    'history' => 'History',
    'history_desc' => 'Dive into the past with over <strong>1,200 books</strong> covering world history, civilizations, and historical figures.',
    'browse_history' => 'Browse History Books →',
    'science' => 'Science',
    'science_desc' => 'Explore <strong>900+ books</strong> in Physics, Chemistry, Biology, and Environmental Science curated for students and researchers.',
    'browse_science' => 'Browse Science Books →',
    'cs' => 'Computer Science',
    'cs_desc' => 'Access <strong>1,500+ titles</strong> on programming, networking, cybersecurity, and AI technologies.',
    'browse_cs' => 'Browse Computer Books →',
    'literature' => 'Literature',
    'literature_desc' => 'Enjoy <strong>850+ books</strong> from world-famous authors, including novels, poems, and literary criticism.',
    'browse_lit' => 'Browse Literature →',
    'islamic' => 'Islamic Studies',
    'islamic_desc' => 'Explore <strong>1,000+ books</strong> on Quran, Hadith, Fiqh, and Islamic history in Arabic, English, Pashto, and Dari.',
    'browse_islamic' => 'Browse Islamic Studies →',
    'economics' => 'Economics & Management',
    'economics_desc' => 'Find <strong>700+ books</strong> on micro/macro economics, business strategies, and management techniques.',
    'browse_economics' => 'Browse Economics Books →',
    'contact_us' => 'Contact Us',
    'email' => 'Email: library@internationaluniv.edu',
    'phone' => 'Phone: +123 456 7890',
    'address' => 'Address: University Rd, City, Country',
    'footer' => '&copy; 2025 International University E-Library. All rights reserved.',
    'lang_ps' => 'پښتو',
    'lang_fa' => 'دری',
    'lang_en' => 'English',
  ],
  'ps' => [
    'title' => 'د نړیوال پوهنتون برېښنايي کتابتون',
    'site_title' => 'د کابل د ښوونې او روزنې پوهنتون برېښنايي کتابتون',
    'home' => 'کور',
    'services' => 'خدمات',
    'books' => 'کتابونه',
    'contact' => 'اړیکه',
    'welcome' => 'برېښنايي کتابتون ته ښه راغلاست',
    'welcome_desc' => 'زرګونه علمي سرچینې، ژورنالونه او برېښنايي کتابونه هر وخت، هر ځای ته لاسرسی.',
    'explore_books' => 'کتابونه وګورئ',
    'usage_title' => 'څنګه برېښنايي کتابتون وکاروئ',
    'usage_desc' => 'زموږ برېښنايي کتابتون تاسو ته اسانه او کاروونکي دوستانه پلیټفارم برابروي. که تاسو زده کوونکی، ښوونکی یا څېړونکی یاست، دلته دا ده چې څنګه زموږ له کتابتون څخه ګټه واخلئ.',
    'register' => '۱. ثبت او ننوتل',
    'register_desc' => 'د ځانګړو محتواوو او شخصي بڼو ته د لاسرسي لپاره، باید حساب جوړ کړئ. وروسته له ثبت، یوازې ننوتل وکړئ او د کتابونو لټون، خوښول او د علاقې وړ وړاندیزونه ترلاسه کړئ.',
    'search' => '۲. د کتابونو لټون',
    'search_desc' => 'د لټون بار وکاروئ ترڅو کتابونه، مقالې یا نور علمي سرچینې پیدا کړئ. تاسو کولای شئ د عنوان، لیکوال یا کلیدي کلمو له مخې لټون وکړئ.',
    'browse' => '۳. د کټګورۍ له مخې پلټنه',
    'browse_desc' => 'زموږ پراخ ټولګه د مضمونونو له مخې تنظیم شوې ده لکه کمپیوټر ساینس، تاریخ، ادبیات او نور. د خپلې علاقې ساحې اړوند سرچینې پیدا کړئ.',
    'download' => '۴. ډاونلوډ یا آنلاین لوستل',
    'download_desc' => 'کله چې کتاب پیدا کړئ، کولای شئ دا ډاونلوډ کړئ یا مستقیم له براوزر څخه آنلاین ولولئ.',
    'anywhere' => '۵. له هر ځایه لاسرسی',
    'anywhere_desc' => 'زموږ برېښنايي کتابتون ۲۴/۷ فعال دی، نو تاسو هر وخت او هر ځای مطالعه یا څېړنه کولای شئ.',
    'updated' => '۶. له نوو اضافو خبر اوسئ',
    'updated_desc' => 'د نوو کتابونو، ژورنالونو او سرچینو په اړه د خبرتیا لپاره زموږ خبرپاڼه سبسکرایب کړئ یا د "نوې راغلي" برخه وګورئ.',
    'start_exploring' => 'اوس له کتابتون څخه ګټه واخلئ',
    'slideshow' => 'سلایدونه',
    'our_services' => 'زموږ خدمات',
    'ebooks' => 'برېښنايي کتابونه',
    'ebooks_desc' => 'د مختلفو برخو برېښنايي کتابونو پراخه ټولګه ته لاسرسی.',
    'journals' => 'څېړنیز ژورنالونه',
    'journals_desc' => 'د مخکښو ژورنالونو وروستي علمي څېړنې تعقیب کړئ.',
    'support' => 'آنلاین ملاتړ',
    'support_desc' => 'زموږ له کتابتون کارکوونکو سره د چټ او ایمیل له لارې مرسته ترلاسه کړئ.',
    'gallery' => 'ګالري',
    'explore_collection' => 'زموږ ټولګه وپلټئ',
    'history' => 'تاریخ',
    'history_desc' => 'د نړۍ تاریخ، تمدنونو او تاریخي شخصیتونو په اړه له ۱۲۰۰ څخه زیات کتابونه.',
    'browse_history' => 'د تاریخ کتابونه وګورئ →',
    'science' => 'ساینس',
    'science_desc' => 'د فزیک، کیمیا، بیولوژي او چاپېریالي علومو کې له ۹۰۰ څخه زیات کتابونه.',
    'browse_science' => 'د ساینس کتابونه وګورئ →',
    'cs' => 'کمپیوټر ساینس',
    'cs_desc' => 'د پروګرامینګ، شبکو، سایبري امنیت او مصنوعي هوښیارۍ په اړه له ۱۵۰۰ څخه زیات کتابونه.',
    'browse_cs' => 'د کمپیوټر کتابونه وګورئ →',
    'literature' => 'ادبیات',
    'literature_desc' => 'د نړۍ مشهور لیکوالانو ناولونه، شعرونه او ادبي نقدونه، له ۸۵۰ څخه زیات کتابونه.',
    'browse_lit' => 'ادبي کتابونه وګورئ →',
    'islamic' => 'اسلامي مطالعات',
    'islamic_desc' => 'قرآن، حدیث، فقه او اسلامي تاریخ په عربي، انګلیسي، پښتو او دري ژبو کې له ۱۰۰۰ څخه زیات کتابونه.',
    'browse_islamic' => 'اسلامي کتابونه وګورئ →',
    'economics' => 'اقتصاد او مدیریت',
    'economics_desc' => 'د اقتصاد، سوداګرۍ او مدیریت په اړه له ۷۰۰ څخه زیات کتابونه.',
    'browse_economics' => 'د اقتصاد کتابونه وګورئ →',
    'contact_us' => 'اړیکه ونیسئ',
    'email' => 'برېښنالیک: library@internationaluniv.edu',
    'phone' => 'تلیفون: +123 456 7890',
    'address' => 'پته: پوهنتون سړک، ښار، هېواد',
    'footer' => '&copy; ۲۰۲۵ د نړیوال پوهنتون برېښنايي کتابتون. ټول حقوق خوندي دي.',
    'lang_ps' => 'پښتو',
    'lang_fa' => 'دری',
    'lang_en' => 'English',
  ],
  'fa' => [
    'title' => 'کتابخانه الکترونیکی پوهنتون بین‌المللی',
    'site_title' => 'کتابخانه الکترونیکی پوهنتون تعلیم و تربیه کابل',
    'home' => 'خانه',
    'services' => 'خدمات',
    'books' => 'کتاب‌ها',
    'contact' => 'تماس',
    'welcome' => 'به کتابخانه دیجیتال خوش آمدید',
    'welcome_desc' => 'هزاران منبع علمی، ژورنال و کتاب الکترونیکی را هر زمان و هر مکان دسترسی داشته باشید.',
    'explore_books' => 'کتاب‌ها را ببینید',
    'usage_title' => 'چگونه از کتابخانه الکترونیکی استفاده کنیم',
    'usage_desc' => 'کتابخانه الکترونیکی ما یک پلتفرم آسان و کاربرپسند برای دسترسی به منابع علمی مختلف فراهم می‌کند. چه دانشجو، استاد یا پژوهشگر باشید، اینجا نحوه استفاده از کتابخانه دیجیتال ما آمده است.',
    'register' => '۱. ثبت‌نام و ورود',
    'register_desc' => 'برای دسترسی به محتوای اختصاصی و امکانات شخصی، باید حساب کاربری ایجاد کنید. پس از ثبت‌نام، فقط وارد شوید و کتاب‌های مورد علاقه خود را جستجو و ذخیره کنید و پیشنهادات مرتبط دریافت نمایید.',
    'search' => '۲. جستجوی کتاب‌ها',
    'search_desc' => 'از نوار جستجو برای یافتن کتاب‌ها، مقالات یا منابع علمی دیگر استفاده کنید. می‌توانید بر اساس عنوان، نویسنده یا کلیدواژه جستجو کنید.',
    'browse' => '۳. مرور بر اساس دسته‌بندی',
    'browse_desc' => 'مجموعه گسترده ما بر اساس موضوعاتی مانند کامپیوتر، تاریخ، ادبیات و غیره دسته‌بندی شده است. منابع مرتبط با حوزه علاقه خود را بیابید.',
    'download' => '۴. دانلود یا مطالعه آنلاین',
    'download_desc' => 'پس از یافتن کتاب، می‌توانید آن را دانلود کنید یا مستقیماً از مرورگر خود به صورت آنلاین مطالعه نمایید.',
    'anywhere' => '۵. دسترسی از هر جا',
    'anywhere_desc' => 'کتابخانه الکترونیکی ما ۲۴ ساعته فعال است، بنابراین می‌توانید هر زمان و هر جا مطالعه یا تحقیق کنید.',
    'updated' => '۶. با تازه‌ها به‌روز باشید',
    'updated_desc' => 'برای اطلاع از کتاب‌ها، ژورنال‌ها و منابع جدید، خبرنامه ما را مشترک شوید یا بخش "تازه‌ها" را ببینید.',
    'start_exploring' => 'اکنون از کتابخانه استفاده کنید',
    'slideshow' => 'اسلایدشو',
    'our_services' => 'خدمات ما',
    'ebooks' => 'کتاب‌های الکترونیکی',
    'ebooks_desc' => 'به مجموعه‌ای گسترده از کتاب‌های الکترونیکی در رشته‌های مختلف دسترسی داشته باشید.',
    'journals' => 'ژورنال‌های پژوهشی',
    'journals_desc' => 'با جدیدترین پژوهش‌های علمی از ژورنال‌های برتر به‌روز باشید.',
    'support' => 'پشتیبانی آنلاین',
    'support_desc' => 'از کتابداران ما از طریق چت و ایمیل کمک بگیرید.',
    'gallery' => 'گالری',
    'explore_collection' => 'مجموعه ما را ببینید',
    'history' => 'تاریخ',
    'history_desc' => 'با بیش از <strong>۱۲۰۰ کتاب</strong> درباره تاریخ جهان، تمدن‌ها و شخصیت‌های تاریخی آشنا شوید.',
    'browse_history' => 'کتاب‌های تاریخ →',
    'science' => 'علوم',
    'science_desc' => 'بیش از <strong>۹۰۰ کتاب</strong> در فیزیک، شیمی، زیست‌شناسی و علوم محیط زیست برای دانشجویان و پژوهشگران.',
    'browse_science' => 'کتاب‌های علوم →',
    'cs' => 'کمپیوتر',
    'cs_desc' => 'به بیش از <strong>۱۵۰۰ عنوان</strong> درباره برنامه‌نویسی، شبکه، امنیت سایبری و هوش مصنوعی دسترسی داشته باشید.',
    'browse_cs' => 'کتاب‌های کمپیوتر →',
    'literature' => 'ادبیات',
    'literature_desc' => 'از بیش از <strong>۸۵۰ کتاب</strong> نویسندگان مشهور جهان، شامل رمان، شعر و نقد ادبی لذت ببرید.',
    'browse_lit' => 'کتاب‌های ادبیات →',
    'islamic' => 'مطالعات اسلامی',
    'islamic_desc' => 'بیش از <strong>۱۰۰۰ کتاب</strong> درباره قرآن، حدیث، فقه و تاریخ اسلام به زبان‌های عربی، انگلیسی، پشتو و دری.',
    'browse_islamic' => 'کتاب‌های اسلامی →',
    'economics' => 'اقتصاد و مدیریت',
    'economics_desc' => 'بیش از <strong>۷۰۰ کتاب</strong> درباره اقتصاد خرد و کلان، استراتژی‌های کسب‌وکار و مدیریت.',
    'browse_economics' => 'کتاب‌های اقتصاد →',
    'contact_us' => 'تماس با ما',
    'email' => 'ایمیل: library@internationaluniv.edu',
    'phone' => 'تلفن: +123 456 7890',
    'address' => 'آدرس: سرک پوهنتون، شهر، کشور',
    'footer' => '&copy; ۲۰۲۵ کتابخانه الکترونیکی پوهنتون بین‌المللی. همه حقوق محفوظ است.',
    'lang_ps' => 'پښتو',
    'lang_fa' => 'دری',
    'lang_en' => 'English',
  ],
];
$t = $texts[$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $t['title'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800" <?= $lang === 'ps' ? 'dir="rtl" style="font-family: Tahoma, Arial, sans-serif;"' : ($lang === 'fa' ? 'dir="rtl" style="font-family: Tahoma, Arial, sans-serif;"' : '') ?>>

<!-- Language Switcher -->
<div class="flex justify-end space-x-2 p-2 bg-blue-50">
  <a href="?lang=ps" class="px-2 py-1 bg-blue-700 text-white rounded"><?= $t['lang_ps'] ?></a>
  <a href="?lang=fa" class="px-2 py-1 bg-blue-700 text-white rounded"><?= $t['lang_fa'] ?></a>
  <a href="?lang=en" class="px-2 py-1 bg-blue-700 text-white rounded"><?= $t['lang_en'] ?></a>
</div>


<!-- Navbar -->
<header class="bg-blue-800 text-white shadow">
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold"><?= $t['site_title'] ?></h1>
      <div class="md:hidden">
        <button id="menu-toggle" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      <nav class="hidden md:flex space-x-4 items-center">
        <a href="#" class="hover:text-yellow-300"><?= $t['home'] ?></a>
        <a href="#services" class="hover:text-yellow-300"><?= $t['services'] ?></a>
        <a href="#books" class="hover:text-yellow-300"><?= $t['books'] ?></a>
        <a href="#contact" class="hover:text-yellow-300"><?= $t['contact'] ?></a>
        <a href="login.php" class="bg-white text-blue-800 px-3 py-1 rounded hover:bg-blue-100 transition"><?= ($lang === 'ps' ? 'ننوتل' : ($lang === 'fa' ? 'ورود' : 'Login')) ?></a>
        <a href="" class="bg-yellow-400 text-blue-900 px-3 py-1 rounded hover:bg-yellow-300 transition"><?= ($lang === 'ps' ? 'ثبت نام' : ($lang === 'fa' ? 'ثبت‌نام' : 'Register')) ?></a>
      </nav>
    </div>
    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="hidden flex-col mt-4 space-y-2 md:hidden bg-blue-700 rounded p-4">
      <a href="#" class="block py-1 px-2 rounded hover:bg-blue-600"><?= $t['home'] ?></a>
      <a href="#services" class="block py-1 px-2 rounded hover:bg-blue-600"><?= $t['services'] ?></a>
      <a href="#books" class="block py-1 px-2 rounded hover:bg-blue-600"><?= $t['books'] ?></a>
      <a href="#contact" class="block py-1 px-2 rounded hover:bg-blue-600"><?= $t['contact'] ?></a>
      <a href="login.php" class="block py-1 px-2 rounded bg-white text-blue-800 hover:bg-blue-100"><?= ($lang === 'ps' ? 'ننوتل' : ($lang === 'fa' ? 'ورود' : 'Login')) ?></a>
      <a href="register.php" class="block py-1 px-2 rounded bg-yellow-400 text-blue-900 hover:bg-yellow-300"><?= ($lang === 'ps' ? 'ثبت نام' : ($lang === 'fa' ? 'ثبت‌نام' : 'Register')) ?></a>
    </nav>
  </div>
</header>
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>

<!-- Hero Section -->
<section class="bg-white py-16 shadow">
  <div class="container mx-auto text-center">
    <h2 class="text-4xl font-bold mb-4"><?= $t['welcome'] ?></h2>
    <p class="text-lg text-gray-700"><?= $t['welcome_desc'] ?></p>
    <a href="#books" class="mt-6 inline-block bg-blue-700 hover:bg-blue-900 text-white font-semibold py-2 px-4 rounded"><?= $t['explore_books'] ?></a>
  </div>
</section>

<!-- Usage Section -->
<section id="usage" class="py-16 bg-gray-100">
  <div class="container mx-auto text-center">
    <h2 class="text-4xl font-bold mb-8"><?= $t['usage_title'] ?></h2>
    <p class="text-lg text-gray-600 mb-12"><?= $t['usage_desc'] ?></p>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
      <div class="bg-white rounded shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-4"><?= $t['register'] ?></h3>
        <p class="text-gray-700 mb-4"><?= $t['register_desc'] ?></p>
        <img src="https://via.placeholder.com/200" alt="Register and Login" class="w-full rounded-md">
      </div>
      <div class="bg-white rounded shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-4"><?= $t['search'] ?></h3>
        <p class="text-gray-700 mb-4"><?= $t['search_desc'] ?></p>
        <img src="https://via.placeholder.com/200" alt="Search for Books" class="w-full rounded-md">
      </div>
      <div class="bg-white rounded shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-4"><?= $t['browse'] ?></h3>
        <p class="text-gray-700 mb-4"><?= $t['browse_desc'] ?></p>
        <img src="https://via.placeholder.com/200" alt="Browse by Category" class="w-full rounded-md">
      </div>
      <div class="bg-white rounded shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-4"><?= $t['download'] ?></h3>
        <p class="text-gray-700 mb-4"><?= $t['download_desc'] ?></p>
        <img src="https://via.placeholder.com/200" alt="Download or Read Online" class="w-full rounded-md">
      </div>
      <div class="bg-white rounded shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-4"><?= $t['anywhere'] ?></h3>
        <p class="text-gray-700 mb-4"><?= $t['anywhere_desc'] ?></p>
        <img src="https://via.placeholder.com/200" alt="Access from Anywhere" class="w-full rounded-md">
      </div>
      <div class="bg-white rounded shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-4"><?= $t['updated'] ?></h3>
        <p class="text-gray-700 mb-4"><?= $t['updated_desc'] ?></p>
        <img src="https://via.placeholder.com/200" alt="Stay Updated" class="w-full rounded-md">
      </div>
    </div>
    <div class="mt-12">
      <a href="#books" class="px-8 py-3 bg-blue-800 text-white rounded-lg text-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        <?= $t['start_exploring'] ?>
      </a>
    </div>
  </div>
</section>



<!-- Services Section -->
<section id="services" class="py-16 bg-gray-50">
  <div class="container mx-auto text-center">
    <h3 class="text-3xl font-bold mb-12"><?= $t['our_services'] ?></h3>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-white p-6 rounded shadow hover:shadow-lg">
        <h4 class="text-xl font-bold mb-2"><?= $t['ebooks'] ?></h4>
        <p><?= $t['ebooks_desc'] ?></p>
      </div>
      <div class="bg-white p-6 rounded shadow hover:shadow-lg">
        <h4 class="text-xl font-bold mb-2"><?= $t['journals'] ?></h4>
        <p><?= $t['journals_desc'] ?></p>
      </div>
      <div class="bg-white p-6 rounded shadow hover:shadow-lg">
        <h4 class="text-xl font-bold mb-2"><?= $t['support'] ?></h4>
        <p><?= $t['support_desc'] ?></p>
      </div>
    </div>
  </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="py-16 bg-gray-50">
  <div class="container mx-auto text-center">
    <h3 class="text-3xl font-bold mb-8"><?= $t['gallery'] ?></h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <img src="image/b.jpg" alt="Gallery 1" class="rounded shadow">
      <img src="image/b1.jpg" alt="Gallery 2" class="rounded shadow">
      <img src="image/b2.jpg" alt="Gallery 3" class="rounded shadow">
      <img src="image/g3.jpeg" alt="Gallery 4" class="rounded shadow">
      <img src="image/g4.jpeg" alt="Gallery 5" class="rounded shadow">
      <img src="image/g5.jpeg" alt="Gallery 6" class="rounded shadow">
      <img src="image/g6.jpeg" alt="Gallery 7" class="rounded shadow">
      <img src="image/g7.jpg" alt="Gallery 8" class="rounded shadow">
    </div>
  </div>
</section>

<!-- Explore Subjects Section -->
<section id="subjects" class="py-20 bg-gray-100">
  <div class="container mx-auto px-4">
    <h2 class="text-4xl font-bold text-center mb-12"><?= $t['explore_collection'] ?></h2>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2"><?= $t['history'] ?></h3>
        <p class="text-gray-600 mb-4"><?= $t['history_desc'] ?></p>
        <a href="#" class="text-blue-600 hover:underline"><?= $t['browse_history'] ?></a>
      </div>
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2"><?= $t['science'] ?></h3>
        <p class="text-gray-600 mb-4"><?= $t['science_desc'] ?></p>
        <a href="#" class="text-blue-600 hover:underline"><?= $t['browse_science'] ?></a>
      </div>
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2"><?= $t['cs'] ?></h3>
        <p class="text-gray-600 mb-4"><?= $t['cs_desc'] ?></p>
        <a href="#" class="text-blue-600 hover:underline"><?= $t['browse_cs'] ?></a>
      </div>
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2"><?= $t['literature'] ?></h3>
        <p class="text-gray-600 mb-4"><?= $t['literature_desc'] ?></p>
        <a href="#" class="text-blue-600 hover:underline"><?= $t['browse_lit'] ?></a>
      </div>
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2"><?= $t['islamic'] ?></h3>
        <p class="text-gray-600 mb-4"><?= $t['islamic_desc'] ?></p>
        <a href="#" class="text-blue-600 hover:underline"><?= $t['browse_islamic'] ?></a>
      </div>
      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
        <h3 class="text-2xl font-semibold mb-2"><?= $t['economics'] ?></h3>
        <p class="text-gray-600 mb-4"><?= $t['economics_desc'] ?></p>
        <a href="#" class="text-blue-600 hover:underline"><?= $t['browse_economics'] ?></a>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-16 bg-blue-50">
  <div class="container mx-auto text-center">
    <h3 class="text-3xl font-bold mb-6"><?= $t['contact_us'] ?></h3>
    <p><?= $t['email'] ?></p>
    <p><?= $t['phone'] ?></p>
    <p><?= $t['address'] ?></p>
  </div>
</section>
<?php
 
include
 
'back-to-top.html'
; 
?>

<!-- Footer -->
<footer class="bg-blue-800 text-white text-center py-4">
  <p><?= $t['footer'] ?></p>
</footer>
</body>
</html>