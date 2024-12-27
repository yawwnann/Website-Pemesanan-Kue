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

    <!-- Box Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- Animasi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>

<body id="container" class="bg-yellow-50 mx-auto ">

    <header class="bg-white shadow-md fixed top-4 left-1/2 transform -translate-x-1/2 w-[90%] rounded-lg z-50">
        <div class="flex justify-between items-center px-6 py-4">
            <!-- Logo -->
            <div
                class="text-yellow-950 text-2xl font-bold hover:text-yellow-500 hover:scale-105 transform transition duration-300">
                Bakery Indonesia
            </div>

            <!-- Navigation Menu -->
            <nav class="flex space-x-6 text-gray-700 font-medium">
                <a href="index.php" class="hover:text-yellow-500 hover:scale-105 transition duration-300">Home</a>
                <a href="show_products.php"
                    class="hover:text-yellow-500 hover:scale-105 transition duration-300">Products</a>
                <a href="contact.php" class="hover:text-yellow-500 hover:scale-105 transition duration-300">Lokasi</a>
                <a href="pesanan_status.php"
                    class="hover:text-yellow-500 hover:scale-105 transition duration-300">Pesanan</a>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center ">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Tampilkan username jika login -->
                    <span class="text-gray-700 hover:text-yellow-500 hover:scale-105 font-medium transition duration-300">
                        Hello, <?= htmlspecialchars($_SESSION['user']['username']); ?>
                    </span>

                    <!-- Ikon Keranjang -->
                    <a href="keranjang.php"
                        class="text-gray-700 hover:text-yellow-500 hover:scale-105 font-medium transition duration-300">
                        <i class="bx bx-cart-alt text-2xl"></i> <!-- Ikon keranjang -->
                    </a>

                    <!-- Ikon Logout -->
                    <form action="logout.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                        <button type="submit"
                            class="text-gray-700 hover:text-red-500 hover:scale-105 font-medium transition duration-300">
                            <i class="bx bx-log-out text-2xl"></i> <!-- Ikon logout -->
                        </button>
                    </form>
                <?php else: ?>
                    <!-- Tampilkan Login/Register jika belum login -->
                    <a href="login.php"
                        class="text-gray-700 hover:text-yellow-500 hover:scale-105 font-medium transition duration-300">Login/Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script>
        AOS.init({
            duration: 1000,
            once: false,
            offset: 100,
            mirror: true,
        });
    </script>

</body>

</html>