<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Mulai sesi hanya jika belum aktif
}
include 'config/database.php';
include 'header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Ambil data dari keranjang
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Perbarui jumlah barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    }
    header("Location: keranjang.php");
    exit;
}

// Hapus barang
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    unset($_SESSION['cart'][$productId]);
    header("Location: keranjang.php");
    exit;
}

// Hitung total harga
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<main>
    <div class="bg-gradient-to-br from-pink-50 via-purple-100 to-pink-300 min-h-screen py-20 pt-30">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Judul Halaman -->
            <div class="text-center mb-10">
                <h2 class="text-5xl font-bold text-black">Keranjang Belanja</h2>
                <p class="text-lg text-gray-600 mt-2">Kelola barang yang ingin Anda beli.</p>
            </div>

            <!-- Tabel Keranjang -->
            <form action="keranjang.php" method="POST">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 text-left">
                                    <th class="px-4 py-3">Produk</th>
                                    <th class="px-4 py-3">Harga</th>
                                    <th class="px-4 py-3">Jumlah</th>
                                    <th class="px-4 py-3">Subtotal</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($cartItems)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-600 py-4">Keranjang Anda kosong.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($cartItems as $productId => $item): ?>
                                        <tr>
                                            <td class="px-4 py-3 flex items-center">
                                                <img src="<?= htmlspecialchars($item['image']) ?>"
                                                    alt="<?= htmlspecialchars($item['name']) ?>"
                                                    class="w-16 h-16 object-cover rounded-md mr-4">
                                                <span><?= htmlspecialchars($item['name']) ?></span>
                                            </td>
                                            <td class="px-4 py-3">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="quantity[<?= $productId ?>]"
                                                    value="<?= $item['quantity'] ?>" min="1"
                                                    class="w-16 border rounded-lg p-1 text-center">
                                            </td>
                                            <td class="px-4 py-3">Rp
                                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="keranjang.php?action=remove&id=<?= $productId ?>"
                                                    class="text-red-500 hover:underline">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($cartItems)): ?>
                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" name="update_cart"
                                class="bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700">
                                Perbarui Keranjang
                            </button>
                            <div class="font-bold text-lg">
                                Total: Rp <?= number_format($totalPrice, 0, ',', '.') ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (!empty($cartItems)): ?>
                <!-- Tombol Checkout -->
                <div class="flex justify-end mt-6">
                    <a href="checkout.php"
                        class="bg-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-purple-700 transition">
                        Lanjutkan ke Checkout
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>