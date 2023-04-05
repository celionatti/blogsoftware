<?php

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

<div class="row g-5">
    <div class="col-md-8">
        <h3 class="pb-4 mb-4 fst-italic border-bottom">
            From the Firehose
        </h3>

        <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <article class="col">
                <div class="card">
                    <a href="#">
                        <img src="<?= get_image() ?>" alt="" class="post-img">
                    </a>
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-center mb-2 px-3 py-1 text-center rounded border-bottom border-danger border-3">
                            <h6 class="text-center">
                                <a href="#" class="text-black">
                                    <span class="bi bi-tags"></span>
                                    Nigeria
                                </a>
                            </h6>
                            <h6 class="text-black fw-bold"><span class="bi bi-clock"></span> 5min</h6>
                        </div>
                        <a href="#" class="post-title">Card title Some quick example text to build on the card title and
                            make up
                        </a>
                        <p class="post-description">Some quick example text to build on the card title and make up the
                            bulk of card's content.</p>
                        <div class="profile">
                            <img src="<?= get_image('', 'user') ?>" alt="" class="profile-img">
                            <span class="profile-name">
                                Celio Natti
                            </span>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col">
                <div class="card">
                    <a href="#">
                        <img src="<?= get_image() ?>" alt="" class="post-img">
                    </a>
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-center mb-2 px-3 py-1 text-center rounded border-bottom border-danger border-3">
                            <h6 class="text-center">
                                <a href="#" class="text-black">
                                    <span class="bi bi-tags"></span>
                                    Nigeria
                                </a>
                            </h6>
                            <h6 class="text-black fw-bold"><span class="bi bi-clock"></span> 5min</h6>
                        </div>
                        <a href="#" class="post-title">Card title Some quick example text to build on the card title and
                            make up
                        </a>
                        <p class="post-description">Some quick example text to build on the card title and make up the
                            bulk of card's content.</p>
                        <div class="profile">
                            <img src="<?= get_image('', 'user') ?>" alt="" class="profile-img">
                            <span class="profile-name">
                                Celio Natti
                            </span>
                        </div>
                    </div>
                </div>
            </article>

        </div>

        <nav class="blog-pagination" aria-label="Pagination">
            <a class="btn btn-outline-primary rounded-pill w-100" href="#">Load More</a>
        </nav>

    </div>

    <?= $this->partial('sidebar') ?>

</div>

<?php $this->end(); ?>