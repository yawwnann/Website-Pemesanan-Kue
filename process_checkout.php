<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/database.php';

// Pastikan keranjang tidak kosong
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang Anda kosong!'); window.location.href = 'keranjang.php';</script>";
    exit;
}

// Ambil data dari form
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$paymentMethod = $_POST['payment_method'];

// Ambil data keranjang
$cartItems = $_SESSION['cart'];
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Simpan data pesanan ke database (contoh query)
$stmt = $pdo->prepare("INSERT INTO orders (name, address, phone, payment_method, total_price) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$name, $address, $phone, $paymentMethod, $totalPrice]);
$orderId = $pdo->lastInsertId();

// Simpan detail pesanan
foreach ($cartItems as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
}

// Hapus keranjang
unset($_SESSION['cart']);

// Tampilkan pesan sukses
echo "<script>alert('Pesanan Anda berhasil diproses!'); window.location.href = 'index.php';</script>";
?>