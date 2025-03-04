<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Sidebar & Content -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white p-5 space-y-6 hidden md:block">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <nav>
                <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Home</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Profile</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Settings</a>
                <a href="logout.php" class="block py-2 px-4 rounded bg-red-600 hover:bg-red-700">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <button class="md:hidden text-blue-900" onclick="toggleSidebar()">☰</button>
                <h2 class="text-xl font-semibold">Dashboard</h2>
                <span class="text-gray-600">Welcome, User</span>
            </header>

            <!-- Content -->
            <main class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold">Total Users</h3>
                        <p class="text-2xl font-bold">1,234</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold">Total Sales</h3>
                        <p class="text-2xl font-bold">$12,345</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold">New Orders</h3>
                        <p class="text-2xl font-bold">56</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar (Hidden by Default) -->
    <div id="mobileSidebar" class="fixed inset-0 bg-blue-900 text-white p-5 space-y-6 hidden md:hidden">
        <button class="text-white" onclick="toggleSidebar()">✖</button>
        <nav>
            <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Home</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Profile</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Settings</a>
            <a href="logout.php" class="block py-2 px-4 rounded bg-red-600 hover:bg-red-700">Logout</a>
        </nav>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("mobileSidebar").classList.toggle("hidden");
        }
    </script>

</body>
</html>
