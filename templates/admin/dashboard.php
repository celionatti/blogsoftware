<?php


use Core\Config;


?>

<?php $this->start('content') ?>

<?php include('../templates/partials/breadcrumbs.php') ?>
<div id="table-actions" class="row mt-3">

    <div class="col text-start">
        <a href="<?= Config::get('domain') ?>admin/board-posts" class="btn btn-primary btn-sm position-relative">
            <i class="bi bi-user"></i>
            Board Posts
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                99+
                <span class="visually-hidden">unread messages</span>
            </span>
        </a>
    </div>

    <div class="col text-end">
        <a href="<?= Config::get('domain') ?>admin/subscribers" class="btn btn-warning btn-sm position-relative">
            <i class="bi bi-user"></i>
            Subscribers
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                99+
                <span class="visually-hidden">unread messages</span>
            </span>
        </a>
    </div>
</div>

<div class="row border-bottom border-3 border-secondary p-2 m-2">
    <!-- Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-header"># of Articles</div>
            <div class="card-body">
                <h4 class="m-0 bi bi-newspaper"></h4>
                <h2 class="m-0"><?= $articles_count ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= Config::get('domain') ?>admin/articles">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <!-- // Card -->

    <!-- Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-header"># of Users</div>
            <div class="card-body">
                <h4 class="m-0 bi bi-people"></h4>
                <h2 class="m-0"><?= $users_count ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= Config::get('domain') ?>admin/users">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <!-- // Card -->

    <!-- Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-header">Withdrawal Request</div>
            <div class="card-body">
                <h4 class="m-0 bi bi-wallet2"></h4>
                <h2 class="m-0"><?= $withdrawals_count ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= Config::get('domain') ?>admin/credits">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <!-- // Card -->

    <!-- Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-header"># of Messages</div>
            <div class="card-body">
                <h4 class="m-0 bi bi-envelope-open"></h4>
                <h2 class="m-0"><?= $messages_count ?></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= Config::get("domain") ?>admin/messages">View Details</a>
                <div class="small text-white"><i class="bi bi-angle-right"></i></div>
            </div>
        </div>
    </div>
    <!-- // Card -->
</div>

<?php $this->end() ?>