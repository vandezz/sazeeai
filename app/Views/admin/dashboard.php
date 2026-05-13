<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <?php
    $cards = [
        ['Total Users',    $stats['total_users'],   '👥', 'text-blue-400'],
        ['Total Prompts',  $stats['total_prompts'],  '📝', 'text-green-400'],
        ['Pro Users',      $stats['pro_users'],      '⭐', 'text-amber-400'],
        ["Today's Prompts",$stats['today_prompts'],  '⚡', 'text-purple-400'],
    ];
    ?>
    <?php foreach ($cards as $c): ?>
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm text-gray-400"><?= $c[0] ?></span>
            <span class="text-xl"><?= $c[2] ?></span>
        </div>
        <p class="text-2xl font-bold <?= $c[3] ?>"><?= $c[1] ?></p>
    </div>
    <?php endforeach; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Prompts -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-700 flex items-center justify-between">
            <h3 class="font-semibold text-white">Recent Prompts</h3>
            <a href="<?= base_url('admin/prompts') ?>" class="text-xs text-brand-400 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-700">
            <?php foreach ($recentPrompts as $p): ?>
            <div class="px-5 py-3">
                <p class="text-sm font-medium text-white truncate"><?= esc($p['title'] ?: $p['product_name'] ?: 'Untitled') ?></p>
                <p class="text-xs text-gray-400 mt-0.5"><?= esc($p['user_name'] ?? 'Guest') ?> · <?= date('M j, g:ia', strtotime($p['created_at'])) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-700 flex items-center justify-between">
            <h3 class="font-semibold text-white">Recent Users</h3>
            <a href="<?= base_url('admin/users') ?>" class="text-xs text-brand-400 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-700">
            <?php foreach ($recentUsers as $u): ?>
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                    <?= strtoupper(substr($u['name'], 0, 1)) ?>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-white truncate"><?= esc($u['name']) ?></p>
                    <p class="text-xs text-gray-400 truncate"><?= esc($u['email']) ?></p>
                </div>
                <span class="ml-auto text-xs px-2 py-0.5 rounded-full <?= $u['role'] === 'admin' ? 'bg-orange-900/40 text-orange-400' : 'bg-gray-700 text-gray-400' ?>">
                    <?= $u['role'] ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
