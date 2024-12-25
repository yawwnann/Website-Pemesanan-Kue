<?php
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $role = 'user';

    // Verifikasi kecocokan password
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match! Please try again.'); window.location.href = 'register.php';</script>";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Validasi email untuk role admin (opsional, jika admin menggunakan domain khusus)
    if (preg_match('/^[a-zA-Z0-9._%+-]+@adm\.co\.id$/', $email)) {
        $role = 'admin';
    }

    // Validasi apakah email sudah ada
    $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $query->execute([$email]);
    $emailExists = $query->fetchColumn();

    if ($emailExists) {
        echo "<script>alert('Email already registered! Please use a different email.'); window.location.href = 'register.php';</script>";
        exit;
    }

    // Simpan data ke database
    $query = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $query->execute([$username, $email, $hashedPassword, $role]);

    echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
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
                class="bg-gradient-to-br from-pink-50 via-purple-100 to-pink-300 w-full lg:w-1/2 p-10 flex flex-col justify-center relative">
                <img src="img/toko.png" alt="Toko"
                    class="absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/4 w-3/4 lg:w-1/2">
                <h1 class="text-4xl font-bold text-purple-600 text-center mt-64 lg:mt-80">Toko Roti Indonesia</h1>
            </div>

            <!-- Bagian Kanan: Form Registrasi -->
            <div class="w-full lg:w-1/2 p-10 flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Akun Anda</h2>
                <form action="" method="POST">
                    <!-- Username Input -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-medium mb-2">Nama Pengguna</label>
                        <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                            <span class="text-gray-500 mr-2"></span>
                            <input type="text" name="username" placeholder="Masukkan nama pengguna" required
                                class="bg-transparent outline-none flex-1">
                        </div>
                    </div>
                    <!-- Email Input -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-medium mb-2">Alamat Email</label>
                        <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                            <span class="text-gray-500 mr-2"></span>
                            <input type="email" name="email" placeholder="Masukkan email" required
                                class="bg-transparent outline-none flex-1">
                        </div>
                    </div>
                    <!-- Password Input -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-medium mb-2">Kata Sandi</label>
                        <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                            <span class="text-gray-500 mr-2"></span>
                            <input type="password" name="password" placeholder="Masukkan kata sandi" required
                                class="bg-transparent outline-none flex-1">
                        </div>
                    </div>
                    <!-- Confirm Password Input -->
                    <div class="mb-4">
                        <label class="block text-gray-600 font-medium mb-2">Konfirmasi Kata Sandi</label>
                        <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                            <span class="text-gray-500 mr-2"></span>
                            <input type="password" name="confirm_password" placeholder="Konfirmasi kata sandi" required
                                class="bg-transparent outline-none flex-1">
                        </div>
                    </div>
                    <!-- Register Button -->
                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold shadow-lg hover:bg-purple-700 transition">
                        Daftar
                    </button>
                </form>
                <p class="text-gray-500 text-center mt-4">
                    Sudah punya akun?
                    <a href="login.php" class="text-purple-600 font-bold hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.tailwindcss.com"></script>