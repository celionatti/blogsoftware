<?php

use Core\Config;


?>


<nav aria-label="breadcrumb" class="d-flex justify-content-center align-items-center border-bottom border-3 border-info my-1">
    <ol class="breadcrumb">
        <?php $count = count($navigations); ?>
        <?php foreach ($navigations as $index => $navigation) : ?>
            <?php if($index === $count - 1): ?>
                <li class="breadcrumb-item <?= ($index === $count - 1) ? 'active' : '' ?>"><?= $navigation['label'] ?></a></li>
            <?php else: ?>
                <li class="breadcrumb-item"><a href="<?= Config::get("domain") . $navigation['url'] ?>"><?= $navigation['label'] ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
