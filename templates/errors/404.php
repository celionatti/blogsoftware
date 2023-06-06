<?php

use Core\Config;

?>


<?php $this->start('content') ?>
<div class="container py-5 d-flex flex-column align-items-center justify-content-center shadow">
    <div class="py-5">
        <img src="<?= get_image("assets/img/404.svg") ?>" class="" />

        <a href="<?= Config::get("domain") ?>" class="bi bi-arrow-left-circle px-2 btn btn-sm btn-primary w-100"> Back</a>
    </div>
</div>
<?php $this->end(); ?>
