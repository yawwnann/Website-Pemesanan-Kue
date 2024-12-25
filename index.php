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
    <div class="min-h-screen px-6 py-10 flex items-center bg-gradient-to-br from-pink-50 via-purple-100 to-pink-300">
        <div class="container mx-auto px-6 lg:px-20 py-10 flex flex-col lg:flex-row items-center">
            <!-- Bagian Kiri: Teks dan Tombol -->
            <div class="lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0" data-aos="fade-right">
                <h1 class="text-4xl lg:text-6xl font-extrabold text-purple-800 leading-tight">
                    Momen Manis, Dipanggang dengan Cinta
                </h1>
                <p class="mt-6 text-gray-600 text-lg lg:text-xl">
                    Kue, hidangan manis, dan semua yang spesial untuk momen istimewa Anda.
                </p>
                <a href="pages/products.php"
                    class="mt-8 inline-block bg-purple-600 text-white text-lg px-8 py-3 rounded-lg hover:bg-purple-700 transition duration-300"
                    data-aos="zoom-in">
                    Belanja Sekarang
                </a>
                <!-- Ikon Media Sosial -->
                <div class="mt-8 flex justify-center lg:justify-start space-x-4">
                    <a href="#"
                        class="bg-purple-200 text-purple-600 w-12 h-12 flex items-center justify-center rounded-full hover:bg-purple-300 transition"
                        data-aos="fade-up" data-aos-delay="100">
                        <i class="bx bxl-facebook text-2xl"></i>
                    </a>
                    <a href="#"
                        class="bg-purple-200 text-purple-600 w-12 h-12 flex items-center justify-center rounded-full hover:bg-purple-300 transition"
                        data-aos="fade-up" data-aos-delay="200">
                        <i class="bx bxl-linkedin text-2xl"></i>
                    </a>
                    <a href="#"
                        class="bg-purple-200 text-purple-600 w-12 h-12 flex items-center justify-center rounded-full hover:bg-purple-300 transition"
                        data-aos="fade-up" data-aos-delay="300">
                        <i class="bx bxl-instagram text-2xl"></i>
                    </a>
                </div>
            </div>

            <!-- Bagian Kanan: Gambar -->
            <div class="lg:w-1/2 flex justify-center relative" data-aos="fade-left">
                <img src="img/kue1.png" alt="Kue dan Donat" class="w-full max-w-3xl relative z-10">
            </div>
        </div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center"
        style="background: linear-gradient(to right, rgba(255, 214, 244, 0.8), rgba(252, 249, 251, 0.8)), url('img/bg-prof2.jpg'); background-size: cover; background-position: center;">
        <div class="container mx-auto px-6 lg:px-20 py-8 flex flex-col lg:flex-row items-center lg:items-start">
            <!-- Bagian Kiri -->
            <div class="lg:w-1/2 text-center lg:text-left space-y-4">
                <h3 class="text-lg font-semibold text-pink-800 uppercase" data-aos="fade-down">Kesenangan yang
                    Dipanggang dengan Cinta</h3>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800" data-aos="fade-down">Bakery Indonesia</h1>
                <p class="text-lg text-gray-Black" data-aos="fade-right">
                    Selamat datang di Bakery Indonesia! Dengan lebih dari 90 cabang yang tersebar di seluruh Indonesia,
                    termasuk Sumatra, Kalimantan, Sulawesi, Jawa, dan Kepulauan Bangka, Bakery Indonesia adalah tujuan
                    utama untuk hidangan panggang yang segar, lezat, dan berkualitas tinggi. Kami bangga menghadirkan
                    bukan hanya produk, tetapi juga pengalaman—perjalanan penuh senyuman hangat, aroma dapur, dan rasa
                    yang tak terlupakan.
                </p>
            </div>
            <div class="lg:w-1/2 flex justify-center mt-6 lg:mt-0" data-aos="fade-left">
                <img src="img/roti-profil.jpg" alt="Roti Profil"
                    class="rounded-lg shadow-lg object-cover w-full max-w-md lg:max-w-lg">
            </div>
        </div>
    </div>

    <div class="bg-pink-50 py-16">
        <div class="container mx-auto px-6 lg:px-20 flex flex-wrap justify-center gap-8">
            <!-- Card Diskon -->
            <div class="bg-purple-600 text-white rounded-lg shadow-lg p-6 w-full lg:w-[45%] flex flex-col justify-between relative overflow-hidden"
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
            <div class="bg-purple-600 text-white rounded-lg shadow-lg p-6 w-full lg:w-[45%] flex flex-col justify-between relative overflow-hidden"
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

    <!-- Bagian Kartu -->
    <div class="bg-pink-50 min-h-screen ">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Judul Bagian dan Tombol -->
            <div class="flex justify-between items-center mb-10" data-aos="fade-down">
                <div>
                    <h3 class="text-lg font-semibold text-orange-600 uppercase">Temukan produk yang paling dicintai dan
                        populer</h3>
                    <h1 class="text-4xl font-bold text-gray-800 mt-2">Produk Terlaris Kami</h1>
                </div>
                <a href="show_products.php"
                    class="bg-purple-600 text-white text-lg px-6 py-3 rounded-lg hover:bg-purple-700 transition shadow-md">
                    Lihat Lainnya
                </a>
            </div>

            <!-- Slider Produk -->
            <div class="swiper mySwiper mx-auto" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <?php
                    $query = $pdo->query("SELECT * FROM products limit 10");
                    $products = $query->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($products as $product):
                        ?>
                        <!-- Kartu dalam Slider -->
                        <div class="swiper-slide">
                            <div class="bg-white rounded-lg p-3 shadow-md overflow-hidden flex flex-col items-center h-[450px] w-[300px] mx-auto"
                                data-aos="fade-up">
                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="w-full h-[60%] object-cover rounded-lg">
                                <div class="p-6 flex flex-col justify-between h-[40%]">
                                    <h3 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($product['name']) ?>
                                    </h3>
                                    <p class="text-base text-gray-600 mt-2">
                                        <?= strlen($product['description']) > 50 ? substr(htmlspecialchars($product['description']), 0, 50) . '...' : htmlspecialchars($product['description']) ?>
                                    </p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-xl font-semibold text-purple-800">
                                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                        </span>
                                        <a href="#"
                                            class="bg-purple-600 text-white text-lg px-4 py-2 rounded-lg hover:bg-purple-700 transition shadow-md">
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
    <div class="bg-pink-50 py-16">
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



<!-- Tambahkan Swiper.js JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>


<!-- Inisialisasi Swiper.js -->
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