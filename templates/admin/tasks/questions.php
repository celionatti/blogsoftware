<?php

use Core\Config;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Questions</h2>

    <h5 class="text-muted text-center border-bottom border-3 border-danger py-2">Task:
        <?= $task->title ?>
    </h5>

    <div id="table-actions" class="row mt-3">
        <div class="col text-start">
            <h5 class="border-bottom border-primary border-3 w-25"><span>10</span> Questions</h5>
        </div>

        <div class="col text-end">
            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-plus-circle"></i>
                    Add Question
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <h6 class="dropdown-header">Question Options</h6>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="<?= Config::get("domain") ?>admin/tasks/questions/question?task-slug=<?= $task->slug ?>&type=objective">Objective
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="<?= Config::get("domain") ?>admin/tasks/questions/question?task-slug=<?= $task->slug ?>&type=subjective">Subjective
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="<?= Config::get("domain") ?>admin/tasks/questions/question?task-slug=<?= $task->slug ?>&type=theory">Theory
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


</div>
<?php $this->end(); ?>