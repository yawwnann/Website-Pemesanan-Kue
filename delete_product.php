<?php
include 'config/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $checkQuery = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $checkQuery->execute([$id]);
    $product = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $deleteQuery = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $deleteQuery->execute([$id]);
        header('Location: products.php');
        exit;
    } else {
        echo '<p class="text-red-500 text-center mt-10">Product not found.</p>';
    }
} else {

    header('HTTP/1.0 404 Not Found');
    echo '<p class="text-red-500 text-center mt-10">Invalid product ID.</p>';
    exit;
}
