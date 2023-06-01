<?php


use Core\Config;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;


?>

<?php $this->start('header') ?>
<style>
.author-bg {
    background-image: url('/assets/img/bg-2.jpg');
    background-position: center;
    background-repeat: no-repeat, repeat;
    background-size: cover;
    background-blend-mode: lighten;
}
</style>
<?php $this->end(); ?>

<?php $this->start('content') ?>
<div class="p-2 mb-4 bg-light rounded-3">
    <div class="container-fluid d-flex justify-content-center align-items-center author-bg rounded">
        <img src="<?= get_image($user->avatar) ?>" class="rounded-5 m-2"
            style="object-fit: cover; height: 350px; width:350px;" />
    </div>
    <div class="pt-3 pb-5 d-flex flex-column justify-content-center align-items-center">
        <h1 class="display-5 fw-bold text-capitalize"><?= $user->surname . " " . $user->name ?></h1>
        <h3 class="text-muted"><?= $user->username ?></h3>
        <div class="border-bottom border-danger border-3 my-2 p-2">
            <span>
                <i class="bi bi-envelope-at"></i>
                <a href="mailto:<?= $user->email ?>" class="text-black"><?= $user->email ?></a>
            </span>
            <span class="mx-2">|</span>
            <span>
                <i class="bi bi-twitter"></i>
                <a href="<?= $user->social ?>" class="text-black"><?= $user->social ?></a>
            </span>
        </div>
        <header class="pb-3 my-4 border-bottom">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor"
                    class="bi bi-info-square me-2" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                    <path
                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                </svg>
                <span class="fs-4">About Author</span>
            </a>
        </header>
        <div class="px-3">
            <p class="col-md-8 fs-4 text-center mb-3"><?= htmlspecialchars_decode($user->bio) ?></p>
            <form action="" method="post" class="my-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fs-4 flex-center">Rating</span>
                    <div class="fs-4 text-end">
                        <span class="text-normal"><i class="bi bi-star-fill text-info"></i></span>
                        <span class="text-normal"><i class="bi bi-star-fill text-info"></i></span>
                        <span class="text-normal"><i class="bi bi-star-fill text-info"></i></span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">

                    <div class="form-check my-3 mx-2">
                        <input type="radio" class="form-check-input border border-primary"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="5">
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                    </div>

                    <div class="form-check my-3 mx-2">
                        <input type="radio" class="form-check-input border border-primary"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="10">
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star"></i></span>
                    </div>

                    <div class="form-check my-3 mx-2">
                        <input type="radio" class="form-check-input border border-primary"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="15">
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star"></i></span>
                    </div>

                    <div class="form-check my-3 mx-2">
                        <input type="radio" class="form-check-input border border-primary"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="20">
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star"></i></span>
                    </div>

                    <div class="form-check my-3 mx-2">
                        <input type="radio" class="form-check-input border border-primary"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="25">
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star-half"></i></span>
                        <span class="text-normal"><i class="bi bi-star"></i></span>
                    </div>

                </div>
                <!-- Review -->
                <?= BootstrapForm::textareaField('Review', 'review', '', ['class' => 'form-control', 'rows' => '5'], ['class' => 'my-2'], $errors) ?>
                <button type="submit" class="btn btn-sm btn-info px-3 py-2">Rate</button>
            </form>
        </div>
    </div>
</div>
<?php $this->end(); ?>