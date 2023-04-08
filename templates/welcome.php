<?php


use Core\Config;
use Core\Support\Helpers\TimeFormat;


?>


<?php $this->start('content') ?>

<div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
    <div class="col-md-6 px-0">
        <h1 class="display-4 fst-italic">Title of a longer featured blog post</h1>
        <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently
            about what’s most interesting in this post’s contents.</p>
        <p class="lead mb-0"><a href="#" class="text-white fw-bold">Continue reading...</a></p>
    </div>
</div>

<?php if ($featured): ?>
    <div class="row mb-3 text-center my-3 rounded border p-2 shadow">
        <h3 class="pb-4 mb-4 fst-italic border-bottom text-start">
            Featured Article
        </h3>
        <div class="col-md-7 text-start">
            <h1 class="fw-bold">
                <?= $featured->title ?>
            </h1>
            <div class="my-2 text-muted">By
                <?= $featured->author ?>
            </div>
            <div class="my-2 text-muted">
                <i class="bi bi-tag"></i>
                <?= $featured->topic ?>
            </div>
            <small class="text-muted">Updated
                <?= TimeFormat::BlogDate($featured->created_at) ?>
            </small>
            <div class="d-flex my-2">
                <a href="#" class="bi bi-facebook fs-5 me-3 text-primary"></a>
                <a href="#" class="bi bi-telegram fs-5 me-3 text-primary"></a>
                <a href="#" class="bi bi-whatsapp fs-5 me-3 text-success"></a>
                <a href="#" class="bi bi-twitter fs-5 me-3 text-info"></a>
            </div>
        </div>
        <div class="col-md-5" style="overflow:hidden;">
            <img src="<?= get_image($featured->thumbnail) ?>" alt="" class="img-fluid shadow rounded"
                style="object-fit: cover; height: 280px; width:100%;">
            <figure class="my-2 text-muted">
                <?= $featured->thumbnail_caption ?>
            </figure>
        </div>
    </div>
<?php endif; ?>

<!-- Section One -->
<div class="row mb-3">
    <h3 class="pb-4 mb-4 fst-italic border-bottom">
        From the Firehose
    </h3>

    <?php if ($articles): ?>
        <?php foreach ($articles as $article): ?>
            <div class="col-6 my-3">
                <div class="border rounded p-2 shadow">
                    <article class="">
                        <div class="image">
                            <a href="<?= Config::get("domain") ?>news/read?slug=<?= $article->slug ?>">
                                <img src="<?= get_image($article->thumbnail) ?>" alt="" class="img-fluid shadow"
                                    style="object-fit: cover; height: 280px; width:100%;">
                            </a>
                        </div>

                        <div
                            class="d-flex justify-content-between align-items-center my-2 px-3 py-1 text-center rounded border-bottom border-danger border-3">
                            <h6 class="text-center">
                                <a href="#" class="text-black">
                                    <span class="bi bi-tag"></span>
                                    <?= $article->topic ?>
                                </a>
                            </h6>
                            <h6 class="text-black fw-bold"><span class="bi bi-clock"></span>
                                <?= TimeFormat::TimeInAgo($article->created_at) ?>
                            </h6>
                        </div>

                        <a href="<?= Config::get("domain") ?>news/read?slug=<?= $article->slug ?>" class="post-title mt-3 px-3">
                            <?= $article->title ?>
                        </a>
                    </article>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
<!-- End of Section One -->

<?php $this->end(); ?>