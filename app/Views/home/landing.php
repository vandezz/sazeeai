<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- ===========================
     HERO SECTION
     =========================== -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-950 via-gray-900 to-indigo-950 text-white py-24 md:py-36">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-700/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-500/10 border border-brand-500/30 text-brand-300 text-xs font-semibold mb-8 uppercase tracking-widest">
            <span class="w-2 h-2 bg-brand-400 rounded-full animate-pulse"></span>
            Akses Premium — Khusus Member
        </div>

        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight mb-6">
            Buat Prompt Banner Iklan
            <span class="bg-gradient-to-r from-brand-400 to-indigo-400 bg-clip-text text-transparent"> dengan AI</span>
            <br>Dalam Detik
        </h1>

        <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed">
            Isi detail produk Anda, dan SazeeAI akan menghasilkan prompt profesional siap pakai
            untuk ChatGPT, Midjourney, DALL-E, Flux & lebih banyak lagi.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?= base_url('auth/login') ?>"
               class="px-9 py-4 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-600/40 transition-all transform hover:scale-105 text-base">
                Masuk ke Aplikasi →
            </a>
            <a href="#cara-akses"
               class="px-9 py-4 border border-white/20 hover:border-white/40 text-white font-semibold rounded-xl transition-all text-base">
                Cara Mendapatkan Akses
            </a>
        </div>

        <!-- Lock badge -->
        <div class="mt-10 inline-flex items-center gap-2 text-xs text-gray-400">
            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
            Akses eksklusif — hanya untuk member yang telah melakukan pembelian
        </div>
    </div>
</section>

<!-- ===========================
     PREVIEW MOCKUP SECTION
     =========================== -->
<section class="py-16 bg-gray-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-gray-500 text-xs uppercase tracking-widest mb-8 font-semibold">Tampilan Aplikasi</p>

        <!-- Mockup window -->
        <div class="rounded-2xl border border-gray-700 overflow-hidden shadow-2xl shadow-black/60">
            <!-- Browser bar -->
            <div class="bg-gray-800 px-4 py-3 flex items-center gap-2 border-b border-gray-700">
                <div class="flex gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-red-500/70"></span>
                    <span class="w-3 h-3 rounded-full bg-yellow-500/70"></span>
                    <span class="w-3 h-3 rounded-full bg-green-500/70"></span>
                </div>
                <div class="flex-1 mx-4 bg-gray-700 rounded-md px-3 py-1 text-xs text-gray-400 text-center">
                    🔒 sazeeai.com/generator
                </div>
            </div>
            <!-- Blurred app preview -->
            <div class="relative bg-gray-950 p-6 md:p-10 select-none">
                <div class="blur-sm pointer-events-none opacity-60">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="bg-gray-800 rounded-xl p-4 space-y-3">
                                <div class="h-3 bg-gray-600 rounded w-1/3"></div>
                                <div class="h-9 bg-gray-700 rounded-lg"></div>
                                <div class="h-3 bg-gray-600 rounded w-1/3"></div>
                                <div class="h-9 bg-gray-700 rounded-lg"></div>
                                <div class="h-3 bg-gray-600 rounded w-1/2"></div>
                                <div class="h-20 bg-gray-700 rounded-lg"></div>
                            </div>
                            <div class="bg-gray-800 rounded-xl p-4 space-y-3">
                                <div class="h-3 bg-gray-600 rounded w-1/3"></div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="h-8 bg-gray-700 rounded-lg"></div>
                                    <div class="h-8 bg-brand-700 rounded-lg"></div>
                                    <div class="h-8 bg-gray-700 rounded-lg"></div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-gray-800 rounded-xl p-4 space-y-3">
                                <div class="h-3 bg-gray-600 rounded w-1/4"></div>
                                <div class="h-32 bg-gray-700 rounded-lg"></div>
                                <div class="h-9 bg-brand-700 rounded-lg"></div>
                            </div>
                            <div class="bg-gray-800 rounded-xl p-4">
                                <div class="h-3 bg-gray-600 rounded w-1/3 mb-3"></div>
                                <div class="space-y-2">
                                    <div class="h-3 bg-gray-700 rounded w-full"></div>
                                    <div class="h-3 bg-gray-700 rounded w-5/6"></div>
                                    <div class="h-3 bg-gray-700 rounded w-4/6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lock overlay -->
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-950/70 backdrop-blur-[2px]">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-brand-600/20 border border-brand-500/40 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <p class="text-white font-semibold text-lg mb-1">Konten Premium</p>
                        <p class="text-gray-400 text-sm mb-5">Login untuk mengakses generator</p>
                        <a href="<?= base_url('auth/login') ?>" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-sm font-semibold rounded-xl transition-all">
                            Masuk Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===========================
     FEATURES SECTION
     =========================== -->
<section id="features" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-brand-600 dark:text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Fitur Unggulan</p>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Semua yang Anda Butuhkan untuk
                <span class="bg-gradient-to-r from-brand-500 to-indigo-500 bg-clip-text text-transparent"> Desain Banner Iklan</span>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                Engine prompt kami dirancang khusus untuk menghasilkan instruksi AI yang detail dan berkualitas tinggi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $features = [
                ['🎨', 'Multi-Style Design', 'Pilih dari Cinematic Luxury, Minimalist Modern, Futuristic Tech, Bold Vibrant & banyak style lainnya.'],
                ['🤖', '6+ Platform AI', 'Output dioptimasi untuk ChatGPT, Midjourney, DALL-E, Flux, Ideogram, Leonardo AI.'],
                ['⚡', 'Generate Instan', 'Satu klik langsung menghasilkan prompt profesional yang terstruktur dan siap pakai.'],
                ['📋', 'Copy & Download', 'Salin ke clipboard atau download sebagai file TXT — langsung tempel ke AI tool favorit Anda.'],
                ['📚', 'Riwayat Prompt', 'Semua prompt yang Anda generate tersimpan otomatis di akun Anda.'],
                ['📱', 'Mobile Friendly', 'Gunakan SazeeAI dari HP, tablet, atau laptop dengan nyaman.'],
            ];
            foreach ($features as $f): ?>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 hover:shadow-md transition-shadow border border-gray-100 dark:border-gray-700">
                <div class="text-3xl mb-4"><?= $f[0] ?></div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2"><?= $f[1] ?></h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed"><?= $f[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===========================
     HOW IT WORKS
     =========================== -->
<section class="py-20 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-brand-600 dark:text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Cara Kerja</p>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-14">
            3 Langkah Mudah Buat Prompt Banner
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- connector line desktop -->
            <div class="hidden md:block absolute top-6 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-brand-500/0 via-brand-500/40 to-brand-500/0"></div>
            <?php $steps = [
                ['1','Isi Formulir','Masukkan nama brand, produk, headline, fitur unggulan, dan preferensi visual.'],
                ['2','Generate Prompt','Klik tombol Generate — engine kami membangun prompt AI yang terstruktur dan profesional.'],
                ['3','Pakai di AI Tool','Copy prompt dan paste ke ChatGPT, Midjourney, atau AI image generator pilihan Anda.'],
            ]; ?>
            <?php foreach ($steps as $i => $step): ?>
            <div class="relative flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-brand-600 text-white font-bold text-lg flex items-center justify-center mb-4 shadow-lg shadow-brand-600/30 z-10">
                    <?= $step[0] ?>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2"><?= $step[1] ?></h3>
                <p class="text-sm text-gray-500 dark:text-gray-400"><?= $step[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===========================
     CARA MENDAPATKAN AKSES
     =========================== -->
<section id="cara-akses" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-brand-600 dark:text-brand-400 text-sm font-semibold uppercase tracking-widest mb-3">Akses Premium</p>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Cara Mendapatkan Akses
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                SazeeAI adalah tools premium. Ikuti 3 langkah berikut untuk mendapatkan akses.
            </p>
        </div>

        <div class="space-y-4">
            <?php
            $access_steps = [
                ['01', 'bg-brand-600', 'Lakukan Pemesanan di OrderHero', 'Kunjungi halaman order kami di <strong>orderhero.id</strong> dan lakukan pemesanan. Isi nama & email Anda dengan benar.', 'https://orderhero.id', 'Pesan Sekarang →'],
                ['02', 'bg-indigo-600', 'Konfirmasi Pembayaran', 'Selesaikan pembayaran sesuai instruksi. Setelah pembayaran terkonfirmasi, tim kami akan memproses akun Anda.', null, null],
                ['03', 'bg-green-600', 'Terima Kredensial & Login', 'Anda akan menerima <strong>email</strong> dan <strong>password</strong> akun dari kami. Gunakan untuk login dan mulai gunakan SazeeAI!', null, null],
            ];
            foreach ($access_steps as $s): ?>
            <div class="flex gap-5 p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="flex-shrink-0 w-10 h-10 rounded-xl <?= $s[1] ?> text-white font-bold text-sm flex items-center justify-center">
                    <?= $s[0] ?>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1"><?= $s[2] ?></h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed"><?= $s[3] ?></p>
                    <?php if ($s[4]): ?>
                    <a href="<?= $s[4] ?>" target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-sm text-brand-600 dark:text-brand-400 font-semibold hover:underline">
                        <?= $s[5] ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-10 text-center">
            <p class="text-gray-400 text-sm mb-5">Sudah punya akun?</p>
            <a href="<?= base_url('auth/login') ?>"
               class="inline-block px-10 py-4 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-600/30 transition-all transform hover:scale-105 text-base">
                Login ke SazeeAI →
            </a>
        </div>
    </div>
</section>

<!-- ===========================
     TESTIMONIAL / TRUST
     =========================== -->
<section class="py-16 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-8">Dipercaya oleh para kreator & pebisnis digital</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $testimonials = [
                ['"Prompt yang dihasilkan sangat detail, langsung bisa dipakai di Midjourney. Banner produk saya jadi jauh lebih profesional."', 'Rina S.', 'Pemilik Toko Online'],
                ['"Dulu harus spend berjam-jam nulis prompt, sekarang cuma butuh 30 detik. Game changer banget buat bisnis saya!"', 'Dimas P.', 'Digital Marketer'],
                ['"Hasilnya konsisten dan sesuai brand guideline. Sangat membantu untuk tim kreatif kami."', 'Sari W.', 'Creative Director'],
            ];
            foreach ($testimonials as $t): ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 text-left">
                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-4"><?= $t[0] ?></p>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white text-sm"><?= $t[1] ?></p>
                    <p class="text-gray-400 text-xs"><?= $t[2] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===========================
     CTA SECTION
     =========================== -->
<section class="py-20 bg-gradient-to-br from-brand-700 via-brand-600 to-indigo-700 text-white">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Membuat Banner Iklan Profesional?</h2>
        <p class="text-brand-100 mb-6 text-lg">Dapatkan akses dan mulai generate prompt AI berkualitas tinggi hari ini.</p>

        <!-- Countdown Timer -->
        <div class="mb-8">
            <p class="text-brand-200 text-sm font-medium mb-3 uppercase tracking-widest">⏳ Penawaran berakhir dalam</p>
            <div class="inline-flex items-center gap-2 sm:gap-3" id="countdown-timer">
                <div class="flex flex-col items-center">
                    <span id="cd-hours" class="text-4xl sm:text-5xl font-extrabold tabular-nums leading-none">01</span>
                    <span class="text-brand-200 text-xs mt-1 uppercase tracking-widest">Jam</span>
                </div>
                <span class="text-3xl sm:text-4xl font-extrabold text-brand-300 pb-4">:</span>
                <div class="flex flex-col items-center">
                    <span id="cd-minutes" class="text-4xl sm:text-5xl font-extrabold tabular-nums leading-none">00</span>
                    <span class="text-brand-200 text-xs mt-1 uppercase tracking-widest">Menit</span>
                </div>
                <span class="text-3xl sm:text-4xl font-extrabold text-brand-300 pb-4">:</span>
                <div class="flex flex-col items-center">
                    <span id="cd-seconds" class="text-4xl sm:text-5xl font-extrabold tabular-nums leading-none">00</span>
                    <span class="text-brand-200 text-xs mt-1 uppercase tracking-widest">Detik</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#cara-akses"
               class="px-9 py-4 bg-white text-brand-700 font-bold rounded-xl hover:bg-brand-50 shadow-lg transition-all transform hover:scale-105 text-base">
                Dapatkan Akses →
            </a>
            <a href="<?= base_url('auth/login') ?>"
               class="px-9 py-4 border border-white/30 hover:border-white/60 text-white font-semibold rounded-xl transition-all text-base">
                Sudah Punya Akun? Login
            </a>
        </div>
    </div>
</section>

<script>
(function () {
    const STORAGE_KEY = 'sazeeai_cta_expiry';
    const DURATION_MS = 60 * 60 * 1000; // 1 jam

    let expiry = parseInt(localStorage.getItem(STORAGE_KEY), 10);
    if (!expiry || Date.now() > expiry) {
        expiry = Date.now() + DURATION_MS;
        localStorage.setItem(STORAGE_KEY, expiry);
    }

    const elH = document.getElementById('cd-hours');
    const elM = document.getElementById('cd-minutes');
    const elS = document.getElementById('cd-seconds');

    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        const diff = Math.max(0, expiry - Date.now());
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        elH.textContent = pad(h);
        elM.textContent = pad(m);
        elS.textContent = pad(s);
        if (diff <= 0) {
            clearInterval(timer);
            localStorage.removeItem(STORAGE_KEY);
        }
    }

    tick();
    const timer = setInterval(tick, 1000);
})();
</script>

<?= $this->endSection() ?>
