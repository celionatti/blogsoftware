<?php


use Core\Support\Helpers\TimeFormat;


?>


<?php $this->start('content') ?>

<div class="row mb-3 text-center my-3">
    <div class="col-md-7 text-start">
        <h1 class="fw-bold">
            <?= $board->title ?>
        </h1>
        <div class="my-2 text-muted">By
            <?= $board->author ?>
        </div>
        <small class="text-muted">Updated
            <?= TimeFormat::BlogDate($board->created_at) ?>
        </small>
        <!-- <small class="text-muted">Updated 05:45 PM GMT. April 05, 2023</small> -->
        <div class="d-flex my-2">
            <a href="#" class="bi bi-facebook fs-5 me-3 text-primary"></a>
            <a href="#" class="bi bi-telegram fs-5 me-3 text-primary"></a>
            <a href="#" class="bi bi-whatsapp fs-5 me-3 text-success"></a>
            <a href="#" class="bi bi-twitter fs-5 me-3 text-info"></a>
        </div>

    </div>
    <div class="col-md-5" style="overflow:hidden;">
        <img src="<?= get_image($board->thumbnail) ?>" alt="<?= $board->thumbnail_caption ?? '' ?>"
            class="img-fluid shadow" style="object-fit: cover; height: 280px; width:100%;">
        <figure class="my-2 text-muted">
            <?= $board->thumbnail_caption ?? '' ?>
        </figure>
    </div>
</div>

<div class="shadow p-3">
    <?= htmlspecialchars_decode($board->content) ?>
</div>

<?php $this->end(); ?>