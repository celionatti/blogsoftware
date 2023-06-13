<?php

use Core\Config;
use Core\Forms\BootstrapForm;


?>


<?php $this->start('content') ?>
<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="p-2 mb-4 bg-light rounded-3">
        <div class="container-fluid m-2 p-3 text-center rounded">
            <p class="text-muted">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt libero, id quos est eligendi ex possimus consectetur maxime. Impedit nemo quisquam odit nulla? Nesciunt explicabo doloremque dolore voluptatum, tempora animi!
            </p>
        </div>

        <h5 class="text-center border-bottom border-danger border-3 p-2">Create Wallet</h5>


        <div class="pt-3 pb-5">
            <?= BootstrapForm::selectField('Type', 'type', $credit->type ?? '', $typeOpts ?? [], ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Token (Pin)', 'token', $credit->token ?? '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-floating my-2'], $errors) ?>


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