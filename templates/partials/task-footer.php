<?php

use Core\Config;


?>


<footer class="mt-auto text-white-50">
    <p>Task template for <a href="<?= Config::get('domain') ?>" class="text-white"><?= $this->getTitle() ?></a>, by <a
            href="<?= Config::get('domain') ?>author" class="text-white"><?= Config::get('author') ?? "Owner" ?></a>.</p>
</footer>