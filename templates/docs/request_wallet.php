<?php

use Core\Config;
use Core\Forms\BootstrapForm;


?>


<?php $this->start('content') ?>
<form action="" method="post" enctype="multipart/form-data">
    <?= BootstrapForm::method("PATCH"); ?>
    <div class="p-2 mb-4 bg-light rounded-3">
        <div class="container-fluid m-2 p-3 text-center rounded">
            <p class="text-muted">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt libero, id quos est eligendi ex possimus consectetur maxime. Impedit nemo quisquam odit nulla? Nesciunt explicabo doloremque dolore voluptatum, tempora animi!
            </p>
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