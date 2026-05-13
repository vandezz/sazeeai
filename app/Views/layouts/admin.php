<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> — SazeeAI Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['Inter', 'ui-sans-serif'] } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-900 text-gray-100" x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?= view('partials/admin_sidebar') ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
        <header class="bg-gray-800 border-b border-gray-700 px-6 py-4 flex items-center justify-between">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="text-lg font-semibold"><?= esc($title ?? 'Admin Panel') ?></h1>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-400"><?= esc($authUser['name'] ?? '') ?></span>
                <a href="<?= base_url('auth/logout') ?>" class="text-sm text-red-400 hover:text-red-300">Logout</a>
            </div>
        </header>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="mx-6 mt-4 bg-green-900/50 border border-green-500 text-green-300 px-4 py-3 rounded-lg text-sm">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="mx-6 mt-4 bg-red-900/50 border border-red-500 text-red-300 px-4 py-3 rounded-lg text-sm">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
        <?php endif; ?>

        <!-- Page body -->
        <main class="flex-1 overflow-y-auto p-6">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

</body>
</html>
