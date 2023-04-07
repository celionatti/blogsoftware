<?php

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
        <small class="text-muted">Updated 05:45 PM GMT. April 05, 2023</small>
        <div class="d-flex my-2">
            <a href="#" class="bi bi-facebook fs-5 me-3"></a>
            <a href="#" class="bi bi-telegram fs-5 me-3"></a>
            <a href="#" class="bi bi-whatsapp fs-5 me-3"></a>
            <a href="#" class="bi bi-twitter fs-5 me-3"></a>
        </div>
    </div>
    <div class="col-md-5" style="overflow:hidden;">
        <img src="<?= get_image($article->sub_image) ?>" alt="" class="img-fluid shadow"
            style="object-fit: cover; height: 280px; width:100%;">
        <figure>No image caption</figure>
    </div>
</div>


<div class="row g-5 mt-3">
    <div class="col-md-8">

        <article class="col" style="line-height:2rem;">
            <div class="card">
                <div class="pb-4 mb-2 fst-italic border-bottom">
                    <a href="#">
                        <img src="<?= get_image($article->thumbnail) ?>" alt="" class=""
                            style="object-fit: cover; height: 600px; width:100%;">
                    </a>
                    <figure class="text-muted px-3">No image caption</figure>
                </div>

                <div class="card-body">
                    <?= htmlspecialchars_decode($article->content) ?>
                </div>
            </div>
        </article>

    </div>

    <?= $this->partial('sidebar') ?>

</div>

<?php $this->end(); ?>