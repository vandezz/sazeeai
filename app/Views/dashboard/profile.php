<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">My Profile</h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="p-6 bg-gradient-to-br from-brand-600 to-indigo-700 text-white flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <div>
                <p class="font-bold text-lg"><?= esc($user['name']) ?></p>
                <p class="text-brand-100 text-sm"><?= esc($user['email']) ?></p>
                <p class="text-xs text-brand-200 mt-1">Member since <?= date('M Y', strtotime($user['created_at'])) ?></p>
            </div>
        </div>

        <form action="<?= base_url('dashboard/profile') ?>" method="POST" class="p-6 space-y-5">
            <?= csrf_field() ?>

            <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 rounded-xl p-4">
                <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
                <p class="text-sm text-red-600 dark:text-red-400"><?= esc($err) ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Full Name</label>
                <input type="text" name="name" value="<?= esc($user['name']) ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
                <input type="email" name="email" value="<?= esc($user['email']) ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm">
            </div>

            <hr class="border-gray-100 dark:border-gray-800">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Change Password <span class="text-xs font-normal text-gray-400">(leave blank to keep current)</span></p>

            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1.5">New Password</label>
                <input type="password" name="password" minlength="8"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                       placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1.5">Confirm New Password</label>
                <input type="password" name="password_confirm"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                       placeholder="••••••••">
            </div>

            <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all text-sm">
                Save Changes
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
