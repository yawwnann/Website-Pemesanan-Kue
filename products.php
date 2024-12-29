<?php
include 'config/database.php';
include 'header_admin.php';

// Menangani filter kategori
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Membuat query berdasarkan filter kategori
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/tailwind.css">
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

            <!-- Tabel untuk produk -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-left">
                            <th class="px-6 py-3 border-b border-gray-300">Gambar</th>
                            <th class="px-6 py-3 border-b border-gray-300">Nama</th>
                            <th class="px-6 py-3 border-b border-gray-300">Harga</th>
                            <th class="px-6 py-3 border-b border-gray-300">Deskripsi</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <img src="<?= htmlspecialchars($product['image']) ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                        class="w-16 h-16 object-cover rounded-lg">
                                </td>
                                <td class="px-6 py-4"><?= htmlspecialchars($product['name']) ?></td>
                                <td class="px-6 py-4">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($product['description']) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <a href="edit_product.php?id=<?= $product['id'] ?>"
                                        class="text-blue-500 hover:text-blue-700 transition duration-200">Edit</a>
                                    <span class="mx-2">|</span>
                                    <a href="delete_product.php?id=<?= $product['id'] ?>"
                                        class="text-red-500 hover:text-red-700 transition duration-200"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>