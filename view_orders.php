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

// Default order by and direction
$orderBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$orderDir = isset($_GET['sort_dir']) && $_GET['sort_dir'] === 'asc' ? 'asc' : 'desc';

// Validating columns that can be sorted
$allowedColumns = ['id', 'total_price', 'created_at'];
if (!in_array($orderBy, $allowedColumns)) {
    $orderBy = 'created_at';
}

// Get order data from orders table with sorting
$stmt = $pdo->prepare("SELECT * FROM orders ORDER BY $orderBy $orderDir");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle status change for orders
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Update order status in the database
    $updateStmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $updateStmt->execute([$newStatus, $orderId]);

    // Redirect after update
    header("Location: view_orders.php");
    exit;
}

function sortingLink($column, $currentOrderBy, $currentOrderDir)
{
    $nextOrderDir = ($currentOrderBy === $column && $currentOrderDir === 'asc') ? 'desc' : 'asc';
    return "?sort_by=$column&sort_dir=$nextOrderDir";
}
?>
<style>
    /* Sidebar styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 240px;
        /* Sidebar width */
        background-color: #ffffff;
        box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
        z-index: 50;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    /* Content area */
    .content {
        margin-left: 240px;
        /* Sidebar width */
        padding: 20px;
        padding-right: 20px;
        /* Add padding-right to create space on the right */
    }

    /* Table adjustments */
    table {
        width: 80%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px 12px;
        /* Reduced padding for more compactness */
        text-align: left;
    }

    th {
        background-color: #f1f1f1;
    }

    td {
        word-wrap: break-word;
    }

    /* Specific column widths */
    th:nth-child(1),
    td:nth-child(1) {
        /* ID column */
        width: 4%;
    }

    th:nth-child(2),
    td:nth-child(2) {
        /* Name column */
        width: 15%;
    }

    th:nth-child(3),
    td:nth-child(3) {
        /* Total Harga column */
        width: 5%;
    }

    th:nth-child(4),
    td:nth-child(4) {
        /* Status column */
        width: 10%;
    }

    th:nth-child(5),
    td:nth-child(5) {
        /* Actions column */
        width: 5%;
    }
</style>
<main>
    <div class="container mx-auto mt-10 px-10" style="margin-left: 240px; padding-right: 20px;">
        <!-- Tabel Daftar Pesanan -->
        <div class="bg-white rounded-lg shadow-md w-5/6 p-6">
            <div class="text-center mb-6">
                <h2 class="text-5xl font-bold text-black">Daftar Pesanan</h2>
                <p class="text-lg text-gray-600 mt-2">Lihat dan ubah status pesanan yang telah dibuat oleh pelanggan.
                </p>
            </div>

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
                            <a href="<?= sortingLink('total_price', $orderBy, $orderDir) ?>" class="hover:underline">
                                Total Harga
                                <?= $orderBy === 'total_price' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
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
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-10">
            <a href="generate_all_orders_pdf.php"
                class="bg-yellow-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 transition">
                Cetak Semua Pesanan
            </a>
        </div>
    </div>
</main>

<script src="js/view_order.js"></script>