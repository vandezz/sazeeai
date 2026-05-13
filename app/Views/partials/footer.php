<footer class="bg-gray-900 dark:bg-gray-950 text-gray-400 py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">S</span>
                    </div>
                    <span class="font-bold text-xl text-white">SazeeAI</span>
                </div>
                <p class="text-sm leading-relaxed max-w-xs">
                    Generate premium AI prompts for digital flyers, banners, and marketing creatives powered by the best AI tools.
                </p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3 text-sm">Product</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= base_url('generator') ?>" class="hover:text-white transition-colors">Generator</a></li>
                    <li><a href="<?= base_url('/') ?>#features" class="hover:text-white transition-colors">Features</a></li>
                    <li><a href="<?= base_url('/') ?>#pricing" class="hover:text-white transition-colors">Pricing</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3 text-sm">Account</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= base_url('auth/login') ?>" class="hover:text-white transition-colors">Login</a></li>
                    <li><a href="<?= base_url('auth/register') ?>" class="hover:text-white transition-colors">Register</a></li>
                    <?php if (session()->get('user_id')): ?>
                    <li><a href="<?= base_url('dashboard') ?>" class="hover:text-white transition-colors">Dashboard</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-6 text-center text-xs">
            <p>&copy; <?= date('Y') ?> SazeeAI. All rights reserved. Built with CodeIgniter 4 &amp; Tailwind CSS.</p>
        </div>
    </div>
</footer>
