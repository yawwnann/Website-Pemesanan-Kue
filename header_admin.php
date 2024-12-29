<?php
// Start output buffering to prevent the "headers already sent" error
ob_start();

// Ensure session is started before any output is sent
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect user if not logged in or not an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect to login page if not logged in or not an admin
    header('Location: login.php');
    exit; // Always call exit after header redirection
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
    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- Animasi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        /* Sidebar styles */
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
            font-weight: bold;
            color: #f59e0b;
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar .logo:hover {
            color: #d97706;
            transform: scale(1.05);
        }

        /* Navigation links */
        .sidebar a {
            display: block;
            padding: 14px 18px;
            color: #4B5563;
            font-size: 18px;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
        }

        /* Hover effect to match active state */
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #f59e0b;
            color: white;
            transform: scale(1.05);
            width: 100%;
        }

        /* Active state to make it fill the sidebar width */
        .sidebar a.active {
            background-color: #f59e0b;
            color: white;
            transform: scale(1.05);
            width: 100%;
        }

        .sidebar .user-info {
            position: absolute;
            bottom: 30px;
            width: 100%;
            padding-left: 20px;
            padding-right: 20px;
        }

        .sidebar .user-info span {
            display: block;
            color: #4B5563;
            font-size: 16px;
            margin-bottom: 8px;
            text-align: center;
        }

        .sidebar .user-info a {
            display: block;
            text-align: center;
            padding: 10px;
            color: #4B5563;
            border-radius: 8px;
            background-color: #f9fafb;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .sidebar .user-info a:hover {
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

<body class="bg-yellow-50 mx-auto">

    <div class="sidebar">
        <!-- Logo -->
        <div class="logo">
            Bakery Indonesia
        </div>

        <!-- Navigation Menu -->
        <nav class="flex flex-col items-start"> <!-- space-y-2 reduces the gap between items -->
            <a href="statistik.php" class="<?= ($current_page == 'statistik.php') ? 'active' : '' ?>">Statistik</a>
            <a href="products.php" class="<?= ($current_page == 'products.php') ? 'active' : '' ?>">Data Produk</a>
            <a href="view_orders.php" class="<?= ($current_page == 'view_orders.php') ? 'active' : '' ?>">Pesanan</a>
            <a href="add_product.php" class="<?= ($current_page == 'add_product.php') ? 'active' : '' ?>">Tambah
                Produk</a>
        </nav>

        <!-- User Info Section -->
        <div class="user-info">
            <?php if (isset($_SESSION['user'])): ?>
                <span>Hello, <?= htmlspecialchars($_SESSION['user']['username']); ?></span>
                <!-- Logout Form -->
                <form action="logout.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                    <button type="submit"
                        class="w-full py-2 text-gray-700 font-medium transition duration-300">Logout</button>
                </form>
            <?php else: ?>
                <a href="login.php">Login/Register</a>
            <?php endif; ?>
        </div>
    </div>

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