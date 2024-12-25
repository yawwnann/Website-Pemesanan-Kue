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

<div class="container mx-auto mt-40">
    <h1 class="text-2xl font-bold">Edit Product</h1>
    <form action="" method="POST" class="mt-5">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Product Name"
            class="border p-2 w-full mb-3" required>
        <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>" placeholder="Price"
            class="border p-2 w-full mb-3" required>
        <textarea name="description" placeholder="Product Description" class="border p-2 w-full mb-3" rows="5"
            required><?= htmlspecialchars($product['description']) ?></textarea>
        <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" placeholder="Image URL"
            class="border p-2 w-full mb-3" required>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update Product</button>
    </form>
</div>