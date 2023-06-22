<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use models\Topics;


?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Topics</h2>

    <div id="table-actions" class="row my-3">

        <div class="col text-end">
            <a href="<?= Config::get('domain') ?>admin/topics/trash" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                Trash
            </a>
            <a href="<?= Config::get('domain') ?>admin/topics/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New Topic
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($topics): ?>
            <table class="table table-primary">
                <thead>
                    <th>S/N</th>
                    <th># of Articles</th>
                    <th>Topic</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <?php foreach ($topics as $key => $topic): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td><?= Topics::articles_topic_count($topic->slug) ?></td>
                            <td class="text-capitalize">
                                <a href="" target="_blank" class="text-dark text-decoration-none">
                                    <?= $topic->topic ?>
                                </a>
                                <div class="my-2">
                                    <a href="<?= Config::get('domain') ?>admin/topics/delete?topic-slug=<?= $topic->slug ?>"
                                        class="text-danger">Trash</a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/topics/edit?topic-slug=<?= $topic->slug ?>"
                                        class="text-info">Edit</a>
                                </div>
                            </td>
                            <td class="text-capitalize">
                                <?= $topic->status ?>
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