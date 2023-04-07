<?php

use Core\Forms\BootstrapForm;

?>


<?php $this->start('content') ?>

<main class="container">
    <div class="about position-relative overflow-hidden text-center d-flex justify-content-center mt-5">
        <img src="<?= get_image("assets/img/about-heading.jpg") ?>" alt="" class="w-100">
        <div class="about-head position-absolute bottom-50 top-0">
            <h3 class="text-danger mt-3">About Us</h3>
            <h1 class="text-white text-uppercase fw-bold fs-1 my-auto">
                <?= $settings['site_name'] ?? $this->getTitle(); ?>
            </h1>
        </div>
    </div>
    <h2 class="text-black h3 border-bottom border-danger border-3 p-3">Our Background</h2>
    <section>
        <div class="row">
            <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                <img src="<?= get_image("assets/img/post-4.jpg") ?>" alt="" class="w-100 img-fluid rounded-5"
                    style="object-fit: cover;">
            </div>
            <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                <h2
                    class="text-shadow h3 text-uppercase border-bottom border-3 border-danger pb-2 text-black text-start">
                    About <?= $settings['site_name'] ?? $this->getTitle() ?></h2>
                <p>
                    <?= $settings['about'] ?? '...' ?>
                </p>
            </div>
        </div>
    </section>
    <h2 class="text-black border-3 border-danger border-bottom p-2 border-top my-3">Contact Us</h2>
    <section>
        <div class="row">
            <div class="col-12 col-lg-8 col-md-6 col-sm-12">
                <form action="" method="post" class="border-end border-3 border-danger p-2">
                    <?= BootstrapForm::csrfField(); ?>
                    <?= BootstrapForm::inputField('FullName', 'fullname', $contact->fullname ?? '', ['class' => 'form-control'], ['class' => 'mb-3 form-floating'], $errors); ?>

                    <?= BootstrapForm::inputField('E-Mail', 'email', $contact->email ?? '', ['class' => 'form-control', 'type' => 'email'], ['class' => 'mb-3 form-floating'], $errors); ?>

                    <?= BootstrapForm::inputField('Subject', 'subject', $contact->subject ?? '', ['class' => 'form-control'], ['class' => 'mb-3 form-floating'], $errors); ?>

                    <?= BootstrapForm::textareaField('Message', 'message', $contact->message ?? '', ['class' => 'form-control'], ['class' => 'mb-3'], $errors); ?>

                    <button type="submit" class="btn btn-danger w-100">Send Message</button>
                </form>
            </div>
            <div class="col-12 col-lg-4 col-md-6 col-sm-12">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                About the Founder
                            </button>
                        </h4>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?= $settings['founder'] ?? 'Loading...' ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Mission And Aim
                            </button>
                        </h4>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem rerum illo recusandae
                                dicta
                                quos saepe repudiandae sunt. Omnis numquam tempora, rem ipsum et asperiores ipsa enim,
                                corrupti tenetur consequatur nisi!
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<?php $this->end(); ?>