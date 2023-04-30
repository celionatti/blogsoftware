<?php

use Core\Config;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Task Details</h2>

    <h5 class="text-muted text-center border-bottom border-3 border-danger py-2">Task:
        <?= $task->title ?>
    </h5>

    <a href="<?= Config::get('domain') ?>admin/tasks" class="btn btn-sm btn-primary my-2"><i
            class="bi bi-arrow-left"></i> Back</a>

    <div id="table-actions" class="row mt-3">
        <div class="col text-start">
            <a href="<?= Config::get('domain') ?>admin/tasks/participants?task-slug=<?= $task->slug ?>" class="btn btn-info btn-sm">
                <i class="bi bi-people"></i>
                Participants
            </a>
        </div>

        <div class="col text-end">
            <?php if ($task->type === "quiz"): ?>
                <a href="<?= Config::get('domain') ?>admin/tasks/questions?task-slug=<?= $task->slug ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i>
                    Questions
                </a>
            <?php else: ?>
                <a href="<?= Config::get('domain') ?>admin/tasks/competitions?task-slug=<?= $task->slug ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i>
                    Challenge/Competition
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="">

    </div>


</div>
<?php $this->end(); ?>