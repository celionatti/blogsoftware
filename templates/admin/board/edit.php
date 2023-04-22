<?php

use Core\Forms\BootstrapForm;

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Update Board Post</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <?= BootstrapForm::method("PATCH"); ?>

        <?= BootstrapForm::inputField('Title', 'title', $board->title ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::textareaField('Content', 'content', $board->content ?? '', ['class' => 'form-control summernote'], ['class' => 'form-floating my-2'], $errors) ?>

        <div class="row">
            <?= bootstrapForm::inputField('Author', 'author', $board->author ?? '', ['class' => 'form-control'], ['class' => 'form-floating col'], $errors) ?>

            <?= bootstrapForm::fileField('', 'thumbnail', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

            <div class="d-flex align-items-center justify-content-center my-2">
                <h5 class="mx-3">Current Board Thumbnail: </h5>
                <img src="<?= get_image($board->thumbnail) ?? '' ?>" alt="" class="mx-auto d-block image-preview-edit"
                    style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
            </div>
            <?= bootstrapForm::inputField('Thumbnail Caption', 'thumbnail_caption', $board->thumbnail_caption ?? '', ['class' => 'form-control'], ['class' => 'form-floating col'], $errors) ?>
        </div>

        <small class="mt-3 text-danger">Meta Details</small>

        <?= BootstrapForm::inputField('Meta Title', 'meta_title', $board->meta_title ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::inputField('Meta Keywords', 'meta_keywords', $board->meta_keywords ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::inputField('Meta Description', 'meta_description', $board->meta_description ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <div class="row my-3">
            <div class="col">
                <a href="/admin/board-posts" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Create Board Post</button>
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
        placeholder: 'Board Post Content',
        tabsize: 2,
        height: 400
    });
</script>
<?php $this->end() ?>