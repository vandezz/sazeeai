<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-white">Prompt Templates</h2>
    <a href="<?= base_url('admin/templates/create') ?>"
       class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-medium transition-all">
        + New Template
    </a>
</div>

<div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-700/50">
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Category</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php foreach ($templates as $t): ?>
                <tr class="hover:bg-gray-700/30">
                    <td class="px-5 py-3">
                        <p class="text-white font-medium"><?= esc($t['name']) ?></p>
                        <p class="text-gray-400 text-xs"><?= esc($t['slug']) ?></p>
                    </td>
                    <td class="px-5 py-3 text-gray-400"><?= esc($t['category'] ?? '-') ?></td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs <?= $t['is_active'] ? 'bg-green-900/40 text-green-400' : 'bg-gray-700 text-gray-400' ?>">
                            <?= $t['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                        <?php if ($t['is_premium']): ?>
                        <span class="ml-1 px-2 py-0.5 rounded-full text-xs bg-amber-900/40 text-amber-400">Pro</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 flex items-center gap-2">
                        <a href="<?= base_url('admin/templates/' . $t['id'] . '/edit') ?>"
                           class="text-xs px-3 py-1 rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-300 transition-all">Edit</a>
                        <form action="<?= base_url('admin/templates/' . $t['id'] . '/delete') ?>" method="POST"
                              onsubmit="return confirm('Delete this template?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-xs px-3 py-1 rounded-lg bg-red-900/30 hover:bg-red-900/60 text-red-400 transition-all">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
