<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../config/database.php';
include '../config/midtrans_config.php';

// Memastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Ambil data dari keranjang
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Hitung total harga
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Ambil data dari form
if (isset($_POST['name'], $_POST['address'], $_POST['phone'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
} else {
    echo "<script>alert('Data tidak lengkap. Silakan lengkapi informasi pengiriman.'); window.location.href = 'checkout.php';</script>";
    exit;
}

// Ambil ID pengguna yang sedang login
$userId = $_SESSION['user']['id'];

// Simpan data pesanan ke database
$stmt = $pdo->prepare("INSERT INTO orders (user_id, name, address, phone, total_price, status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$userId, $name, $address, $phone, $totalPrice, 'pending']);
$orderId = $pdo->lastInsertId();

// Simpan detail pesanan
foreach ($cartItems as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
}

// Persiapkan data transaksi untuk Midtrans
$transaction_details = [
    'order_id' => 'ORDER-' . $orderId,
    'gross_amount' => $totalPrice,
];

$item_details = [];
foreach ($cartItems as $item) {
    $item_details[] = [
        'id' => $item['id'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'name' => $item['name'],
    ];
}

$customer_details = [
    'first_name' => $name,
    'email' => $_SESSION['user']['email'],
    'phone' => $phone,
    'shipping_address' => [
        'address' => $address,
        'city' => 'Yogyakarta',
        'postal_code' => '12345',
        'country_code' => 'IDN',
    ],
];

// Data transaksi untuk Midtrans
$transaction_data = [
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'customer_details' => $customer_details,
    'return_url' => 'https://d4d7-2001-448a-4041-c894-9d84-b162-3e58-7101.ngrok-free.app/Website-Pemesanan-Kue/show_products.php'
];

try {
    // mendapatkan token pembayaran
    $snapToken = \Midtrans\Snap::getSnapToken($transaction_data);

    // Kirimkan snap token ke frontend
    echo json_encode(['snap_token' => $snapToken]);


} catch (Exception $e) {
    // Jika terjadi kesalahan dalam proses pembayaran
    echo "<script>alert('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.'); window.location.href = 'keranjang.php';</script>";
    exit;
}
?>