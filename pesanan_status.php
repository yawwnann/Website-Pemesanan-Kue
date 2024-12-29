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

// Ambil id user yang sedang login
$userId = $_SESSION['user']['id'];

// Query untuk mendapatkan data pesanan berdasarkan user_id
$query = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
$query->execute([$userId]);
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="bg-gradient-to-br from-yellow-100 via-yellow-500 to-yellow-900">
    <div class="min-h-screen mt-20 py-20 pt-30">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Judul Halaman -->
            <div class="text-center mb-10" data-aos="fade-up" data-aos-duration="500">
                <h2 class="text-5xl font-bold text-black">Status Pesanan</h2>
                <p class="text-lg text-gray-900 mt-2">Lihat status pesanan yang telah Anda buat.</p>
            </div>

            <!-- Tabel Status Pesanan -->
            <div class="bg-white rounded-lg shadow-md p-6" data-aos="fade-right" data-aos-duration="500">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-left">
                                <th class="px-4 py-3">ID Pesanan</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Alamat</th>
                                <th class="px-4 py-3">Total Harga</th>
                                <th class="px-4 py-3">Metode Pembayaran</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-gray-600 py-4" data-aos="fade-in"
                                        data-aos-delay="200">Anda belum memiliki pesanan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr data-aos="fade-up" data-aos-delay="200">
                                        <td class="px-4 py-3"><?= htmlspecialchars($order['id']) ?></td>
                                        <td class="px-4 py-3"><?= htmlspecialchars($order['name']) ?></td>
                                        <td class="px-4 py-3"><?= htmlspecialchars($order['address']) ?></td>
                                        <td class="px-4 py-3">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                                        <td class="px-4 py-3"><?= ucfirst(htmlspecialchars($order['payment_method'])) ?></td>
                                        <td class="px-4 py-3"><?= ucfirst(htmlspecialchars($order['status'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 500,
        once: true,
        offset: 100,
        easing: 'ease-in-out',
    });
</script>