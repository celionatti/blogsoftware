<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Tasks</h2>


    <div id="table-actions" class="row mt-3">
        <?= BootstrapForm::inputField('', 'search', '', ['class' => 'form-control form-control-sm shadow', 'type' => 'search'], ['class' => 'col my-1'], $errors) ?>

        <div class="col text-end">
            <a href="/admin/tasks/archive" class="btn btn-warning btn-sm">
                <i class="bi bi-archive"></i>
                Archive Task
            </a>
            <a href="/admin/tasks/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New Task
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($tasks): ?>
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created Date</th>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $key => $task): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <img src="<?= get_image($task->thumbnail) ?? '' ?>" alt="" class="d-block"
                                    style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;">
                            </td>
                            <td>
                                <a href="" target="_blank" class="text-dark text-decoration-none">
                                    <?= $task->title ?>
                                </a>
                                <div class="my-2">
                                    <form action="<?= Config::get('domain') ?>admin/tasks/trash" method="post" class="d-inline">
                                        <?= BootstrapForm::method("DELETE"); ?>
                                        <?= BootstrapForm::hidden("task_slug", $task->slug); ?>
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i>
                                            Trash
                                        </button>
                                    </form>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/tasks/edit?task-slug=<?= $task->slug ?>"
                                        class="btn btn-sm btn-info"><i class="bi bi-pencil"></i>
                                        Edit
                                    </a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/tasks/view?task-slug=<?= $task->slug ?>"
                                        class="btn btn-sm btn-primary"><i class="bi bi-eye"></i>
                                        Preview
                                    </a>
                                </div>
                            </td>
                            <td class="text-capitalize">
                                <?= $task->type ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $task->status ?>
                            </td>
                            <td>
                                <?= TimeFormat::DateOne($task->created_at) ?>
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