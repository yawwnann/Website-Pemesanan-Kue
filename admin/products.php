<?php
include '../config/database.php';
include 'header_admin.php';


$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';


$queryStr = "SELECT * FROM products";
if ($categoryFilter) {
    $queryStr .= " WHERE category = :category";
}

$query = $pdo->prepare($queryStr);
if ($categoryFilter) {
    $query->bindParam(':category', $categoryFilter, PDO::PARAM_STR);
}

$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<style>
    .content {
        margin-left: 240px;
        padding: 20px;
    }
</style>
</head>

<body class="bg-yellow-50">
    <!-- Main content -->
    <div class="content">
        <div class="container mx-auto mt-10 mb-40 px-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Daftar Produk</h1>

                <!-- Filter Dropdown -->
                <div>
                    <form action="" method="GET" class="flex items-center space-x-2">
                        <select name="category" class="border border-gray-300 p-2 rounded-md">
                            <option value="" disabled <?= empty($categoryFilter) ? 'selected' : '' ?>>Pilih Kategori
                            </option>
                            <option value="Kue" <?= $categoryFilter === 'Kue' ? 'selected' : '' ?>>Kue</option>
                            <option value="Roti" <?= $categoryFilter === 'Roti' ? 'selected' : '' ?>>Roti</option>
                        </select>
                        <button type="submit"
                            class="bg-yellow-700 text-white px-6 py-2 rounded-md shadow-md hover:bg-yellow-900 transition duration-300">Filter</button>
                    </form>
                </div>
            </div>

            <!-- Cards Products -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($products as $product): ?>
                    <?php
                    // Membatasi deskripsi menjadi 20 kata
                    $description = htmlspecialchars($product['description']);
                    $descriptionWords = explode(' ', $description);
                    $limitedDescription = implode(' ', array_slice($descriptionWords, 0, 20));
                    if (count($descriptionWords) > 20) {
                        $limitedDescription .= '...';
                    }
                    ?>
                    <div class="bg-white p-3 rounded-lg shadow-lg hover:shadow-xl transition duration-300 group"
                        data-aos="fade-up" data-aos-duration="500">
                        <img src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="w-full h-48 object-cover rounded-lg mb-4 transition duration-300 group-hover:scale-105">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-lg font-bold text-gray-700 mb-2">Rp
                            <?= number_format($product['price'], 0, ',', '.') ?>
                        </p>
                        <p class="text-sm text-gray-600 mb-4"><?= $limitedDescription ?></p>
                        <div class="flex justify-between items-center mt-4">
                            <a href="edit_product.php?id=<?= $product['id'] ?>"
                                class="bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-blue-600 transition duration-300">Edit</a>
                            <a href="delete_product.php?id=<?= $product['id'] ?>"
                                class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-red-600 transition duration-300"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        AOS.init({
            duration: 500,
            once: true,
        });
    </script>
</body>

</html>