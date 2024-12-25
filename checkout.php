<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/database.php';
include 'header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Ambil data dari keranjang
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Hitung total harga
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<main>
    <div class="bg-gradient-to-br from-pink-50 via-purple-100 to-pink-300 min-h-screen py-20 pt-30">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="text-center mb-10">
                <h2 class="text-5xl font-bold text-black">Checkout</h2>
                <p class="text-lg text-gray-600 mt-2">Selesaikan pesanan Anda dengan memasukkan detail pengiriman.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Bagian Ringkasan Pesanan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                    <div class="space-y-4">
                        <?php if (empty($cartItems)): ?>
                            <p class="text-gray-600">Keranjang Anda kosong.</p>
                        <?php else: ?>
                            <?php foreach ($cartItems as $item): ?>
                                <div class="flex items-center space-x-4">
                                    <img src="<?= htmlspecialchars($item['image']) ?>"
                                        alt="<?= htmlspecialchars($item['name']) ?>" class="w-16 h-16 object-cover rounded-md">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($item['name']) ?>
                                        </h4>
                                        <p class="text-sm text-gray-600">Jumlah: <?= $item['quantity'] ?></p>
                                        <p class="text-sm text-gray-600">Subtotal: Rp
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <hr class="my-4">
                    <div class="flex justify-between items-center font-bold text-lg">
                        <span>Total:</span>
                        <span>Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                    </div>
                </div>

                <!-- Form Informasi Pengiriman -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Informasi Pengiriman</h3>
                    <form action="process_checkout.php" method="POST">
                        <div class="mb-4">
                            <label class="block text-gray-600 font-medium">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-purple-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-medium">Alamat Pengiriman</label>
                            <textarea name="address" required
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-purple-200"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-medium">Nomor Telepon</label>
                            <input type="text" name="phone" required
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-purple-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-medium">Metode Pembayaran</label>
                            <select name="payment_method" required
                                class="w-full border border-gray-300 p-3 rounded-lg focus:ring focus:ring-purple-200">
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="credit_card">Kartu Kredit</option>
                                <option value="ewallet">E-Wallet</option>
                                <option value="cod">Bayar di Tempat (COD)</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold shadow-lg hover:bg-purple-700 transition">
                            Proses Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>