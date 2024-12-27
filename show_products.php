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

$showModal = false; // Inisialisasi variabel

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

        $showModal = true; // Tampilkan modal
        $addedProductName = $product['name']; // Simpan nama produk untuk ditampilkan
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : ''; // Menangani parameter sort

// Menyusun query untuk pencarian dan pengurutan
$query = "SELECT * FROM products WHERE name LIKE :search";
$params = ['search' => '%' . $search . '%']; // Parameter pencarian

// Menambahkan pengurutan berdasarkan pilihan
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
$stmt->execute($params); // Eksekusi query dengan parameter yang sesuai
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="bg-gradient-to-br from-yellow-50 via-yellow-100 to-yellow-600 min-h-screen py-20 pt-30">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Search Bar and Sorting -->
            <div class="my-10 flex items-center justify-between space-x-2" data-aos="fade-left">
                <form method="GET" action="" class="flex items-center w-full lg:w-1/2">
                    <input type="text" name="search" placeholder="Cari produk..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-yellow-200"
                        value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"
                        class="ml-4 px-6 py-3 bg-yellow-900 text-white rounded-lg font-semibold shadow-md hover:bg-yellow-700 transition">
                        Cari
                    </button>
                </form>

                <div class="w-1/3">
                    <form method="GET" action="" class="flex justify-end">
                        <select name="sort_by"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-yellow-200">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="name_asc" <?= ($sortBy == 'name_asc') ? 'selected' : ''; ?>>Nama A-Z</option>
                            <option value="name_desc" <?= ($sortBy == 'name_desc') ? 'selected' : ''; ?>>Nama Z-A</option>
                            <option value="price_asc" <?= ($sortBy == 'price_asc') ? 'selected' : ''; ?>>Harga Rendah ke
                                Tinggi</option>
                            <option value="price_desc" <?= ($sortBy == 'price_desc') ? 'selected' : ''; ?>>Harga Tinggi ke
                                Rendah</option>
                        </select>
                        <button type="submit"
                            class="ml-2 px-6 py-3 bg-yellow-900 text-white rounded-lg font-semibold shadow-md hover:bg-yellow-700 transition">
                            Urutkan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php if (empty($products)): ?>
                    <p class="text-center text-gray-600 col-span-full" data-aos="fade-up">Produk tidak ditemukan.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col items-start p-6 hover:scale-105 transition-all duration-300"
                            data-aos="fade-up" data-aos-duration="1000">

                            <!-- Product Image with fixed height and consistent styling -->
                            <img src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-48 object-cover rounded-t-lg mb-4" data-aos="zoom-in" data-aos-duration="1000">

                            <div class="flex flex-col justify-between w-full">

                                <!-- Product Title (Centered) -->
                                <h3 class="text-lg font-semibold text-gray-800 " data-aos="fade-up" data-aos-duration="1000">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>

                                <!-- Product Description (Centered and trimmed) -->
                                <p class="text-sm text-gray-600 " data-aos="fade-up" data-aos-duration="1000">
                                    <?= htmlspecialchars(substr($product['description'], 0, 80)) . (strlen($product['description']) > 80 ? '...' : '') ?>
                                </p>

                                <!-- Product Price and Add to Cart Button (Aligned at the bottom) -->
                                <div class="mt-auto flex items-center justify-between w-full" data-aos="fade-up"
                                    data-aos-duration="1400">
                                    <span class="text-lg font-bold text-yellow-800">
                                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                    </span>
                                    <form method="POST" action="">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <button type="submit"
                                            class="bg-yellow-900 text-white text-sm px-4 py-2 rounded-md shadow hover:bg-yellow-950 transition"
                                            data-aos="zoom-in" data-aos-duration="1500">
                                            Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Modal Produk Ditambahkan -->
<?php if ($showModal): ?>
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" data-aos="fade-up"
        data-aos-duration="1500">
        <div class="bg-white rounded-lg shadow-lg p-6 w-80 text-center">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Berhasil Ditambahkan!</h2>
            <p class="text-gray-600">Produk <strong><?= htmlspecialchars($addedProductName) ?></strong> telah
                ditambahkan ke keranjang.</p>
            <button onclick="closeModal()"
                class="mt-6 bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                Tutup
            </button>
        </div>
    </div>
    <script>
        function closeModal() {
            document.getElementById('modal').remove();
        }
    </script>
<?php endif; ?>

<?php include 'footer.php'; ?>

<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        mirror: true,
    });
</script>