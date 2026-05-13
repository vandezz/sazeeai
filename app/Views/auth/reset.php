<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-gray-50 dark:bg-gray-950">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Set New Password</h2>

            <?php if (session()->getFlashdata('errors')): ?>
            <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 rounded-xl p-4">
                <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
                <p class="text-sm text-red-600 dark:text-red-400"><?= esc($err) ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/reset/' . esc($token)) ?>" method="POST" class="space-y-5">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">New Password</label>
                    <input type="password" name="password" required minlength="8"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                           placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirm" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                           placeholder="••••••••">
                </div>
                <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all text-sm">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
