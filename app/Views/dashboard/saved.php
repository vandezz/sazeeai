<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="savedPrompts()">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                Prompt Tersimpan
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Prompt yang kamu simpan — bisa diedit dan di-generate ulang kapan saja.
            </p>
        </div>
        <a href="<?= base_url('generator') ?>"
           class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-medium transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Prompt Baru
        </a>
    </div>

    <?php if (empty($prompts)): ?>
    <!-- Empty state -->
    <div class="text-center py-24">
        <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-amber-500/10 flex items-center justify-center">
            <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
        </div>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-1">Belum ada prompt tersimpan</p>
        <p class="text-sm text-gray-400 mb-6">Setelah generate prompt, klik ikon bookmark untuk menyimpannya.</p>
        <a href="<?= base_url('generator') ?>"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Mulai Generate
        </a>
    </div>

    <?php else: ?>
    <!-- Grid of saved prompts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <?php foreach ($prompts as $p): ?>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 overflow-hidden transition-shadow hover:shadow-md"
             x-data="{
                 expanded: false,
                 deleted: false,
                 renaming: false,
                 renameValue: <?= json_encode($p['title'] ?: ($p['product_name'] ?: 'Untitled')) ?>,
                 copied: false,
             }"
             x-show="!deleted">

            <div class="p-5">
                <!-- Title row -->
                <div class="flex items-start justify-between gap-3 mb-3">
                    <!-- Title (click to rename) -->
                    <div class="flex-1 min-w-0">
                        <template x-if="!renaming">
                            <div class="flex items-center gap-1.5 group cursor-pointer" @click="renaming = true; $nextTick(() => $refs.renameInput_<?= $p['id'] ?>.focus())">
                                <p class="font-semibold text-gray-900 dark:text-white text-sm truncate" x-text="renameValue"></p>
                                <svg class="w-3.5 h-3.5 text-gray-400 opacity-0 group-hover:opacity-100 shrink-0 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                        </template>
                        <template x-if="renaming">
                            <div class="flex items-center gap-2">
                                <input x-ref="renameInput_<?= $p['id'] ?>"
                                       x-model="renameValue"
                                       @keydown.enter="saveRename(<?= $p['id'] ?>)"
                                       @keydown.escape="renaming = false"
                                       @blur="saveRename(<?= $p['id'] ?>)"
                                       class="flex-1 text-sm font-semibold bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg px-2 py-1 border border-brand-400 outline-none min-w-0">
                                <button @click.stop="saveRename(<?= $p['id'] ?>)"
                                        class="shrink-0 text-brand-400 hover:text-brand-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </div>
                        </template>

                        <!-- Meta tags -->
                        <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                            <?php if ($p['ai_platform']): ?>
                            <span class="px-2 py-0.5 rounded-full text-xs bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400 font-medium"><?= esc($p['ai_platform']) ?></span>
                            <?php endif; ?>
                            <?php if ($p['design_style']): ?>
                            <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300"><?= esc($p['design_style']) ?></span>
                            <?php endif; ?>
                            <?php if ($p['color_theme']): ?>
                            <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400"><?= esc($p['color_theme']) ?></span>
                            <?php endif; ?>
                            <span class="text-xs text-gray-400 ml-auto"><?= date('d M Y', strtotime($p['created_at'])) ?></span>
                        </div>
                    </div>

                    <!-- Bookmark (unsave) icon -->
                    <button @click="unsave(<?= $p['id'] ?>)"
                            title="Hapus dari simpan"
                            class="shrink-0 p-1.5 rounded-lg text-amber-400 hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    </button>
                </div>

                <!-- Prompt preview (truncated) -->
                <div class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-3 mb-4 font-mono bg-gray-50 dark:bg-gray-800/60 rounded-lg px-3 py-2.5 border border-gray-100 dark:border-gray-700/50">
                    <?= esc(substr($p['generated_prompt'] ?? '', 0, 200)) ?>...
                </div>

                <!-- Action buttons -->
                <div class="flex items-center gap-2 flex-wrap">
                    <!-- Edit & Regenerate — primary action -->
                    <a href="<?= base_url('generator') ?>?load=<?= $p['id'] ?>"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit &amp; Generate Ulang
                    </a>

                    <!-- Copy prompt -->
                    <button @click="copyPrompt(<?= json_encode($p['generated_prompt'] ?? '') ?>)"
                            :class="copied ? 'text-green-400 border-green-600 bg-green-900/20' : 'text-gray-400 border-gray-200 dark:border-gray-700 hover:text-green-400 hover:border-green-600'"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl border text-xs font-medium transition-all">
                        <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg x-show="copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                    </button>

                    <!-- Expand/collapse full prompt -->
                    <button @click="expanded = !expanded"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:text-gray-200 text-xs font-medium transition-all ml-auto">
                        <svg class="w-3.5 h-3.5 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        <span x-text="expanded ? 'Sembunyikan' : 'Lihat Prompt'"></span>
                    </button>
                </div>

                <!-- Full prompt (expanded) -->
                <div x-show="expanded" x-cloak x-transition class="mt-4">
                    <div class="bg-gray-950 rounded-xl border border-gray-700 overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-2 bg-gray-800/80 border-b border-gray-700">
                            <span class="text-xs text-gray-400 font-mono">prompt.txt</span>
                        </div>
                        <pre class="text-xs text-green-300 whitespace-pre-wrap leading-relaxed font-mono p-4 max-h-72 overflow-y-auto"><?= esc($p['generated_prompt'] ?? '') ?></pre>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
function savedPrompts() {
    return {
        copied: false,
        async copyPrompt(text) {
            try {
                await navigator.clipboard.writeText(text);
            } catch (e) {
                const el = document.createElement('textarea');
                el.value = text;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
            }
            this.copied = true;
            setTimeout(() => this.copied = false, 2500);
        },
        async unsave(id) {
            if (!confirm('Hapus prompt ini dari daftar simpan?')) return;
            const res = await fetch(`<?= base_url('dashboard/save-prompt/') ?>${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }),
            });
            const data = await res.json();
            if (data.success && !data.saved) {
                // Find the Alpine component wrapping this card and mark it deleted
                const card = event.target.closest('[x-data]');
                if (card && card.__x) card.__x.$data.deleted = true;
            }
        },
        async saveRename(id) {
            const card = event?.target?.closest('[x-data]');
            const name = card?.__x?.$data?.renameValue?.trim() ?? '';
            if (!name) return;
            await fetch(`<?= base_url('dashboard/rename-prompt/') ?>${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    title: name,
                }),
            });
            if (card?.__x) card.__x.$data.renaming = false;
        },
    };
}
</script>

<?= $this->endSection() ?>
