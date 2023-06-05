<?php
use Core\Config;
use Core\Forms\BootstrapForm;



?>

<?php $this->start("content"); ?>
<div class="p-2 mb-4 bg-light rounded-3">
    <div class="p-3 pb-5 row">
        <h1 class="display-5 text-capitalize text-center border-bottom border-danger border-3 py-1">
            Change Password
        </h1>
        <h5 class="text-muted text-center py-2 px-4">
            Notice: Please note that you have to enter the correct Old Password first, then add the new Password you now want. If the Old Password is wrong, you won't be allowed to change the Password. Then you will have to go to forgot Password, or contact one of the Admin Users. Thank You.
        </h5>
    </div>

    <form action="" method="post">
        <?= BootstrapForm::method("PATCH") ?>

        <?= BootstrapForm::inputField("Old Password", "old_password", "", ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating my-2'], $errors) ?>
        <?= BootstrapForm::inputField("New Password", "password", "", ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating my-2'], $errors) ?>
        <?= BootstrapForm::inputField("Confirm Password", "confirm_password", "", ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating my-2'], $errors) ?>

        <div class="row mt-3">
                <div class="col">
                    <a href="<?= Config::get('domain') ?>account" class="btn btn-sm btn-danger w-100"><i
                            class="bi bi-arrow-left-circle"></i>
                        cancel</a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-dark w-100">Change Password</button>
                </div>
            </div>
    </form>
</div>
<?php $this->end(); ?>