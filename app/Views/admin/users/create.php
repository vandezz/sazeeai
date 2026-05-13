<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="<?= base_url('admin/users') ?>" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-xl font-bold text-white">Tambah Member Baru</h1>
    </div>

    <!-- Success: Show credentials to copy -->
    <?php if ($created = session('created')): ?>
    <div class="bg-green-900/30 border border-green-500/40 rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="font-semibold text-green-400">Akun berhasil dibuat!</h2>
        </div>

        <p class="text-gray-300 text-sm mb-4">Kirimkan kredensial berikut ke member/buyer:</p>

        <div id="credentials-box" class="bg-gray-900 rounded-xl p-4 font-mono text-sm space-y-1 border border-gray-700">
            <p class="text-gray-400">🌐 Login URL: <span class="text-white"><?= base_url('auth/login') ?></span></p>
            <p class="text-gray-400">👤 Nama: <span class="text-white"><?= esc($created['name']) ?></span></p>
            <p class="text-gray-400">📧 Email: <span class="text-white"><?= esc($created['email']) ?></span></p>
            <p class="text-gray-400">🔑 Password: <span class="text-white"><?= esc($created['password']) ?></span></p>
            <p class="text-gray-400">⭐ Tipe: <span class="<?= ($created['plan'] ?? 'pro') === 'free' ? 'text-gray-300' : 'text-amber-300 font-semibold' ?>"><?= ($created['plan'] ?? 'pro') === 'free' ? 'Free (10 prompt/bulan)' : 'Premium (Unlimited)' ?></span></p>
        </div>

        <button onclick="copyCredentials()" class="mt-4 flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span id="copy-btn-text">Salin Kredensial</span>
        </button>

        <script>
        function copyCredentials() {
            const text = [
                '🌐 Login URL: <?= base_url('auth/login') ?>',
                '👤 Nama: <?= esc($created['name']) ?>',
                '📧 Email: <?= esc($created['email']) ?>',
                '🔑 Password: <?= esc($created['password']) ?>',
                '⭐ Tipe: <?= ($created['plan'] ?? 'pro') === 'free' ? 'Free (10 prompt/bulan)' : 'Premium (Unlimited)' ?>',
            ].join('\n');
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById('copy-btn-text');
                btn.textContent = 'Tersalin!';
                setTimeout(() => btn.textContent = 'Salin Kredensial', 2000);
            });
        }
        </script>
    </div>
    <?php endif; ?>

    <!-- Errors -->
    <?php if ($errors = session('errors')): ?>
    <div class="bg-red-900/30 border border-red-500/40 rounded-xl px-5 py-4 text-sm text-red-300">
        <ul class="space-y-1 list-disc list-inside">
            <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
        <h2 class="text-white font-semibold mb-5">Informasi Akun</h2>

        <form action="<?= base_url('admin/users/create') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="<?= esc(old('name')) ?>"
                       placeholder="Contoh: Budi Santoso"
                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                <input type="email" name="email" value="<?= esc(old('email')) ?>"
                       placeholder="email@member.com"
                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                <div class="flex gap-2">
                    <input type="text" name="password" id="password-field"
                           placeholder="Min. 8 karakter"
                           class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                           required minlength="8">
                    <button type="button" onclick="generatePassword()"
                            class="px-4 py-2.5 bg-gray-700 hover:bg-gray-600 border border-gray-600 text-gray-300 hover:text-white rounded-xl text-xs font-semibold transition-colors whitespace-nowrap">
                        Generate
                    </button>
                </div>
                <p class="text-gray-500 text-xs mt-1.5">Password ini yang akan Anda kirimkan ke member. Catat sebelum submit.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Tipe Akun</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-3 p-3 bg-gray-700 border-2 border-brand-500 rounded-xl cursor-pointer" id="lbl-pro">
                        <input type="radio" name="plan" value="pro" checked onchange="updatePlanUI()" class="accent-brand-500">
                        <div>
                            <p class="text-white text-sm font-semibold">Premium</p>
                            <p class="text-gray-400 text-xs">Unlimited prompt</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-gray-700 border-2 border-transparent rounded-xl cursor-pointer" id="lbl-free">
                        <input type="radio" name="plan" value="free" onchange="updatePlanUI()" class="accent-brand-500">
                        <div>
                            <p class="text-white text-sm font-semibold">Free</p>
                            <p class="text-gray-400 text-xs">10 prompt/bulan</p>
                        </div>
                    </label>
                </div>
            </div>
            <div class="pt-2">
                <button type="submit"
                        class="w-full px-4 py-3 bg-brand-600 hover:bg-brand-500 text-white font-semibold rounded-xl transition-colors text-sm">
                    Buat Akun Member
                </button>
            </div>
        </form>
    </div>

    <!-- Info box -->
    <div class="bg-gray-800/50 border border-gray-700 rounded-xl px-5 py-4 text-sm text-gray-400">
        <p class="font-semibold text-gray-300 mb-2">Alur kerja:</p>
        <ol class="list-decimal list-inside space-y-1">
            <li>Buyer order & konfirmasi pembayaran di OrderHero.id</li>
            <li>Admin buka halaman ini dan buat akun dengan email buyer</li>
            <li>Salin kredensial dan kirim ke buyer via WhatsApp/email</li>
            <li>Buyer login dengan email & password yang diberikan</li>
        </ol>
    </div>
</div>

<script>
function generatePassword() {
    const chars = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789@#$!';
    let pass = '';
    for (let i = 0; i < 12; i++) {
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('password-field').value = pass;
}
</script>

<script>
function updatePlanUI() {
    const isPro = document.querySelector('input[name="plan"][value="pro"]').checked;
    document.getElementById('lbl-pro').classList.toggle('border-brand-500', isPro);
    document.getElementById('lbl-pro').classList.toggle('border-transparent', !isPro);
    document.getElementById('lbl-free').classList.toggle('border-brand-500', !isPro);
    document.getElementById('lbl-free').classList.toggle('border-transparent', isPro);
}
</script>

<?= $this->endSection() ?>
