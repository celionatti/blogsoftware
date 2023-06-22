<?php

use Core\Config;
use Core\Forms\BootstrapForm;

$this->setHeader("Create User");

?>

<?php $this->start('header'); ?>
<link rel="stylesheet" href="<?= assets_path("summernote/summernote-lite.min.css") ?>">
<?php $this->end(); ?>

<?php $this->start('content') ?>

<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center">Create New User</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <?= BootstrapForm::inputField('Surname', 'surname', $user->surname ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2 col'], $errors) ?>

            <?= BootstrapForm::inputField('First Name', 'name', $user->name ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2 col'], $errors) ?>
        </div>

        <div class="row">
            <?= BootstrapForm::inputField('Username', 'username', $user->username ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2 col'], $errors) ?>

            <?= BootstrapForm::inputField('E-Mail', 'email', $user->email ?? '', ['class' => 'form-control', 'type' => 'email'], ['class' => 'form-floating my-2 col'], $errors) ?>
        </div>

        <div class="row">
            <?= BootstrapForm::inputField('Phone Number', 'phone', $user->phone ?? '', ['class' => 'form-control', 'type' => 'tel'], ['class' => 'form-floating my-2 col'], $errors) ?>

            <?= BootstrapForm::inputField('Social', 'social', $user->social ?? '', ['class' => 'form-control', 'type' => 'url'], ['class' => 'form-floating my-2 col'], $errors) ?>
        </div>

        <div class="row">
            <?= BootstrapForm::inputField('Password', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating my-2 col'], $errors) ?>

            <?= BootstrapForm::inputField('Confirm Password', 'confirm_password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating my-2 col'], $errors) ?>
        </div>

        <div class="row">
            <?= bootstrapForm::selectField('Access Level', 'acl', '', $aclOpts ?? [], ['class' => 'form-control form-select'], ['class' => 'form-floating col'], $errors) ?>

            <?= bootstrapForm::fileField('', 'avatar', ['class' => 'form-control', 'onchange' => "display_image_edit(this.files[0])"], ['class' => 'col m-0 form-floating'], $errors) ?>

            <div class="d-flex align-items-center justify-content-center my-2">
                <h5 class="mx-3">Current User Avatar: </h5>
                <img src="<?= get_image() ?? '' ?>" alt="" class="mx-auto d-block image-preview-edit"
                    style="height:150px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
            </div>
        </div>

        <small class="text-danger fw-bold">Social Details</small>

        <?= BootstrapForm::textareaField('Bio', 'bio', $user->bio ?? '', ['class' => 'form-control summernote'], ['class' => 'form-floating my-2'], $errors) ?>

        <div class="row my-3">
            <div class="col">
                <a href="<?= Config::get('domain') ?>admin/users" class="btn btn-danger w-100"><i class="bi bi-arrow-left-circle"></i>
                    cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-dark w-100">Create User</button>
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
        placeholder: 'User bio',
        tabsize: 2,
        height: 300
    });
</script>
<?php $this->end() ?>