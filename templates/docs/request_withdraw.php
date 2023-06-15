<?php

use Core\Config;
use Core\Forms\BootstrapForm;


?>


<?php $this->start('content') ?>
<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="p-2 mb-4 bg-light rounded-3">

        <h5 class="text-center border-bottom border-danger border-3 p-2">Withdraw from Wallet</h5>


        <div class="pt-3 pb-5">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="text-end border border-3 border-info p-2">Name: <span class="text-capitalize"><?= $credit->surname . ' ' . $credit->name ?></span></h6>
                <h6 class="text-end border border-3 border-primary p-2">Balance: <span><?= $credit->balance ?></span> CNT</h6>
            </div>
            <?= BootstrapForm::inputField('Amount', 'amount', $withdraw->amount ?? '', ['class' => 'form-control', 'type' => 'number'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::inputField('Bank', 'bank', $withdraw->bank ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>
            <?= BootstrapForm::inputField('Account Number', 'account_number', $withdraw->account_number ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>
            <?= BootstrapForm::inputField('Account Name', 'account_name', $withdraw->account_name ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>


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