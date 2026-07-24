<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="flex justify-center mt-8">
    <ul class="inline-flex -space-x-px text-sm">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-2xl hover:bg-gray-100 hover:text-gray-700 transition-all">
                    <span aria-hidden="true">««</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 transition-all">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 transition-all <?= $link['active'] ? 'z-10 text-indigo-600 border-indigo-300 bg-indigo-50 font-black' : 'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 transition-all">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-2xl hover:bg-gray-100 hover:text-gray-700 transition-all">
                    <span aria-hidden="true">»»</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
