<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SazeeAI') ?> — SazeeAI</title>
    <meta name="description" content="AI Ad Canvas Generator — Generate premium AI prompts for your marketing creatives.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#f0f7ff',
                            100: '#e0efff',
                            200: '#baddff',
                            300: '#7dc2ff',
                            400: '#38a3f8',
                            500: '#0e87e9',
                            600: '#0069c7',
                            700: '#0155a1',
                            800: '#064985',
                            900: '#0b3d6f',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                },
            },
        }
    </script>

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #0e87e9, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .prompt-output {
            font-family: 'Courier New', Courier, monospace;
        }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

<?= view('partials/navbar') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
     class="fixed top-20 right-4 z-50 max-w-sm bg-green-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 transition-all">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    <span><?= esc(session()->getFlashdata('success')) ?></span>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
     class="fixed top-20 right-4 z-50 max-w-sm bg-red-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    <span><?= esc(session()->getFlashdata('error')) ?></span>
</div>
<?php endif; ?>

<!-- Page Content -->
<main>
    <?= $this->renderSection('content') ?>
</main>

<?= view('partials/footer') ?>

</body>
</html>
