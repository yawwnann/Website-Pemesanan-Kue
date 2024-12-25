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
$stmt = $pdo->prepare("SELECT * FROM orders ORDER BY id ASC");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data pemasukan per bulan
$stmt = $pdo->prepare("SELECT SUM(total_price) AS total_income, DATE_FORMAT(created_at, '%Y-%m') AS month FROM orders GROUP BY month ORDER BY month");
$stmt->execute();
$monthlyIncome = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Persiapkan data untuk Chart.js
$months = [];
$incomes = [];
foreach ($monthlyIncome as $data) {
    $months[] = $data['month'];
    $incomes[] = (int) $data['total_income'];
}

// Ambil data produk yang paling banyak dipesan
$stmt = $pdo->prepare("
    SELECT oi.product_id, p.name, SUM(oi.quantity) AS total_quantity
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    GROUP BY oi.product_id
    ORDER BY total_quantity DESC
");
$stmt->execute();
$topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Persiapkan data untuk Chart.js (produk yang paling banyak dipesan)
$productNames = [];
$productQuantities = [];
foreach ($topProducts as $product) {
    $productNames[] = $product['name'];
    $productQuantities[] = (int) $product['total_quantity'];
}

function sortingLink($column, $currentOrderBy, $currentOrderDir)
{
    $nextOrderDir = ($currentOrderBy === $column && $currentOrderDir === 'asc') ? 'desc' : 'asc';
    return "?sort_by=$column&sort_dir=$nextOrderDir";
}
?>

<main>
    <div class="container mx-auto mt-10 px-4">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="text-center mb-10">
                <h2 class="text-5xl font-bold text-black">Daftar Pesanan</h2>
                <p class="text-lg text-gray-600 mt-2">Lihat semua pesanan yang telah dibuat oleh pelanggan.</p>
            </div>

            <!-- Diagram Batang Pemasukan per Bulan dan Diagram Donat Produk Paling Banyak Dipesan -->
            <div class="flex space-x-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6 w-full lg:w-1/2">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Pemasukan per Bulan</h3>
                    <canvas id="incomeChart"></canvas>
                </div>

                <!-- Diagram Donat Produk Paling Banyak Dipesan -->
                <div class="bg-white rounded-lg shadow-md p-6 w-full lg:w-1/2">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Item Paling Banyak Dipesan</h3>
                    <canvas id="productChart"></canvas>
                </div>
            </div>

            <!-- Tabel Daftar Pesanan -->
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
                                    <td class="px-4 py-3"><?= strtoupper(htmlspecialchars($order['name'])) ?></td>
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

            <div class="text-center mt-10">
                <a href="generate_all_orders_pdf.php"
                    class="bg-purple-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 transition">
                    Cetak Semua Pesanan
                </a>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data untuk grafik pemasukan
    const months=<?php echo json_encode($months); ?>;
    const incomes=<?php echo json_encode($incomes); ?>;

    // Data untuk grafik item yang paling banyak dipesan
    const productNames=<?php echo json_encode($productNames); ?>;
    const productQuantities=<?php echo json_encode($productQuantities); ?>;
</script>

<script src="js/view_order.js"></script>