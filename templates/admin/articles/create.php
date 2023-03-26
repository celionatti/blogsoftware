<?php

use Core\Forms\BootstrapForm;

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Create Article</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <?= BootstrapForm::inputField('Title', 'title', '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::textareaField('Content', 'content', '', ['class' => 'form-control summernote'], ['class' => 'form-floating my-2'], $errors) ?>

        <div class="row">
            <?= bootstrapForm::selectField('Topics', 'topic', '', [], ['class' => 'form-control'], ['class' => 'form-floating col'], $errors) ?>

            <?= bootstrapForm::fileField('', 'thumbnail', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

            <div class="d-flex align-items-center justify-content-center my-2">
                <h5 class="mx-3">Current Article Thumbnail: </h5>
                <img src="<?= get_image() ?? '' ?>" alt="" class="mx-auto d-block image-preview-edit"
                    style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
            </div>
        </div>

        <?= BootstrapForm::inputField('Title', 'title', '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>
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
        placeholder: 'Article content',
        tabsize: 2,
        height: 400
    });
</script>
<?php $this->end() ?>