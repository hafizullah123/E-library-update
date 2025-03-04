<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Apply RTL styles */
        .rtl {
            direction: rtl;
            text-align: right;
        }
        .ltr {
            direction: ltr;
            text-align: left;
        }
        
        /* Adjust navbar spacing for RTL */
        .rtl .nav-links {
            direction: rtl;
            display: flex;
            gap: 16px;
        }
        .ltr .nav-links {
            direction: ltr;
            display: flex;
            gap: 16px;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-900 text-white p-4 flex justify-between items-center">
        <h1 id="title" class="text-2xl font-bold">Dashboard</h1>

        <div id="nav-links" class="nav-links">
            <a href="#" class="hover:underline" onclick="loadPage(event, 'add_book.php')" id="book">Book</a>
            <a href="#" class="hover:underline" onclick="loadPage(event, 'add_paper.php')" id="paper">Paper</a>
            <a href="#" class="hover:underline" onclick="loadPage(event, 'settings.php')" id="settings">Settings</a>
            <a href="logout.php" class="hover:underline text-red-400" id="logout">Logout</a>
        </div>

        <!-- Language Switcher -->
        <select id="language" onchange="changeLanguage()" class="p-2 border rounded text-black">
            <option value="en">English</option>
            <option value="ps">پښتو</option>
            <option value="fa">دری</option>
        </select>
    </nav>

    <!-- Main Content -->
    <main class="p-6" id="content">
        <h2 class="text-xl font-bold" id="dashboard">Welcome to the Dashboard</h2>
        <p id="welcome">Select an option from the navbar to view details.</p>
    </main>

    <script>
        function loadPage(event, page) {
            event.preventDefault(); // Prevent default navigation

            fetch(page)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("content").innerHTML = data;
                })
                .catch(error => console.error("Error loading page:", error));
        }

        // Language Translations
        const translations = {
            en: {
                title: "Dashboard",
                book: "Book",
                paper: "Paper",
                settings: "Settings",
                logout: "Logout",
                dashboard: "Welcome to the Dashboard",
                welcome: "Select an option from the navbar to view details.",
                direction: "ltr"
            },
            ps: {
                title: "ډشبورډ",
                book: "کتاب",
                paper: "مقاله",
                settings: "ترتیبات",
                logout: "وتل",
                dashboard: "ډشبورډ ته ښه راغلاست",
                welcome: "د پورتني مینو څخه یوه برخه وټاکئ.",
                direction: "rtl"
            },
            fa: {
                title: "داشبورد",
                book: "کتاب",
                paper: "مقاله",
                settings: "تنظیمات",
                logout: "خروج",
                dashboard: "به داشبورد خوش آمدید",
                welcome: "لطفاً از نوار منو یک گزینه را انتخاب کنید.",
                direction: "rtl"
            }
        };

        function changeLanguage() {
            let selectedLang = document.getElementById("language").value;
            localStorage.setItem("lang", selectedLang);
            applyLanguage(selectedLang);
        }

        function applyLanguage(lang) {
            document.getElementById("title").textContent = translations[lang].title;
            document.getElementById("book").textContent = translations[lang].book;
            document.getElementById("paper").textContent = translations[lang].paper;
            document.getElementById("settings").textContent = translations[lang].settings;
            document.getElementById("logout").textContent = translations[lang].logout;
            document.getElementById("dashboard").textContent = translations[lang].dashboard;
            document.getElementById("welcome").textContent = translations[lang].welcome;

            // Apply RTL for Pashto and Dari, LTR for English
            let dir = translations[lang].direction;
            document.documentElement.setAttribute("dir", dir);
            document.body.className = dir === "rtl" ? "rtl bg-gray-100" : "ltr bg-gray-100";

            // Adjust navbar direction
            document.getElementById("nav-links").className = dir === "rtl" ? "nav-links rtl" : "nav-links ltr";
        }

        // Apply saved language on page load
        document.addEventListener("DOMContentLoaded", function() {
            let savedLang = localStorage.getItem("lang") || "en";
            document.getElementById("language").value = savedLang;
            applyLanguage(savedLang);
        });
    </script>

</body>
</html>
