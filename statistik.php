<?php
include 'config/database.php';
include 'header_admin.php';

// Fetching monthly income data
$stmt = $pdo->prepare("SELECT SUM(total_price) AS total_income, DATE_FORMAT(created_at, '%Y-%m') AS month FROM orders GROUP BY month ORDER BY month");
$stmt->execute();
$monthlyIncome = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preparing data for Chart.js
$months = [];
$incomes = [];
foreach ($monthlyIncome as $data) {
    $months[] = $data['month'];
    $incomes[] = (int) $data['total_income'];
}

// Fetching top ordered products data
$stmt = $pdo->prepare("SELECT oi.product_id, p.name, SUM(oi.quantity) AS total_quantity
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
                        GROUP BY oi.product_id
                        ORDER BY total_quantity DESC");
$stmt->execute();
$topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preparing data for Chart.js (top ordered products)
$productNames = [];
$productQuantities = [];
foreach ($topProducts as $product) {
    $productNames[] = $product['name'];
    $productQuantities[] = (int) $product['total_quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/tailwind.css">
</head>

<body class="bg-yellow-50">

    <div class="container w-auto mx-auto mt-10 mb-40 px-10">
        <!-- Title for Statistik -->
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-black">Statistik Penjualan</h2>
            <p class="text-lg text-gray-600 mt-2">Lihat statistik pemasukan dan produk paling banyak dipesan</p>
        </div>

        <!-- Charts: Pemasukan per Bulan and Produk Paling Banyak Dipesan -->
        <div class="flex gap-4 ">
            <!-- Income Line Chart -->
            <div class="bg-white rounded-lg shadow-md ml-40 p-6 h-auto w-full sm:w-[100%]" style="max-width: 1000px;">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Pemasukan per Bulan</h3>
                <canvas id="incomeChart"></canvas>
            </div>

            <!-- Top Products Doughnut Chart -->
            <div class="bg-white rounded-lg shadow-md p-6 w-full sm:w-[50%]" style="max-width: 600px;">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Item Paling Banyak Dipesan</h3>
                <canvas id="productChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Data for income chart (pemasukan per bulan)
        const months=<?php echo json_encode($months); ?>;
        const incomes=<?php echo json_encode($incomes); ?>;

        // Data for product chart (produk paling banyak dipesan)
        const productNames=<?php echo json_encode($productNames); ?>;
        const productQuantities=<?php echo json_encode($productQuantities); ?>;

        const ctxIncome=document.getElementById("incomeChart").getContext("2d");
        const incomeChart=new Chart(ctxIncome,{
            type: "line",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Pemasukan (Rp)",
                        data: incomes,
                        backgroundColor: "rgba(75, 0, 75, 0.2)",
                        borderColor: "rgb(202, 111, 8)",
                        borderWidth: 1,
                        pointRadius: 5,
                    },
                ],
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

        // Doughnut chart for top ordered products
        const ctxProduct=document.getElementById("productChart").getContext("2d");
        const productChart=new Chart(ctxProduct,{
            type: "doughnut",
            data: {
                labels: productNames,
                datasets: [
                    {
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
                    },
                ],
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
</body>

</html>