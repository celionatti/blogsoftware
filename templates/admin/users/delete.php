<?php

use Core\Forms\BootstrapForm;

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Delete User (
        <span class="text-uppercase">
            <?= $user->surname ?>
            <?= $user->name ?>
        </span> )
    </h2>
    <form action="" method="POST">
        <?= BootstrapForm::method('DELETE'); ?>

        <h1 class="text-center fs-5 my-5">Are you sure you want to delete this User?</h1>

        <div class="row my-3">
            <div class="col">
                <a href="/admin/users" class="btn btn-dark w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-danger w-100">Delete User</button>
            </div>
        </div>
    </form>
</div>

<?php $this->end() ?>