<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;

$this->setHeader("Subscribers");

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Subscribers</h2>

    <div id="table-actions" class="row my-2">
        <div class="col text-end">
            <form action="<?= Config::get('domain') ?>admin/subscribers/trash" method="post" class="d-inline">
                <?= BootstrapForm::method('DELETE') ?>
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                    Trash All
                </button>
            </form>
            <a href="<?= Config::get('domain') ?>admin/subscribers/mail" class="btn btn-info btn-sm">
                <i class="bi bi-envelope"></i>
                Message
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 py-2 table-responsive">
        <?php if ($subscribers): ?>
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>E-Mail</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $key => $subscriber): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $subscriber->email ?>
                            </td>
                            <td class="text-end">
                                <div class="my-2">
                                    <form
                                        action="<?= Config::get('domain') ?>admin/subscribers/trash?slug=<?= $subscriber->slug ?>"
                                        method="post" class="d-inline">
                                        <?= BootstrapForm::method('DELETE') ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Trash</button>
                                    </form>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/subscribers/mail?slug=<?= $subscriber->slug ?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-envelope"></i>
                                        Message
                                    </a>
                                    <span class="divider">|</span>
                                    <?php if ($subscriber->status === "active"): ?>
                                        <form action="<?= Config::get('domain') ?>admin/subscribers/status" method="post"
                                            class="d-inline">
                                            <?= BootstrapForm::method('PATCH') ?>
                                            <?= BootstrapForm::hidden("slug", $subscriber->slug); ?>
                                            <?= BootstrapForm::hidden("status", "disabled"); ?>
                                            <button type="submit" class="btn btn-sm btn-warning">Disabled</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?= Config::get('domain') ?>admin/subscribers/status" method="post"
                                            class="d-inline">
                                            <?= BootstrapForm::method('PATCH') ?>
                                            <?= BootstrapForm::hidden("slug", $subscriber->slug); ?>
                                            <?= BootstrapForm::hidden("status", "active"); ?>
                                            <button type="submit" class="btn btn-sm btn-info">Active</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= Pagination::bootstrap_prev_next($prevPage, $nextPage) ?>
        <?php else: ?>
            <h4 class="text-center text-danger border-bottom border-danger py-2">No Data Available Yet!</h4>
        <?php endif; ?>
    </div>

</div>
<?php $this->end(); ?>