<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
<div class="mb-4 bg-green-900/30 border border-green-700 rounded-xl px-4 py-3 text-sm text-green-400">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-white">AI Platforms</h2>
    <a href="<?= base_url('admin/platforms/create') ?>"
       class="px-4 py-2 bg-violet-600 hover:bg-violet-500 text-white rounded-xl text-sm font-medium transition-all">
        + Tambah Platform
    </a>
</div>

<div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
    <div class="overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-700/50">
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">#</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Slug</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Prompt Suffix</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php foreach ($platforms as $i => $p): ?>
                <tr class="hover:bg-gray-700/30">
                    <td class="px-5 py-3 text-gray-500"><?= $i + 1 ?></td>
                    <td class="px-5 py-3 text-white font-medium"><?= esc($p['name']) ?></td>
                    <td class="px-5 py-3 text-gray-400 font-mono text-xs"><?= esc($p['slug']) ?></td>
                    <td class="px-5 py-3 text-gray-400 text-xs max-w-xs truncate"><?= esc($p['prompt_suffix']) ?></td>
                    <td class="px-5 py-3">
                        <form action="<?= base_url('admin/platforms/' . $p['id'] . '/toggle') ?>" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="px-2 py-0.5 rounded-full text-xs <?= $p['is_active'] ? 'bg-green-900/40 text-green-400 hover:bg-red-900/40 hover:text-red-400' : 'bg-gray-700 text-gray-400 hover:bg-green-900/40 hover:text-green-400' ?> transition-all">
                                <?= $p['is_active'] ? 'Active' : 'Inactive' ?>
                            </button>
                        </form>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <a href="<?= base_url('admin/platforms/' . $p['id'] . '/edit') ?>" class="text-xs text-blue-400 hover:text-blue-300">Edit</a>
                            <form action="<?= base_url('admin/platforms/' . $p['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Hapus platform ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-xs text-red-400 hover:text-red-300">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
