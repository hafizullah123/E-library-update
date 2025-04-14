<?php
session_start();

// Default language is English
$lang = $_GET['lang'] ?? 'en';
$_SESSION['lang'] = $lang;

switch ($lang) {
    case 'ps':
        $lang_file = 'locale_ps.php';
        $dir = 'rtl';
        break;
    case 'fa':
        $lang_file = 'locale_fa.php';
        $dir = 'rtl';
        break;
    default:
        $lang_file = 'locale_en.php';
        $dir = 'ltr';
        break;
}

$lang_file_path = "language/" . $lang_file;
if (file_exists($lang_file_path)) {
    $lang_arr = include_once($lang_file_path);
} else {
    die("Language file not found for {$_SESSION['lang']}.");
}

function translate($key) {
    global $lang_arr;
    return $lang_arr[$key] ?? '';
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= translate('page_title') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Noto Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans leading-relaxed">
  <!-- Header -->
  <header class="bg-blue-900 text-white py-6 border-b-4 border-blue-400">
    <div class="max-w-6xl mx-auto text-center px-4">
      <h1 class="text-3xl sm:text-4xl font-bold"><?= translate('library_name') ?></h1>
    </div>
  </header>

  <!-- Navigation -->
  <nav class="my-6 text-center">
    <ul class="flex justify-center flex-wrap gap-4 px-4">
      <li><a href="index.php" class="text-blue-900 font-semibold hover:underline"><?= translate('nav_home') ?></a></li>
      <li><a href="?lang=ps" class="text-blue-900 font-semibold hover:underline">پښتو</a></li>
      <li><a href="?lang=fa" class="text-blue-900 font-semibold hover:underline">دری</a></li>
      <li><a href="?lang=en" class="text-blue-900 font-semibold hover:underline">English</a></li>
    </ul>
  </nav>

  <!-- Content Box -->
  <main class="max-w-4xl mx-auto px-4">
    <div class="bg-white p-6 shadow-md rounded-lg">
      <h1 class="text-2xl font-bold mb-4"><?= translate('about_us') ?></h1>
      <p class="mb-4 text-justify"><?= translate('welcome_message') ?></p>

      <h2 class="text-xl font-semibold mb-2"><?= translate('mission_heading') ?></h2>
      <p class="mb-4 text-justify"><?= translate('mission_text') ?></p>

      <h2 class="text-xl font-semibold mb-2"><?= translate('what_we_offer') ?></h2>
      <ul class="list-disc list-inside mb-4 text-justify">
        <li><?= translate('extensive_collection') ?></li>
        <li><?= translate('programs_events') ?></li>
        <li><?= translate('support_guidance') ?></li>
      </ul>

      <h2 class="text-xl font-semibold mb-2"><?= translate('our_history') ?></h2>
      <p class="mb-4 text-justify"><?= translate('history_text') ?></p>

      <h2 class="text-xl font-semibold mb-2"><?= translate('get_involved') ?></h2>
      <ul class="list-disc list-inside mb-4 text-justify">
        <li><?= translate('membership') ?></li>
        <li><?= translate('volunteer') ?></li>
        <li><?= translate('donate') ?></li>
        <li><?= translate('friends_of_library') ?></li>
      </ul>

      <h2 class="text-xl font-semibold mb-2"><?= translate('visit_us') ?></h2>
      <p class="mb-2 text-justify"><?= translate('visit_text') ?></p>
      <p><strong><?= translate('location') ?>:</strong> <?= translate('location') ?></p>
      <p><strong><?= translate('hours') ?>:</strong> <?= translate('hours') ?></p>
      <p><strong><?= translate('contact') ?>:</strong> <?= translate('contact') ?></p>

      <!-- Team Section -->
      <h2 class="text-xl font-semibold mt-6 mb-4"><?= translate('meet_team') ?></h2>
      <div class="flex flex-wrap justify-center gap-6">
        <?php
          $team = [
            ['id' => 'member1', 'img' => 'image/ha.jpg', 'title' => 'library_manager', 'text' => 'manager_text'],
            ['id' => 'member2', 'img' => 'image/im.jpg', 'title' => 'head_librarian', 'text' => 'librarian_text'],
            ['id' => 'member3', 'img' => 'image/nur.jpg', 'title' => 'library_assistant', 'text' => 'assistant_text']
          ];
          foreach ($team as $member):
        ?>
        <div onclick="openPopup('<?= $member['id'] ?>')" class="bg-white p-4 rounded-lg shadow-md text-center w-64 cursor-pointer hover:scale-105 transition-transform duration-300">
          <img src="<?= $member['img'] ?>" alt="<?= translate($member['title']) ?>" class="rounded-full w-24 h-24 mx-auto mb-2 object-cover" />
          <h3 class="font-semibold text-lg"><?= translate($member['title']) ?></h3>
          <p class="text-gray-600 text-sm"><?= translate($member['text']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <!-- Team Popups -->
  <?php foreach ($team as $member): ?>
    <div id="<?= $member['id'] ?>-popup" class="popup fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
      <div class="popup-content bg-white p-6 rounded-lg max-w-xl mx-auto relative text-center">
        <span class="popup-close absolute top-2 right-4 text-gray-600 text-2xl cursor-pointer" onclick="closePopup('<?= $member['id'] ?>')">&times;</span>
        <img src="<?= $member['img'] ?>" alt="<?= translate($member['title']) ?>" class="rounded-full w-36 h-36 mx-auto mb-4 object-cover">
        <h2 class="text-xl font-semibold"><?= translate($member['title']) ?></h2>
        <p class="text-gray-700 mt-2"><?= translate($member['text']) ?></p>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 mt-8 border-t-4 border-blue-400">
    <div class="max-w-6xl mx-auto text-center">
      <p>&copy; <?= date('Y') ?> <?= translate('library_name') ?>. <?= translate('footer_text') ?></p>
    </div>
  </footer>

  <!-- Popup Script -->
  <script>
    function openPopup(id) {
      const popup = document.getElementById(id + '-popup');
      popup.classList.remove('hidden');
      popup.classList.add('flex');
    }

    function closePopup(id) {
      const popup = document.getElementById(id + '-popup');
      popup.classList.remove('flex');
      popup.classList.add('hidden');
    }
  </script>
</body>
</html>
