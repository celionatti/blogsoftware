<?php


use Core\Config;


?>

<?php $this->start('content') ?>

<div id="table-actions" class="row mt-3">

    <div class="col text-start">
        <a href="<?= Config::get('domain') ?>admin/board-posts" class="btn btn-primary btn-sm">
            <i class="bi bi-user"></i>
            Board Posts
        </a>
    </div>

    <div class="col text-end">
        <a href="<?= Config::get('domain') ?>admin/subscribers" class="btn btn-warning btn-sm">
            <i class="bi bi-user"></i>
            Subscribers
        </a>
    </div>
</div>

<?php $this->end() ?>