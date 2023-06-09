<?php


use Core\Config;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;


?>


<?php $this->start('content') ?>

<div class="row mb-3 text-center my-3">
    <div class="col-md-7 text-start">
        <h1 class="fw-bold">
            <?= $article->title ?>
        </h1>
        <div class="my-2 text-muted">By
            <?= $article->author ?>
        </div>
        <small class="text-muted">Updated
            <?= TimeFormat::BlogDate($article->created_at) ?>
        </small>
        <!-- <small class="text-muted">Updated 05:45 PM GMT. April 05, 2023</small> -->
        <div class="d-flex my-2">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= Config::get("domain") ?>news/read?slug=<?= $article->slug ?>" class="bi bi-facebook fs-5 me-3 text-primary" target="_blank"></a>
            <a href="https://telegram.me/share/url?url=<?= Config::get("domain") ?>news/read?slug=<?= $article->slug ?>&text=<?= $article->title ?>" class="bi bi-telegram fs-5 me-3 text-primary"></a>
            <a href="mailto:?subject=<?= $article->title ?>&body=<?= Config::get("domain") ?>news/read?slug=<?= $article->slug ?>" class="bi bi-envelope-at fs-5 me-3 text-success" target="_blank"></a>
            <a href="https://api.whatsapp.com/send?text=<?= Config::get("domain") ?>news/read?slug=<?= $article->slug ?>" class="bi bi-whatsapp fs-5 me-3 text-success" target="_blank"></a>
            <a href="https://twitter.com/intent/tweet?text=<?= $article->title ?>&url=<?= Config::get("domain") ?>news/read?slug=<?= $article->slug ?>" class="bi bi-twitter fs-5 me-3 text-info" target="_blank"></a>
        </div>

        <?php if ($article->point_one) : ?>

            <div class="p-4 mb-3 bg-light rounded border-top border-primary border-3">
                <h4 class="fst-italic pb-2">What we covered here</h4>
                <ul>
                    <li>
                        <?= $article->point_one ?>
                    </li>
                    <?php if ($article->point_two) : ?>
                        <li>
                            <?= $article->point_two ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>
    <div class="col-md-5" style="overflow:hidden;">
        <img src="<?= get_image($article->sub_image) ?>" alt="<?= $article->sub_image_caption ?? '' ?>" class="img-fluid shadow" style="object-fit: cover; height: 280px; width:100%;">
        <figure class="my-2 text-muted">
            <?= $article->sub_image_caption ?? '' ?>
        </figure>
    </div>
</div>


<div class="row g-5 mt-3">
    <div class="col-md-8">

        <article class="col" style="line-height:2rem;">
            <div class="card">
                <div class="pb-4 mb-2 fst-italic border-bottom">
                    <a href="#">
                        <img src="<?= get_image($article->thumbnail) ?>" alt="<?= $article->thumbnail_caption ?? '' ?>" class="" style="object-fit: cover; height: 600px; width:100%;">
                    </a>
                    <figure class="text-muted my-2 px-2">
                        <?= $article->thumbnail_caption ?? '' ?>
                    </figure>
                </div>

                <div class="card-body shadow">
                    <?= htmlspecialchars_decode($article->content) ?>
                    <div class="share post-container border-top border-3 border-danger mt-5 text-center d-flex flex-column justify-content-center align-items-center">
                        <h5 class="share-title">Author</h5>
                        <div class="profile">
                            <img src="<?= get_image($article->avatar ?? "", 'user') ?>" alt="" class="profile-img">
                            <span class="share-title">
                                <a href="<?= Config::get("domain") ?>author?name=<?= $article->username ?>" class="text-dark h6 text-uppercase"><?= $article->username ?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Comment section -->
        <section class="post-container mt-3">
            <h2><span class="bi bi-chat-dots"></span> Comments</h2>

            <hr class="my-2">
            <!-- Add Comment -->
            <div class="card">
                <div class="card-body bg-light">
                    <div class="text-danger" id="error_status"></div>
                    <div class="main-comment">
                        <form action="" method="post">
                            <input type="hidden" class="slug" value="<?= $article->slug ?>">
                            <?= BootstrapForm::textareaField('', 'message', '', ['class' => 'comment_textbox form-control', 'rows' => '2'], ['class' => ''], $errors); ?>
                            <button type="submit" class="btn btn-primary add_comment_btn my-2">Add Comment</button>
                        </form>

                        <hr class="my-2">
                        <!-- List all comments -->
                        <div class="comment-container">

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?= $this->partial('readSidebar') ?>

</div>

<?php $this->end(); ?>

<?php $this->start('script'); ?>
<script src="<?= assets_path("js/comments.js"); ?>"></script>
<?php $this->end(); ?>