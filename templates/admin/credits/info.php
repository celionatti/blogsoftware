<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center text-capitalize border-bottom border-3 border-danger py-2"><?= $credit->surname . " " . $credit->name ?> Wallet Info</h2>

    <div class="border border-muted border-1 px-2 table-responsive">
        <table class="table table-hover table-primary">
            <tr>
                <th>Surname:</th>
                <td class="text-end text-capitalize"><?= $credit->surname ?></td>
                <th class="text-end">Wallet Type:</th>
                <td class="text-end text-capitalize"><?= $credit->type ?></td>
            </tr>
            <tr>
                <th>Name:</th>
                <td class="text-end text-capitalize"><?= $credit->name ?></td>
                <th class="text-end">Wallet Balance:</th>
                <td class="text-end text-capitalize"><?= $credit->balance ?></td>
            </tr>
            <tr>
                <th colspan="3" class="text-end">Status:</th>
                <td colspan="2" class="text-end text-capitalize"><?= $credit->status ?></td>
            </tr>
            <tr>
                <th colspan="3" class="text-end">Created at:</th>
                <td colspan="2" class="text-end text-capitalize"><?= TimeFormat::DateOne($credit->created_at) ?></td>
            </tr>
        </table>
        <!-- Add Credits -->
        <form action="" method="post">
            <h5 class="text-muted text-center text-capitalize border-bottom border-3 border-danger py-2">Add Credit</h5>
            <p class="text-muted text-center border-bottom border-3 border-danger py-2">Only add credits to user if it was a reward, or for any tangible reason, cause it will be account for. And reasons must be will stated.</p>
            <?= BootstrapForm::csrfField() ?>

            <?= BootstrapForm::inputField("Amount", "amount", "", ['class' => 'form-control', 'type' => 'number'], ['class' => 'form-floating my-2'], $errors) ?>

            <?= BootstrapForm::textareaField('Details of Transaction', 'details', $credit->details ?? '', ['class' => 'form-control'], ['class' => 'form-floating my-2'], $errors) ?>

            <button type="submit" class="btn btn-sm btn-dark w-100">Add Credit</button>
        </form>
    </div>

</div>
<?php $this->end(); ?>