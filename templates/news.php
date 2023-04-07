<?php

use Core\Support\Helpers\StringFormat;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>

<div class="row g-5">
    <div class="col-md-8">

        <?php if ($articles): ?>
            <div class="g-4 mb-5">
                <?php foreach ($articles as $article): ?>
                    <article class="my-3 shadow">
                        <div class="card">
                            <div class="card-header">
                                <a href="/news/read?slug=<?= $article->slug ?>">
                                    <img src="<?= get_image($article->thumbnail) ?>" alt="" class="post-img">
                                </a>
                            </div>
                            <div class="card-body">
                                <div
                                    class="d-flex justify-content-between align-items-center mb-2 px-3 py-1 text-center rounded border-bottom border-danger border-3">
                                    <h6 class="text-center">
                                        <a href="/topics?slug=<?= $article->topic_slug ?>" class="text-black">
                                            <span class="bi bi-tags"></span>
                                            <?= $article->topic ?>
                                        </a>
                                    </h6>
                                    <h6 class="text-black"><span class="bi bi-clock"></span>
                                        <?= TimeFormat::TimeInAgo($article->created_at) ?>
                                    </h6>
                                </div>
                                <a href="/news/read?slug=<?= $article->slug ?>" class="post-title">
                                    <?= $article->title ?>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn btn-outline-secondary rounded-pill w-100" href="#">Load More</a>
            </nav>
        <?php else: ?>
            <h4 class="text-center text-danger my-3">No Data Available yet!</h4>
        <?php endif; ?>

    </div>

    <?= $this->partial('sidebar') ?>

</div>

<?php $this->end(); ?>