<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-gray-50 dark:bg-gray-950">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8">
            <div class="text-center mb-8">
                <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold">S</span>
                    </div>
                </a>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create your account</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Start generating AI prompts for free</p>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
            <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <p class="text-sm text-red-600 dark:text-red-400"><?= esc($err) ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/register') ?>" method="POST" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="<?= old('name') ?>" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                           placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="<?= old('email') ?>" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                           placeholder="you@example.com">
                </div>

                <div x-data="{ showPw: false }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password <span class="text-gray-400 font-normal">(min. 8 characters)</span></label>
                    <div class="relative">
                        <input :type="showPw ? 'text' : 'password'" name="password" required
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                               placeholder="••••••••">
                        <button type="button" @click="showPw = !showPw"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirm" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm"
                           placeholder="••••••••">
                </div>

                <button type="submit"
                        class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all shadow-md text-sm">
                    Create Account — It's Free
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
                Already have an account?
                <a href="<?= base_url('auth/login') ?>" class="text-brand-600 dark:text-brand-400 font-medium hover:underline">Sign in</a>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
