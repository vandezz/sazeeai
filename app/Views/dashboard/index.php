<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Welcome header -->
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Welcome back, <?= esc(explode(' ', $authUser['name'])[0]) ?>! 👋
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                <?= ucfirst($sub['plan'] ?? 'free') ?> Plan ·
                <?= ($sub['prompts_used'] ?? 0) ?>/<?= ($sub['prompts_limit'] ?? 10) ?> prompts used
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= base_url('dashboard/saved') ?>"
               class="flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-gray-900 rounded-xl font-semibold text-sm transition-all shadow-md">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                Saved Prompts
            </a>
            <a href="<?= base_url('generator') ?>"
               class="flex items-center gap-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold text-sm transition-all shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Prompt Baru
            </a>
        </div>
    </div>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <?php
        $cards = [
            ['Total Prompts',  $totalPrompts,  '🗒️', 'text-blue-600 dark:text-blue-400',   'bg-blue-50 dark:bg-blue-900/20'],
            ['Saved Prompts',  $savedCount,    '⭐', 'text-amber-600 dark:text-amber-400', 'bg-amber-50 dark:bg-amber-900/20'],
            ['Plan',           ucfirst($sub['plan'] ?? 'free'), '🎯', 'text-green-600 dark:text-green-400', 'bg-green-50 dark:bg-green-900/20'],
            ['Credits Left',   max(0, ($sub['prompts_limit'] ?? 10) - ($sub['prompts_used'] ?? 0)), '⚡', 'text-purple-600 dark:text-purple-400', 'bg-purple-50 dark:bg-purple-900/20'],
        ];
        ?>
        <?php foreach ($cards as $card): ?>
        <?php $cardHref = $card[0] === 'Saved Prompts' ? base_url('dashboard/saved') : null; ?>
        <<?= $cardHref ? 'a' : 'div' ?>
            <?= $cardHref ? 'href="' . $cardHref . '"' : '' ?>
            class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 <?= $cardHref ? 'block hover:shadow-md transition-all hover:border-amber-200 dark:hover:border-amber-800' : '' ?>">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm text-gray-500 dark:text-gray-400"><?= $card[0] ?></span>
                <span class="text-xl"><?= $card[2] ?></span>
            </div>
            <p class="text-2xl font-bold <?= $card[3] ?>"><?= esc($card[1]) ?></p>
        </<?= $cardHref ? 'a' : 'div' ?>>
        <?php endforeach; ?>
    </div>

    <!-- Usage progress -->
    <?php $pct = $sub ? min(100, round(($sub['prompts_used'] / max(1, $sub['prompts_limit'])) * 100)) : 0; ?>
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Monthly Usage</span>
            <span class="text-sm text-gray-500 dark:text-gray-400"><?= $pct ?>%</span>
        </div>
        <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2.5">
            <div class="bg-brand-600 h-2.5 rounded-full transition-all" style="width: <?= $pct ?>%"></div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            <?= ($sub['prompts_used'] ?? 0) ?> of <?= ($sub['prompts_limit'] ?? 10) ?> prompts used
            <?php if ($pct >= 80): ?><span class="text-amber-500 font-medium">· Running low! <a href="<?= base_url('/') ?>#pricing" class="underline hover:text-amber-600">Upgrade plan</a></span><?php endif; ?>
        </p>
    </div>

    <!-- Recent prompts -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900 dark:text-white">Recent Prompts</h2>
            <div class="flex items-center gap-4">
                <a href="<?= base_url('dashboard/saved') ?>" class="text-sm text-amber-600 dark:text-amber-400 hover:underline">Saved prompts</a>
                <a href="<?= base_url('dashboard/history') ?>" class="text-sm text-brand-600 dark:text-brand-400 hover:underline">View all →</a>
            </div>
        </div>

        <?php if (empty($recentPrompts)): ?>
        <div class="px-6 py-12 text-center text-gray-400 dark:text-gray-600">
            <p class="text-4xl mb-3">✨</p>
            <p class="text-sm">No prompts yet. <a href="<?= base_url('generator') ?>" class="text-brand-600 dark:text-brand-400 hover:underline">Generate your first one!</a></p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-gray-50 dark:divide-gray-800">
            <?php foreach ($recentPrompts as $p): ?>
            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            <?= esc($p['title'] ?: $p['product_name'] ?: 'Untitled Prompt') ?>
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 truncate">
                            <?= esc(substr($p['generated_prompt'] ?? '', 0, 100)) ?>...
                        </p>
                        <div class="flex items-center gap-3 mt-1.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400">
                                <?= esc($p['ai_platform'] ?? 'AI') ?>
                            </span>
                            <span class="text-xs text-gray-400"><?= date('M j, Y', strtotime($p['created_at'])) ?></span>
                        </div>
                    </div>
                    <?php if ($p['is_saved']): ?>
                    <span title="Saved" class="text-amber-500 flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
