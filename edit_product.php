<?php
include 'config/database.php';
include 'header_admin.php';

// Periksa apakah ID produk ada di URL dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data produk berdasarkan ID
    $query = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $query->execute([$id]);
    $product = $query->fetch(PDO::FETCH_ASSOC);

    // Jika produk tidak ditemukan, tampilkan pesan error
    if (!$product) {
        echo '<p class="text-red-500 text-center mt-10">Product not found.</p>';
        exit;
    }
} else {
    // Jika ID tidak valid, redirect ke halaman produk
    header('Location: products.php');
    exit;
}

// Jika form disubmit, perbarui data produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    // Query untuk memperbarui data produk
    $updateQuery = $pdo->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
    $updateQuery->execute([$name, $price, $description, $image, $id]);

    // Redirect kembali ke halaman produk
    header('Location: products.php');
    exit;
}
?>

<div class="container mx-auto mt-10 p-6 bg-white shadow-xl rounded-lg max-w-2xl">
    <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Edit Product</h1>

    <form action="" method="POST" class="space-y-6">
        <!-- Product Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-600">Product Name</label>
            <input id="name" type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"
                placeholder="Product Name"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-600">Price</label>
            <input id="price" type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>"
                placeholder="Price"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-600">Product Description</label>
            <textarea id="description" name="description" placeholder="Enter Product Description"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                rows="5" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <!-- Image URL -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-600">Image URL</label>
            <input id="image" type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>"
                placeholder="Image URL"
                class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 transition duration-200">Update
                Product</button>
        </div>
    </form>
</div>