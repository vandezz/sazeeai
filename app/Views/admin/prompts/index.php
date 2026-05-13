<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-700">
        <h2 class="font-semibold text-white">All Prompts</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-700/50">
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Prompt</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">User</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Platform</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php foreach ($prompts as $p): ?>
                <tr class="hover:bg-gray-700/30">
                    <td class="px-5 py-3">
                        <p class="text-white font-medium truncate max-w-xs"><?= esc($p['title'] ?: $p['product_name'] ?: 'Untitled') ?></p>
                        <p class="text-gray-400 text-xs truncate max-w-xs"><?= esc(substr($p['generated_prompt'] ?? '', 0, 80)) ?>...</p>
                    </td>
                    <td class="px-5 py-3 text-gray-300 text-xs">
                        <?= esc($p['user_name'] ?? 'Guest') ?><br>
                        <span class="text-gray-500"><?= esc($p['user_email'] ?? '') ?></span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs bg-brand-900/40 text-brand-400"><?= esc($p['ai_platform'] ?? '-') ?></span>
                    </td>
                    <td class="px-5 py-3 text-gray-400 text-xs"><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
