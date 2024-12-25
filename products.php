<?php
include 'config/database.php';
include 'header_admin.php';

// Ambil semua produk dari database
$query = $pdo->query("SELECT * FROM products");
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto mt-40 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Produk</h1>
        <a href="add_product.php"
            class="bg-purple-500 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-purple-600 transition duration-300">
            Tambah Produk
        </a>
    </div>

    <!-- Tabel untuk produk -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-left">
                    <th class="px-6 py-3 border-b border-gray-300">Gambar</th>
                    <th class="px-6 py-3 border-b border-gray-300">Nama</th>
                    <th class="px-6 py-3 border-b border-gray-300">Harga</th>
                    <th class="px-6 py-3 border-b border-gray-300">Deskripsi</th>
                    <th class="px-6 py-3 border-b border-gray-300 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <!-- Kolom untuk Gambar -->
                        <td class="px-6 py-4">
                            <img src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>" class="w-16 h-16 object-cover rounded-lg">
                        </td>
                        <!-- Kolom untuk Nama -->
                        <td class="px-6 py-4"><?= htmlspecialchars($product['name']) ?></td>
                        <!-- Kolom untuk Harga -->
                        <td class="px-6 py-4">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                        <!-- Kolom untuk Deskripsi -->
                        <td class="px-6 py-4"><?= htmlspecialchars($product['description']) ?></td>
                        <!-- Kolom untuk Aksi -->
                        <td class="px-6 py-4 text-center">
                            <a href="edit_product.php?id=<?= $product['id'] ?>"
                                class="text-blue-500 hover:text-blue-700 transition duration-200">Edit</a>
                            <span class="mx-2">|</span>
                            <a href="#" data-id="<?= $product['id'] ?>"
                                class="delete-button text-red-500 hover:text-red-700 transition duration-200">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal untuk konfirmasi hapus -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-96 rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Hapus</h2>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus produk ini?</p>
        <div class="flex justify-end">
            <button id="cancelButton"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400 transition">
                Batal
            </button>
            <a id="confirmDeleteButton" href="#"
                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                Hapus
            </a>
        </div>
    </div>
</div>

<script>
    const deleteButtons=document.querySelectorAll('.delete-button');
    const deleteModal=document.getElementById('deleteModal');
    const confirmDeleteButton=document.getElementById('confirmDeleteButton');
    const cancelButton=document.getElementById('cancelButton');

    deleteButtons.forEach(button => {
        button.addEventListener('click',(e) => {
            e.preventDefault();
            const productId=button.getAttribute('data-id');
            confirmDeleteButton.setAttribute('href',`delete_product.php?id=${productId}`);
            deleteModal.classList.remove('hidden');
        });
    });

    cancelButton.addEventListener('click',() => {
        deleteModal.classList.add('hidden');
    });
</script>