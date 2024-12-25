<?php
require_once 'vendor/autoload.php';

// Periksa apakah user adalah admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'config/database.php';

// Ambil data semua pesanan
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buat PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Daftar Pesanan');
$pdf->SetHeaderData('', 0, 'Daftar Pesanan', 'Bakery Indonesia');

// Set margins
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();

// Header Tabel
$html = '<h2>Daftar Pesanan</h2>';
$html .= '<table border="1" cellspacing="3" cellpadding="4">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>';

// Isi Tabel
foreach ($orders as $order) {
    $html .= '<tr>
                <td>' . htmlspecialchars($order['id']) . '</td>
                <td>' . htmlspecialchars($order['name']) . '</td>
                <td>Rp ' . number_format($order['total_price'], 0, ',', '.') . '</td>
                <td>' . ucfirst($order['payment_method']) . '</td>
                <td>' . htmlspecialchars($order['created_at']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Tulis ke PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('daftar_pesanan.pdf', 'I');
