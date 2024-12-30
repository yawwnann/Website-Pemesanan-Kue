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

$userId = $_SESSION['user']['id'];

$orderId = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if ($orderId) {
    $query = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $query->execute([$orderId, $userId]);
    $order = $query->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $itemQuery = $pdo->prepare("SELECT oi.*, p.name AS product_name, p.image, p.price 
                                    FROM order_items oi
                                    JOIN products p ON oi.product_id = p.id
                                    WHERE oi.order_id = ?");
        $itemQuery->execute([$orderId]);
        $items = $itemQuery->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    header('Location: pesanan_status.php');
    exit;
}
?>

<main>
    <div class="min-h-screen mt-20 py-20">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="text-center mb-10">
                <h2 class="text-5xl font-bold text-black">Detail Pesanan</h2>
                <p class="text-lg text-gray-900 mt-2">Informasi lengkap tentang pesanan Anda.</p>
            </div>

            <?php if ($order): ?>
                <div class="mb-6">
                    <a href="pesanan_status.php"
                        class="inline-block px-6 py-2 text-white bg-yellow-600 hover:bg-yellow-700 rounded-lg shadow-md">
                        &larr; Kembali ke Daftar Pesanan
                    </a>
                </div>

                <!-- Detail Pesanan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-4">Informasi Pesanan</h3>
                        <table class="w-full border-collapse">
                            <tbody>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-bold bg-gray-100">ID Pesanan</td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($order['id']) ?></td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-bold bg-gray-100">Nama</td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($order['name']) ?></td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-bold bg-gray-100">Alamat</td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($order['address']) ?></td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-bold bg-gray-100">Total Harga</td>
                                    <td class="px-4 py-2">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold bg-gray-100">Tanggal Pesanan</td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($order['created_at']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Daftar Item Pesanan -->
                    <div>
                        <h4 class="text-xl font-bold mb-4">Item Pesanan</h4>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 text-left">
                                    <th class="px-4 py-3">Gambar</th>
                                    <th class="px-4 py-3">Nama Produk</th>
                                    <th class="px-4 py-3">Jumlah</th>
                                    <th class="px-4 py-3">Harga</th>
                                    <th class="px-4 py-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr class="border-t">
                                        <td class="px-4 py-3">
                                            <img src="<?= htmlspecialchars($item['image']) ?>"
                                                alt="<?= htmlspecialchars($item['product_name']) ?>"
                                                class="w-16 h-16 object-cover rounded">
                                        </td>
                                        <td class="px-4 py-3"><?= htmlspecialchars($item['product_name']) ?></td>
                                        <td class="px-4 py-3"><?= htmlspecialchars($item['quantity']) ?></td>
                                        <td class="px-4 py-3">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td class="px-4 py-3">Rp
                                            <?= number_format($item['quantity'] * $item['price'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-600">Pesanan tidak ditemukan atau Anda tidak memiliki akses ke pesanan ini.
                </p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>