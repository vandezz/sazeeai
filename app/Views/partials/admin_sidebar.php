<!-- Admin Sidebar -->
<aside class="w-64 bg-gray-800 border-r border-gray-700 flex flex-col flex-shrink-0 transition-transform duration-200 fixed lg:relative inset-y-0 left-0 z-30 lg:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       x-cloak>

    <!-- Logo -->
    <div class="px-6 py-5 border-b border-gray-700 flex items-center gap-2">
        <div class="w-7 h-7 bg-gradient-to-br from-brand-500 to-indigo-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-xs">S</span>
        </div>
        <span class="font-bold text-white">SazeeAI <span class="text-xs text-brand-400 font-normal">Admin</span></span>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <?php
        $currentUri = current_url();
        $links = [
            ['url' => base_url('admin'),           'label' => 'Dashboard',   'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['url' => base_url('admin/users'),     'label' => 'Users',       'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ['url' => base_url('admin/templates'), 'label' => 'Templates',   'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['url' => base_url('admin/platforms'), 'label' => 'AI Platforms','icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-2'],
            ['url' => base_url('admin/styles'),    'label' => 'Styles',      'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
            ['url' => base_url('admin/prompts'),   'label' => 'Prompts',     'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z'],
            ['url' => base_url('admin/analytics'), 'label' => 'Analytics',   'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        ];
        foreach ($links as $link):
            $active = str_contains($currentUri, $link['url']);
        ?>
        <a href="<?= $link['url'] ?>"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  <?= $active ? 'bg-brand-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $link['icon'] ?>"/>
            </svg>
            <?= $link['label'] ?>
        </a>
        <?php endforeach; ?>
    </nav>

    <!-- User at bottom -->
    <div class="px-4 py-4 border-t border-gray-700">
        <a href="<?= base_url('/') ?>" class="flex items-center gap-2 text-xs text-gray-500 hover:text-gray-300 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            View Site
        </a>
        <a href="<?= base_url('auth/logout') ?>" class="flex items-center gap-2 text-xs text-red-400 hover:text-red-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
        </a>
    </div>
</aside>
