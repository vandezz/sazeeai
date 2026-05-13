<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-gray-50 dark:bg-gray-950">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reset Password</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Enter your email to receive a reset link</p>
            </div>

            <?php if ($resetLink = session()->getFlashdata('reset_link')): ?>
            <div class="mb-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <p class="text-sm text-blue-700 dark:text-blue-300 font-medium mb-1">Dev mode — Reset link:</p>
                <a href="<?= esc($resetLink) ?>" class="text-xs text-blue-600 dark:text-blue-400 break-all hover:underline"><?= esc($resetLink) ?></a>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/forgot') ?>" method="POST" class="space-y-5">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                           placeholder="you@example.com">
                </div>
                <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all text-sm">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
                <a href="<?= base_url('auth/login') ?>" class="text-brand-600 dark:text-brand-400 hover:underline">← Back to login</a>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
