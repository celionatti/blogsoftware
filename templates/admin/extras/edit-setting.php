<?php

use Core\Config;
use Core\Forms\BootstrapForm;

$this->setHeader("Update Setting");

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Update Setting</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <?= BootstrapForm::method("PATCH"); ?>
        <?= BootstrapForm::inputField('Setting Name', 'name', $setting->name ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= bootstrapForm::selectField('Setting Type', 'type', $setting->type ?? '', $typeOpts ?? [], ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?php if ($setting->type === "image"): ?>
                <?= bootstrapForm::fileField('', 'value', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col my-2 form-floating'], $errors) ?>

                <div class="d-flex align-items-center justify-content-center">
                <h5 class="mx-3">Current Image: </h5>
                <img src="<?= get_image($setting->value) ?? '' ?>" alt="" class="mx-auto d-block image-preview-edit"
                        style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
                </div>
        <?php elseif ($setting->type === "link"): ?>
                <?= BootstrapForm::inputField('Setting URL', 'value', $setting->value ?? '', ['class' => 'form-control', 'type' => "url"], ['class' => 'form-floating my-2'], $errors) ?>
        <?php elseif ($setting->type === "text"): ?>
                <?= BootstrapForm::textareaField('Content', 'value', $setting->value ?? '', ['class' => 'form-control summernote'], ['class' => 'form-floating my-2'], $errors) ?>
        <?php else: ?>
                <p class="text-center mx-auto text-danger small fw-semibold border-top border-dark border-3 py-2 my-2">
                Note it will show up in the edit mode, after creating it.
                </p>
        <?php endif; ?>
        <?= bootstrapForm::selectField('Setting Status', 'status', $setting->status ?? '', $statusOpts ?? [], ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>
        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/settings" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Update</button>
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
        placeholder: 'Setting Content',
        tabsize: 2,
        height: 300
    });
</script>
<?php $this->end(); ?>