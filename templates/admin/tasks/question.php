<?php

use Core\Config;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-info py-2">Create Question</h2>

    <h5 class="text-muted text-center border-bottom border-3 border-info py-2">Task:
        <?= $task->title ?>
    </h5>

    <form action="" method="post" enctype="multipart/form-data">
        <?= BootstrapForm::hidden("task_slug", $task->slug); ?>
        <?= BootstrapForm::hidden("type", $type); ?>

        <?= BootstrapForm::inputField('Question', 'question', $question->question ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= bootstrapForm::fileField('', 'image', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

        <div class="d-flex align-items-center justify-content-center my-2">
            <h5 class="mx-3">Current Question Image: </h5>
            <img src="<?= get_image() ?>" alt="" class="mx-auto d-block image-preview-edit"
                style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
        </div>

        <?php if ($type === "objective"): ?>
            <div class="row">
                <?= bootstrapForm::inputField('Option One', 'opt_one', $question->opt_one ?? '', ['class' => 'form-control'], ['class' => 'form-floating col my-2'], $errors) ?>
                <?= bootstrapForm::inputField('Option Two', 'opt_two', $question->opt_two ?? '', ['class' => 'form-control'], ['class' => 'form-floating col my-2'], $errors) ?>
            </div>
            <div class="row">
                <?= bootstrapForm::inputField('Option Three', 'opt_three', $question->opt_three ?? '', ['class' => 'form-control'], ['class' => 'form-floating col my-2'], $errors) ?>
                <?= bootstrapForm::inputField('Option Four', 'opt_four', $question->opt_four ?? '', ['class' => 'form-control'], ['class' => 'form-floating col my-2'], $errors) ?>
            </div>
        <?php endif; ?>

        <?= bootstrapForm::inputField('Correct Answer', 'correct_answer', $question->correct_answer ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::textareaField('Comment', 'comment', $question->comment ?? '', ['class' => 'form-control summernote'], ['class' => 'form-floating my-2'], $errors) ?>

        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/tasks/questions?task-slug=<?= $task->slug ?>" class="btn btn-danger w-100"><i
                        class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Add Question</button>
            </div>
        </div>
    </form>

</div>
<?php $this->end(); ?>

<?php $this->start('script'); ?>
<script src="<?= assets_path("summernote/summernote-lite.min.js") ?>"></script>
<script>
    function display_image_edit(file) {
        document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'Question Comment',
        tabsize: 2,
        height: 200
    });
</script>
<?php $this->end() ?>