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
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- Tambahkan Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- animasi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</head>

<body id="container" class="bg-pink-50">
    <header class="bg-white shadow-md fixed top-4 left-1/2 transform -translate-x-1/2 w-[90%] rounded-lg z-50">
        <div class="flex justify-between items-center px-6 py-4">
            <!-- Logo -->
            <div class="text-purple-600 text-2xl font-bold">
                Bakery Indonesia
            </div>

            <!-- Navigation Menu -->
            <nav class="flex space-x-6 text-gray-700 font-medium">
                <a href="products.php" class="hover:text-purple-500">Data Produk</a>
                <a href="view_orders.php" class="hover:text-purple-500">Pesanan</a>

            </nav>

            <!-- Right Section -->
            <div class="flex items-center space-x-6">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Tampilkan username jika login -->
                    <span class="text-gray-700 hover:text-purple-500 font-medium">
                        Hello, <?= htmlspecialchars($_SESSION['user']['username']); ?>
                    </span>
                    <a href="logout.php" class="text-gray-700 hover:text-red-500 font-medium">Logout</a>
                <?php else: ?>
                    <!-- Tampilkan Login/Register jika belum login -->
                    <a href="login.php" class="text-gray-700 hover:text-purple-500 font-medium">Login/Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>