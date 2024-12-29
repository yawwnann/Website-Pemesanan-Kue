<?php
// Menghindari "headers already sent" error
ob_start();

// Memastikan session telah dimulai sebelum ada output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengalihkan pengguna jika tidak login atau bukan admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirect ke halaman login
    exit; // Menghentikan eksekusi setelah pengalihan
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
    <link rel="stylesheet" href="css/tailwind.css">

    <!-- Box Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Cart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Animasi AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background-color: #ffffff;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 50;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .sidebar .logo {
            font-size: 24px;
            text-align: center;
            font-weight: bold;
            color: rgb(0, 0, 0);
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            padding: 14px 18px;
            color: #4b5563;
            font-size: 18px;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
        }

        /* Hover effect for sidebar links */
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #f59e0b;
            color: white;
            transform: scale(1.05);
        }

        /* Styling user info section */
        .sidebar .user-info {
            position: absolute;
            bottom: 30px;
            width: 100%;
            padding-left: 20px;
            padding-right: 20px;
        }

        .sidebar .user-info span {
            display: block;
            color: #4b5563;
            font-size: 16px;
            margin-bottom: 8px;
            text-align: center;
        }

        /* Hover effect for the logout button */
        .sidebar .user-info a,
        .sidebar .user-info button {
            display: block;
            text-align: center;
            padding: 10px;
            color: #4b5563;
            border-radius: 8px;
            background-color: #f9fafb;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        /* Logout button hover effect */
        .sidebar .user-info a:hover,
        .sidebar .user-info button:hover {
            background-color: #f59e0b;
            color: white;
        }

        /* Content area */
        .content {
            margin-left: 240px;
            padding: 20px;
        }
    </style>

</head>

<body class="bg-neutral-100 mx-auto">

    <div class="sidebar">
        <!-- Logo -->
        <div class="logo ">
            Admin
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex flex-col items-start space-y-2">
            <a href="statistik.php" class="flex items-center <?= ($current_page == 'statistik.php') ? 'active' : '' ?>">
                <i class="fas fa-chart-line mr-3"></i> Statistik
            </a>

            <a href="products.php" class="flex items-center <?= ($current_page == 'products.php') ? 'active' : '' ?>">
                <i class="fas fa-box-open mr-3"></i> Data Produk
            </a>

            <a href="view_orders.php"
                class="flex items-center <?= ($current_page == 'view_orders.php') ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list mr-3"></i> Pesanan
            </a>

            <a href="add_product.php"
                class="flex items-center <?= ($current_page == 'add_product.php') ? 'active' : '' ?>">
                <i class="fas fa-plus-circle mr-3"></i> Tambah Produk
            </a>
        </nav>

        <!-- Tombol Logout -->
        <div class="user-info mt-4">
            <?php if (isset($_SESSION['user'])): ?>
                <form action="logout.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                    <button type="submit"
                        class="flex items-center w-full py-2 text-gray-700 font-medium transition duration-300">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            <?php else: ?>
                <a href="login.php" class="w-full py-2 text-gray-700 font-medium transition duration-300 flex items-center">
                    <i class="fas fa-sign-in-alt mr-3"></i> Login/Register
                </a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Inisialisasi AOS (Animation On Scroll)
        AOS.init({
            duration: 1000,
            once: false,
            offset: 100,
            mirror: true,
        });
    </script>