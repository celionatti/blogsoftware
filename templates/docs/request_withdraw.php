<?php

use Core\Config;
use Core\Forms\BootstrapForm;


?>


<?php $this->start('content') ?>
<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="p-2 mb-4 bg-light rounded-3">

        <h5 class="text-center border-bottom border-danger border-3 p-2">Create Wallet</h5>


        <div class="pt-3 pb-5">
            <?= BootstrapForm::inputField('Amount', 'amount', $withdraw->amount ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Token (Pin)', 'token', $withdraw->token ?? '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating my-2'], $errors) ?>


            <div class="row mt-3">
                <div class="col">
                    <a href="<?= Config::get('domain') ?>account" class="btn btn-sm btn-danger w-100"><i
                            class="bi bi-arrow-left-circle"></i>
                        cancel</a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-dark w-100">Create Wallet</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $this->end(); ?>