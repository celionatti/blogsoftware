<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;

$this->setHeader("Messages");

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Messages</h2>

    <div id="table-actions" class="row my-2">
        <div class="col text-end">
            <form action="<?= Config::get('domain') ?>admin/messages/trash" method="post">
                <?= BootstrapForm::method('DELETE') ?>
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                    Trash All
                </button>
            </form>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 py-2 table-responsive">
        <?php if ($messages): ?>
            <table class="table table-primary">
                <thead>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Message</th>
                </thead>
                <tbody>
                    <?php foreach ($messages as $key => $message): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $message->name ?>
                            </td>
                            <td>
                                <?= $message->subject ?>
                            </td>
                            <td>
                                <?= $message->message ?>
                                <div class="my-2">
                                    <form
                                        action="<?= Config::get('domain') ?>admin/messages/trash?message-slug=<?= $message->slug ?>"
                                        method="post">
                                        <?= BootstrapForm::method('DELETE') ?>
                                        <button type="submit" class="btn text-danger">Trash</button>
                                    </form>
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