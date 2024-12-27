<?php include 'config/database.php';
include 'header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>

<link rel="stylesheet" href="css/tailwind.css">

<main class="container mx-auto ">
    <!-- Konten Utama -->
    <div
        class="min-h-screen px-6 py-10 flex items-center bg-gradient-to-br from-yellow-200 via-yellow-600 to-yellow-700">
        <div class="container mx-auto px-6 lg:px-20 py-10 flex flex-col lg:flex-row items-center">
            <!-- Bagian Kiri: Teks dan Tombol -->
            <div class="lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0" data-aos="fade-right">
                <h1 class="text-4xl lg:text-6xl font-extrabold text-yellow-800 leading-tight">
                    Momen Manis, Dipanggang dengan Cinta
                </h1>
                <p class="mt-6 text-gray-600 text-lg lg:text-xl">
                    Kue, hidangan manis, dan semua yang spesial untuk momen istimewa Anda.
                </p>
                <a href="show_products.php"
                    class="mt-8 inline-block bg-yellow-950 text-white font-bold text-lg px-8 py-3 rounded-lg hover:bg-yellow-700 transition duration-300"
                    data-aos="zoom-in">
                    Belanja Sekarang
                </a>

            </div>

            <!-- Bagian Kanan: Gambar -->
            <div class="lg:w-1/2 flex justify-center relative" data-aos="fade-left">
                <img src="img/kue1.png" alt="Kue dan Donat" class="w-full max-w-3xl relative z-10">
            </div>
        </div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center"
        style="background: linear-gradient(to right, rgba(105, 75, 30, 0.8), rgba(226, 159, 83, 0.8)), url('img/bg-prof2.jpg'); background-size: cover; background-position: center;">
        <div class="container mx-auto  px-6 lg:px-20 py-8 flex flex-col lg:flex-row items-center lg:items-start">
            <!-- Bagian Kiri -->
            <div class="lg:w-1/2 text-center lg:text-left space-y-4">
                <h3 class="text-lg font-semibold text-yellow-50 uppercase" data-aos="fade-down">Kesenangan yang
                    Dipanggang dengan Cinta</h3>
                <h1 class="text-4xl lg:text-5xl font-bold text-white" data-aos="fade-down">Bakery Indonesia</h1>
                <p class="text-lg text-white" data-aos="fade-right">
                    Selamat datang di Bakery Indonesia! Dengan lebih dari 90 cabang yang tersebar di seluruh Indonesia,
                    termasuk Sumatra, Kalimantan, Sulawesi, Jawa, dan Kepulauan Bangka, Bakery Indonesia adalah tujuan
                    utama untuk hidangan panggang yang segar, lezat, dan berkualitas tinggi. Kami bangga menghadirkan
                    bukan hanya produk, tetapi juga pengalaman—perjalanan penuh senyuman hangat, aroma dapur, dan rasa
                    yang tak terlupakan.
                </p>
            </div>
            <div class="lg:w-1/2 flex justify-center rounded-lg mt-6 lg:mt-0 overflow-hidden" data-aos="fade-left">
                <img src="img/roti-profil.jpg" alt="Roti Profil"
                    class="rounded-lg shadow-lg object-cover w-full max-w-md lg:max-w-lg transition-transform duration-300 transform hover:scale-110">
            </div>
        </div>
    </div>

    <div class="bg-yellow-50 py-16">
        <div class="container mx-auto px-6 lg:px-20 flex flex-wrap justify-center gap-8">
            <!-- Card Diskon -->
            <div class="bg-yellow-600 text-white rounded-lg shadow-lg p-6 w-full lg:w-[45%] flex flex-col justify-between relative overflow-hidden"
                data-aos="slide-right">
                <div>
                    <h3 class="text-lg font-semibold uppercase">Diskon</h3>
                    <p class="mt-4 text-base">
                        Dapatkan potongan harga up to 50% tanpa minimal pembelian di seluruh outlet*
                    </p>
                </div>
                <div class="mt-6">
                    <a href="#"
                        class="inline-block bg-white text-[#A0522D] px-6 py-2 rounded-lg font-semibold hover:bg-gray-200 transition">
                        Cek Diskon →
                    </a>
                </div>
                <p class="mt-4 text-sm italic opacity-80">*berbeda diskon di setiap toko</p>
                <!-- Background Pattern -->
                <div class="absolute bottom-0 right-0 w-20 h-20 bg-no-repeat bg-cover"
                    style="background-image: url('img/wave-pattern.png'); opacity: 0.3;">
                </div>
            </div>

            <!-- Card Tentang -->
            <div class="bg-yellow-600 text-white rounded-lg shadow-lg p-6 w-full lg:w-[45%] flex flex-col justify-between relative overflow-hidden"
                data-aos="slide-left">
                <div>
                    <h3 class="text-lg font-semibold uppercase">Tentang</h3>
                    <p class="mt-4 text-base">
                        Berdiri pada tahun 2000, dan hanya memproduksi Brownies dan Piscok, yang dipasarkan ke
                        warung-warung kecil memakai motor. Tahun demi tahun berlalu, kami terus berkembang hingga saat
                        ini.
                    </p>
                </div>
                <div class="mt-6">
                    <a href="#"
                        class="inline-block bg-white text-[#A0522D] px-6 py-2 rounded-lg font-semibold hover:bg-gray-200 transition">
                        Ini Cerita Kami →
                    </a>
                </div>
                <!-- Background Pattern -->
                <div class="absolute bottom-0 right-0 w-20 h-20 bg-no-repeat bg-cover"
                    style="background-image: url('img/wave-pattern.png'); opacity: 0.3;">
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Pilih Favorit -->
    <div class="bg-yellow-50 ">
        <div class="container mx-auto px-6 lg:px-20">
            <div data-aos="fade-right">
                <h3 class="text-lg font-semibold text-orange-600 uppercase">Cari hal yang kamu sukai</h3>
                <h1 class="text-4xl font-bold text-gray-800 mb-8">Produk Terlaris Kami</h1>
            </div>

            <!-- Grid Produk (2 Gambar Atas, 2 Gambar Bawah) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
                <!-- Kolom Gambar 1 -->
                <div class="relative group overflow-hidden" data-aos="fade-right">
                    <img src="img/cakes.jpg" alt="Cakes"
                        class="w-full h-72 object-cover transition-transform duration-300 transform group-hover:scale-110 ">
                    <div
                        class="absolute inset-0 top-1/2 transform -translate-y-35%] text-white text-3xl font-bold text-center">
                        CAKES
                    </div>
                </div>

                <!-- Kolom Gambar 2 -->
                <div class="relative group overflow-hidden" data-aos="fade-down">
                    <img src="img/dry-cakes.jpg" alt="Dry Cakes"
                        class="w-full h-72 object-cover transition-transform duration-300 transform group-hover:scale-110 ">
                    <div
                        class="absolute inset-0 top-1/2 transform -translate-y-35%] text-white text-3xl font-bold text-center">
                        DRY CAKE
                    </div>
                </div>

                <!-- Kolom Gambar 3 -->
                <div class="relative group overflow-hidden" data-aos="fade-up">
                    <img src="img/cookies.jpg" alt="Cookies"
                        class="w-full h-72 object-cover transition-transform duration-300 transform group-hover:scale-110 ">
                    <div
                        class="absolute inset-0 top-1/2 transform -translate-y-35%] text-white text-3xl font-bold text-center">
                        COOKIES
                    </div>
                </div>

                <!-- Kolom Gambar 4 -->
                <div class="relative group overflow-hidden" data-aos="fade-left">
                    <img src="img/butter-cake.jpeg" alt="Butter Cake"
                        class="w-full h-72 object-cover transition-transform duration-300 transform group-hover:scale-110 ">
                    <div
                        class="absolute inset-0 top-1/2 transform -translate-y-35%] text-white text-3xl font-bold text-center">
                        BUTTER CAKE
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Kartu -->
    <div class="bg-yellow-50 min-h-screen mt-20">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Judul Bagian dan Tombol -->
            <div class="flex justify-between items-center mb-10" data-aos="fade-down">
                <div>
                    <h3 class="text-lg font-semibold text-orange-600 uppercase">Temukan produk yang paling dicintai dan
                        populer</h3>
                    <h1 class="text-4xl font-bold text-gray-800 mt-2">Produk Terlaris Kami</h1>
                </div>
                <a href="show_products.php"
                    class="bg-yellow-600 text-white text-lg px-6 py-3 rounded-lg hover:bg-yellow-700 transition shadow-md">
                    Lihat Lainnya
                </a>
            </div>

            <!-- Slider Produk -->
            <div class="swiper mySwiper mx-auto" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <?php
                    $query = $pdo->query("SELECT * FROM products limit 10");
                    $products = $query->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($products as $product): ?>
                        <!-- Kartu dalam Slider -->
                        <div class="swiper-slide">
                            <div
                                class="bg-white rounded-lg shadow-md p-2 overflow-hidden flex flex-col items-center w-full max-w-[300px] mx-auto transition-transform duration-300 transform hover:scale-105">
                                <!-- Image with fixed height -->
                                <!-- Product Image with fixed height and consistent styling -->
                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="w-full h-48 object-cover rounded-t-lg mb-4" data-aos="zoom-in"
                                    data-aos-duration="1000">

                                <div class="flex flex-col justify-between w-full">

                                    <!-- Product Title (Centered) -->
                                    <h3 class="text-lg font-semibold text-gray-800 " data-aos="fade-up"
                                        data-aos-duration="1000">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h3>

                                    <!-- Product Description (Centered and trimmed) -->
                                    <p class="text-sm text-gray-600 " data-aos="fade-up" data-aos-duration="1000">
                                        <?= htmlspecialchars(substr($product['description'], 0, 80)) . (strlen($product['description']) > 80 ? '...' : '') ?>
                                    </p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-lg font-semibold text-yellow-800">
                                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                        </span>
                                        <a href="#"
                                            class="bg-yellow-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-yellow-700 transition-shadow shadow-md">
                                            Keranjang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="swiper-pagination top-15"></div>
            </div>
        </div>
    </div>

    <!-- Testimoni Slider -->
    <div class="bg-yellow-50 py-2 mb-10">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Heading Section -->
            <div class="mb-8 " data-aos="slide-right">
                <h3 class="text-lg font-semibold text-orange-600 uppercase">Testimoni</h3>
                <h1 class="text-4xl font-bold text-gray-800 mt-2">Penilaian dari para pelanggan</h1>
            </div>

            <!-- Swiper Container -->
            <div class="swiper testimoniSwiper" data-aos="slide-left">
                <div class="swiper-wrapper">
                    <!-- Card Testimoni -->
                    <div class="swiper-slide">
                        <div
                            class="bg-white shadow-md rounded-lg p-6 max-w-sm min-h-[200px] flex flex-col justify-between text-left">
                            <h4 class="text-lg font-bold text-gray-800">Tian</h4>
                            <p class="mt-2 text-gray-600">
                                Baru sekali coba roti ini. Jatah konsumsi dari suatu acara. Dimakan setelah 1 hari masih
                                lembut.
                                Gak nyangka rasanya enak banget. Ada paduan susu, coklat di tengah roti...
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="bg-white shadow-md rounded-lg p-6 max-w-sm min-h-[200px] flex flex-col justify-between text-left">
                            <h4 class="text-lg font-bold text-gray-800">Rianita Hany</h4>
                            <p class="mt-2 text-gray-600">
                                Emg iya semua nya enak2 dengan harga yang terjangkau... 💕banget pokoknya... yg andalan
                                ku roti pizza
                                nya sama signature brownies... sukses terus khasanah.
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="bg-white shadow-md rounded-lg p-6 max-w-sm min-h-[200px] flex flex-col justify-between text-left">
                            <h4 class="text-lg font-bold text-gray-800">Husnul Khotimah</h4>
                            <p class="mt-2 text-gray-600">
                                Ini seriusan roti enakk bgt min, selalu beli yg brownis kukusnya 🥰 next aku beli kue
                                tart nya kalo
                                buat acara2 ya min.
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="bg-white shadow-md rounded-lg p-6 max-w-sm min-h-[200px] flex flex-col justify-between text-left">
                            <h4 class="text-lg font-bold text-gray-800">Tiara Sabrina</h4>
                            <p class="mt-2 text-gray-600">
                                Rekomendasi setiap ke khasanah sari selalu beli abon pedas 😭 karena se enak itu, sampe
                                mmh aku aja
                                ketagihan 😂
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script src="js/Swiper.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: false,
        offset: 100,
        mirror: true,
    });
</script>

<?php include 'footer.php'; ?>