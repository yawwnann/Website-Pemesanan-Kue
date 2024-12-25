<?php include 'header.php'; ?>
<div class="container mx-auto py-16 px-4 md:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

    <div class="p-8 bg-white rounded-lg shadow-xl hover:shadow-2xl transition duration-300" data-aos="fade-right">
        <h2 class="text-3xl font-bold text-purple-600 mb-6">Hubungi Kami</h2>
        <p class="text-gray-600 mb-6 text-lg" data-aos="fade-up" data-aos-delay="100">
            Kami senang mendengar dari Anda. Silakan isi form berikut dan kami akan segera menghubungi Anda.
        </p>

        <form action="#" class="space-y-6">
            <div class="relative" data-aos="fade-up" data-aos-delay="200">
                <input type="text" name="name" id="name" placeholder=" "
                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 transition duration-200 input-field">
                <label for="name" class="absolute left-4 top-4 text-gray-500 transition-all duration-200">Nama *</label>
            </div>

            <div class="relative" data-aos="fade-up" data-aos-delay="300">
                <input type="email" name="email" id="email" placeholder=" "
                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 transition duration-200 input-field">
                <label for="email" class="absolute left-4 top-4 text-gray-500 transition-all duration-200">Email
                    *</label>
            </div>

            <div class="relative" data-aos="fade-up" data-aos-delay="400">
                <input type="tel" name="phone" id="phone" placeholder=" "
                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 transition duration-200 input-field">
                <label for="phone" class="absolute left-4 top-4 text-gray-500 transition-all duration-200">Nomor Telepon
                    *</label>
            </div>

            <div class="relative" data-aos="fade-up" data-aos-delay="500">
                <select name="inquiry" id="inquiry" required
                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 transition duration-200">
                    <option value="" disabled selected>Bagaimana Anda menemukan kami?</option>
                    <option value="google">Google</option>
                    <option value="social-media">Media Sosial</option>
                    <option value="referral">Referensi</option>
                </select>
            </div>

            <div class="relative" data-aos="fade-up" data-aos-delay="600">
                <textarea name="message" rows="4" placeholder=" " required
                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 transition duration-200 input-field"></textarea>
                <label for="message" class="absolute left-4 top-4 text-gray-500 transition-all duration-200">Pesan
                    Anda</label>
            </div>

            <button type="submit"
                class="w-full bg-purple-600 text-white py-4 rounded-lg hover:bg-purple-700 transition duration-300 font-semibold"
                data-aos="fade-up" data-aos-delay="700">KIRIM PESAN</button>
        </form>
    </div>

    <div class="p-8 bg-white rounded-lg shadow-xl hover:shadow-2xl transition duration-300" data-aos="fade-left">
        <h3 class="text-2xl font-bold text-purple-600 mb-4">Lokasi Kami</h3>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2794.906330183016!2d110.38073404585195!3d-7.832675564020434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5701a2ae1c23%3A0x173dbeeddc56d9e!2sUniversitas%20Ahmad%20Dahlan%20-%20Kampus%204!5e0!3m2!1sid!2sid!4v1735155711008!5m2!1sid!2sid"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

</div>

<?php include "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-in-out',
    });
</script>