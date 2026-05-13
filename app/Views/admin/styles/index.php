<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-700">
        <h2 class="font-semibold text-white">Design Styles</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-700/50">
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">#</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Keywords</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php foreach ($styles as $i => $s): ?>
                <tr class="hover:bg-gray-700/30">
                    <td class="px-5 py-3 text-gray-500"><?= $i + 1 ?></td>
                    <td class="px-5 py-3 text-white font-medium"><?= esc($s['name']) ?></td>
                    <td class="px-5 py-3 text-gray-400 text-xs max-w-xs truncate"><?= esc($s['prompt_keywords'] ?? '-') ?></td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs <?= $s['is_active'] ? 'bg-green-900/40 text-green-400' : 'bg-gray-700 text-gray-400' ?>">
                            <?= $s['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
