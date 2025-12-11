<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="inline-flex -space-x-px text-sm">
        <?php if ($pager->hasPreviousPage()) : ?>
        <li>
            <a href="<?= $pager->getPreviousPage() ?>" aria-label="<?= lang('Pager.previous') ?>"
                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= lang('Pager.previous') ?></a>
        </li>
        <?php endif ?>

        <?php foreach ($pager->links() as  $link) : ?>
        <li>
            <a href="<?= $link['uri'] ?>"
                class="flex items-center justify-center px-3 h-8  border border-gray-300 <?= $link['active'] ? 'bg-blue-400 hover:bg-blue-500 text-white' :'bg-blue-50 hover:bg-blue-100 text-blue-600' ?> hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?= $link['title'] ?></a>
        </li>
        <?php endforeach ?>
        <?php if ($pager->hasNextPage()) : ?>
        <li>
            <a href="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>"
                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= lang('Pager.next') ?></a>
        </li>
        <?php endif ?>
    </ul>
</nav>