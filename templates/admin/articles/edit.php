<?php

use Core\Forms\BootstrapForm;

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Update Article</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <?= BootstrapForm::method('PATCH'); ?>

        <?= BootstrapForm::inputField('Title', 'title', $article->title ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::textareaField('Content', 'content', $article->content ?? '', ['class' => 'form-control summernote'], ['class' => 'form-floating my-2'], $errors) ?>

        <div class="row">
            <?= bootstrapForm::selectField('Topics', 'topic', $article->topic ?? '', $topicOpts ?? [], ['class' => 'form-control'], ['class' => 'form-floating col'], $errors) ?>

            <?= bootstrapForm::fileField('', 'thumbnail', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

            <div class="d-flex align-items-center justify-content-center my-2">
                <h5 class="mx-3">Current Article Thumbnail: </h5>
                <img src="<?= get_image($article->thumbnail) ?? '' ?>" alt="" class="mx-auto d-block image-preview-edit"
                    style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
            </div>
            <?= bootstrapForm::inputField('Thumbnail Caption', 'thumbnail_caption', $article->thumbnail_caption ?? '', ['class' => 'form-control'], ['class' => 'form-floating col'], $errors) ?>
        </div>

        <div class="row mt-3">
            <?= bootstrapForm::inputField('Author', 'author', $article->author ?? '', ['class' => 'form-control'], ['class' => 'form-floating col'], $errors) ?>

            <?= bootstrapForm::fileField('', 'sub_image', ['class' => 'form-control', 'onchange' => "display_sub_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

            <div class="d-flex align-items-center justify-content-center my-2">
                <h5 class="mx-3">Current Article Sub Image: </h5>
                <img src="<?= get_image($article->sub_image) ?? '' ?>" alt=""
                    class="mx-auto d-block image-sub_preview-edit"
                    style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
            </div>
            <?= bootstrapForm::inputField('Sub Thumbnail Caption', 'sub_image_caption', $article->sub_image_caption ?? '', ['class' => 'form-control'], ['class' => 'form-floating col'], $errors) ?>
        </div>

        <small class="">Meta Details</small>

        <?= BootstrapForm::inputField('Meta Title', 'meta_title', $article->meta_title ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::inputField('Meta Keywords', 'meta_keywords', $article->meta_keywords ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= BootstrapForm::inputField('Meta Description', 'meta_description', $article->meta_description ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= bootstrapForm::selectField('Status', 'status', $article->status ?? '', $statusOpts ?? [], ['class' => 'form-select form-select-lg'], ['class' => 'form-floating col'], $errors) ?>

        <div class="row my-3">
            <div class="col">
                <a href="/admin/articles" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Update Article</button>
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

    function display_sub_image_edit(file) {
        document.querySelector(".image-sub_preview-edit").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'Article content',
        tabsize: 2,
        height: 400
    });
</script>
<?php $this->end() ?>