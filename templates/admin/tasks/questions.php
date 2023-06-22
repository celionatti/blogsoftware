<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

$this->setHeader("Questions");

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Questions</h2>

    <h5 class="text-muted text-center border-bottom border-3 border-danger py-2">Task:
        <?= $task->title ?>
    </h5>

    <a href="<?= Config::get('domain') ?>admin/tasks/view?task-slug=<?= $task->slug ?>"
        class="btn btn-sm btn-primary my-2"><i class="bi bi-arrow-left"></i> Back</a>

    <div id="table-actions" class="row mt-3">
        <div class="col text-start">
            <h5 class="border-bottom border-primary border-3 w-25 px-2"><span>
                    <?= $totalQuestions ?>
                </span> Questions</h5>
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

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($questions): ?>
            <table class="table table-primary">
                <thead>
                    <th>S/N</th>
                    <th>User</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Image</th>
                    <th>Comment</th>
                    <th>Created Date</th>
                </thead>
                <tbody>
                    <?php foreach ($questions as $key => $question): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $question->username ?>
                            </td>
                            <td>
                                <?= $question->question ?>
                                <div class="my-2">
                                    <form action="<?= Config::get('domain') ?>admin/tasks/questions/question/trash"
                                        method="post" class="d-inline">
                                        <?= BootstrapForm::method("DELETE") ?>
                                        <?= BootstrapForm::hidden("question_slug", $question->slug); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                            Trash
                                        </button>
                                    </form>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/tasks/questions/question/edit?task-slug=<?= $question->task_slug ?>&slug=<?= $question->slug ?>&type=<?= $question->type ?>"
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>
                                </div>
                            </td>
                            <td>
                                <?= $question->correct_answer ?>
                            </td>
                            <td>
                                <img src="<?= get_image($question->image) ?? '' ?>" alt="" class="d-block"
                                    style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;">
                            </td>
                            <td>
                                <?= $question->comment == null ? "No Comment" : htmlspecialchars_decode($question->comment) ?>
                            </td>
                            <td>
                                <?= TimeFormat::DateOne($question->created_at) ?>
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