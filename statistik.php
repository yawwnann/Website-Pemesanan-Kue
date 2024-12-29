<?php
include 'config/database.php';
include 'header_admin.php';

// Mengambil data statistik
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_user FROM users");
$stmt->execute();
$totalUser = $stmt->fetch(PDO::FETCH_ASSOC)['total_user'];

$stmt = $pdo->prepare("SELECT COUNT(*) AS total_order FROM orders");
$stmt->execute();
$totalOrder = $stmt->fetch(PDO::FETCH_ASSOC)['total_order'];

$stmt = $pdo->prepare("SELECT COUNT(*) AS total_pending FROM orders WHERE status = 'pending'");
$stmt->execute();
$totalPending = $stmt->fetch(PDO::FETCH_ASSOC)['total_pending'];

// Mengambil data total pemasukan
$stmt = $pdo->prepare("SELECT SUM(total_price) AS total_income FROM orders");
$stmt->execute();
$totalIncome = $stmt->fetch(PDO::FETCH_ASSOC)['total_income'];

// Mengambil data pemasukan per bulan
$stmt = $pdo->prepare("SELECT SUM(total_price) AS total_income, DATE_FORMAT(created_at, '%Y-%m') AS month FROM orders GROUP BY month ORDER BY month");
$stmt->execute();
$monthlyIncome = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Menyiapkan data untuk Chart.js
$months = [];
$incomes = [];
foreach ($monthlyIncome as $data) {
    $months[] = $data['month'];
    $incomes[] = (int) $data['total_income'];
}

// Mengambil data produk yang paling banyak dipesan
$stmt = $pdo->prepare("SELECT oi.product_id, p.name, SUM(oi.quantity) AS total_quantity
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
                        GROUP BY oi.product_id
                        ORDER BY total_quantity DESC");
$stmt->execute();
$topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Menyiapkan data untuk Chart.js (produk paling banyak dipesan)
$productNames = [];
$productQuantities = [];
foreach ($topProducts as $product) {
    $productNames[] = $product['name'];
    $productQuantities[] = (int) $product['total_quantity'];
}
?>

<div class="container w-auto mx-auto mt-10 ml-60 mb-40 px-10">
    <div class="text-center mb-10">
        <h2 class="text-4xl font-bold text-left text-black" data-aos="fade-up" data-aos-duration="500">Statistik
            Penjualan</h2>
        <p class="text-lg text-gray-600 text-left mt-2" data-aos="fade-up" data-aos-duration="500">Lihat statistik
            pemasukan dan produk paling banyak dipesan</p>
    </div>
    <div class="flex gap-6 justify-between mb-10">
        <!-- Total User Card -->
        <div class="bg-white p-4 rounded-lg shadow-lg text-center flex items-center justify-between w-1/4"
            data-aos="fade-right" data-aos-duration="500">
            <div class="flex flex-col items-start">
                <p class="text-lg text-gray-800">Total User</p>
                <p class="text-5xl font-bold text-gray-800"><?php echo number_format($totalUser); ?></p>
                <p class="text-sm text-green-500">8.5% Up from yesterday</p>
            </div>
            <div class="flex-shrink-0">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-users text-2xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <!-- Total Order Card -->
        <div class="bg-white p-4 rounded-lg shadow-lg text-center flex items-center justify-between w-1/4"
            data-aos="fade-right" data-aos-duration="500">
            <div class="flex flex-col items-start">
                <p class="text-lg text-gray-800">Total Order</p>
                <p class="text-5xl font-bold text-gray-800"><?php echo number_format($totalOrder); ?></p>
                <p class="text-sm text-green-500">1.3% Up from past week</p>
            </div>
            <div class="flex-shrink-0">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-boxes text-2xl text-yellow-500"></i>
                </div>
            </div>
        </div>

        <!-- Total Pending Card -->
        <div class="bg-white p-4 rounded-lg shadow-lg text-center flex items-center justify-between w-1/4"
            data-aos="fade-left" data-aos-duration="500">
            <div class="flex flex-col items-start">
                <p class="text-lg text-gray-800">Total Pending</p>
                <p class="text-5xl font-bold text-gray-800"><?php echo number_format($totalPending); ?></p>
                <p class="text-sm text-green-500">1.8% Up from yesterday</p>
            </div>
            <div class="flex-shrink-0">
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-clock text-2xl text-orange-500"></i>
                </div>
            </div>
        </div>

        <!-- Income -->
        <div class="bg-white p-4 rounded-lg shadow-lg text-center flex items-center py-5 justify-between w-1/4"
            data-aos="fade-left" data-aos-duration="500">
            <div class="flex flex-col items-start">
                <p class="text-lg text-gray-800">Total Pemasukan</p>
                <p class="text-3xl text-left font-bold text-gray-800">
                    <?php echo "Rp " . number_format($totalIncome); ?>
                </p>
                <p class="text-sm text-green-500">1.8% Up from yesterday</p>
            </div>
            <div class="flex-shrink-0">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fa-solid fa-money-bill-wave text-2xl text-green-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts: Pemasukan per Bulan and Produk Paling Banyak Dipesan -->
    <div class="flex gap-4">
        <!-- Income Line Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 h-auto w-full sm:w-[100%]" style="max-width: 1000px;"
            data-aos="fade-up" data-aos-duration="500">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Pemasukan per Bulan</h3>
            <canvas id="incomeChart"></canvas>
        </div>

        <!-- Top Products Doughnut Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 w-full sm:w-[50%]" style="max-width: 600px;" data-aos="fade-up"
            data-aos-duration="500">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Item Paling Banyak Dipesan</h3>
            <canvas id="productChart"></canvas>
        </div>
    </div>
</div>

<script>
    // Data untuk chart pemasukan per bulan
    const months=<?php echo json_encode($months); ?>;
    const incomes=<?php echo json_encode($incomes); ?>;

    // Data untuk chart produk paling banyak dipesan
    const productNames=<?php echo json_encode($productNames); ?>;
    const productQuantities=<?php echo json_encode($productQuantities); ?>;

    const ctxIncome=document.getElementById("incomeChart").getContext("2d");
    const incomeChart=new Chart(ctxIncome,{
        type: "line",
        data: {
            labels: months,
            datasets: [{
                label: "Pemasukan (Rp)",
                data: incomes,
                backgroundColor: "rgba(75, 0, 75, 0.2)",
                borderColor: "rgb(202, 111, 8)",
                borderWidth: 1,
                pointRadius: 5,
            }],
        },
        options: {
            responsive: true,
            layout: {
                padding: {
                    bottom: 20,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return "Rp "+value.toLocaleString();
                        },
                    },
                },
            },
        },
    });

    // Doughnut chart untuk produk paling banyak dipesan
    const ctxProduct=document.getElementById("productChart").getContext("2d");
    const productChart=new Chart(ctxProduct,{
        type: "doughnut",
        data: {
            labels: productNames,
            datasets: [{
                label: "Jumlah Pesanan",
                data: productQuantities,
                backgroundColor: [
                    "rgb(39, 20, 24)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderColor: [
                    "rgb(54, 26, 32)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label+": "+tooltipItem.raw+" pcs";
                        },
                    },
                },
            },
        },
    });
</script>