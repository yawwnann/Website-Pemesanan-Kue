<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Mulai sesi hanya jika belum aktif
}
include 'config/database.php';

// Pastikan keranjang tidak kosong
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang Anda kosong!'); window.location.href = 'keranjang.php';</script>";
    exit;
}

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit;
}

// Ambil data dari form
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$paymentMethod = $_POST['payment_method'];

// Ambil ID pengguna yang sedang login
$userId = $_SESSION['user']['id'];

// Ambil data keranjang
$cartItems = $_SESSION['cart'];
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Simpan data pesanan ke database
$stmt = $pdo->prepare("INSERT INTO orders (user_id, name, address, phone, payment_method, total_price, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$userId, $name, $address, $phone, $paymentMethod, $totalPrice, 'pending']);
$orderId = $pdo->lastInsertId();  // Ambil ID pesanan yang baru saja dimasukkan

// Simpan detail pesanan
foreach ($cartItems as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
}

// Hapus keranjang setelah pesanan diproses
unset($_SESSION['cart']);

// Tampilkan pesan sukses dan arahkan ke halaman utama
echo "<script>alert('Pesanan Anda berhasil diproses!'); window.location.href = 'index.php';</script>";
?>