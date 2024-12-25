<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Mulai sesi hanya jika belum aktif
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Roti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/tailwind.css">

    <!-- box icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- Tambahkan Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- animasi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</head>

<body id="container" class="bg-pink-50 mx-auto ">
    <header class="bg-white shadow-md fixed top-4 left-1/2 transform -translate-x-1/2 w-[90%] rounded-lg z-50">
        <div class="flex justify-between items-center px-6 py-4">
            <!-- Logo -->
            <div class="text-purple-600 text-2xl font-bold">
                Bakery Indonesia
            </div>

            <!-- Navigation Menu -->
            <nav class="flex space-x-6 text-gray-700 font-medium">
                <a href="index.php" class="hover:text-purple-500">Home</a>
                <a href="show_products.php" class="hover:text-purple-500">Products</a>
                <a href="#" class="hover:text-purple-500">Lokasi</a>
                <a href="keranjang.php" class="hover:text-purple-500">Keranjang</a>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center space-x-6">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Tampilkan username jika login -->
                    <span class="text-gray-700 hover:text-purple-500 font-medium">
                        Hello, <?= htmlspecialchars($_SESSION['user']['username']); ?>
                    </span>
                    <button id="logoutButton" class="text-gray-700 hover:text-red-500 font-medium">Logout</button>
                <?php else: ?>
                    <!-- Tampilkan Login/Register jika belum login -->
                    <a href="login.php" class="text-gray-700 hover:text-purple-500 font-medium">Login/Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Modal Konfirmasi Logout -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Logout</h2>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin logout?</p>
            <div class="flex justify-end">
                <button id="cancelLogoutButton"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400 transition">
                    Batal
                </button>
                <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Logout
                </a>
            </div>
        </div>
    </div>


    <script>
        const logoutButton=document.getElementById('logoutButton');
        const logoutModal=document.getElementById('logoutModal');
        const cancelLogoutButton=document.getElementById('cancelLogoutButton');

        // Tampilkan modal saat tombol logout diklik
        logoutButton.addEventListener('click',() => {
            logoutModal.classList.remove('hidden');
        });

        // Sembunyikan modal saat tombol batal diklik
        cancelLogoutButton.addEventListener('click',() => {
            logoutModal.classList.add('hidden');
        });
    </script>