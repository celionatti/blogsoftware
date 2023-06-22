<?php

use Core\Config;
use Core\Forms\BootstrapForm;

$this->setHeader("Create Task");

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Create Task</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <?= BootstrapForm::inputField('Title', 'title', $task->title ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>


        <div class="row">
            <?= bootstrapForm::selectField('Type', 'type', $task->type ?? '', $typeOpts ?? [], ['class' => 'form-select form-select-lg'], ['class' => 'form-floating col'], $errors) ?>

            <?= bootstrapForm::fileField('', 'thumbnail', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

            <div class="d-flex align-items-center justify-content-center my-2">
                <h5 class="mx-3">Current Task Thumbnail: </h5>
                <img src="<?= get_image($task->thumbnail) ?>" alt="" class="mx-auto d-block image-preview-edit"
                    style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
            </div>
        </div>

        <?= BootstrapForm::textareaField('Instruction', 'instruction', $task->instruction ?? '', ['class' => 'form-control summernote'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= bootstrapForm::inputField('Time', 'time', $task->time ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= bootstrapForm::inputField('Questions Limit', 'limit', $task->limit ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= bootstrapForm::selectField('Status', 'status', $task->status ?? '', $statusOpts ?? [], ['class' => 'form-select form-select-lg'], ['class' => 'form-floating col'], $errors) ?>

        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/tasks" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Create Task</button>
            </div>
        </div>
    </form>
</div>

<?php $this->end() ?>

<?php $this->start('script'); ?>
<script src="<?= assets_path("summernote/summernote-lite.min.js") ?>"></script>
<script>
    function display_image_edit(file) {
        document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'Task Instruction',
        tabsize: 2,
        height: 400
    });
</script>
<?php $this->end() ?>