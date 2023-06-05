<?php

use Core\Config;
use Core\Forms\BootstrapForm;

?>

<?php $this->start('content'); ?>
<div class="container col-xl-12 col-xxl-12 px-2 py-2 shadow-lg mx-auto my-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-5 text-center text-lg-start">
            <img src="<?= get_image() ?>" alt="" class="w-100" style="object-fit: cover;">
        </div>
        <div class="col-md-10 mx-auto col-lg-7">
                <h3 class="text-muted text-center border-bottom border-danger border-3 py-2">Change Password</h3>
            <form action="" method="post" class="p-4 p-md-2 rounded-3">
                <?= BootstrapForm::csrfField(); ?>
                <?= BootstrapForm::inputField('Password', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating mb-3'], $errors) ?>

                <?= BootstrapForm::inputField('Confirm Password', 'confirm_password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating mb-3'], $errors) ?>

                <button class="w-100 btn btn-sm btn-dark" type="submit"><i class="bi bi-lock"></i>
                    Change Password</button>
                <hr class="my-1">

                <p class="mb-1 text-muted text-center">&copy; 2020 -
                    <?= date("Y"); ?>
                </p>

                <p class="text-muted text-center">
                    <?= $this->getTitle(); ?>, Inc. All Rights Reserved.
                </p>
            </form>
        </div>
    </div>
</div>
<?php $this->end(); ?>