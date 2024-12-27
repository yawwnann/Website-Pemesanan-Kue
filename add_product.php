<?php
include 'config/database.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description']; // Menambahkan deskripsi produk

    // Simpan data produk ke database
    $query = $pdo->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
    $query->execute([$name, $price, $image, $description]); // Menambahkan deskripsi dalam query

    header('Location: products.php');
    exit;
}
?>

<div class="container mx-auto mt-40 mb-40 p-5 max-w-lg bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-semibold text-center text-gray-700 mb-5">Add New Product</h1>

    <form action="" method="POST" class="space-y-4">
        <!-- Product Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-600">Product Name</label>
            <input id="name" type="text" name="name" placeholder="Enter Product Name"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-600">Price</label>
            <input id="price" type="text" name="price" placeholder="Enter Product Price"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-600">Product Description</label>
            <textarea id="description" name="description" placeholder="Enter Product Description"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                rows="5" required></textarea>
        </div>

        <!-- Image URL -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-600">Image URL</label>
            <input id="image" type="text" name="image" placeholder="Enter Image URL"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full bg-yellow-900 text-white p-3 rounded-md hover:bg-green-600 transition duration-200">Add
                Product</button>
        </div>
    </form>
</div>