<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'config/database.php';
include 'header_admin.php';

$orderId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data pesanan berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location.href = 'view_orders.php';</script>";
    exit;
}

// Ambil detail item pesanan dari tabel order_items
$stmtItems = $pdo->prepare("SELECT oi.*, p.name AS product_name FROM order_items oi
                            JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmtItems->execute([$orderId]);
$orderItems = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="bg-gradient-to-br from-pink-50 via-purple-100 to-pink-300 min-h-screen py-20 pt-30">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Judul Halaman -->
            <div class="text-center mb-10">
                <h2 class="text-5xl font-bold text-black">Detail Pesanan</h2>
                <p class="text-lg text-gray-600 mt-2">Lihat detail pesanan ID <?= htmlspecialchars($order['id']) ?></p>
            </div>

            <!-- Detail Pesanan -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Informasi Pesanan</h3>
                <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($order['name']) ?></p>
                <p><strong>Alamat Pengiriman:</strong> <?= htmlspecialchars($order['address']) ?></p>
                <p><strong>Nomor Telepon:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p><strong>Metode Pembayaran:</strong> <?= ucfirst($order['payment_method']) ?></p>
                <p><strong>Total Harga:</strong> Rp <?= number_format($order['total_price'], 0, ',', '.') ?></p>
                <p><strong>Tanggal Pemesanan:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
            </div>

            <!-- Tabel Detail Barang -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Detail Barang</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-left">
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Harga Satuan</th>
                            <th class="px-4 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orderItems)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-gray-600 py-4">Tidak ada barang dalam pesanan ini.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td class="px-4 py-3"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td class="px-4 py-3"><?= $item['quantity'] ?></td>
                                    <td class="px-4 py-3">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td class="px-4 py-3">Rp
                                        <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="text-right mt-6">
                    <a href="generate_pdf.php?id=<?= $order['id'] ?>" target="_blank"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                        Cetak PDF
                    </a>
                </div>

            </div>
        </div>
    </div>
</main>