<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Articles</h2>

    <div id="featured_posts">
        <form action="" method="post">
            <strong>Featured Post: </strong>
            <span class="title-wrapper">
                <span>This is a sample post title</span>
                <button type="button" class="change-featured-post btn btn-sm btn-secondary">Change</button>
            </span>
            <span class="input-wrapper d-none">
                <?= BootstrapForm::inputField('Featured Article', 'title', '', ['class' => 'form-control form-control-sm'], ['class' => 'form-floating my-2'], $errors) ?>
                <button type="submit" class="btn btn-dark">Update</button>
            </span>
        </form>
    </div>

    <div id="table-actions" class="row mt-3">
        <?= BootstrapForm::inputField('', 'search', '', ['class' => 'form-control form-control-sm shadow', 'type' => 'search'], ['class' => 'col my-1'], $errors) ?>

        <div class="col text-end">
            <a href="<?= Config::get('domain') ?>admin/articles/drafts" class="btn btn-warning btn-sm">
                <i class="bi bi-archive"></i>
                Drafts
            </a>
            <a href="<?= Config::get('domain') ?>admin/articles/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New Article
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($articles): ?>
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Topic</th>
                    <th>Created Date</th>
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
                                <a href="<?= Config::get('domain') ?>admin/articles/review?article-slug=<?= $article->slug ?>" target="_blank" class="text-dark text-decoration-none">
                                    <?= $article->title ?>
                                </a>
                                <div class="my-2">
                                    <a href="<?= Config::get('domain') ?>admin/articles/trash?article-slug=<?= $article->slug ?>"
                                        class="text-danger">Trash</a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/articles/edit?article-slug=<?= $article->slug ?>"
                                        class="text-info">Edit</a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/articles/related-articles?article-slug=<?= $article->slug ?>"
                                        class="text-primary">Related Article</a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/articles/comments-article?article-slug=<?= $article->slug ?>"
                                        class="text-warning">Comments</a>
                                </div>
                            </td>
                            <td>
                                <?= $article->topic ?>
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

<?php $this->start('script') ?>

<script>
    const changeFeaturedPostBtn = document.querySelector('.change-featured-post');
    const inputWrapper = document.querySelector('.input-wrapper');
    const titleWrapper = document.querySelector('.title-wrapper');

    changeFeaturedPostBtn.addEventListener('click', function () {
        inputWrapper.classList.toggle('d-none');
        titleWrapper.classList.toggle('d-none');
    });
</script>

<?php $this->end(); ?>