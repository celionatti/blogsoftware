<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

$this->setHeader("Wallet Transactions");

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Credits</h2>

    <div id="table-actions" class="row my-3">

        <div class="col text-end">
            <a href="<?= Config::get('domain') ?>admin/wallets" class="btn btn-primary btn-sm">
                <i class="bi bi-wallet"></i>
                Wallets
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($credits) : ?>
            <table class="table table-sm table-dark">
                <thead>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Bank</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th colspan="2"></th>
                </thead>
                <tbody>
                    <?php foreach ($credits as $key => $credit) : ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $credit->surname . " " . $credit->name ?>
                            </td>
                            <td>
                                <?= $credit->amount ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $credit->bank ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $credit->account_name ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $credit->account_number ?>
                            </td>
                            <?php if ($credit->status === 'success') : ?>
                                <td class="text-capitalize">
                                    <span class="badge bg-success p-2"><?= $credit->status ?></span>
                                </td>
                            <?php elseif ($credit->status === 'failed') : ?>
                                <td class="text-capitalize">
                                    <span class="badge bg-danger p-2"><?= $credit->status ?></span>
                                </td>
                            <?php else : ?>
                                <td class="text-capitalize">
                                    <span class="badge bg-warning p-2"><?= $credit->status ?></span>
                                </td>
                            <?php endif; ?>
                            <td>
                                <?= TimeFormat::StringTime($credit->created_at) ?>
                            </td>
                            <td class="text-end">
                                <div class="row g-2">
                                    <?php if ($credit->status === 'pending') : ?>
                                        <form action="<?= Config::get('domain') ?>admin/credits/withdraw" method="post" class="d-inlines col">
                                            <?= BootstrapForm::method("PATCH") ?>

                                            <?= BootstrapForm::hidden("wallet_id", $credit->wallet_id) ?>
                                            <?= BootstrapForm::hidden("amount", $credit->amount) ?>
                                            <button type="submit" class="btn btn-sm btn-primary w-100">Withdraw</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($credit->status !== 'success') : ?>
                                        <form action="<?= Config::get('domain') ?>admin/credits/status" method="post" class="d-inlines col">
                                            <?= BootstrapForm::method("PATCH") ?>

                                            <?= BootstrapForm::hidden("slug", $credit->slug) ?>
                                            <?= BootstrapForm::hidden("wallet_id", $credit->wallet_id) ?>
                                            <?= BootstrapForm::hidden("amount", $credit->amount) ?>
                                            <?= BootstrapForm::hidden("status", "success") ?>
                                            <button type="submit" class="btn btn-sm btn-success w-100">Approve</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if($credit->status === 'pending'): ?>
                                    <form action="<?= Config::get('domain') ?>admin/credits/status" method="post" class="d-inlines col">
                                        <?= BootstrapForm::method("PATCH") ?>

                                        <?= BootstrapForm::hidden("slug", $credit->slug) ?>
                                        <?= BootstrapForm::hidden("wallet_id", $credit->wallet_id) ?>
                                        <?= BootstrapForm::hidden("amount", $credit->amount) ?>
                                        <?= BootstrapForm::hidden("status", "failed") ?>
                                        <button type="submit" class="btn btn-sm btn-danger w-100">Cancel</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= Pagination::bootstrap_prev_next($prevPage, $nextPage) ?>
        <?php else : ?>
            <h4 class="text-center text-muted border-bottom border-3 border-danger p-3">No Data Available at the moment!
            </h4>
        <?php endif; ?>
    </div>

</div>
<?php $this->end(); ?>