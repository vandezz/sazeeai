<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h2 class="text-lg font-semibold text-white mb-6">Analytics Overview</h2>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Prompts Per Day -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-5">
        <h3 class="text-sm font-medium text-gray-300 mb-4">Prompts — Last 7 Days</h3>
        <div class="space-y-2">
            <?php
            $max = max(array_column($promptsPerDay, 'total') ?: [1]);
            foreach ($promptsPerDay as $row):
                $pct = $max > 0 ? round(($row['total'] / $max) * 100) : 0;
            ?>
            <div>
                <div class="flex justify-between text-xs text-gray-400 mb-1">
                    <span><?= esc($row['date']) ?></span>
                    <span><?= $row['total'] ?></span>
                </div>
                <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-brand-500 rounded-full" style="width: <?= $pct ?>%"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Platform Distribution -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-5">
        <h3 class="text-sm font-medium text-gray-300 mb-4">Top Platforms</h3>
        <div class="space-y-2">
            <?php
            $total = array_sum(array_column($platformStats, 'total')) ?: 1;
            foreach ($platformStats as $row):
                $pct = round(($row['total'] / $total) * 100);
            ?>
            <div>
                <div class="flex justify-between text-xs text-gray-400 mb-1">
                    <span><?= esc($row['ai_platform'] ?? 'Unknown') ?></span>
                    <span><?= $row['total'] ?> (<?= $pct ?>%)</span>
                </div>
                <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 rounded-full" style="width: <?= $pct ?>%"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Plan Distribution -->
    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-5">
        <h3 class="text-sm font-medium text-gray-300 mb-4">Plan Distribution</h3>
        <div class="space-y-3">
            <?php foreach ($planStats as $row): ?>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <?php
                    $colors = ['free' => 'bg-gray-400', 'pro' => 'bg-brand-500', 'agency' => 'bg-purple-500'];
                    $c = $colors[$row['plan']] ?? 'bg-gray-400';
                    ?>
                    <span class="w-2.5 h-2.5 rounded-full <?= $c ?>"></span>
                    <span class="text-sm text-gray-300 capitalize"><?= esc($row['plan']) ?></span>
                </div>
                <span class="text-sm font-semibold text-white"><?= $row['count'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
