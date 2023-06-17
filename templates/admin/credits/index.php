<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

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
            <table class="table table-sm table-dark table-striped">
                <thead>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created Date</th>
                </thead>
                <tbody>
                    <?php foreach ($credits as $key => $credit) : ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $credit->surname . " " . $credit->name ?>
                            </td>
                            <td>
                                <a class="text-white text-decoration-none">
                                    <?= $credit->amount ?>
                                </a>
                                <div class="my-2">
                                    <a href="<?= Config::get('domain') ?>admin/credits/info?credit-slug=<?= $credit->slug ?>" class="btn btn-sm btn-info"><i class="bi bi-info-circle"></i></a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/credits/trash?credit-slug=<?= $credit->slug ?>" class="btn btn-sm btn-danger">Trash</a>
                                    <span class="divider">|</span>
                                    <form action="<?= Config::get('domain') ?>admin/credits/status" method="post" class="d-inline">
                                        <?= BootstrapForm::method("PATCH") ?>

                                        <?= BootstrapForm::hidden("slug", $credit->slug) ?>
                                        <?= BootstrapForm::hidden("status", "disabled") ?>
                                        <button type="submit" class="btn btn-sm btn-secondary">Disabled</button>
                                    </form>
                                </div>
                            </td>
                            <?php if ($credit->status === 'success') : ?>
                                <td class="text-capitalize badge bg-success">
                                    <?= $credit->status ?>
                                </td>
                            <?php elseif ($credit->status === 'failed') : ?>
                                <td class="text-capitalize badge bg-danger">
                                    <?= $credit->status ?>
                                </td>
                            <?php else : ?>
                                <td class="text-capitalize badge bg-warning">
                                    <?= $credit->status ?>
                                </td>
                            <?php endif; ?>
                            <td>
                                <?= TimeFormat::DateOne($credit->created_at) ?>
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