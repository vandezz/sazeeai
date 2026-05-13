<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="<?= base_url('admin/users') ?>" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-white">Edit User</h1>
            <p class="text-xs text-gray-400 mt-0.5"><?= esc($user['email']) ?></p>
        </div>
    </div>

    <!-- Success Flash -->
    <?php if ($msg = session('success')): ?>
    <div class="bg-green-900/30 border border-green-500/40 rounded-xl px-5 py-3 flex items-center gap-3 text-sm text-green-400">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <?= $msg ?>
    </div>
    <?php endif; ?>

    <!-- Error Flash -->
    <?php if ($errors = session('errors')): ?>
    <div class="bg-red-900/30 border border-red-500/40 rounded-xl px-5 py-4 text-sm text-red-300">
        <ul class="space-y-1 list-disc list-inside">
            <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Reset Password Success -->
    <?php if ($rs = session('reset_success')): ?>
    <div class="bg-green-900/30 border border-green-500/40 rounded-2xl p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-7 h-7 rounded-full bg-green-500/20 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="font-semibold text-green-400 text-sm">Password berhasil direset!</p>
        </div>
        <div id="reset-box" class="bg-gray-900 rounded-xl p-4 font-mono text-sm space-y-1 border border-gray-700">
            <p class="text-gray-400">👤 Nama: <span class="text-white"><?= esc($rs['name']) ?></span></p>
            <p class="text-gray-400">🔑 Password Baru: <span class="text-white"><?= esc($rs['password']) ?></span></p>
        </div>
        <button onclick="copyReset()" class="mt-3 flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-500 text-white text-xs font-semibold rounded-xl transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span id="copy-reset-text">Salin Kredensial</span>
        </button>
        <script>
        function copyReset() {
            const text = '👤 Nama: <?= esc($rs['name']) ?>\n🔑 Password Baru: <?= esc($rs['password']) ?>';
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById('copy-reset-text');
                btn.textContent = 'Tersalin!';
                setTimeout(() => btn.textContent = 'Salin Kredensial', 2000);
            });
        }
        </script>
    </div>
    <?php endif; ?>

    <!-- ── Edit Info Form ── -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
        <h2 class="text-white font-semibold mb-5">Informasi Akun</h2>

        <form action="<?= base_url("admin/users/{$user['id']}/edit") ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="<?= esc(old('name', $user['name'])) ?>"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                    <input type="email" name="email" value="<?= esc(old('email', $user['email'])) ?>"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                           required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Role</label>
                    <select name="role"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <option value="user"  <?= $user['role'] === 'user'  ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Status Akun</label>
                    <select name="is_active"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <option value="1" <?= $user['is_active'] ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= ! $user['is_active'] ? 'selected' : '' ?>>Non-aktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tipe Akun (Plan)</label>
                <?php
                $currentPlan = $sub['plan'] ?? 'free';
                $isPremium   = in_array($currentPlan, ['pro', 'agency']);
                ?>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-3 p-3 bg-gray-700 border-2 <?= $isPremium ? 'border-brand-500' : 'border-transparent' ?> rounded-xl cursor-pointer" id="lbl-pro">
                        <input type="radio" name="plan" value="pro" <?= $isPremium ? 'checked' : '' ?> onchange="updatePlanUI()" class="accent-brand-500">
                        <div>
                            <p class="text-white text-sm font-semibold">Premium</p>
                            <p class="text-gray-400 text-xs">Unlimited prompt</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-gray-700 border-2 <?= ! $isPremium ? 'border-brand-500' : 'border-transparent' ?> rounded-xl cursor-pointer" id="lbl-free">
                        <input type="radio" name="plan" value="free" <?= ! $isPremium ? 'checked' : '' ?> onchange="updatePlanUI()" class="accent-brand-500">
                        <div>
                            <p class="text-white text-sm font-semibold">Free</p>
                            <p class="text-gray-400 text-xs">10 prompt/bulan</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-brand-600 hover:bg-brand-500 text-white font-semibold rounded-xl transition-colors text-sm">
                    Simpan Perubahan
                </button>
                <a href="<?= base_url('admin/users') ?>"
                   class="px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-gray-300 font-medium rounded-xl transition-colors text-sm text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- ── Reset Password ── -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6">
        <h2 class="text-white font-semibold mb-1">Reset Password</h2>
        <p class="text-gray-400 text-xs mb-5">Set password baru untuk user ini. Catat dan kirimkan ke user.</p>

        <?php if ($re = session('reset_errors')): ?>
        <div class="bg-red-900/30 border border-red-500/40 rounded-xl px-4 py-3 text-sm text-red-300 mb-4">
            <?php foreach ($re as $e): ?><p><?= esc($e) ?></p><?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url("admin/users/{$user['id']}/reset-password") ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Password Baru</label>
                <div class="flex gap-2">
                    <input type="text" name="new_password" id="new-password-field"
                           placeholder="Min. 8 karakter"
                           class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                           required minlength="8">
                    <button type="button" onclick="generateResetPassword()"
                            class="px-4 py-2.5 bg-gray-700 hover:bg-gray-600 border border-gray-600 text-gray-300 hover:text-white rounded-xl text-xs font-semibold transition-colors whitespace-nowrap">
                        Generate
                    </button>
                </div>
                <p class="text-gray-500 text-xs mt-1.5">Catat password ini sebelum submit — hanya tampil sekali setelah reset.</p>
            </div>
            <button type="submit"
                    class="px-5 py-2.5 bg-violet-700 hover:bg-violet-600 text-white font-semibold rounded-xl transition-colors text-sm">
                Reset Password
            </button>
        </form>
    </div>

    <!-- ── Danger Zone ── -->
    <?php if ($user['id'] !== ($authUser['id'] ?? 0)): ?>
    <div class="bg-red-950/30 border border-red-800/40 rounded-2xl p-6">
        <h2 class="text-red-400 font-semibold mb-1 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            Zona Bahaya
        </h2>
        <p class="text-gray-400 text-xs mb-5">
            Menghapus akun ini bersifat permanen (soft delete). User tidak dapat login lagi.
        </p>
        <form action="<?= base_url("admin/users/{$user['id']}/delete") ?>" method="POST"
              onsubmit="return confirm('Yakin hapus akun <?= esc(addslashes($user['name'])) ?>?\nTindakan ini tidak dapat dibatalkan.')">
            <?= csrf_field() ?>
            <button type="submit"
                    class="px-5 py-2.5 bg-red-700 hover:bg-red-600 text-white font-semibold rounded-xl transition-colors text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus User Ini
            </button>
        </form>
    </div>
    <?php endif; ?>

</div>

<script>
function generateResetPassword() {
    const chars = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789@#$!';
    let pass = '';
    for (let i = 0; i < 12; i++) {
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('new-password-field').value = pass;
}

function updatePlanUI() {
    const pro  = document.querySelector('input[name="plan"][value="pro"]');
    const lblPro  = document.getElementById('lbl-pro');
    const lblFree = document.getElementById('lbl-free');
    if (pro.checked) {
        lblPro.classList.replace('border-transparent', 'border-brand-500');
        lblFree.classList.replace('border-brand-500', 'border-transparent');
    } else {
        lblFree.classList.replace('border-transparent', 'border-brand-500');
        lblPro.classList.replace('border-brand-500', 'border-transparent');
    }
}
</script>

<?= $this->endSection() ?>
