<?php
include 'config/database.php';
include 'header_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description']; // Menambahkan deskripsi produk

    // Simpan data produk ke database
    $query = $pdo->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
    $query->execute([$name, $price, $image, $description]); // Menambahkan deskripsi dalam query

    // Redirect ke halaman products.php setelah data berhasil ditambahkan
    header('Location: products.php');
    exit; // Always call exit after header redirection
}
?>

<!-- Form to add product -->
<div class="min-h-screen ml-80 mr-10 py-10 ">
    <div class="container mx-auto bg-white p-8 shadow-lg rounded-lg">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-8">Tambah Produk Baru</h1>

        <form action="" method="POST" class="space-y-6">
            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600">Nama Produk</label>
                <input id="name" type="text" name="name" placeholder="Masukkan Nama Produk"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>

            <!-- Harga -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-600">Harga</label>
                <input id="price" type="text" name="price" placeholder="Masukkan Harga Produk"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-600">Deskripsi Produk</label>
                <textarea id="description" name="description" placeholder="Masukkan Deskripsi Produk"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    rows="5" required></textarea>
            </div>

            <!-- URL Gambar -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-600">URL Gambar</label>
                <input id="image" type="text" name="image" placeholder="Masukkan URL Gambar"
                    class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>

            <!-- Tombol Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-yellow-600 text-white p-3 rounded-md hover:bg-amber-600 transition duration-200">Tambah
                    Produk</button>
            </div>
        </form>
    </div>
</div>