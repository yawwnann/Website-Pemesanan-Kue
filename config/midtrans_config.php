<?php
require_once __DIR__ . '/../vendor/autoload.php';

\Midtrans\Config::$serverKey = '';  // Server Key Anda
\Midtrans\Config::$clientKey = '';  // Client Key Anda
\Midtrans\Config::$isProduction = false; // Pastikan menggunakan sandbox mode
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
