<?php $pager->setSurroundCount(2); ?>
<nav class="flex items-center justify-center gap-1" aria-label="Pagination">
    <?php if ($pager->hasPrevious()): ?>
    <a href="<?= $pager->getFirst() ?>" class="px-3 py-1.5 rounded-lg text-sm bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-brand-50 dark:hover:bg-brand-900/20 hover:text-brand-600 transition-all">&laquo;</a>
    <a href="<?= $pager->getPrevious() ?>" class="px-3 py-1.5 rounded-lg text-sm bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-brand-50 dark:hover:bg-brand-900/20 hover:text-brand-600 transition-all">&lsaquo;</a>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
    <a href="<?= $link['uri'] ?>"
       class="px-3 py-1.5 rounded-lg text-sm transition-all <?= $link['active'] ? 'bg-brand-600 text-white font-medium' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-brand-50 dark:hover:bg-brand-900/20 hover:text-brand-600' ?>">
        <?= $link['title'] ?>
    </a>
    <?php endforeach; ?>

    <?php if ($pager->hasNext()): ?>
    <a href="<?= $pager->getNext() ?>" class="px-3 py-1.5 rounded-lg text-sm bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-brand-50 dark:hover:bg-brand-900/20 hover:text-brand-600 transition-all">&rsaquo;</a>
    <a href="<?= $pager->getLast() ?>" class="px-3 py-1.5 rounded-lg text-sm bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-brand-50 dark:hover:bg-brand-900/20 hover:text-brand-600 transition-all">&raquo;</a>
    <?php endif; ?>
</nav>
