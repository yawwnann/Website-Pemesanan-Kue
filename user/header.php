<?php
ob_start(); // Menangguhkan output
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Memulai sesi jika belum dimulai
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Roti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/tailwind.css">

    <!-- Box Icon - hanya menggunakan satu link untuk Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- Animasi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Snap Midtrans -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-PEVLiowZwZNrnJPX"></script>

    <style>
        .underline-animation {
            position: relative;
            display: inline-block;
            color: #4B5563;
        }

        .underline-animation::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #f59e0b;
            transition: width 0.3s ease-in-out;
        }

        .underline-animation:hover::after,
        .underline-animation.active::after {
            width: 100%;
        }

        .underline-animation:hover,
        .underline-animation.active {
            color: #f59e0b;
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .modal-button {
            background-color: #f59e0b;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-button:hover {
            background-color: #d97706;
        }
    </style>

</head>

<body id="container" class="bg-yellow-50 mx-auto ">

    <header class="bg-white shadow-md fixed top-4 left-1/2 transform -translate-x-1/2 w-[90%] rounded-lg z-50">
        <div class="flex justify-between items-center px-6 py-4">
            <div
                class="text-yellow-950 text-2xl font-bold hover:text-yellow-500 hover:scale-105 transform transition duration-300">
                Bakery Indonesia
            </div>
            <nav class="flex space-x-6 text-gray-700 font-medium">
                <!-- ternary operator -->
                <a href="index.php"
                    class="underline-animation <?= ($current_page == 'index.php') ? 'active' : '' ?> hover:text-yellow-500 hover:scale-105 transition duration-300">Home</a>
                <a href="show_products.php"
                    class="underline-animation <?= ($current_page == 'show_products.php') ? 'active' : '' ?> hover:text-yellow-500 hover:scale-105 transition duration-300">Produk</a>
                <a href="contact.php"
                    class="underline-animation <?= ($current_page == 'contact.php') ? 'active' : '' ?> hover:text-yellow-500 hover:scale-105 transition duration-300">Lokasi</a>
                <a href="pesanan_status.php"
                    class="underline-animation <?= ($current_page == 'pesanan_status.php') ? 'active' : '' ?> hover:text-yellow-500 hover:scale-105 transition duration-300">Pesanan</a>
            </nav>

            <div class="flex items-center ">
                <?php if (isset($_SESSION['user'])): ?>
                        <span class="text-gray-700 hover:text-yellow-500 hover:scale-105 font-medium transition duration-300">
                            Hello, <?= htmlspecialchars($_SESSION['user']['username']); ?>
                        </span>

                        <!-- Keranjang dengan indikator jumlah item -->
                        <a href="keranjang.php"
                            class="relative text-gray-700 hover:text-yellow-500 hover:scale-105 font-medium transition duration-300">
                            <i class="bx bx-cart-alt text-2xl"></i>
                            <?php if (isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0): ?>
                                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                        <?= $_SESSION['cart_count'] ?>
                                    </span>
                            <?php endif; ?>
                        </a>

                        <!-- Logout Button -->
                        <button id="logoutBtn"
                            class="text-gray-700 hover:text-red-500 hover:scale-105 font-medium transition duration-300">
                            <i class="bx bx-log-out text-2xl"></i>
                        </button>

                <?php else: ?>

                        <a href="login.php"
                            class="text-gray-700 hover:text-yellow-500 hover:scale-105 font-medium transition duration-300">Login/Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Modal Logout -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h2 class="text-lg font-bold mb-4">Apakah Anda yakin ingin logout?</h2>
            <form action="../logout.php" method="POST">
                <button type="submit" class="modal-button">Logout</button>
            </form>
            <button id="closeModalBtn" class="modal-button bg-gray-500 hover:bg-gray-600">Batal</button>
        </div>
    </div>

    <script>
        const logoutBtn = document.getElementById("logoutBtn");
        const logoutModal = document.getElementById("logoutModal");
        const closeModalBtn = document.getElementById("closeModalBtn");

        // Menampilkan modal
        logoutBtn.addEventListener("click", () => {
            logoutModal.style.display = "flex";
        });

        // Menutup modal
        closeModalBtn.addEventListener("click", () => {
            logoutModal.style.display = "none";
        });

        // Menutup modal jika klik di luar area modal
        window.addEventListener("click", (event) => {
            if (event.target === logoutModal) {
                logoutModal.style.display = "none";
            }
        });
    </script>

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

<?php
ob_end_flush(); // Mengirimkan output yang tertunda
?>
