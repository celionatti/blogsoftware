<?php

?>


<?php $this->start('content') ?>

<div class="row mb-3 text-center my-3">
    <div class="col-md-7 text-start">
        <h1 class="fw-bold">This is where the title of the News Blog will be going. Also this is will
            be
            the finally
            work in jesus name.
            Amen</h1>
        <div class="my-2 text-muted">By CNB Amisu usman</div>
        <small class="text-muted">Updated 05:45 PM GMT. April 05, 2023</small>
    </div>
    <div class="col-md-5" style="overflow:hidden;">
        <img src="<?= get_image() ?>" alt="" class="img-fluid" style="object-fit: cover; height: 280px; width:100%;">
        <figure>No image caption</figure>
    </div>
</div>


<div class="row g-5 mt-3">
    <div class="col-md-8">

        <article class="col" style="line-height:2rem;">
            <div class="card">
                <div class="pb-4 mb-2 fst-italic border-bottom">
                    <a href="#">
                        <img src="<?= get_image("uploads/articles/20230403115111.jpg") ?>" alt="" class=""
                            style="object-fit: cover; height: 800px; width:100%;">
                    </a>
                    <figure class="text-muted px-3">No image caption</figure>
                </div>

                <div class="card-body">
                    A few rules to stop you (and us) getting in trouble.
                    These apply to our services and content. One exception
                    is content that’s made to be shared – “shareable” for
                    short – which has some different, more relaxed rules.
                    The A few rules to stop you (and us) getting in trouble.
                    These apply to our services and content. One exception
                    is content that’s made to be shared – “shareable” for
                    short – which has some different, more relaxed rules.
                    The A few rules to stop you (and us) getting in trouble.
                    These apply to our services and content. One exception
                    is content that’s made to be shared – “shareable” for
                    short – which has some different, more relaxed rules.
                    The
                </div>
            </div>
        </article>

    </div>

    <?= $this->partial('sidebar') ?>

</div>

<?php $this->end(); ?>