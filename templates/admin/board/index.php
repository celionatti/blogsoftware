<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Board Posts</h2>


    <div id="table-actions" class="row mt-3">
        <?= BootstrapForm::inputField('', 'search', '', ['class' => 'form-control form-control-sm shadow', 'type' => 'search'], ['class' => 'col my-1'], $errors) ?>

        <div class="col text-end">
            <a href="/admin/board-posts/drafts" class="btn btn-warning btn-sm">
                <i class="bi bi-archive"></i>
                Drafts
            </a>
            <a href="/admin/board-posts/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New Board Post
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($boards): ?>
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Created Date</th>
                </thead>
                <tbody>
                    <?php foreach ($boards as $key => $board): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $board->author ?>
                            </td>
                            <td>
                                <a href="" target="_blank" class="text-dark text-decoration-none">
                                    <?= $board->title ?>
                                </a>
                                <div class="my-2">
                                    <form action="<?= Config::get('domain') ?>admin/board-posts/trash" method="post"
                                        class="d-inline">
                                        <?= BootstrapForm::method("DELETE"); ?>
                                        <?= BootstrapForm::hidden("slug", $board->slug) ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Trash</button>
                                    </form>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/board-posts/edit?slug=<?= $board->slug ?>"
                                        class="btn btn-sm btn-info">Edit</a>
                                </div>
                            </td>
                            <td>
                                <?= TimeFormat::DateOne($board->created_at) ?>
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