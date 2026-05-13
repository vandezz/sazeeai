<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if ($msg = session('success')): ?>
<div class="mb-4 bg-green-900/30 border border-green-500/40 rounded-xl px-5 py-3 flex items-center gap-3 text-sm text-green-400">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    <?= $msg ?>
</div>
<?php endif; ?>

<div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-700 flex items-center justify-between">
        <h2 class="font-semibold text-white">All Users</h2>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-400"><?= count($users) ?> shown</span>
            <a href="<?= base_url('admin/users/create') ?>"
               class="flex items-center gap-1.5 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-semibold rounded-xl transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Member
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-700/50">
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">User</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Role</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Plan</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Joined</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php foreach ($users as $u): ?>
                <tr class="hover:bg-gray-700/30 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-600/50 flex items-center justify-center text-brand-300 text-xs font-bold">
                                <?= strtoupper(substr($u['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="text-white font-medium"><?= esc($u['name']) ?></p>
                                <p class="text-gray-400 text-xs"><?= esc($u['email']) ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs <?= $u['role'] === 'admin' ? 'bg-orange-900/40 text-orange-400' : 'bg-gray-700 text-gray-400' ?>">
                            <?= $u['role'] ?>
                        </span>
                    </td>
                    <td class="px-5 py-3" id="plan-cell-<?= $u['id'] ?>">
                        <?php
                        $plan = $u['plan'] ?? 'free';
                        $isPremium = in_array($plan, ['pro', 'agency']);
                        $planLabel = $isPremium ? 'Premium' : 'Free';
                        $planClass = $isPremium ? 'bg-amber-900/40 text-amber-400' : 'bg-gray-700 text-gray-400';
                        ?>
                        <span class="px-2 py-0.5 rounded-full text-xs <?= $planClass ?>">
                            <?= $planLabel ?>
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs <?= $u['is_active'] ? 'bg-green-900/40 text-green-400' : 'bg-red-900/40 text-red-400' ?>">
                            <?= $u['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-400 text-xs"><?= date('M j, Y', strtotime($u['created_at'])) ?></td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                        <a href="<?= base_url('admin/users/' . $u['id'] . '/edit') ?>"
                           class="text-xs px-3 py-1 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        <?php if ($u['id'] !== $authUser['id']): ?>
                        <button onclick="toggleUser(<?= $u['id'] ?>, this)"
                                data-active="<?= $u['is_active'] ?>"
                                class="text-xs px-3 py-1 rounded-lg transition-colors <?= $u['is_active'] ? 'bg-red-900/30 text-red-400 hover:bg-red-900/60' : 'bg-green-900/30 text-green-400 hover:bg-green-900/60' ?>">
                            <?= $u['is_active'] ? 'Deactivate' : 'Activate' ?>
                        </button>
                        <?php if ($u['role'] !== 'admin'): ?>
                        <button onclick="setPlan(<?= $u['id'] ?>, '<?= $isPremium ? 'free' : 'pro' ?>', this)"
                                class="text-xs px-3 py-1 rounded-lg transition-colors <?= $isPremium ? 'bg-gray-700 text-gray-400 hover:bg-gray-600' : 'bg-amber-900/30 text-amber-400 hover:bg-amber-900/60' ?>">
                            <?= $isPremium ? '→ Free' : '→ Premium' ?>
                        </button>
                        <?php endif; ?>
                        <button onclick="deleteUser(<?= $u['id'] ?>, '<?= esc(addslashes($u['name'])) ?>')"
                                class="text-xs px-3 py-1 rounded-lg bg-red-900/20 text-red-500 hover:bg-red-900/50 transition-colors">
                            Hapus
                        </button>
                        <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if ($pager): ?>
    <div class="px-6 py-4 border-t border-gray-700">
        <?= $pager->links() ?>
    </div>
    <?php endif; ?>
</div>

<script>
const csrfName  = '<?= csrf_token() ?>';
const csrfHash  = '<?= csrf_hash() ?>';
const baseUrl   = '<?= base_url('admin/users/') ?>';

async function toggleUser(id, btn) {
    const res  = await fetch(`${baseUrl}${id}/toggle`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ [csrfName]: csrfHash }),
    });
    const data = await res.json();
    if (data.success) { location.reload(); }
}

async function setPlan(id, newPlan, btn) {
    const res  = await fetch(`${baseUrl}${id}/set-plan`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ [csrfName]: csrfHash, plan: newPlan }),
    });
    const data = await res.json();
    if (data.success) { location.reload(); }
}

async function deleteUser(id, name) {
    if (! confirm(`Yakin hapus akun "${name}"?\nTindakan ini tidak dapat dibatalkan.`)) return;
    const res  = await fetch(`${baseUrl}${id}/delete`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ [csrfName]: csrfHash }),
    });
    if (res.ok) { location.reload(); }
}
</script>

<?= $this->endSection() ?>
