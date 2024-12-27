<?php
session_start(); // Memulai sesi
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query untuk memeriksa email
    $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Simpan data pengguna ke dalam sesi
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        // Redirect berdasarkan peran pengguna
        if ($user['role'] === 'admin') {
            header('Location: products.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        echo "<script>alert('Invalid email or password!');</script>";
    }
}

?>

<main class="bg-gray-300">
    <style>
        body {
            overflow: hidden;
        }
    </style>
    <div class="flex items-center justify-center h-screen">
        <!-- Kontainer Utama -->
        <div class="flex flex-col lg:flex-row bg-white shadow-lg rounded-lg w-full lg:w-3/4 overflow-hidden">
            <!-- Bagian Kiri: Gradasi dengan Gambar -->
            <div
                class="bg-gradient-to-br from-amber-600 via-amber-900 to-amber-950 w-full lg:w-1/2 p-10 flex flex-col justify-center relative">
                <img src="img/toko.png" alt="Toko"
                    class="absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 w-3/4 lg:w-1/2">
                <h1 class="text-4xl font-bold text-white text-center mt-64 lg:mt-80">Toko Roti Indonesia</h1>
            </div>

            <!-- Bagian Kanan: Form Login -->
            <div class="w-full lg:w-1/2 p-10 flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Selamat Datang Kembali!</h2>
                <p class="text-gray-600 mb-6">Silakan masuk ke akun Anda</p>
                <form action="" method="POST">
                    <!-- Email Input -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-medium mb-2">Alamat Email</label>
                        <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                            <input type="email" name="email" placeholder="Masukkan alamat email" required
                                class="bg-transparent outline-none flex-1">
                        </div>
                    </div>
                    <!-- Password Input -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-medium mb-2">Kata Sandi</label>
                        <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                            <input type="password" name="password" placeholder="Masukkan kata sandi" required
                                class="bg-transparent outline-none flex-1">
                        </div>
                    </div>
                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-br from-amber-600 via-amber-900 to-amber-950 text-white py-3 rounded-lg font-semibold shadow-lg hover:bg-brown-700 transition">
                        Masuk
                    </button>
                </form>
                <p class="text-amber-900 text-center mt-4">
                    Belum punya akun?
                    <a href="register.php" class="200 font-bold hover:underline">Daftar</a>
                </p>
                <p class="text-amber-900 text-center mt-4">
                    <a href="#" class="text-brown-500 font-bold hover:underline">Lupa Kata Sandi?</a>
                </p>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.tailwindcss.com"></script>