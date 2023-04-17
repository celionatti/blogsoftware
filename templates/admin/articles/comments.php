<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;
use models\RelatedArticles;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Comments Article</h2>
    <h5 class="text-muted text-center border-bottom border-3 border-danger py-2">Title:
        <?= $article->title ?>
    </h5>

    <a href="<?= Config::get('domain') ?>admin/articles" class="btn btn-sm btn-primary my-2"><i
            class="bi bi-arrow-left"></i> Back</a>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($comments): ?>
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>User</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Created Date</th>
                </thead>
                <tbody>
                    <?php foreach ($comments as $key => $comment): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $comment->user ?>
                            </td>
                            <td>
                                <?= $comment->message ?>
                                <div class="my-2">
                                    <form action="<?= Config::get('domain') ?>admin/articles/comments-article/trash"
                                        method="post" class="d-inline">
                                        <?= BootstrapForm::method("DELETE"); ?>
                                        <?= BootstrapForm::hidden("comment_id", $comment->id) ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Trash</button>
                                    </form>
                                    <span class="divider">|</span>
                                    <?php if ($comment->status === "active"): ?>
                                        <form action="<?= Config::get('domain') ?>admin/articles/comments-article/status"
                                            method="post" class="d-inline">
                                            <?= BootstrapForm::method("PATCH"); ?>
                                            <?= BootstrapForm::hidden("comment_id", $comment->id) ?>
                                            <?= BootstrapForm::hidden("status", "disabled") ?>
                                            <button type="submit" class="btn btn-sm btn-warning">Block</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?= Config::get('domain') ?>admin/articles/comments-article/status"
                                            method="post" class="d-inline">
                                            <?= BootstrapForm::method("PATCH"); ?>
                                            <?= BootstrapForm::hidden("comment_id", $comment->id) ?>
                                            <?= BootstrapForm::hidden("status", "active") ?>
                                            <button type="submit" class="btn btn-sm btn-info">Active</button>
                                        </form>
                                    <?php endif; ?>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/articles/comments-article/replies?article-slug=<?= $comment->article_slug ?>&comment-id=<?= $comment->id ?>"
                                        class="btn btn-sm btn-primary">Replies</a>
                                </div>
                            </td>
                            <td class="text-capitalize">
                                <?= $comment->status ?>
                            </td>
                            <td>
                                <?= TimeFormat::DateOne($article->created_at) ?>
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