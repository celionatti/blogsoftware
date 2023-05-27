<?php

use Core\Config;
use Core\Forms\BootstrapForm;

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Add New Setting</h2>
    <form action="" method="post">
        <?= BootstrapForm::inputField('Setting Name', 'name', $setting->name ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

        <?= bootstrapForm::selectField('Setting Type', 'type', $setting->type ?? '', $typeOpts ?? [], ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>
        
        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/settings" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Create</button>
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