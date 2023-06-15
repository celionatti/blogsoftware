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

<div class="row border border-3 border-secondary p-2 m-2">
    <div class="col card">
        <div class="card-header">
            <h3 class="card-title">Subscribers</h3>
        </div>
        <div class="card-body">

        </div>
        <div class="card-footer">
            
        </div>
    </div>
</div>

<?php $this->end() ?>