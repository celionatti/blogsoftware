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
            <div class="">
                <a href="<?= Config::get('domain') ?>" class="btn btn-outline-secondary mb-2"><i
                        class="bi bi-house-fill px-4"></i></a>
            </div>
            <form action="" method="post" class="p-4 p-md-2 rounded-3">
                <?= BootstrapForm::inputField('E-mail', 'email', $user->email ?? '', ['class' => 'form-control', 'type' => 'email'], ['class' => 'form-floating mb-3'], $errors) ?>

                <?= BootstrapForm::inputField('Password', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating mb-3'], $errors) ?>

                <div class="row">
                    <div class="col">
                        <?= BootstrapForm::checkField('Remember', 'remember', $user->remember == "on" ?? '', ['class' => 'mx-1'], ['class' => 'checkbox my-2'], $errors) ?>
                    </div>
                    <div class="col">
                        <div class="text-muted text-end"><i class="bi bi-key"></i> <a
                                href="<?= Config::get('domain') ?>forgot_password" class="text-black">Forgot
                                Password?</a>
                        </div>
                    </div>
                </div>

                <button class="w-100 btn btn-lg btn-dark" type="submit"><i class="bi bi-box-arrow-right"></i>
                    Login</button>
                <button class="w-100 btn btn-lg btn-danger my-2" type="button">Google Sign In</button>
                <hr class="my-1">
                <div class="text-muted text-center my-2">Don't have an account? <a
                        href="<?= Config::get('domain') ?>register" class="text-black">Create an Account</a></div>
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