<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;
use models\RelatedArticles;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Related Articles</h2>
    <h5 class="text-muted text-center border-bottom border-3 border-danger py-2">Title:
        <?= $article->title ?>
    </h5>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($articles): ?>
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Created Date</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($articles as $key => $article): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $article->author ?>
                            </td>
                            <td>
                                <a href="" target="_blank" class="text-dark text-decoration-none">
                                    <?= $article->title ?>
                                </a>
                            </td>
                            <td>
                                <?= TimeFormat::DateOne($article->created_at) ?>
                            </td>
                            <td>
                                <?php if (RelatedArticles::add_related_articles($article->slug)): ?>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i>
                                        Add
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-warning btn-sm">
                                        <i class="bi bi-x-circle"></i>
                                        Remove
                                    </button>
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