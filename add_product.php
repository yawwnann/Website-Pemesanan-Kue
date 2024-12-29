<?php
include 'config/database.php';
include 'header_admin.php';

$category = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $query = $pdo->prepare("INSERT INTO products (name, price, image, description, category) VALUES (?, ?, ?, ?, ?)");
    $query->execute([$name, $price, $image, $description, $category]);

    header('Location: products.php');
    exit;
}
?>

<div class="min-h-screen ml-80 mr-10 py-10 ">
    <div class="container mx-auto p-8  rounded-lg">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-8">Tambah Produk Baru</h1>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600">Nama Produk</label>
                <input id="name" type="text" name="name" placeholder="Masukkan Nama Produk"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-600">Harga</label>
                <input id="price" type="text" name="price" placeholder="Masukkan Harga Produk"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-600">Deskripsi Produk</label>
                <textarea id="description" name="description" placeholder="Masukkan Deskripsi Produk"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    rows="5" required></textarea>
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-600">Kategori Produk</label>
                <select name="category" id="category"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
                    <option value="Kue" <?= ($category === 'Kue') ? 'selected' : '' ?>>Kue</option>
                    <option value="Roti" <?= ($category === 'Roti') ? 'selected' : '' ?>>Roti</option>
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-600">URL Gambar</label>
                <input id="image" type="text" name="image" placeholder="Masukkan URL Gambar"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-yellow-600 text-white p-3 rounded-md hover:bg-amber-600 transition duration-200">Tambah
                    Produk</button>
            </div>
        </form>
    </div>
</div>