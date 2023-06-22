<?php

use Core\Config;
use Core\Forms\BootstrapForm;

$this->setHeader("Edit Topic");

?>


<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Update Topic
        <span>
            (
            <?= $topic->topic ?> )
        </span>
    </h2>
    <form action="" method="post">
        <?= bootstrapForm::method('PATCH'); ?>

        <?= BootstrapForm::inputField('Topic', 'topic', $topic->topic ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2 col'], $errors) ?>

        <?= bootstrapForm::selectField('Status', 'status', $topic->status ?? '', $statusOpts ?? [], ['class' => 'form-control form-select'], ['class' => 'form-floating col'], $errors) ?>

        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/topics" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Update Topic</button>
            </div>
        </div>
    </form>
</div>

<?php $this->end() ?>