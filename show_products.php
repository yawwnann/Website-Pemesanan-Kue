<?php

include 'config/database.php';
include 'header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$showMessage = false;
$addedProductName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $cartItem = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1,
            'image' => $product['image'],
        ];

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $cartItem['id']) {

                $item['quantity']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $cartItem;
        }

        // Mengirimkan nama produk yang berhasil ditambahkan ke keranjang jika permintaan AJAX
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo htmlspecialchars($product['name']);
            exit;
        }

        $showMessage = true;
        $addedProductName = $product['name'];
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Query untuk pencarian dan pengurutan produk
$query = "SELECT * FROM products WHERE name LIKE :search";
$params = ['search' => '%' . $search . '%'];

if ($categoryFilter) {
    $query .= " AND category = :category";
    $params['category'] = $categoryFilter;
}

if (!empty($sortBy)) {
    if ($sortBy == 'name_asc') {
        $query .= " ORDER BY name ASC";
    } elseif ($sortBy == 'name_desc') {
        $query .= " ORDER BY name DESC";
    } elseif ($sortBy == 'price_asc') {
        $query .= " ORDER BY price ASC";
    } elseif ($sortBy == 'price_desc') {
        $query .= " ORDER BY price DESC";
    }
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="min-h-screen py-20">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Search Bar, Filter, and Sort -->
            <div class="my-10 flex flex-col lg:flex-row items-center justify-between space-y-4 lg:space-y-0 lg:space-x-6"
                data-aos="fade-left">
                <form method="GET" action="" class="flex items-center w-full lg:w-2/5 space-x-2">
                    <input type="text" name="search" placeholder="Cari produk..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-yellow-200"
                        value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"
                        class="flex items-center px-6 py-3 bg-yellow-900 text-white rounded-lg font-semibold shadow-md hover:bg-yellow-700 transition">
                        <i class="fas fa-search"></i> <!-- Search Icon inside button -->
                        <span>Cari</span>
                    </button>
                </form>

                <div class="flex space-x-2">
                    <!-- Filter -->
                    <button id="filterButton"
                        class="px-6 py-3 bg-yellow-900 text-white rounded-lg font-semibold shadow-md hover:bg-yellow-700 transition">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>

                    <!-- Sort -->
                    <button id="sortButton"
                        class="px-6 py-3 bg-yellow-900 text-white rounded-lg font-semibold shadow-md hover:bg-yellow-700 transition">
                        <i class="fas fa-sort mr-2"></i> Urutkan
                    </button>
                </div>
            </div>

            <div id="filterDropdown" class="hidden mb-6">
                <form method="GET" action="" class="flex w-full space-x-2">
                    <select name="category" onchange="this.form.submit()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-yellow-200">
                        <option value="">Pilih Kategori</option>
                        <option value="Kue" <?= ($categoryFilter == 'Kue') ? 'selected' : ''; ?>>Kue</option>
                        <option value="Roti" <?= ($categoryFilter == 'Roti') ? 'selected' : ''; ?>>Roti</option>
                    </select>
                </form>
            </div>

            <div id="sortDropdown" class="hidden mb-6">
                <form method="GET" action="" class="flex flex-1 justify-between space-x-2">
                    <select name="sort_by" onchange="this.form.submit()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-yellow-200">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="name_asc" <?= ($sortBy == 'name_asc') ? 'selected' : ''; ?>>Nama A-Z</option>
                        <option value="name_desc" <?= ($sortBy == 'name_desc') ? 'selected' : ''; ?>>Nama Z-A</option>
                        <option value="price_asc" <?= ($sortBy == 'price_asc') ? 'selected' : ''; ?>>Harga Rendah ke Tinggi
                        </option>
                        <option value="price_desc" <?= ($sortBy == 'price_desc') ? 'selected' : ''; ?>>Harga Tinggi ke
                            Rendah</option>
                    </select>
                </form>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php if (empty($products)): ?>
                    <p class="text-center text-gray-600 col-span-full" data-aos="fade-up">Produk tidak ditemukan.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col items-start p-6 hover:scale-105 transition-all duration-300"
                            data-aos="fade-up" data-aos-duration="500">
                            <img src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-48 object-cover rounded-t-lg mb-4" data-aos="zoom-in" data-aos-duration="500">

                            <div class="flex flex-col justify-between w-full">

                                <h3 class="text-lg font-semibold text-gray-800 " data-aos="fade-up" data-aos-duration="500">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>
                                <p class="text-sm text-gray-600 " data-aos="fade-up" data-aos-duration="500">
                                    <?= htmlspecialchars(substr($product['description'], 0, 80)) . (strlen($product['description']) > 80 ? '...' : '') ?>
                                </p>

                                <div class="mt-auto flex items-center justify-between w-full">
                                    <span class="text-lg font-bold text-yellow-800">
                                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                    </span>
                                    <button type="button" onclick="addToCart(<?= $product['id'] ?>)"
                                        class="bg-yellow-900 text-white text-sm px-4 py-2 rounded-md shadow hover:bg-yellow-950 transition">
                                        <i class="fas fa-cart-plus"></i> Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pesan Berhasil Ditambahkan -->
            <?php if ($showMessage): ?>
                <div id="successMessage" class="bg-green-200 p-4 rounded-lg mt-4">
                    <p class="text-green-800">Produk <strong><?= htmlspecialchars($addedProductName) ?></strong> telah
                        berhasil ditambahkan ke keranjang.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
    // Fungsi untuk menambahkan produk ke keranjang
    function addToCart(productId) {
        const formData=new FormData();
        formData.append('product_id',productId);

        fetch('',{
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if(data) {
                    // Tampilkan pesan bahwa produk telah berhasil ditambahkan ke keranjang
                    const successMessage=document.getElementById('successMessage');
                    successMessage.style.display='block';
                    successMessage.querySelector('p').textContent='Produk '+data+' telah berhasil ditambahkan ke keranjang.';
                }
            })
            .catch(error => console.error('Error:',error));
    }
</script>

<script>
    AOS.init({
        duration: 300,
        once: true,
        offset: 100,
        mirror: true,
    });

    // Show filter and sort dropdowns when buttons are clicked
    document.getElementById('filterButton').addEventListener('click',function() {
        document.getElementById('filterDropdown').classList.toggle('hidden');
    });

    document.getElementById('sortButton').addEventListener('click',function() {
        document.getElementById('sortDropdown').classList.toggle('hidden');
    });
</script>