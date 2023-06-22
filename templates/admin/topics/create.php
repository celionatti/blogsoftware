<?php

use Core\Config;
use Core\Forms\BootstrapForm;

$this->setHeader("Create Topic");

?>


<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Create New Topic</h2>
    <form action="" method="post">

        <?= BootstrapForm::inputField('Topic', 'topic', $topic->topic ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2 col'], $errors) ?>

        <?= bootstrapForm::selectField('Status', 'status', $topic->status ?? '', $statusOpts ?? [], ['class' => 'form-control form-select'], ['class' => 'form-floating col'], $errors) ?>

        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/topics" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Create Topic</button>
            </div>
        </div>
    </form>
</div>

<?php $this->end() ?>