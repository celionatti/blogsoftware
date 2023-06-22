<?php

use Core\Config;
use Core\Forms\BootstrapForm;
use Core\Support\Pagination;

$this->setHeader("Task Participants");

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Task Participants</h2>
    <h5 class="text-muted text-center border-bottom border-3 border-danger py-2">Task:
        <?= $task->title ?>
    </h5>

    <div id="table-actions" class="row mt-3">
        <div class="col text-start">
            <a href="<?= Config::get('domain') ?>admin/tasks/view?task-slug=<?= $task->slug ?>"
                class="btn btn-sm btn-primary my-2"><i class="bi bi-arrow-left"></i> Back</a>
        </div>

        <div class="col text-end">
            <form action="<?= Config::get('domain') ?>admin/tasks/participants/trash" method="post">
                <?= BootstrapForm::method("DELETE"); ?>
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                    Trash All
                </button>
            </form>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($participants): ?>
            <table class="table table-primary">
                <thead>
                    <th>S/N</th>
                    <th>Task No</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Status</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($participants as $key => $participant): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td class="">
                                <?= $participant->task_slug ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $participant->surname ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $participant->name ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $participant->status ?>
                            </td>
                            <td class="text-capitalize text-end">
                                <?php if ($participant->status === "active"): ?>
                                    <form action="<?= Config::get('domain') ?>admin/tasks/participant/status" method="post">
                                        <?= BootstrapForm::method("PATCH"); ?>
                                        <?= BootstrapForm::hidden("task_slug", $participant->task_slug); ?>
                                        <?= BootstrapForm::hidden("status", "blocked"); ?>
                                        <button type="submit" class="btn btn-info btn-sm">Block</button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?= Config::get('domain') ?>admin/tasks/participant/status" method="post">
                                        <?= BootstrapForm::method("PATCH"); ?>
                                        <?= BootstrapForm::hidden("task_slug", $participant->task_slug); ?>
                                        <?= BootstrapForm::hidden("status", "active"); ?>
                                        <button type="submit" class="btn btn-info btn-sm">Active</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= Pagination::bootstrap_prev_next($prevPage, $nextPage) ?>
        <?php else: ?>
            <h4 class="text-center text-muted border-bottom border-3 border-danger p-3">No Data Available at the moment!
            </h4>
        <?php endif; ?>
    </div>

</div>
<?php $this->end(); ?>

<?php $this->start('script') ?>

<script>

</script>

<?php $this->end(); ?>