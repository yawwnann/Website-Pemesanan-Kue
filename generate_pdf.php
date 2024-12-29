<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah user adalah admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
include 'config/database.php';

// Ambil ID pesanan dari parameter URL
$orderId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data pesanan berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die('Pesanan tidak ditemukan!');
}

// Ambil detail item pesanan dari tabel order_items
$stmtItems = $pdo->prepare("SELECT oi.*, p.name AS product_name FROM order_items oi
                            JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmtItems->execute([$orderId]);
$orderItems = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

// Mulai menggunakan TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bakery Indonesia');
$pdf->SetTitle('Detail Pesanan');
$pdf->SetSubject('Detail Pesanan');
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

// Judul
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 10, 'Detail Pesanan', 0, 1, 'C');
$pdf->Ln(5);

// Informasi Pesanan
$pdf->SetFont('helvetica', '', 12);
$html = '
    <h3>Informasi Pesanan</h3>
    <p><strong>ID Pesanan:</strong> ' . htmlspecialchars($order['id']) . '</p>
    <p><strong>Nama Pelanggan:</strong> ' . htmlspecialchars($order['name']) . '</p>
    <p><strong>Alamat Pengiriman:</strong> ' . htmlspecialchars($order['address']) . '</p>
    <p><strong>Nomor Telepon:</strong> ' . htmlspecialchars($order['phone']) . '</p>
    <p><strong>Total Harga:</strong> Rp ' . number_format($order['total_price'], 0, ',', '.') . '</p>
    <p><strong>Tanggal Pemesanan:</strong> ' . htmlspecialchars($order['created_at']) . '</p>
';
$pdf->writeHTML($html);
$pdf->Ln(10);

// Detail Barang
$pdf->SetFont('helvetica', '', 12);
$html = '
    <h3>Detail Barang</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th><strong>Nama Produk</strong></th>
                <th><strong>Jumlah</strong></th>
                <th><strong>Harga Satuan</strong></th>
                <th><strong>Subtotal</strong></th>
            </tr>
        </thead>
        <tbody>
';

foreach ($orderItems as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $html .= '
        <tr>
            <td>' . htmlspecialchars($item['product_name']) . '</td>
            <td>' . $item['quantity'] . '</td>
            <td>Rp ' . number_format($item['price'], 0, ',', '.') . '</td>
            <td>Rp ' . number_format($subtotal, 0, ',', '.') . '</td>
        </tr>
    ';
}

$html .= '
        </tbody>
    </table>
';
$pdf->writeHTML($html);

// Output PDF
$pdf->Output('Detail_Pesanan_' . $orderId . '.pdf', 'I');
