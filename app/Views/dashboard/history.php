<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Prompt History</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">All your generated prompts</p>
        </div>
        <a href="<?= base_url('generator') ?>" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-medium transition-all">New Prompt</a>
    </div>

    <?php if (empty($prompts)): ?>
    <div class="text-center py-20 text-gray-400 dark:text-gray-600">
        <p class="text-5xl mb-4">📋</p>
        <p>No prompts yet. <a href="<?= base_url('generator') ?>" class="text-brand-600 dark:text-brand-400 hover:underline">Generate your first prompt!</a></p>
    </div>
    <?php else: ?>
    <div class="space-y-4" x-data="{}">
        <?php foreach ($prompts as $p): ?>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 hover:shadow-sm transition-shadow"
             x-data="{ expanded: false, deleted: false }" x-show="!deleted">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 dark:text-white">
                        <?= esc($p['title'] ?: $p['product_name'] ?: 'Untitled') ?>
                    </p>
                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                        <?php if ($p['ai_platform']): ?>
                        <span class="px-2 py-0.5 rounded-full text-xs bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400"><?= esc($p['ai_platform']) ?></span>
                        <?php endif; ?>
                        <?php if ($p['design_style']): ?>
                        <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400"><?= esc($p['design_style']) ?></span>
                        <?php endif; ?>
                        <span class="text-xs text-gray-400"><?= date('M j, Y · g:i a', strtotime($p['created_at'])) ?></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <button @click="expanded = !expanded" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <button @click="deletePrompt(<?= $p['id'] ?>, $el)" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>

            <!-- Expanded prompt -->
            <div x-show="expanded" x-cloak class="mt-4">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <pre class="text-xs text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed font-mono"><?= esc($p['generated_prompt']) ?></pre>
                </div>
                <div class="mt-2 flex gap-2">
                    <button @click="copyText(`<?= addslashes($p['generated_prompt']) ?>`)"
                            class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-600 dark:text-gray-400 hover:text-green-700 transition-all">
                        Copy Prompt
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pager): ?>
    <div class="mt-6">
        <?= $pager->links('default', 'tailwind_pagination') ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<script>
async function deletePrompt(id, el) {
    if (!confirm('Delete this prompt?')) return;
    const res = await fetch(`<?= base_url('dashboard/delete-prompt/') ?>${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }),
    });
    const data = await res.json();
    if (data.success) {
        // Alpine x-show will hide, but simplest is just remove
        el.closest('[x-data]').__x.$data.deleted = true;
    }
}
async function copyText(text) {
    await navigator.clipboard.writeText(text);
    alert('Copied!');
}
</script>

<?= $this->endSection() ?>
