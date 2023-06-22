<?php

use Core\Config;
use Core\Forms\BootstrapForm;

$this->setHeader("Delete Article");

?>

<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Delete Article (
        <span class="text-uppercase">
            <?= $article->title ?>
        </span> )
    </h2>
    <form action="" method="POST">
        <?= BootstrapForm::method('DELETE'); ?>

        <h1 class="text-center fs-5 my-5">Are you sure you want to delete this Article?</h1>

        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/articles" class="btn btn-dark w-100"><i class="bi bi-arrow-left-circle"></i>
                    Cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-danger w-100">Delete Article</button>
            </div>
        </div>
    </form>
</div>

<?php $this->end() ?>