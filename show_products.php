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

// Tambahkan inisialisasi variabel $showModal sebelum digunakan
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

// Logika Fetch Produk dengan Pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :search");
    $stmt->execute(['search' => '%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM products");
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="bg-gradient-to-br from-pink-50 via-purple-100 to-pink-300 min-h-screen py-20 pt-30">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Search Bar -->
            <div class="mb-10" data-aos="fade-left">
                <form method="GET" action="" class="flex items-center justify-center">
                    <input type="text" name="search" placeholder="Cari produk..."
                        class="w-full lg:w-1/2 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-purple-200"
                        value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"
                        class="ml-4 px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold shadow-md hover:bg-purple-700 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php if (empty($products)): ?>
                    <p class="text-center text-gray-600 col-span-full">Produk tidak ditemukan.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col items-center p-4 hover:scale-105 transition-all duration-300">

                            <!-- Product Image with fixed height and consistent styling -->
                            <img src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-48 object-cover rounded-t-lg mb-4">

                            <div class="flex flex-col justify-between h-full w-full">

                                <!-- Product Title (Centered) -->
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 text-center">
                                    <?= htmlspecialchars($product['name']) ?></h3>

                                <!-- Product Description (Centered and trimmed) -->
                                <p class="text-sm text-gray-600 mb-4 text-center">
                                    <?= htmlspecialchars(substr($product['description'], 0, 80)) . (strlen($product['description']) > 80 ? '...' : '') ?>
                                </p>

                                <!-- Product Price and Add to Cart Button (Aligned at the bottom) -->
                                <div class="mt-auto flex items-center justify-between">
                                    <span class="text-lg font-bold text-purple-800">
                                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                    </span>
                                    <form method="POST" action="">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <button type="submit"
                                            class="bg-purple-600 text-white text-sm px-4 py-2 rounded-md shadow hover:bg-purple-700 transition">
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
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-80 text-center">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Berhasil Ditambahkan!</h2>
            <p class="text-gray-600">Produk <strong><?= htmlspecialchars($addedProductName) ?></strong> telah
                ditambahkan ke keranjang.</p>
            <button onclick="closeModal()"
                class="mt-6 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
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