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

// Default order by dan direction
$orderBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$orderDir = isset($_GET['sort_dir']) && $_GET['sort_dir'] === 'asc' ? 'asc' : 'desc';

// Validasi kolom yang bisa diurutkan
$allowedColumns = ['id', 'total_price', 'created_at'];
if (!in_array($orderBy, $allowedColumns)) {
    $orderBy = 'created_at';
}

// Ambil data pesanan dari tabel orders dengan sorting
$stmt = $pdo->prepare("SELECT * FROM orders ORDER BY $orderBy $orderDir");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

function sortingLink($column, $currentOrderBy, $currentOrderDir)
{
    $nextOrderDir = ($currentOrderBy === $column && $currentOrderDir === 'asc') ? 'desc' : 'asc';
    return "?sort_by=$column&sort_dir=$nextOrderDir";
}
?>

<main>
    <div class="bg-gradient-to-br from-pink-50 via-purple-100 to-pink-300 min-h-screen py-20 pt-30">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="text-center mb-10">
                <h2 class="text-5xl font-bold text-black">Daftar Pesanan</h2>
                <p class="text-lg text-gray-600 mt-2">Lihat semua pesanan yang telah dibuat oleh pelanggan.</p>
            </div>
            <div class="mb-6">
                <a href="generate_all_orders_pdf.php"
                    class="bg-purple-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 transition">
                    Cetak Semua Pesanan
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-left">
                            <th class="px-4 py-3">
                                <a href="<?= sortingLink('id', $orderBy, $orderDir) ?>" class="hover:underline">
                                    ID Pesanan
                                    <?= $orderBy === 'id' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th class="px-4 py-3">Nama Pelanggan</th>
                            <th class="px-4 py-3">
                                <a href="<?= sortingLink('total_price', $orderBy, $orderDir) ?>"
                                    class="hover:underline">
                                    Total Harga
                                    <?= $orderBy === 'total_price' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th class="px-4 py-3">Metode Pembayaran</th>
                            <th class="px-4 py-3">
                                <a href="<?= sortingLink('created_at', $orderBy, $orderDir) ?>" class="hover:underline">
                                    Tanggal
                                    <?= $orderBy === 'created_at' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-gray-600 py-4">Belum ada pesanan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td class="px-4 py-3"><?= htmlspecialchars($order['id']) ?></td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($order['name']) ?></td>
                                    <td class="px-4 py-3">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                                    <td class="px-4 py-3"><?= ucfirst($order['payment_method']) ?></td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($order['created_at']) ?></td>
                                    <td class="px-4 py-3">
                                        <a href="order_details.php?id=<?= $order['id'] ?>"
                                            class="text-purple-500 hover:underline">Lihat Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>