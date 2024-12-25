<?php
include 'config/database.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Simpan data produk ke database
    $query = $pdo->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $query->execute([$name, $price, $image]);

    header('Location: products.php');
    exit;
}
?>

<div class="container mx-auto mt-40">
    <h1 class="text-2xl font-bold">Add Product</h1>
    <form action="" method="POST" class="mt-5">
        <input type="text" name="name" placeholder="Product Name" class="border p-2 w-full mb-3" required>
        <input type="text" name="price" placeholder="Price" class="border p-2 w-full mb-3" required>
        <input type="text" name="image" placeholder="Image URL" class="border p-2 w-full mb-3" required>
        <button type="submit" class="bg-green-500 text-white p-2 rounded">Add Product</button>
    </form>
</div>