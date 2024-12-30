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

$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$queryStr = "SELECT * FROM orders";
if ($statusFilter && $statusFilter !== 'all') {
    $queryStr .= " WHERE status = :status";
}

$orderBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$orderDir = isset($_GET['sort_dir']) && $_GET['sort_dir'] === 'asc' ? 'asc' : 'desc';

$allowedColumns = ['id', 'total_price', 'created_at'];
if (!in_array($orderBy, $allowedColumns)) {
    $orderBy = 'created_at';
}

$query = $pdo->prepare($queryStr);
if ($statusFilter && $statusFilter !== 'all') {
    $query->bindParam(':status', $statusFilter, PDO::PARAM_STR);
}

$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    $updateStmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $updateStmt->execute([$newStatus, $orderId]);

    header("Location: view_orders.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $orderId = $_POST['order_id'];

    try {
        $pdo->beginTransaction();

        $deleteItemsStmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
        $deleteItemsStmt->execute([$orderId]);

        $deleteOrderStmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
        $deleteOrderStmt->execute([$orderId]);

        $pdo->commit();
        header("Location: view_orders.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Terjadi kesalahan saat menghapus pesanan.'); window.location.href = 'view_orders.php';</script>";
        exit;
    }
}

function sortingLink($column, $currentOrderBy, $currentOrderDir)
{
    $nextOrderDir = ($currentOrderBy === $column && $currentOrderDir === 'asc') ? 'desc' : 'asc';
    return "?sort_by=$column&sort_dir=$nextOrderDir";
}
?>
<link rel="stylesheet" href="css/view_orders.css">
<main>
    <div class="container mx-auto mt-10 px-10" style="margin-left: 240px; padding-right: 20px;">
        <div class="w-5/6 p-6">
            <div class="text-center mb-10">
                <h2 class="text-5xl font-bold text-left text-black">Daftar Pesanan</h2>
                <p class="text-lg text-left text-gray-600 mt-2">Lihat dan ubah status pesanan yang telah dibuat oleh
                    pelanggan.</p>
            </div>

            <div class="mb-6 flex justify-between items-center">
                <form action="" method="GET" class="flex items-center space-x-2">
                    <select name="status" class="border border-gray-300 p-2 rounded-md">
                        <option value="all" <?= empty($statusFilter) || $statusFilter === 'all' ? 'selected' : '' ?>>
                            Tampilkan Semua</option>
                        <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="shipped" <?= $statusFilter === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $statusFilter === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                    </select>
                    <button type="submit"
                        class="bg-yellow-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-yellow-900 transition duration-300">Filter
                        Status</button>
                </form>
                <a href="generate_all_orders_pdf.php"
                    class="bg-yellow-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-yellow-900 transition ml-4">
                    Cetak Semua Pesanan
                </a>
            </div>

            <table class="w-full boborder-collapse">
                <thead>
                    <tr class="text-left">
                        <th class="px-4 py-3 bg-yellow-600 text-white rounded-l-lg">
                            <a href="<?= sortingLink('id', $orderBy, $orderDir) ?>" class="hover:underline">
                                ID Pesanan
                                <?= $orderBy === 'id' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th class="px-4 py-3 bg-yellow-600 text-white">
                            Nama Pelanggan
                        </th>
                        <th class="px-4 py-3 bg-yellow-600 text-white">
                            <a href="<?= sortingLink('total_price', $orderBy, $orderDir) ?>" class="hover:underline">
                                Total Harga
                                <?= $orderBy === 'total_price' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th class="px-4 py-3 bg-yellow-600 text-white">
                            Status
                        </th>
                        <th class="px-4 py-3 bg-yellow-600 text-white rounded-r-lg">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-gray-600 py-4">Belum ada pesanan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="px-4 py-3"><?= htmlspecialchars($order['id']) ?></td>
                                <td class="px-4 py-3"><?= strtoupper(htmlspecialchars($order['name'])) ?></td>
                                <td class="px-4 py-3">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                                <td class="px-4 py-3">
                                    <!-- Form for changing order status -->
                                    <form action="view_orders.php" method="POST">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <select name="status" class="border rounded p-2">
                                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>
                                                Pending
                                            </option>
                                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>
                                                Shipped
                                            </option>
                                            <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>
                                                Delivered
                                            </option>
                                        </select>
                                        <button type="submit" name="update_status"
                                            class="bg-yellow-600 text-white px-4 py-2 rounded ml-2">Update</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="order_details.php?id=<?= $order['id'] ?>"
                                        class="text-yellow-500 hover:underline">Lihat Detail</a>
                                    <form action="view_orders.php" method="POST" class="mt-2 inline-block">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="js/view_order.js"></script>