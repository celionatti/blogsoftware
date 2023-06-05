<?php

use Core\Config;
use Core\Forms\BootstrapForm;


?>


<?php $this->start('header') ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<style>
    .author-bg {
        background-image: url('/assets/img/bg-2.jpg');
        background-position: center;
        background-repeat: no-repeat, repeat;
        background-size: cover;
        background-blend-mode: lighten;
    }
</style>
<?php $this->end(); ?>


<?php $this->start('content') ?>
<form action="" method="post" enctype="multipart/form-data">
    <?= BootstrapForm::method("PATCH"); ?>
    <div class="p-2 mb-4 bg-light rounded-3">
        <div class="container-fluid d-flex justify-content-center align-items-center author-bg rounded">
            <img src="<?= get_image($user->avatar) ?>" class="m-2 img-thumbnail image-preview-edit"
                style="object-fit: cover; height: 350px; width:350px; border-radius: 50%;" />
        </div>

        <?= bootstrapForm::fileField('', 'avatar', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

        <div class="pt-3 pb-5">
            <?= BootstrapForm::inputField('Surname', 'surname', $user->surname ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Name', 'name', $user->name ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Username', 'username', $user->username ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('E-Mail', 'email', $user->email ?? '', ['class' => 'form-control', 'type' => 'email'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Phone Number', 'phone', $user->phone ?? '', ['class' => 'form-control', 'type' => 'tel'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Social (Twitter)', 'social', $user->social ?? '', ['class' => 'form-control', 'type' => 'url'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Token (Pin)', 'token', $user->token ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::textareaField('Bio', 'bio', $user->bio ?? '', ['class' => 'form-control summernote'], ['class' => 'form-floating mb-2'], $errors) ?>

            <div class="row mt-3">
                <div class="col">
                    <a href="<?= Config::get('domain') ?>account" class="btn btn-sm btn-danger w-100"><i
                            class="bi bi-arrow-left-circle"></i>
                        cancel</a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-dark w-100">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $this->end(); ?>


<?php $this->start('script'); ?>
<script src="<?= assets_path("summernote/summernote-lite.min.js") ?>"></script>
<script>
    function display_image_edit(file) {
        document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'Your Bio',
        tabsize: 2,
        height: 250
    });
</script>
<?php $this->end() ?>