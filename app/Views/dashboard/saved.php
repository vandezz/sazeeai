<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Saved Prompts</h1>

    <?php if (empty($prompts)): ?>
    <div class="text-center py-20 text-gray-400 dark:text-gray-600">
        <p class="text-5xl mb-4">⭐</p>
        <p>No saved prompts yet. <a href="<?= base_url('generator') ?>" class="text-brand-600 dark:text-brand-400 hover:underline">Generate and save some!</a></p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <?php foreach ($prompts as $p): ?>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-start justify-between gap-2 mb-3">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">
                    <?= esc($p['title'] ?: $p['product_name'] ?: 'Untitled') ?>
                </p>
                <span class="text-amber-400 flex-shrink-0">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 line-clamp-3">
                <?= esc(substr($p['generated_prompt'] ?? '', 0, 150)) ?>...
            </p>
            <div class="flex items-center gap-2 flex-wrap">
                <?php if ($p['ai_platform']): ?>
                <span class="px-2 py-0.5 rounded-full text-xs bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400"><?= esc($p['ai_platform']) ?></span>
                <?php endif; ?>
                <span class="text-xs text-gray-400 ml-auto"><?= date('M j, Y', strtotime($p['created_at'])) ?></span>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-50 dark:border-gray-800">
                <button onclick="navigator.clipboard.writeText(<?= json_encode($p['generated_prompt']) ?>)"
                        class="text-xs text-brand-600 dark:text-brand-400 hover:underline">Copy Prompt</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
